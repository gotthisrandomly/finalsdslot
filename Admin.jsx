import React from 'react';
import { Link } from 'react-router-dom';
import { useQuery, useAction, getTransactions, approveCashout } from 'wasp/client/operations';

const AdminPage = () => {
  const { data: transactions, isLoading, error } = useQuery(getTransactions);
  const approveCashoutFn = useAction(approveCashout);

  if (isLoading) return 'Loading...';
  if (error) return 'Error: ' + error;

  return (
    <div className='p-4'>
      {transactions.map((transaction) => (
        <div key={transaction.id} className='flex items-center justify-between bg-gray-100 p-4 mb-4 rounded-lg'>
          <div>{transaction.amount}</div>
          <div>{transaction.type}</div>
          <div>
            <button
              onClick={() => approveCashoutFn({ userId: transaction.userId, amount: transaction.amount })}
              className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
              Approve Cashout
            </button>
          </div>
        </div>
      ))}
    </div>
  );
}

export default AdminPage;