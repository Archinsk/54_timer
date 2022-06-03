<template>
  <div class="settings">
    <transition name="fade-in-right" mode="out-in">
      <!--      Работало при v-show-->
      <AppSettingsTabTrainings
        v-if="selectedTab === 'trainings'"
        :auth-user="authUser"
        :config="config"
        @change-auth-form="changeAuthForm($event)"
        @select-training-scheme="$emit('select-training-scheme', $event)"
        @change-prep-time="$emit('change-prep-time', $event)"
        @change-work-time="$emit('change-work-time', $event)"
        @change-rest-time="$emit('change-rest-time', $event)"
        @change-clear-time="$emit('change-clear-time', $event)"
        @change-rounds="$emit('change-rounds', $event)"
        @change-cycles="$emit('change-cycles', $event)"
      />
      <!--      Работало при v-show-->
      <AppSettingsTabInterface
        v-else-if="selectedTab === 'interface'"
        :config="config.interface"
        @full-timer-display-toggle="$emit('full-timer-display-toggle')"
        @color-display-toggle="$emit('color-display-toggle')"
        @timer-clickability-toggle="$emit('timer-clickability-toggle')"
        @controls-display-toggle="$emit('controls-display-toggle')"
      />
      <!--      Работало при v-show-->
      <AppSettingsTabSounds
        v-else-if="selectedTab === 'sounds'"
        :config="config.sounds"
        @set-work-mode-sound="$emit('set-work-mode-sound', $event)"
        @set-rest-mode-sound="$emit('set-rest-mode-sound', $event)"
      />
      <AppSettingsTabAuth
        v-else-if="selectedTab === 'auth'"
        :auth-user="authUser"
        :sign-mode="signMode"
        :url="url"
        @change-auth-form="changeAuthForm($event)"
        @select-settings-tab="$emit('select-settings-tab', $event)"
        @sign-in="$emit('sign-in')"
        @sign-out="$emit('sign-out')"
      />
    </transition>
  </div>
</template>

<script>
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
  },
  props: ["authUser", "config", "url", "selectedTab"],

  data() {
    return {
      signMode: "signin",
    };
  },

  methods: {
    changeAuthForm(signMode) {
      this.$emit("select-settings-tab", "auth");
      this.signMode = signMode;
    },
  },
};
</script>
