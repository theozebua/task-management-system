import { createBrowserRouter } from 'react-router-dom'
import AppLayout from '../components/layouts/AppLayout'
import SignIn from '../pages/auth/SignIn'
import SignUp from '../pages/auth/SignUp'
import Index from '../pages/tasks/Index'

export const routes = createBrowserRouter([
  {
    path: '/',
    element: (
      <AppLayout>
        <Index />
      </AppLayout>
    )
  },
  {
    path: '/signin',
    element: (
      <AppLayout>
        <SignIn />
      </AppLayout>
    )
  },
  {
    path: '/signup',
    element: (
      <AppLayout>
        <SignUp />
      </AppLayout>
    )
  }
])
