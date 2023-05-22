<?php

declare(strict_types=1);

namespace App\Feature\Api\Rest;

use App\Constants\TaskPriorityEnum;
use App\Models\Task;
use CodeIgniter\HTTP\Response;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Database\Seeds\DatabaseSeeder;

/**
 * @runTestsInSeparateProcesses
 */
final class TaskTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = DatabaseSeeder::class;

    private string $endpoint = '/api/tasks';
    private string $token    = '';
    private int    $userId   = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $response = $this->withBodyFormat('json')->post('/api/login', [
            'email'    => 'johndoe@gmail.com',
            'password' => 'password',
        ])->response()->getJSON();

        $token       = json_decode($response, true)['token'];
        $this->token = sprintf('Bearer %s', $token);

        unset($response);

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/profile');

        $response     = json_decode($response->getJSON(), true);
        $this->userId = $response['user']['id'];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testUnauthorizedUser(): void
    {
        $this->headers = [];

        $this
            ->withBodyFormat('json')
            ->get($this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED); // index
        $this
            ->withBodyFormat('json')
            ->post($this->endpoint, [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED); // store
        $this
            ->withBodyFormat('json')
            ->get("{$this->endpoint}/1")
            ->assertStatus(Response::HTTP_UNAUTHORIZED); // show
        $this
            ->withBodyFormat('json')
            ->put("{$this->endpoint}/1", [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED); // update
        $this
            ->withBodyFormat('json')
            ->delete("{$this->endpoint}/1")
            ->assertStatus(Response::HTTP_UNAUTHORIZED); // delete
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this
            ->withBodyFormat('json')
            ->post($this->endpoint, $invalidJsonData)->assertStatus(Response::HTTP_BAD_REQUEST);
        $this
            ->withBodyFormat('json')
            ->put("{$this->endpoint}/{$this->getFirstTaskId()}", $invalidJsonData)->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testItReturnsRequestedData(): void
    {
        $this->get($this->endpoint)->assertOk(); // index
        $this->get("{$this->endpoint}/{$this->getFirstTaskId()}")->assertOk(); // show
    }

    public function testStoreUpdateDelete(): void
    {
        $this->post($this->endpoint, $this->validData())->assertStatus(Response::HTTP_CREATED); // store
        $this->put("{$this->endpoint}/{$this->getFirstTaskId()}", $this->validData())->assertOK(); // update
        $this->delete("{$this->endpoint}/{$this->getFirstTaskId()}")->assertStatus(Response::HTTP_NO_CONTENT); // delete
    }

    private function validData(): array
    {
        return [
            'title'       => 'Something',
            'description' => 'Something',
            'due_date'    => Time::now()->addDays(7)->toDateString(),
            'priority'    => TaskPriorityEnum::cases()[array_rand(TaskPriorityEnum::cases())]->value,
            'is_finished' => (bool) random_int(0, 1),
        ];
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/task.json'), true);
    }

    private function getFirstTaskId(): int
    {
        return (new Task())->where('user_id', $this->userId)->first()->id;
    }
}
