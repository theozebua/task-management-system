import express, { Request, Response, Router } from 'express'

const route: Router = express.Router()

route.post('/api', (_req: Request, res: Response) => {
  res.json({
    status: true,
    message: 'Success'
  })
})

export default route
