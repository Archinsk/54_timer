<template>
  <div id="timer-full">
    <StatusBar :mode="mode" />

    <FitnessTimer
      :initial-timer-state="initialTimerState"
      :config="config"
      :actual="actual"
      :mode="mode"
      :play="play"
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
</template>

<script>
import StatusBar from "./AppTimerStatusBar";
import FitnessTimer from "./FitnessTimer";
import AppTimerRepeatsBar from "./AppTimerRepeatsBar";
export default {
  name: "AppTimer",
  components: { AppTimerRepeatsBar, FitnessTimer, StatusBar },
  props: [
    "initialTimerState",
    "play",
    "mode",
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
