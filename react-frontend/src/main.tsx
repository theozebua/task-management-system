import { StrictMode } from 'react'
import ReactDOM from 'react-dom/client'
import { routes } from './routes/web'
import { RouterProvider } from 'react-router-dom'
import 'animate.css'
import './index.css'
import TokenContext from './contexts/TokenContext'

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <StrictMode>
    <TokenContext>
      <RouterProvider router={routes} />
    </TokenContext>
  </StrictMode>
)
