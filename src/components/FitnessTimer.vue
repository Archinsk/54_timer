<template>
  <div id="timers-with-progress-bars" @click="timerClick">
    <div
      v-if="settingsMode && config.interface.timerClickability"
      id="clickable-setting"
    ></div>

    <svg
      id="progress"
      viewBox="0 0 272 272"
      version="1.1"
      xmlns="http://www.w3.org/2000/svg"
    >
      <circle
        id="progress-track-external"
        :stroke-dasharray="fullStrokeLength + 'rem'"
      ></circle>
      <circle
        id="progress-bar-external"
        :stroke-dasharray="fullStrokeLength + 'rem'"
        :stroke-dashoffset="fullStrokeOffset + 'rem'"
      ></circle>

      <circle
        id="progress-track-internal"
        :stroke-dasharray="strokeLength + 'rem'"
      ></circle>

      <FitnessTimerBarInternal
        v-if="modeRefresher"
        id="progress-bar-internal"
        :initial-timer-state="initialTimerState"
        :stroke-length="strokeLength"
        :stroke-offset="strokeOffset"
        :mode-color="modeColor"
        :progress-of-internal="progressOfInternal"
      />
      <FitnessTimerBarInternal
        v-else
        id="progress-bar-internal"
        :initial-timer-state="initialTimerState"
        :stroke-length="strokeLength"
        :stroke-offset="strokeOffset"
        :mode-color="modeColor"
        :progress-of-internal="progressOfInternal"
      />
      <FitnessTimerBarInternal
        v-if="authUser && settingsMode && !pastTime"
        id="progress-bar-internal-setting"
        :initial-timer-state="initialTimerState"
        :stroke-length="strokeLength"
        :stroke-offset="strokeLength / 2"
        :mode-color="modeColor"
        :progress-of-internal="progressOfInternal"
      />
    </svg>

    <div id="counters">
      <div v-if="config.interface.fullTimerDisplay" id="total-counter">
        {{ futureMinutes }} :
        {{ futureSeconds }}
      </div>

      <div id="current-counter">
        <div class="current-timer-digit-wrapper">
          <Transition name="fade-down">
            <div v-if="minutesFirstDigitTrigger" class="current-timer-digit">
              {{ currentMinutesFirstDigit }}
            </div>
            <div v-else class="current-timer-digit">
              {{ currentMinutesFirstDigit }}
            </div>
          </Transition>
        </div>
        <div class="current-timer-digit-wrapper">
          <Transition name="fade-down">
            <div v-if="minutesSecondDigitTrigger" class="current-timer-digit">
              {{ currentMinutesSecondDigit }}
            </div>
            <div v-else class="current-timer-digit">
              {{ currentMinutesSecondDigit }}
            </div>
          </Transition>
        </div>
        <div class="current-timer-digit-wrapper">
          <div class="current-timer-digit main-digit-divider">:</div>
        </div>
        <div class="current-timer-digit-wrapper">
          <Transition name="fade-down">
            <div v-if="secondsFirstDigitTrigger" class="current-timer-digit">
              {{ currentSecondsFirstDigit }}
            </div>
            <div v-else class="current-timer-digit">
              {{ currentSecondsFirstDigit }}
            </div>
          </Transition>
        </div>
        <div class="current-timer-digit-wrapper">
          <Transition name="fade-down">
            <div v-if="secondsSecondDigitTrigger" class="current-timer-digit">
              {{ currentSecondsSecondDigit }}
            </div>
            <div v-else class="current-timer-digit">
              {{ currentSecondsSecondDigit }}
            </div>
          </Transition>
        </div>
      </div>

      <div v-if="config.interface.fullTimerDisplay" id="total-counter-info">
        {{ totalTimeMinutes }} :
        {{ totalTimeSeconds }}
      </div>
    </div>

    <audio
      id="workMusic"
      volume="0.5"
      :src="'./sounds/' + config.sounds.workMode + '.mp3'"
      type="audio/mpeg"
      loop
    ></audio>
    <audio
      id="restMusic"
      volume="0.5"
      :src="'./sounds/' + config.sounds.restMode + '.mp3'"
      type="audio/mpeg"
      loop
    ></audio>
  </div>
</template>

