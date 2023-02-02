export namespace ValidationErrorsContract {
  interface General {
    message: string
  }

  export namespace Authentication {
    export namespace SignIn {
      export interface Response extends General {
        errors: Errors
      }

      export interface Errors {
        email: string[]
        password: string[]
      }
    }

    export namespace SignUp {
      export interface Response extends General {
        errors: Errors
      }

      export interface Errors {
        name: string[]
        email: string[]
        password: string[]
        password_confirmation: string[]
      }
    }
  }

  export namespace User {
    export interface Response extends General {
      errors: Errors
    }

    export interface Errors {
      current_password: string[]
      password: string[]
      password_confirmation: string[]
    }
  }
}
