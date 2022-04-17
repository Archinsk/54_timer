<template>
  <h5>Подготовка</h5>
  <div>{{ prepMinutes }} : {{ prepSeconds }}</div>
  <h5>Работа</h5>
  <div>{{ workMinutes }} : {{ workSeconds }}</div>
  <h5>Отдых</h5>
  <div>{{ restMinutes }} : {{ restSeconds }}</div>
  <h5>Между циклами</h5>
  <div>{{ clearMinutes }} : {{ clearSeconds }}</div>

  <hr />
  <h5>Настройки</h5>
  <ul>
    <li>
      Циклов: <b>{{ config.cycles }}</b>
    </li>
    <li>
      Раундов: <b>{{ config.rounds }}</b>
    </li>
    <li>
      Подготовка: <b>{{ configPrepMinutes }} : {{ configPrepSeconds }}</b>
    </li>
    <li>
      Работа: <b>{{ configWorkMinutes }} : {{ configWorkSeconds }}</b>
    </li>
    <li>
      Отдых: <b>{{ configRestMinutes }} : {{ configRestSeconds }}</b>
    </li>
    <li>
      Между циклами:
      <b>{{ configClearMinutes }} : {{ configClearSeconds }}</b>
    </li>
  </ul>
</template>

<script>
export default {
  name: "SchemeSettings",
};
</script>

<style scoped></style>
