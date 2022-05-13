<template>
  <AppSettingsNavbar
    v-if="authUser"
    @select-settings-tab="selectedTab = $event"
  />
  <AppSettingsTabAuth
    v-if="selectedTab === 'auth'"
    :auth-user="authUser"
    :sign-mode="signMode"
    :url="url"
    @open-auth-tab="openAuthTab($event)"
    @sign-in="$emit('sign-in')"
    @sign-out="$emit('sign-out')"
  />
  <AppSettingsTabInterface
    v-show="selectedTab === 'interface'"
    :config="config.interface"
    @full-timer-display-toggle="$emit('full-timer-display-toggle')"
    @color-display-toggle="$emit('color-display-toggle')"
    @timer-clickability-toggle="$emit('timer-clickability-toggle')"
    @controls-display-toggle="$emit('controls-display-toggle')"
  />
  <AppSettingsTabSounds
    v-show="selectedTab === 'sounds'"
    :config="config.interface"
    @set-work-mode-sound="$emit('set-work-mode-sound', $event)"
    @set-rest-mode-sound="$emit('set-rest-mode-sound', $event)"
  />
  <AppSettingsTabTrainings
    v-show="selectedTab === 'trainings'"
    :auth-user="authUser"
    :config="config"
    @select-training-scheme="$emit('select-training-scheme', $event)"
    @open-auth-tab="openAuthTab($event)"
  />
</template>

<script>
import AppSettingsNavbar from "./AppSettingsNavbar";
import AppSettingsTabAuth from "./AppSettingsTabAuth";
import AppSettingsTabInterface from "./AppSettingsTabInterface";
import AppSettingsTabSounds from "./AppSettingsTabSounds";
import AppSettingsTabTrainings from "./AppSettingsTabTrainings";
export default {
  name: "AppSettings",
  components: {
    AppSettingsTabTrainings,
    AppSettingsTabSounds,
    AppSettingsTabInterface,
    AppSettingsTabAuth,
    AppSettingsNavbar,
  },
  props: ["authUser", "config", "url"],

  data() {
    return {
      selectedTab: "trainings",
      signMode: "signin",
    };
  },

  methods: {
    openAuthTab(signMode) {
      console.log("Сработало");
      this.selectedTab = "auth";
      this.signMode = signMode;
    },
  },
};
</script>
