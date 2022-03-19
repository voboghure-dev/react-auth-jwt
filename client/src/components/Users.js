import { useState, } from 'react';

export default function Users() {
  const [users, setUsers] = useState();
  return (
    <article>
      <h2>Users List</h2>
      {users?.length ? (
        <ul>
          {users.map((user, i) => {
            <li key={i}>{user?.name}</li>;
          })}
        </ul>
      ) : (
        <p>No users to display</p>
      )}
    </article>
  );
}
