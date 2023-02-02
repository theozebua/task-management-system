import { createBrowserRouter } from 'react-router-dom'
import AppLayout from '../components/layouts/AppLayout'
import SignIn from '../pages/auth/SignIn'
import SignUp from '../pages/auth/SignUp'
import Tasks from '../pages/tasks/Index'
import User from '../pages/users/Index'

export const routes = createBrowserRouter([
  {
    path: '/',
    element: (
      <AppLayout>
        <Tasks />
      </AppLayout>
    )
  },
  {
    path: '/profile',
    element: (
      <AppLayout>
        <User />
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
