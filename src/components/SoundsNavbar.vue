<template>
  <div id="sounds-navbar" class="row gx-0">
    <input
      class="btn-check"
      type="radio"
      name="sounds-navbar"
      id="sounds-navbar-1"
      checked
    />
    <label
      class="col sounds-navbar-item btn btn-block rounded-pill"
      for="sounds-navbar-1"
      @click="$emit('sound-select', 'work')"
    >
      Работа
    </label>
    <input
      class="btn-check"
      type="radio"
      name="sounds-navbar"
      id="sounds-navbar-2"
    />
    <label
      class="col sounds-navbar-item btn btn-block rounded-pill"
      for="sounds-navbar-2"
      @click="$emit('sound-select', 'rest')"
    >
      Отдых
    </label>
    <div id="sounds-navbar-indicator" class="rounded-pill"></div>
  </div>
</template>

<script>
export default {
  name: "SoundsNavbar",
};
</script>

<style scoped></style>
