export namespace RequestContract {
  export interface SignIn {
    email: string
    password: string
  }

  export interface SignUp {
    name: string
    email: string
    password: string
    password_confirmation: string
  }
}
