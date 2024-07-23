import React from 'react';
import { useParams } from 'react-router-dom';
import { useQuery, useAction, playGame, getGames } from 'wasp/client/operations';

const SlotMachinePage = () => {
  const { id } = useParams();
  const { data: games, isLoading, error } = useQuery(getGames);
  const playGameFn = useAction(playGame);

  if (isLoading) return 'Loading...';
  if (error) return 'Error: ' + error;

  const handlePlayGame = (slotMachineId, wager) => {
    playGameFn({ slotMachineId, wager });
  };

  const slotMachine = games.find(game => game.id === parseInt(id));

  return (
    <div className='p-4'>
      <h1 className='text-2xl font-bold mb-4'>{slotMachine.name}</h1>
      <p>RTP Rate: {slotMachine.rtpRate}</p>
      <button onClick={() => handlePlayGame(slotMachine.id, 10)} className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4'>Play Game</button>
    </div>
  );
}

export default SlotMachinePage;