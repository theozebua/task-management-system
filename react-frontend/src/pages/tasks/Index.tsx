import { useContext, useEffect } from 'react'
import { TokenContext } from '../../contexts/TokenContext'
import Http from '../../utils/Http'

export default (): JSX.Element => {
  const { token, validateToken } = useContext(TokenContext)

  const logout = async (): Promise<void> => {
    Http.setUp({
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      }
    })

    const res = await Http.post('logout')

    if (res.ok) {
      validateToken()
    }
  }

  return (
    <>
      <h1>You logged in.</h1>
      <button
        onClick={() => logout()}
        className='rounded-lg bg-gray-900 px-4 py-2 font-semibold text-gray-100'>
        Logout
      </button>
    </>
  )
}
