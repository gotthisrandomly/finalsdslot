import { HttpError } from 'wasp/server'

export const depositFunds = async (args, context) => {
  if (!context.user) { throw new HttpError(401) };
  const user = await context.entities.User.findUnique({
    where: { id: context.user.id }
  });
  const updatedUser = await context.entities.User.update({
    where: { id: context.user.id },
    data: { balance: user.balance + args.amount }
  });
  const newTransaction = await context.entities.Transaction.create({
    data: {
      amount: args.amount,
      userId: context.user.id,
      type: 'deposit'
    }
  });
  return updatedUser;
}

export const withdrawFunds = async (args, context) => {
  if (!context.user) { throw new HttpError(401) };

  const user = await context.entities.User.findUnique({
    where: { id: context.user.id }
  });

  if (user.balance < args.amount) { throw new HttpError(400, 'Insufficient funds') };

  const updatedUser = await context.entities.User.update({
    where: { id: context.user.id },
    data: { balance: { decrement: args.amount } }
  });

  return context.entities.Transaction.create({
    data: {
      amount: args.amount,
      userId: context.user.id,
      type: 'withdrawal'
    }
  });
}

export const playGame = async (args, context) => {
  if (!context.user) { throw new HttpError(401) };

  const user = await context.entities.User.findUnique({
    where: { id: context.user.id }
  });
  const slotMachine = await context.entities.SlotMachine.findUnique({
    where: { id: args.slotMachineId }
  });

  const wager = args.wager;
  if (wager <= 0 || wager > user.balance) { throw new HttpError(400, 'Invalid wager amount') };

  const win = Math.random() < slotMachine.rtpRate ? wager * 2 : 0;

  await context.entities.User.update({
    where: { id: context.user.id },
    data: { balance: { decrement: wager }, transactions: { create: { amount: -wager, type: 'bet' } } }
  });

  await context.entities.Game.create({
    data: { user: { connect: { id: context.user.id } }, slotMachine: { connect: { id: args.slotMachineId } }, wager, win }
  });

  if (win > 0) {
    await context.entities.User.update({
      where: { id: context.user.id },
      data: { balance: { increment: win }, transactions: { create: { amount: win, type: 'win' } } }
    });
  }

  return { win };
}

export const approveCashout = async (args, context) => {
  if (!context.user) { throw new HttpError(401) };
  const user = await context.entities.User.findUnique({
    where: { id: args.userId }
  });
  if (!user) { throw new HttpError(404, 'User not found') };
  user.balance += args.amount;
  await context.entities.User.update({
    where: { id: args.userId },
    data: { balance: user.balance }
  });
  await context.entities.Transaction.create({
    data: {
      amount: args.amount,
      userId: args.userId,
      type: 'cashout'
    }
  });
}