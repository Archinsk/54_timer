<template>
  <div id="settings-navbar" class="row gx-0">
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-1"
    />
    <label
      class="col settings-navbar-item btn btn-block rounded-pill"
      for="settings-navbar-1"
      @click="$emit('setting-select', 'profile')"
    >
      Выход
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-2"
    />
    <label
      class="col settings-navbar-item btn btn-block rounded-pill"
      for="settings-navbar-2"
      @click="$emit('setting-select', 'interface')"
    >
      Интерфейс
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-3"
    />
    <label
      class="col settings-navbar-item btn btn-block rounded-pill"
      for="settings-navbar-3"
      @click="$emit('setting-select', 'sound')"
    >
      Звуки
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-4"
      checked
    />
    <label
      class="col settings-navbar-item btn btn-block rounded-pill"
      for="settings-navbar-4"
      @click="$emit('setting-select', 'training')"
    >
      Режимы
    </label>
    <div id="settings-navbar-indicator" class="rounded-pill"></div>
  </div>
</template>

<script>
export default {
  name: "SettingsNavbar",
};
</script>
