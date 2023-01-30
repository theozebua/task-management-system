export default interface HttpContract {
  get(endpoint: string): Promise<Response>
  post(endpoint: string): Promise<Response>
  put(endpoint: string): Promise<Response>
  patch(endpoint: string): Promise<Response>
  delete(endpoint: string): Promise<Response>
}
