import ProfileCard from "./ProfileCard.jsx";

function App() {
  const student = {
    name: "Кадыров Артур Рустамович",
    specialty: "Клиент-серверные приложения и сетевые технологии",
    group: "БИВТ-24-4",
    description:
      "Учебная визитка студента, созданная на React. Компонент показывает основную информацию и позволяет загрузить изображение для аватарки.",
  };

  return (
    <main className="app">
      <ProfileCard student={student} />
    </main>
  );
}

export default App;