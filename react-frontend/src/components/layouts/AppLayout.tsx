import { ReactNode, useContext, useEffect } from 'react'
import { Link, useLocation, useNavigate } from 'react-router-dom'
import {
  ArrowLeftOnRectangleIcon,
  ListBulletIcon,
  UserIcon
} from '@heroicons/react/24/outline'
import { TokenContext } from '../../contexts/TokenContext'
import Http from '../../utils/Http'
import { ReactComponent as Logo } from '../../assets/react.svg'

type Props = {
  children: ReactNode
}

export default ({ children }: Props): JSX.Element => {
  const navigate = useNavigate()
  const { pathname } = useLocation()
  const { token, validateToken } = useContext(TokenContext)

  const signOut = async (): Promise<void> => {
    const res = await Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      }
    }).post('logout')

    if (res.ok) {
      validateToken()
    }
  }

  const isAuthenticationRoute = (): boolean => {
    return pathname === '/signin' || pathname === '/signup'
  }

  useEffect((): void => {
    if (!token) {
      navigate('/signin')

      return
    }

    validateToken()

    navigate('/')
  }, [token])

  return (
    <div className='flex h-screen flex-col'>
      {!isAuthenticationRoute() && (
        <nav className='bg-white shadow'>
          <div className='container mx-auto p-4 md:flex md:justify-between'>
            <div className='flex items-center justify-center gap-x-2 md:justify-start'>
              <Logo className='animate-spin-slow' />
              <span className='font-semibold'>Task Management System</span>
            </div>
            <ul className='hidden md:flex md:gap-x-8'>
              <li className={`${pathname === '/' && 'font-semibold'}`}>
                <Link to={'/'}>Tasks</Link>
              </li>
              <li className={`${pathname === '/profile' && 'font-semibold'}`}>
                <Link to={'/profile'}>Profile</Link>
              </li>
              <li>
                <button onClick={() => signOut()}>Sign Out</button>
              </li>
            </ul>
          </div>
        </nav>
      )}
      <div className='container mx-auto p-4'>{children}</div>
      {!isAuthenticationRoute() && (
        <nav className='fixed bottom-0 left-0 right-0 bg-white shadow md:hidden'>
          <div className='conainer mx-auto p-4'>
            <ul className='flex items-center justify-between'>
              <li className='rounded-lg p-2'>
                <button onClick={() => signOut()}>
                  <ArrowLeftOnRectangleIcon className='h-6 w-6' />
                </button>
              </li>
              <li
                className={`${
                  pathname === '/' && 'bg-gray-900 text-gray-100'
                } rounded-lg p-2 transition`}>
                <Link to={'/'}>
                  <ListBulletIcon className='h-6 w-6' />
                </Link>
              </li>
              <li
                className={`${
                  pathname === '/profile' && 'bg-gray-900 text-gray-100'
                } rounded-lg p-2 transition`}>
                <Link to={'/profile'}>
                  <UserIcon className='h-6 w-6' />
                </Link>
              </li>
            </ul>
          </div>
        </nav>
      )}
    </div>
  )
}
