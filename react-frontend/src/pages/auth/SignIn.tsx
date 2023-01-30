import _ from 'lodash'
import { FormEvent, useContext, useEffect, useRef, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { TokenContext } from '../../contexts/TokenContext'
import { ValidationErrorsContract } from '../../contracts/ValidationErrorsContract'
import { RequestContract } from '../../contracts/RequestContract'
import { ResponseContract } from '../../contracts/ResponseContract'
import Http from '../../utils/Http'
import Response from '../../utils/Response'
import Swal from 'sweetalert2'

export default (): JSX.Element => {
  const navigate = useNavigate()
  const wrapper = useRef<HTMLDivElement>(null)
  const { setToken } = useContext(TokenContext)

  const emailRef = useRef<HTMLInputElement>(null)
  const passwordRef = useRef<HTMLInputElement>(null)

  const [response, setResponse] = useState({} as ResponseContract.SignIn)
  const [errors, setErrors] = useState(
    {} as ValidationErrorsContract.SignIn.Errors
  )

  const navigateTo = (url: string): void => {
    wrapper.current!.classList.remove('animate__lightSpeedInLeft')
    wrapper.current!.classList.add('animate__lightSpeedOutRight')

    setTimeout((): void => {
      navigate(url)
    }, 1000)
  }

  const signIn = async (e: FormEvent<HTMLFormElement>): Promise<void> => {
    e.preventDefault()

    const credentials: RequestContract.SignIn = {
      email: emailRef.current!.value,
      password: passwordRef.current!.value
    }

    Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(credentials)
    })

    const res = await Http.post('login')

    if (res.status === Response.HTTP_UNPROCESSABLE_ENTITY) {
      const validationErrors: ValidationErrorsContract.SignIn.Response =
        await res.json()

      setErrors({
        email: validationErrors.errors.email,
        password: validationErrors.errors.password
      } as ValidationErrorsContract.SignIn.Errors)

      return
    }

    setResponse((await res.json()) as ResponseContract.SignIn)
  }

  useEffect((): void => {
    if (!_.isEmpty(response) && !response.status) {
      setErrors({} as ValidationErrorsContract.SignIn.Errors)
      Swal.fire({
        title: 'Error',
        icon: 'error',
        text: response.message
      })

      return
    }

    if (!_.isEmpty(response) && response.token) {
      setToken(response.token)
      localStorage.setItem('access-token', response.token)
    }
  }, [response])

  return (
    <div
      ref={wrapper}
      className='animate__animated animate__lightSpeedInLeft animate__fast'>
      <div className='mx-auto mt-20 rounded-lg bg-white p-4 shadow md:max-w-lg'>
        <div className='border-b pb-4'>
          <span className='block text-center font-semibold'>Sign In</span>
        </div>
        <div>
          <form
            onSubmit={(e) => signIn(e)}
            id='signin-form'>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Email Address</span>
              <input
                ref={emailRef}
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='email'
                autoFocus
              />
              {errors.email && (
                <small className='text-red-600'>{errors.email}</small>
              )}
            </label>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Password</span>
              <input
                ref={passwordRef}
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='password'
              />
              {errors.password && (
                <small className='text-red-600'>{errors.password}</small>
              )}
            </label>
          </form>
        </div>
        <div className='mt-4'>
          <button
            className='block w-full rounded-lg bg-gray-900 px-4 py-2 font-semibold text-gray-100'
            form='signin-form'>
            Sign In
          </button>
          <span className='mt-4 flex flex-col text-center'>
            Do not have an account yet?
            <a
              onClick={() => navigateTo('/signup')}
              className='cursor-pointer font-semibold text-sky-600'>
              Sign Up
            </a>
          </span>
        </div>
      </div>
    </div>
  )
}
