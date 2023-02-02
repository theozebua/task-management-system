import { ReactNode, useContext, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { TokenContext } from '../../contexts/TokenContext'
import Http from '../../utils/Http'
import { ReactComponent as Logo } from '../../assets/react.svg'

type Props = {
  children: ReactNode
}

export default ({ children }: Props): JSX.Element => {
  const navigate = useNavigate()
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
      <nav className='bg-white shadow'>
        <div className='container mx-auto p-4 md:flex md:justify-between'>
          <div className='flex items-center justify-center gap-x-2 md:justify-start'>
            <Logo className='animate-spin-slow' />
            <span className='font-semibold'>Task Management System</span>
          </div>
          <ul className='hidden md:flex md:gap-x-8'>
            <li className='font-semibold'>
              <Link to={'#'}>Tasks</Link>
            </li>
            <li>
              <Link to={'#'}>Profile</Link>
            </li>
            <li>
              <button onClick={() => signOut()}>Sign Out</button>
            </li>
          </ul>
        </div>
      </nav>
      <div className='container mx-auto p-4'>{children}</div>
    </div>
  )
}
