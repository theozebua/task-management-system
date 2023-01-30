import { Dispatch, SetStateAction } from 'react'

export default interface TokenContextContract {
  token: string
  setToken: Dispatch<SetStateAction<string>>
  validateToken: () => Promise<void>
  removeToken: () => void
}
