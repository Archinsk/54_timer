<template>
  <div id="timer-full-scalable-container" :class="{ collapsed: settingsMode }">
    <div id="timer-full">
      <AppTimerStatusBar
        :mode="mode"
        :play="play"
        :settings-mode="settingsMode"
        :initial-timer-state="initialTimerState"
      />

      <FitnessTimer
        :auth-user="authUser"
        :initial-timer-state="initialTimerState"
        :config="config"
        :actual="actual"
        :mode="mode"
        :mode-refresher="modeRefresher"
        :play="play"
        :settings-mode="settingsMode"
        :past-time="pastTime"
        @play-toggle="$emit('play-toggle')"
      />

      <AppTimerRepeatsBar
        :current-repeat="currentRepeat"
        :total-repeats="config.selectedTrainingScheme.repeats"
        :current-round="currentRound"
        :total-rounds="config.selectedTrainingScheme.rounds"
      />
    </div>
  </div>
</template>

<script>
import AppTimerStatusBar from "./AppTimerStatusBar";
import FitnessTimer from "./FitnessTimer";
import AppTimerRepeatsBar from "./AppTimerRepeatsBar";
export default {
  name: "AppTimer",
  components: { AppTimerRepeatsBar, FitnessTimer, AppTimerStatusBar },
  props: [
    "authUser",
    "initialTimerState",
    "play",
    "mode",
    "modeRefresher",
    "settingsMode",
    "config",
    "actual",
    "pastTime",
  ],

  computed: {
    currentRepeat: function () {
      return this.config.selectedTrainingScheme.repeats - this.actual.repeats;
    },
    currentRound: function () {
      return this.config.selectedTrainingScheme.rounds - this.actual.rounds;
    },
  },
};
</script>
