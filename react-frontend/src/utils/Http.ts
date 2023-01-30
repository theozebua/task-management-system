import HttpContract from '../contracts/utils/HttpContract'

export default new (class implements HttpContract {
  private init: RequestInit = {}

  public async get(endpoint: string): Promise<Response> {
    return await this.send(endpoint, 'GET')
  }

  public async post(endpoint: string): Promise<Response> {
    return await this.send(endpoint, 'POST')
  }

  public async put(endpoint: string): Promise<Response> {
    return await this.send(endpoint, 'PUT')
  }

  public async patch(endpoint: string): Promise<Response> {
    return await this.send(endpoint, 'PATCH')
  }

  public async delete(endpoint: string): Promise<Response> {
    return await this.send(endpoint, 'DELETE')
  }

  public setUp(init: RequestInit): void {
    this.init = init
  }

  private async send(endpoint: string, method: string): Promise<Response> {
    return await fetch(import.meta.env.VITE_API_BASE_URL + endpoint, {
      method,
      ...this.init
    })
  }
})()
