export namespace RequestContract {
  export namespace Authentication {
    interface General {
      email: string
      password: string
    }

    export interface SignIn extends General {}

    export interface SignUp extends General {
      name: string
      password_confirmation: string
    }
  }

  export namespace User {
    export interface ChangePassword {
      current_password: string
      password: string
      password_confirmation: string
    }
  }
}
