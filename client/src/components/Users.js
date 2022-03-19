import { useState, useEffect } from 'react';
import axios from '../api/axios';
import useAuth from '../hooks/useAuth';

export default function Users() {
  const { auth } = useAuth();
  // console.log(auth);
  const [users, setUsers] = useState();

  useEffect(() => {
    let isMounted = true;
    const controller = new AbortController();

    const getUsers = async () => {
      try {
        const response = await axios.get('/users', {
          headers: { Authorization: `Bearer ${auth.token}` },
          signal: controller.signal,
        });
        isMounted && setUsers(response.data);
      } catch (err) {
        console.log(err);
      }
    };

    getUsers();

    return () => {
      isMounted = false;
      controller.abort();
    };
  }, []);

  return (
    <article>
      <h2>Users List</h2>
      {users?.length ? (
        <ul className='user-list'>
          {users.map((user, i) => (
            <li key={i}>{user?.name}</li>
          ))}
        </ul>
      ) : (
        <p>No users to display</p>
      )}
    </article>
  );
}
