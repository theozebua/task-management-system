import { PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()

async function main(): Promise<void> {
  await prisma.user.upsert({
    where: { email: 'user@gmail.com' },
    update: {},
    create: {
      email: 'user@gmail.com',
      name: 'user',
      password: '$2a$12$x6hd7uu4Hl2QHcBXtN7JiuyILt/PY6sTlRPAzmIeQyxGrMMf2vfSq'
    }
  })
}

main()
  .then(async () => {
    await prisma.$disconnect()
  })
  .catch(async (e: Error) => {
    console.log(e)

    await prisma.$disconnect()

    process.exit(1)
  })
