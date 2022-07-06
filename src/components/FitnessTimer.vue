<template>
  <div id="timers-with-progress-bars" @click="timerClick">
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
      <!--      <circle-->
      <!--        v-if="modeTrigger"-->
      <!--        id="progress-bar-internal"-->
      <!--        :stroke-dasharray="strokeLength + 'rem'"-->
      <!--        :stroke-dashoffset="strokeOffset + 'rem'"-->
      <!--        :class="modeColor"-->
      <!--      ></circle>-->
      <!--      <circle-->
      <!--        v-else-->
      <!--        id="progress-bar-internal"-->
      <!--        :stroke-dasharray="strokeLength + 'rem'"-->
      <!--        :stroke-dashoffset="strokeOffset + 'rem'"-->
      <!--        :class="modeColor"-->
      <!--      ></circle>-->
      <FitnessTimerBarInternal
        v-if="modeTrigger"
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
    </svg>

    <div id="timers">
      <div v-if="config.interface.fullTimerDisplay" id="total-timer">
        {{ futureMinutes }} :
        {{ futureSeconds }}
      </div>

      <div id="current-timer">
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

      <div v-if="config.interface.fullTimerDisplay" id="total-time-info">
        {{ totalTimeMinutes }} :
        {{ totalTimeSeconds }}
      </div>
    </div>

    <audio
      id="workMusic"
      volume="0.5"
      :src="'./sounds/' + config.sounds.workMode + '.mp3'"
      type="audio/mpeg"
    ></audio>
    <audio
      id="restMusic"
      volume="0.5"
      :src="'./sounds/' + config.sounds.restMode + '.mp3'"
      type="audio/mpeg"
    ></audio>
  </div>
</template>

<script>
import FitnessTimerBarInternal from "./FitnessTimerBarInternal";
export default {
  name: "FitnessTimer",
  components: { FitnessTimerBarInternal },
  props: ["initialTimerState", "config", "actual", "mode", "play", "pastTime"],
  data() {
    return {
      minutesFirstDigitTrigger: false,
      minutesSecondDigitTrigger: false,
      secondsFirstDigitTrigger: false,
      secondsSecondDigitTrigger: false,

      progressBarRadius: "7.25",
      fullProgressBarRadius: "8.25",

      modeTrigger: true,
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
    progress: function () {
      if (
        this.config.selectedTrainingScheme[this.mode + "Time"] ===
        this.actual[this.mode + "Time"]
      ) {
        return (
          ((this.config.selectedTrainingScheme[this.mode + "Time"] -
            this.actual[this.mode + "Time"]) /
            this.config.selectedTrainingScheme[this.mode + "Time"]) *
          100
        );
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

    progressOfInternal: function () {
      return (
        (2 *
          Math.PI *
          this.progressBarRadius *
          (100 -
            ((this.config.selectedTrainingScheme[this.mode + "Time"] -
              this.actual[this.mode + "Time"] +
              1) /
              this.config.selectedTrainingScheme[this.mode + "Time"]) *
              100)) /
        100
      );
    },

    fullProgress: function () {
      return (this.pastTime / this.totalTime) * 100;
    },
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

    // Цвет шкалы
    modeColor() {
      if (this.config.interface.colorsDisplay) {
        if (this.mode === "prep") {
          return "prep-mode";
        } else if (this.mode === "work") {
          return "work-mode";
        } else if (this.mode === "rest") {
          return "rest-mode";
        } else if (this.mode === "clear") {
          return "clear-mode";
        } else if (this.mode === "finish") {
          return "finish-mode";
        } else {
          return false;
        }
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
          workMusic.play();
        } else {
          workMusic.pause();
          restMusic.play();
        }
      } else {
        restMusic.pause();
        workMusic.pause();
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
      this.modeTrigger = !this.modeTrigger;
    },
    initialTimerState: function () {
      if (!this.initialTimerState) {
        let bar = document.getElementById("progress-bar-internal");
        let val = this.progressOfInternal;
        bar.setAttribute("stroke-dashoffset", val + "rem");
      }
    },
  },

  // mounted() {
  //   let bar = document.getElementById("progress-bar-internal");
  //   let val =
  //     ((this.config.selectedTrainingScheme[this.mode + "Time"] -
  //       this.actual[this.mode + "Time"] +
  //       1) /
  //       this.config.selectedTrainingScheme[this.mode + "Time"]) *
  //     100;
  //   console.log("до изменения");
  //   console.log(bar.getAttribute("strokeDashoffset"));
  //   bar.setAttribute("strokeDashoffset", val);
  // },
};
</script>

<!--stroke - заливка контура-->

<!--пример применения градиента к контуру:-->
<!--<defs>-->
<!--  <linearGradient id="myGradient">-->
<!--    <stop offset="0%"   stop-color="green" />-->
<!--    <stop offset="100%" stop-color="white" />-->
<!--  </linearGradient>-->
<!--</defs>-->

<!--<circle cx="15" cy="5" r="4" fill="none"-->
<!--        stroke="url(#myGradient)" />-->

<!--stroke-dasharray="4 1 2 3" -длина штрихов в формате "штрих пробел штрих пробел"-->
<!--stroke-dashoffset="1" - начало первого штриха на "1" раньше-->
<!--stroke-linecap="round" - закругленное окончание линии-->
<!--stroke-opacity="50%" - прозрачность контура-->
<!--stroke-width="3" - ширина контура-->
