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

    <RepeatsBar
      :current-repeat="currentRepeat"
      :total-repeats="config.selectedTrainingScheme.rounds"
      :current-round="currentRound"
      :total-rounds="config.selectedTrainingScheme.cycles"
    />
  </div>
</template>

<script>
import StatusBar from "./StatusBar";
import FitnessTimer from "./FitnessTimer";
import RepeatsBar from "./RepeatsBar";
export default {
  name: "AppTimer",
  components: { RepeatsBar, FitnessTimer, StatusBar },
  props: [
    "initialTimerState",
    "play",
    "mode",
    "settingsMode",
    "config",
    "actual",
    "pastTime",
    "currentRepeat",
    "currentRound",
  ],
};
</script>
