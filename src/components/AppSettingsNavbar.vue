<template>
  <div id="settings-navbar" class="row gx-0">
    <button
      id="btn-settings"
      class="btn border border-light btn-icon-square rounded-circle"
      @click="$emit('settings-toggle')"
    >
      <span :class="['anicons-icons', { 'settings-mode': settingsMode }]"
        >A</span
      >
    </button>

    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-1"
      checked
    />
    <label
      :class="[
        'col settings-navbar-item btn btn-block rounded-pill btn btn-primary btn-icon-square rounded-circle',
        { open: settingsMode },
      ]"
      for="settings-navbar-1"
      @click="$emit('select-settings-tab', 'trainings')"
    >
      <span class="material-icons"> accessibility </span>
      <!--      Режимы-->
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-2"
    />
    <label
      :class="[
        'col settings-navbar-item btn btn-block rounded-pill btn btn-primary btn-icon-square rounded-circle',
        { open: settingsMode },
      ]"
      for="settings-navbar-2"
      @click="$emit('select-settings-tab', 'interface')"
    >
      <span class="material-icons"> settings </span>
      <!--      Интерфейс-->
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-3"
    />
    <label
      :class="[
        'col settings-navbar-item btn btn-block rounded-pill btn btn-primary btn-icon-square rounded-circle',
        { open: settingsMode },
      ]"
      for="settings-navbar-3"
      @click="$emit('select-settings-tab', 'sounds')"
    >
      <span class="material-icons"> music_note </span>
      <!--      Звуки-->
    </label>
    <input
      class="btn-check"
      type="radio"
      name="settings-navbar"
      id="settings-navbar-4"
    />
    <label
      :class="[
        'col settings-navbar-item btn btn-block rounded-pill btn btn-primary btn-icon-square rounded-circle',
        { open: settingsMode },
      ]"
      for="settings-navbar-4"
      @click="$emit('select-settings-tab', 'auth')"
    >
      <span class="material-icons"> logout </span>
      <!--      Выход-->
    </label>
    <div id="settings-navbar-indicator" class="rounded-pill"></div>
  </div>
</template>

<script>
export default {
  name: "AppSettingsNavbar",
  props: ["settingsMode"],
  data() {
    return {
      opened: false,
    };
  },
};
</script>
