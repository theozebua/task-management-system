import _ from 'lodash'
import { FormEvent, useContext, useEffect, useRef, useState } from 'react'
import Swal from 'sweetalert2'
import { TokenContext } from '../../contexts/TokenContext'
import { RequestContract } from '../../contracts/RequestContract'
import { ResponseContract } from '../../contracts/ResponseContract'
import { ValidationErrorsContract } from '../../contracts/ValidationErrorsContract'
import Http from '../../utils/Http'
import Response from '../../utils/Response'

export default (): JSX.Element => {
  const { token } = useContext(TokenContext)

  const currentPasswordRef = useRef<HTMLInputElement>(null)
  const newPasswordRef = useRef<HTMLInputElement>(null)
  const confirmNewPasswordRef = useRef<HTMLInputElement>(null)

  const [response, setResponse] = useState(
    {} as ResponseContract.User.ChangePassword
  )
  const [errors, setErrors] = useState(
    {} as ValidationErrorsContract.User.Errors
  )

  const changePassword = async (
    e: FormEvent<HTMLFormElement>
  ): Promise<void> => {
    e.preventDefault()

    const data: RequestContract.User.ChangePassword = {
      current_password: currentPasswordRef.current!.value,
      password: newPasswordRef.current!.value,
      password_confirmation: confirmNewPasswordRef.current!.value
    }

    const res = await Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      },
      body: JSON.stringify(data)
    }).post('change-password')

    if (res.status === Response.HTTP_UNPROCESSABLE_ENTITY) {
      const validationErrors: ValidationErrorsContract.User.Response =
        await res.json()

      setErrors({
        current_password: validationErrors.errors.current_password,
        password: validationErrors.errors.password,
        password_confirmation: validationErrors.errors.password_confirmation
      } as ValidationErrorsContract.User.Errors)

      return
    }

    setResponse((await res.json()) as ResponseContract.User.ChangePassword)
  }

  useEffect(() => {
    if (!_.isEmpty(response) && response.status) {
      Swal.fire({
        title: 'Success',
        icon: 'success',
        text: response.message,
        timer: 2000
      })

      setErrors({} as ValidationErrorsContract.User.Errors)
      currentPasswordRef.current!.value = ''
      currentPasswordRef.current!.focus()
      newPasswordRef.current!.value = ''
      confirmNewPasswordRef.current!.value = ''
    }
  }, [response])

  return (
    <>
      <div>
        <span className='mb-2 block font-semibold'>Change Password</span>
        <div className='rounded-lg bg-white p-4 shadow'>
          <form
            onSubmit={(e) => changePassword(e)}
            className='flex flex-col gap-y-4'>
            <label className='block'>
              <span className='mb-2 block'>Current Password</span>
              <input
                ref={currentPasswordRef}
                className='form-input'
                type='password'
                autoFocus
              />
              {errors.current_password && (
                <small className='text-red-600'>
                  {errors.current_password}
                </small>
              )}
            </label>
            <label className='block'>
              <span className='mb-2 block'>New Password</span>
              <input
                ref={newPasswordRef}
                className='form-input'
                type='password'
              />
              {errors.password && (
                <small className='text-red-600'>{errors.password}</small>
              )}
            </label>
            <label className='block'>
              <span className='mb-2 block'>Confirm New Password</span>
              <input
                ref={confirmNewPasswordRef}
                className='form-input'
                type='password'
              />
              {errors.password_confirmation && (
                <small className='text-red-600'>
                  {errors.password_confirmation}
                </small>
              )}
            </label>
            <div className='flex justify-end'>
              <button className='btn btn-dark'>Save</button>
            </div>
          </form>
        </div>
      </div>
    </>
  )
}
