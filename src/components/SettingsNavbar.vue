<template>
  <div id="settings-navbar" class="row gx-0">
    <div class="col settings-navbar-item">
      <input
        class="btn-check"
        type="radio"
        name="settings-navbar"
        id="settings-navbar-1"
        checked
      />
      <label class="btn btn-block rounded-pill" for="settings-navbar-1">
        Профиль
      </label>
    </div>
    <div class="col settings-navbar-item">
      <input
        class="btn-check"
        type="radio"
        name="settings-navbar"
        id="settings-navbar-2"
      />
      <label class="btn btn-block rounded-pill" for="settings-navbar-2">
        Интерфейс
      </label>
    </div>
    <div class="col settings-navbar-item">
      <input
        class="btn-check"
        type="radio"
        name="settings-navbar"
        id="settings-navbar-3"
      />
      <label class="btn btn-block rounded-pill" for="settings-navbar-3">
        Звуки
      </label>
    </div>
    <div class="col settings-navbar-item">
      <input
        class="btn-check"
        type="radio"
        name="settings-navbar"
        id="settings-navbar-4"
      />
      <label class="btn btn-block rounded-pill" for="settings-navbar-4">
        Режимы
      </label>
    </div>
    <div id="settings-navbar-indicator" class="rounded-pill"></div>
  </div>
</template>

<script>
export default {
  name: "SettingsNavbar",
};
</script>
