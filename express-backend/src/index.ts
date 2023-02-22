import express, { Express } from 'express'
import dotenv from 'dotenv'
import router from './routes/api'

dotenv.config()

const app: Express = express()
const port: number = parseInt(process.env.APP_PORT!)

app.use('/api', router)

app.listen(port, () => {
  console.log(`Server running on ${process.env.APP_URL}:${port}`)
})
