import { useRef } from 'react'
import { useNavigate } from 'react-router-dom'

export default (): JSX.Element => {
  const navigate = useNavigate()
  const wrapper = useRef<HTMLDivElement>(null)

  const navigateTo = (url: string) => {
    wrapper.current!.classList.remove('animate__lightSpeedInLeft')
    wrapper.current!.classList.add('animate__lightSpeedOutRight')

    setTimeout(() => {
      navigate(url)
    }, 1000)
  }

  return (
    <div
      className='animate__animated animate__lightSpeedInLeft animate__fast'
      ref={wrapper}>
      <div className='mx-auto mt-20 rounded-lg bg-white p-4 shadow md:max-w-lg'>
        <div className='border-b pb-4'>
          <span className='block text-center font-semibold'>Sign Up</span>
        </div>
        <div>
          <form id='signup-form'>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Name</span>
              <input
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='text'
                autoFocus
              />
            </label>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Email Address</span>
              <input
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='email'
              />
            </label>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Password</span>
              <input
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='password'
              />
            </label>
            <label className='mt-4 block'>
              <span className='mb-2 block'>Confirm Password</span>
              <input
                className='w-full rounded-lg border p-2 outline-none focus:ring-2 focus:ring-gray-200'
                type='password'
              />
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
              className='cursor-pointer font-semibold text-sky-600'
              onClick={() => navigateTo('/signin')}>
              Sign In
            </a>
          </span>
        </div>
      </div>
    </div>
  )
}
