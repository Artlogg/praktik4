function UserCard({ user }) {
  return (
    <li className="user-card">
      <h3>{user.name}</h3>
      <p>
        <strong>Email:</strong> {user.email}
      </p>
      <p>
        <strong>Телефон:</strong> {user.phone}
      </p>
      <p>
        <strong>Компания:</strong> {user.company.name}
      </p>
      <a href={`https://${user.website}`} target="_blank" rel="noreferrer">
        {user.website}
      </a>
    </li>
  );
}

export default UserCard;