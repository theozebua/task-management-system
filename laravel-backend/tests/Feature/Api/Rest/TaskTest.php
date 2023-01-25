<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Rest;

use App\Constants\TaskPriorityEnum;
use App\Models\Task;
use App\Traits\FakeUser;
use Database\Seeders\Testing\TaskSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, FakeUser;

    private string $endpoint = '/api/tasks';

    public function testUnauthorizedUser(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized(); // index
        $this->postJson($this->endpoint, [])->assertUnauthorized(); // store
        $this->getJson("{$this->endpoint}/1")->assertUnauthorized(); // show
        $this->putJson("{$this->endpoint}/1")->assertUnauthorized(); // update
        $this->deleteJson("{$this->endpoint}/1")->assertUnauthorized(); // delete
    }

    /**
     * @dataProvider provideInvalidJsonData
     */
    public function testItReturnsValidationErrors(array $invalidJsonData): void
    {
        $this->setupData();

        $this->postJson($this->endpoint, $invalidJsonData)->assertUnprocessable();
        $this->putJson("{$this->endpoint}/{$this->getFirstTaskId()}", $invalidJsonData)->assertUnprocessable();
    }

    public function testItHandleValueErrorSuccesful(): void
    {
        $this->setupData();

        $this->postJson($this->endpoint, $this->invalidPriorityValue())->assertStatus(Response::HTTP_BAD_REQUEST); // store
        $this->putJson("{$this->endpoint}/{$this->getFirstTaskId()}", $this->invalidPriorityValue())->assertStatus(Response::HTTP_BAD_REQUEST); // update
    }

    public function testItReturnsRequestedData(): void
    {
        $this->setupData();

        $this->getJson($this->endpoint)->assertOk(); // index
        $this->getJson("{$this->endpoint}/{$this->getFirstTaskId()}")->assertOk(); // show
    }

    public function testStoreUpdateDelete(): void
    {
        $this->setupData();

        $this->postJson($this->endpoint, $this->validData())->assertCreated(); // store
        $this->putJson("{$this->endpoint}/{$this->getFirstTaskId()}", $this->validData())->assertOk(); // update
        $this->deleteJson("{$this->endpoint}/{$this->getFirstTaskId()}")->assertNoContent(); // delete
    }

    public function provideInvalidJsonData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/task.json'), true);
    }

    private function validData(): array
    {
        return [
            'title'       => 'Something',
            'description' => 'Something',
            'due_date'    => now()->addDays(7)->toDateString(),
            'priority'    => collect(TaskPriorityEnum::cases())->random()->value,
        ];
    }

    private function invalidPriorityValue(): array
    {
        return [
            'title'       => 'Something',
            'description' => 'Something',
            'due_date'    => now()->addDays(7)->toDateString(),
            'priority'    => 100,
        ];
    }

    private function setupData(): void
    {
        $this->actingAsFakeUser();
        $this->seed(TaskSeeder::class);
    }

    private function getFirstTaskId(): int
    {
        return Task::whereUserId($this->user->id)->first()->id;
    }
}
