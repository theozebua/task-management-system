import _ from 'lodash'
import { FormEvent, useContext, useEffect, useRef, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { TokenContext } from '../../contexts/TokenContext'
import { RequestContract } from '../../contracts/RequestContract'
import { ResponseContract } from '../../contracts/ResponseContract'
import { ValidationErrorsContract } from '../../contracts/ValidationErrorsContract'
import Http from '../../utils/Http'
import Response from '../../utils/Response'

export default (): JSX.Element => {
  const navigate = useNavigate()
  const wrapper = useRef<HTMLDivElement>(null)
  const { setToken } = useContext(TokenContext)

  const nameRef = useRef<HTMLInputElement>(null)
  const emailRef = useRef<HTMLInputElement>(null)
  const passwordRef = useRef<HTMLInputElement>(null)
  const passwordConfirmationRef = useRef<HTMLInputElement>(null)

  const [response, setResponse] = useState(
    {} as ResponseContract.Authentication.SignUp
  )
  const [errors, setErrors] = useState(
    {} as ValidationErrorsContract.Authentication.SignUp.Errors
  )

  const navigateTo = (url: string): void => {
    wrapper.current!.classList.remove('animate__lightSpeedInLeft')
    wrapper.current!.classList.add('animate__lightSpeedOutRight')

    setTimeout((): void => {
      navigate(url)
    }, 1000)
  }

  const signUp = async (e: FormEvent<HTMLFormElement>): Promise<void> => {
    e.preventDefault()

    const registerData: RequestContract.Authentication.SignUp = {
      name: nameRef.current!.value,
      email: emailRef.current!.value,
      password: passwordRef.current!.value,
      password_confirmation: passwordConfirmationRef.current!.value
    }

    const res = await Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(registerData)
    }).post('register')

    if (res.status === Response.HTTP_UNPROCESSABLE_ENTITY) {
      const validationErrors: ValidationErrorsContract.Authentication.SignUp.Response =
        await res.json()

      setErrors({
        name: validationErrors.errors.name,
        email: validationErrors.errors.email,
        password: validationErrors.errors.password,
        password_confirmation: validationErrors.errors.password_confirmation
      } as ValidationErrorsContract.Authentication.SignUp.Errors)

      return
    }

    setResponse((await res.json()) as ResponseContract.Authentication.SignUp)
  }

  useEffect((): void => {
    if (!_.isEmpty(response) && response.token) {
      setToken(response.token)
      localStorage.setItem('access-token', response.token)
    }
  }, [response])

  return (
    <div
      className='animate__animated animate__lightSpeedInLeft animate__fast'
      ref={wrapper}>
      <div className='mx-auto mt-20 rounded-lg bg-white p-4 shadow md:max-w-lg'>
        <div className='border-b pb-4'>
          <span className='block text-center font-semibold'>Sign Up</span>
        </div>
        <div>
          <form
            onSubmit={(e) => signUp(e)}
            id='signup-form'>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Name</span>
              <input
                ref={nameRef}
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='text'
                autoFocus
              />
              {errors.name && (
                <small className='text-red-600'>{errors.name}</small>
              )}
            </label>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Email Address</span>
              <input
                ref={emailRef}
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='email'
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
            <label className='mt-4 block'>
              <span className='mb-2 block'>Confirm Password</span>
              <input
                ref={passwordConfirmationRef}
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='password'
              />
              {errors.password_confirmation && (
                <small className='text-red-600'>
                  {errors.password_confirmation}
                </small>
              )}
            </label>
          </form>
        </div>
        <div className='mt-4'>
          <button
            className='block w-full rounded-lg bg-gray-900 px-4 py-2 font-semibold text-gray-100'
            form='signup-form'>
            Sign Up
          </button>
          <span className='mt-4 flex flex-col text-center'>
            Already have an account?
            <a
              onClick={(): void => navigateTo('/signin')}
              className='cursor-pointer font-semibold text-sky-600'>
              Sign In
            </a>
          </span>
        </div>
      </div>
    </div>
  )
}
