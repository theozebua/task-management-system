export namespace ResponseContract {
  export interface SignIn {
    status: boolean
    message?: string
    token?: string
  }

  export interface SignUp {
    status: boolean
    user: object
    token: string
  }
}
