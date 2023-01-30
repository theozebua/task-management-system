import { ReactNode, useContext, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { TokenContext } from '../../contexts/TokenContext'

type Props = {
  children: ReactNode
}

export default ({ children }: Props): JSX.Element => {
  const navigate = useNavigate()
  const { token, validateToken } = useContext(TokenContext)

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
      <div className='container mx-auto p-4'>{children}</div>
    </div>
  )
}
