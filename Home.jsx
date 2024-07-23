import React from 'react';
import { Link } from 'react-router-dom';
import { useQuery, getSlotMachines } from 'wasp/client/operations';

const HomePage = () => {
  const { data: slotMachines, isLoading, error } = useQuery(getSlotMachines);

  if (isLoading) return 'Loading...';
  if (error) return 'Error: ' + error;

  return (
    <div className='p-4'>
      {slotMachines.map((slotMachine) => (
        <Link
          key={slotMachine.id}
          to={`/slot-machine/${slotMachine.id}`}
          className='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2'
        >
          {slotMachine.name}
        </Link>
      ))}
    </div>
  );
}

export default HomePage;