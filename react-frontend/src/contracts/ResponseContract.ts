export namespace ResponseContract {
  interface General {
    status: boolean
  }

  export namespace Authentication {
    export interface SignIn extends General {
      message?: string
      token?: string
    }

    export interface SignUp extends General {
      user: object
      token: string
    }
  }
}
