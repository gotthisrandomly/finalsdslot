import React from 'react';
import { useQuery, useAction, getTransactions } from 'wasp/client/operations';
import { Link } from 'react-router-dom';

const TransactionsPage = () => {
  const { data: transactions, isLoading, error } = useQuery(getTransactions);

  if (isLoading) return 'Loading...';
  if (error) return 'Error: ' + error;

  return (
    <div className='p-4'>
      {transactions.map((transaction) => (
        <div key={transaction.id} className='flex items-center justify-between bg-gray-100 p-4 mb-4 rounded-lg'>
          <div>{transaction.amount}</div>
          <div>{transaction.type}</div>
          <div>{transaction.dateTime}</div>
        </div>
      ))}
    </div>
  );
}

export default TransactionsPage;