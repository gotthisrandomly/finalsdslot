import { HttpError } from 'wasp/server'

export const getUser = async ({ id }, context) => {
  if (!context.user) { throw new HttpError(401) };

  const user = await context.entities.User.findUnique({
    where: { id },
    select: {
      id: true,
      username: true,
      balance: true,
      transactions: true,
      Game: true
    }
  });

  if (!user) throw new HttpError(404, 'No user with id ' + id);

  return user;
}

export const getTransactions = async ({ userId }, context) => {
  if (!context.user) { throw new HttpError(401) };
  return context.entities.Transaction.findMany({
    where: { userId }
  });
}

export const getGames = async (args, context) => {
  if (!context.user) { throw new HttpError(401) }

  return context.entities.Game.findMany({
    where: { userId: context.user.id }
  });
}

export const getSlotMachines = async (args, context) => {
  if (!context.user) { throw new HttpError(401) }

  return context.entities.SlotMachine.findMany();
}