<script>
import FitnessTimerBarInternal from "./FitnessTimerBarInternal";
export default {
  name: "FitnessTimer",
  components: { FitnessTimerBarInternal },
  props: [
    "authUser",
    "initialTimerState",
    "config",
    "actual",
    "mode",
    "modeRefresher",
    "play",
    "pastTime",
    "settingsMode",
  ],
  data() {
    return {
      minutesFirstDigitTrigger: false,
      minutesSecondDigitTrigger: false,
      secondsFirstDigitTrigger: false,
      secondsSecondDigitTrigger: false,

      progressBarRadius: "7.25",
      fullProgressBarRadius: "8.25",
    };
  },

  computed: {
    // Статический таймер общего времени
    totalTime: function () {
      return (
        this.config.selectedTrainingScheme.prepTime +
        ((this.config.selectedTrainingScheme.workTime +
          this.config.selectedTrainingScheme.restTime) *
          this.config.selectedTrainingScheme.repeats -
          this.config.selectedTrainingScheme.restTime +
          this.config.selectedTrainingScheme.clearTime) *
          this.config.selectedTrainingScheme.rounds -
        this.config.selectedTrainingScheme.clearTime
      );
    },
    totalTimeMinutes: function () {
      return this.timeToPeriod(this.totalTime, "min");
    },
    totalTimeSeconds: function () {
      return this.timeToPeriod(this.totalTime, "sec");
    },

    // Динамический таймер общего оставшегося времени
    futureTime: function () {
      return this.totalTime - this.pastTime;
    },
    futureMinutes: function () {
      return this.timeToPeriod(this.futureTime, "min");
    },
    futureSeconds: function () {
      return this.timeToPeriod(this.futureTime, "sec");
    },

    // Первый и второй знак для минутного и секундного значения главного таймера
    currentMinutesFirstDigit: function () {
      if (this.mode === "finish") {
        return "0";
      } else {
        return this.timeToPeriod(this.actual[this.mode + "Time"], "min")[0];
      }
    },
    currentMinutesSecondDigit: function () {
      if (this.mode === "finish") {
        return "0";
      } else {
        return this.timeToPeriod(this.actual[this.mode + "Time"], "min")[1];
      }
    },
    currentSecondsFirstDigit: function () {
      if (this.mode === "finish") {
        return "0";
      } else {
        return this.timeToPeriod(this.actual[this.mode + "Time"], "sec")[0];
      }
    },
    currentSecondsSecondDigit: function () {
      if (this.mode === "finish") {
        return "0";
      } else {
        return this.timeToPeriod(this.actual[this.mode + "Time"], "sec")[1];
      }
    },

    // Круговая шкала таймера
    // Вспомогательные значения прогресса в процентах, необходимы для вычисления смещения штриха в круговых шкалах прогресса
    progress: function () {
      if (this.mode === "finish") {
        return 100;
      }
      if (
        this.config.selectedTrainingScheme[this.mode + "Time"] ===
        this.actual[this.mode + "Time"]
      ) {
        return 0;
      } else {
        return (
          ((this.config.selectedTrainingScheme[this.mode + "Time"] -
            this.actual[this.mode + "Time"] +
            1) /
            this.config.selectedTrainingScheme[this.mode + "Time"]) *
          100
        );
      }
    },
    fullProgress: function () {
      if (this.futureTime === this.totalTime) {
        return 0;
      } else if (this.pastTime === this.totalTime) {
        return 100;
      } else {
        return ((this.pastTime + 1) / this.totalTime) * 100;
      }
    },

    // Длины и смещение штрихов в круговых шкалах таймера
    strokeLength: function () {
      return 2 * Math.PI * this.progressBarRadius;
    },
    strokeOffset: function () {
      return (
        (2 * Math.PI * this.progressBarRadius * (100 - this.progress)) / 100
      );
    },
    fullStrokeLength: function () {
      return 2 * Math.PI * this.fullProgressBarRadius;
    },
    fullStrokeOffset: function () {
      return (
        (2 * Math.PI * this.fullProgressBarRadius * (100 - this.fullProgress)) /
        100
      );
    },
    // Первый шаг круговых шкал для активации JS при старте и смене режимов
    progressOfInternal: function () {
      return (
        2 *
        Math.PI *
        this.progressBarRadius *
        (1 - 1 / this.config.selectedTrainingScheme[this.mode + "Time"])
      );
    },
    progressOfExternal: function () {
      return (
        2 * Math.PI * this.fullProgressBarRadius * (1 - 1 / this.totalTime)
      );
    },

    // Цвет шкалы
    modeColor() {
      if (this.config.interface.colorsDisplay) {
        return this.mode + "-mode";
      } else {
        return false;
      }
    },
  },

  methods: {
    timeToPeriod(timeInSec, period) {
      if (period === "min") {
        return String(Math.floor(timeInSec / 60)).padStart(2, "0");
      }
      if (period === "sec") {
        return String(timeInSec % 60).padStart(2, "0");
      }
      return null;
    },

    timerClick() {
      if (this.config.interface.timerClickability) {
        this.$emit("play-toggle");
      }
    },

    musicPlay() {
      let workMusic = document.getElementById("workMusic");
      let restMusic = document.getElementById("restMusic");
      if (this.play) {
        if (this.mode === "work") {
          restMusic.pause();
          restMusic.currentTime = 0;
          workMusic.play();
        } else {
          workMusic.pause();
          workMusic.currentTime = 0;
          restMusic.play();
        }
      } else {
        restMusic.pause();
        workMusic.pause();
        if (this.mode === "finish") {
          restMusic.currentTime = 0;
          workMusic.currentTime = 0;
        }
      }
    },
  },

  watch: {
    // Смена знаков главного таймера
    currentMinutesFirstDigit: function () {
      this.minutesFirstDigitTrigger = !this.minutesFirstDigitTrigger;
    },
    currentMinutesSecondDigit: function () {
      this.minutesSecondDigitTrigger = !this.minutesSecondDigitTrigger;
    },
    currentSecondsFirstDigit: function () {
      this.secondsFirstDigitTrigger = !this.secondsFirstDigitTrigger;
    },
    currentSecondsSecondDigit: function () {
      this.secondsSecondDigitTrigger = !this.secondsSecondDigitTrigger;
    },
    play: function () {
      this.musicPlay();
    },
    mode: function () {
      this.musicPlay();
    },
    initialTimerState: function () {
      if (!this.initialTimerState) {
        let bar = document.getElementById("progress-bar-internal");
        let val = this.progressOfInternal;
        console.log(this.progressOfInternal);
        bar.setAttribute("stroke-dashoffset", val + "rem");
        let barExt = document.getElementById("progress-bar-external");
        let valExt = this.progressOfExternal;
        barExt.setAttribute("stroke-dashoffset", valExt + "rem");
      }
    },
  },
};
</script>
