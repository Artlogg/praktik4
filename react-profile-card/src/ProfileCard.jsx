import { useState } from "react";

function ProfileCard({ student }) {
  const [avatar, setAvatar] = useState("");

  const handleAvatarChange = (event) => {
    const file = event.target.files[0];

    if (file) {
      setAvatar(URL.createObjectURL(file));
    }
  };

  return (
    <section className="profile-card">
      <h1>Моя визитка</h1>

      <div className="avatar-box">
        {avatar ? (
          <img className="avatar" src={avatar} alt="Аватар студента" />
        ) : (
          <div className="avatar-placeholder">Фото</div>
        )}
      </div>

      <label className="upload-label" htmlFor="avatarInput">
        Загрузить изображение для аватарки
      </label>
      <input
        id="avatarInput"
        className="upload-input"
        type="file"
        accept="image/*"
        onChange={handleAvatarChange}
      />

      <h2>{student.name}</h2>

      <ul className="student-list">
        <li>
          <strong>Специальность:</strong> {student.specialty}
        </li>
        <li>
          <strong>Группа:</strong> {student.group}
        </li>
      </ul>

      <p>{student.description}</p>
    </section>
  );
}

export default ProfileCard;