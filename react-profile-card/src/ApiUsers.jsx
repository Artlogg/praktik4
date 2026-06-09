import { useEffect, useState } from "react";
import UserCard from "./UserCard.jsx";

const USERS_API_URL = "https://jsonplaceholder.typicode.com/users";

function ApiUsers() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    fetch(USERS_API_URL)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Ошибка ответа API");
        }

        return response.json();
      })
      .then((data) => {
        setUsers(data);
      })
      .catch(() => {
        setError("Ошибка загрузки данных");
      })
      .finally(() => {
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p className="status-message">Загрузка...</p>;
  }

  if (error) {
    return <p className="status-message status-message-error">{error}</p>;
  }

  return (
    <section className="api-section">
      <div className="api-header">
        <p className="eyebrow">Практическая работа 8</p>
        <h2>Пользователи из API</h2>
        <p>
          Данные загружаются с тестового сервиса JSONPlaceholder при открытии
          страницы и сохраняются в состояние React.
        </p>
      </div>

      <ul className="users-list">
        {users.map((user) => (
          <UserCard key={user.id} user={user} />
        ))}
      </ul>
    </section>
  );
}

export default ApiUsers;