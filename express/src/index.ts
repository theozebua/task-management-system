import express, { Express } from 'express'
import route from './routes/web'

const app: Express = express()
const port: number = 8000

app.use(route)
app.listen(port, () => {
  console.log(`Server run on http://localhost:${port}`)
})
