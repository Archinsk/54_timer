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
    <template v-if="authUser">
      <input
        class="btn-check"
        type="radio"
        name="settings-navbar"
        id="settings-navbar-1"
        checked
      />
      <label
        :class="[
          'col settings-navbar-item btn btn-icon-square rounded-circle',
          { open: settingsMode },
          { active: selectedTab === 'trainings' },
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
          'col settings-navbar-item btn btn-icon-square rounded-circle',
          { open: settingsMode },
          { active: selectedTab === 'interface' },
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
          'col settings-navbar-item btn btn-icon-square rounded-circle',
          { open: settingsMode },
          { active: selectedTab === 'sounds' },
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
          'col settings-navbar-item btn btn-icon-square rounded-circle',
          { open: settingsMode },
          { active: selectedTab === 'auth' },
        ]"
        for="settings-navbar-4"
        @click="$emit('select-settings-tab', 'auth')"
      >
        <span class="material-icons"> logout </span>
        <!--      Выход-->
      </label>
      <div
        v-if="settingsMode && ballVisibility"
        :class="['navbar-selector', selectorPositionClass]"
      >
        <div class="animated-ball"></div>
      </div>
    </template>
    <template v-else-if="settingsMode">
      <div class="col settings-mode-title">
        {{ settingsModeTitle }}
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "AppSettingsNavbar",
  props: ["authUser", "settingsMode", "selectedTab", "selectedSignForm"],

  data() {
    return {
      ballVisibility: false,
    };
  },

  computed: {
    settingsModeTitle: function () {
      if (this.selectedTab === "trainings") {
        return "Режим тренировки";
      } else if (
        this.selectedTab === "auth" &&
        this.selectedSignForm === "signin"
      ) {
        return "Вход";
      } else {
        return "Регистрация";
      }
    },

    selectorPositionClass: function () {
      if (this.selectedTab === "trainings") {
        return "position-1";
      } else if (this.selectedTab === "interface") {
        return "position-2";
      } else if (this.selectedTab === "sounds") {
        return "position-3";
      } else {
        return "position-4";
      }
    },
  },

  watch: {
    selectedTab: function () {
      if (this.authUser && this.settingsMode) {
        const ball = document.querySelector(".animated-ball");
        ball.classList.remove("animated-ball");
        void ball.offsetWidth;
        ball.classList.add("animated-ball");
      }
    },

    settingsMode: function () {
      if (this.settingsMode) {
        if (this.selectedTab === "trainings") {
          this.ballVisibility = true;
        } else if (this.selectedTab === "interface") {
          setTimeout(this.ballEnableDelay, 200);
        } else if (this.selectedTab === "sounds") {
          setTimeout(this.ballEnableDelay, 400);
        } else {
          setTimeout(this.ballEnableDelay, 600);
        }
      } else {
        this.ballVisibility = false;
      }
    },
  },

  methods: {
    ballEnableDelay() {
      this.ballVisibility = true;
    },
  },
};
</script>
