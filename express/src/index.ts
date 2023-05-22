import express, { Express } from 'express'
import * as dotenv from 'dotenv'
import route from './routes/web'

dotenv.config()

const app: Express = express()
const baseUrl: string | undefined = process.env.BASE_URL
const port: string | undefined = process.env.PORT

app.use(route)
app.listen(port, () => {
  console.log(`Server run on ${baseUrl}:${port}`)
})
