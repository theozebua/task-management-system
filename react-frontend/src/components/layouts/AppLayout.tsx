import { ReactNode } from 'react'

type Props = {
  children: ReactNode
}

export default ({ children }: Props): JSX.Element => {
  return (
    <div className='flex h-screen flex-col'>
      <div className='container mx-auto p-4'>{children}</div>
    </div>
  )
}
