import { createContext, ReactNode, useState } from 'react'
import TokenContextContract from '../contracts/contexts/TokenContextContract'
import Http from '../utils/Http'
import Response from '../utils/Response'

type Props = {
  children: ReactNode
}

export const TokenContext = createContext({} as TokenContextContract)

export default ({ children }: Props): JSX.Element => {
  const [token, setToken] = useState(localStorage.getItem('access-token') || '')

  const removeToken = (): void => {
    setToken('')
    localStorage.removeItem('access-token')
  }

  const validateToken = async (): Promise<void> => {
    Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      }
    })

    const res = await Http.get('profile')

    if (res.status === Response.HTTP_UNAUTHORIZED) {
      removeToken()

      return
    }
  }

  return (
    <TokenContext.Provider
      value={{ token, setToken, validateToken, removeToken }}>
      {children}
    </TokenContext.Provider>
  )
}
