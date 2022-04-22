<template>
  <div class="position-relative">
    <audio id="music" volume="0.5">
      <source src="../assets/sounds/Comsat.mp3" type="audio/mpeg" />
    </audio>
    <div class="position-absolute w-100 h-100">
      <div
        class="d-flex flex-column align-items-center justify-content-center w-100 h-100"
      >
        <div class="secondary-timer text-muted">
          {{ String(futureMinutes).padStart(2, "0") }} :
          {{ String(futureSeconds).padStart(2, "0") }}
        </div>
        <div class="primary-timer fw-bold">
          <div class="wrapper">
            <Transition name="fade-down">
              <div
                v-if="minutesFirstDigitTrigger"
                class="position-absolute main-digit"
              >
                {{ currentMinutesFirstDigit }}
              </div>
              <div v-else class="position-absolute main-digit">
                {{ currentMinutesFirstDigit }}
              </div>
            </Transition>
          </div>
          <div class="wrapper">
            <Transition name="fade-down">
              <div
                v-if="minutesSecondDigitTrigger"
                class="position-absolute main-digit"
              >
                {{ currentMinutesSecondDigit }}
              </div>
              <div v-else class="position-absolute main-digit">
                {{ currentMinutesSecondDigit }}
              </div>
            </Transition>
          </div>
          <div class="wrapper">
            <div class="position-absolute main-digit-divider">:</div>
          </div>
          <div class="wrapper">
            <Transition name="fade-down">
              <div
                v-if="secondsFirstDigitTrigger"
                class="position-absolute main-digit"
              >
                {{ currentSecondsFirstDigit }}
              </div>
              <div v-else class="position-absolute main-digit">
                {{ currentSecondsFirstDigit }}
              </div>
            </Transition>
          </div>
          <div class="wrapper">
            <Transition name="fade-down">
              <div
                v-if="secondsSecondDigitTrigger"
                class="position-absolute main-digit"
              >
                {{ currentSecondsSecondDigit }}
              </div>
              <div v-else class="position-absolute main-digit">
                {{ currentSecondsSecondDigit }}
              </div>
            </Transition>
          </div>
        </div>
        <div class="secondary-timer text-muted">
          {{ String(totalTimeMinutes).padStart(2, "0") }} :
          {{ String(totalTimeSeconds).padStart(2, "0") }}
        </div>
      </div>
    </div>

    <div id="cont">
      <svg
        id="svg"
        viewBox="0 0 272 272"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
      >
        <circle
          id="progress-track-external"
          :r="fullProgressBarRadius + 'rem'"
          :stroke-dasharray="fullStrokeLength + 'rem'"
        ></circle>
        <circle
          id="progress-bar-external"
          :r="fullProgressBarRadius + 'rem'"
          :stroke-dasharray="fullStrokeLength + 'rem'"
          :stroke-dashoffset="fullStrokeOffset + 'rem'"
        ></circle>

        <circle
          id="progress-track-internal"
          :r="progressBarRadius + 'rem'"
          :stroke-dasharray="strokeLength + 'rem'"
        ></circle>
        <circle
          id="progress-bar-internal"
          :r="progressBarRadius + 'rem'"
          :stroke-dasharray="strokeLength + 'rem'"
          :stroke-dashoffset="strokeOffset + 'rem'"
        ></circle>
      </svg>
    </div>
  </div>
</template>

<script>
export default {
  name: "FitnessTimer",
  props: ["config", "actual", "mode", "play", "pastTime"],
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
    progress: function () {
      return (
        ((this.actualModeTime - this.actualModeActualTime) /
          this.actualModeTime) *
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

    // Общее время (в секундах)
    totalTime: function () {
      return (
        this.config.prepTime +
        ((this.config.workTime + this.config.restTime) * this.config.rounds -
          this.config.restTime +
          this.config.clearTime) *
          this.config.cycles -
        this.config.clearTime
      );
    },
    totalTimeMinutes: function () {
      return Math.floor(this.totalTime / 60);
    },
    totalTimeSeconds: function () {
      return this.totalTime % 60;
    },

    // Время в минутах секундах по каждому режиму работы таймера
    configPrepMinutes: function () {
      return Math.floor(this.config.prepTime / 60);
    },
    configPrepSeconds: function () {
      return this.config.prepTime % 60;
    },
    configWorkMinutes: function () {
      return Math.floor(this.config.workTime / 60);
    },
    configWorkSeconds: function () {
      return this.config.workTime % 60;
    },
    configRestMinutes: function () {
      return Math.floor(this.config.restTime / 60);
    },
    configRestSeconds: function () {
      return this.config.restTime % 60;
    },
    configClearMinutes: function () {
      return Math.floor(this.config.clearTime / 60);
    },
    configClearSeconds: function () {
      return this.config.clearTime % 60;
    },

    // Общее время текущего режима
    actualModeTime: function () {
      if (this.mode === "prep") {
        return this.config.prepTime;
      } else if (this.mode === "work") {
        return this.config.workTime;
      } else if (this.mode === "rest") {
        return this.config.restTime;
      } else {
        return this.config.clearTime;
      }
    },
    actualModeActualTime: function () {
      if (this.mode === "prep") {
        return this.actual.prepTime;
      } else if (this.mode === "work") {
        return this.actual.workTime;
      } else if (this.mode === "rest") {
        return this.actual.restTime;
      } else {
        return this.actual.clearTime;
      }
    },

    // Текущие значения таймера в минутах и секундах по каждому режиму работы таймера
    prepMinutes: function () {
      return Math.floor(this.actual.prepTime / 60);
    },
    prepSeconds: function () {
      return this.actual.prepTime % 60;
    },
    workMinutes: function () {
      return Math.floor(this.actual.workTime / 60);
    },
    workSeconds: function () {
      return this.actual.workTime % 60;
    },
    restMinutes: function () {
      return Math.floor(this.actual.restTime / 60);
    },
    restSeconds: function () {
      return this.actual.restTime % 60;
    },
    clearMinutes: function () {
      return Math.floor(this.actual.clearTime / 60);
    },
    clearSeconds: function () {
      return this.actual.clearTime % 60;
    },

    // Текущие значения в минутах и секундах для вывода на главный таймер с учетом текущего режима
    currentMinutes: function () {
      if (this.mode === "prep") {
        return this.prepMinutes;
      } else if (this.mode === "work") {
        return this.workMinutes;
      } else if (this.mode === "rest") {
        return this.restMinutes;
      } else {
        return this.clearMinutes;
      }
    },
    currentSeconds: function () {
      if (this.mode === "prep") {
        return this.prepSeconds;
      } else if (this.mode === "work") {
        return this.workSeconds;
      } else if (this.mode === "rest") {
        return this.restSeconds;
      } else {
        return this.clearSeconds;
      }
    },

    // Первый и второй знак для минутного и секундного значения главного таймера
    currentMinutesFirstDigit: function () {
      return Math.floor(this.currentMinutes / 10);
    },
    currentMinutesFirstDigitNext: function () {
      return (this.currentMinutesFirstDigit + 1) % 10;
    },
    currentMinutesSecondDigit: function () {
      return Math.floor(this.currentMinutes % 10);
    },
    currentMinutesSecondDigitNext: function () {
      return (this.currentMinutesSecondDigit + 1) % 10;
    },
    currentSecondsFirstDigit: function () {
      return Math.floor(this.currentSeconds / 10);
    },
    currentSecondsFirstDigitNext: function () {
      return (this.currentSecondsFirstDigit + 1) % 10;
    },
    currentSecondsSecondDigit: function () {
      return Math.floor(this.currentSeconds % 10);
    },
    currentSecondsSecondDigitNext: function () {
      return (this.currentSecondsSecondDigit + 1) % 10;
    },
    currentTimeArray: function () {
      return [
        { id: 0, value: this.currentMinutesFirstDigit },
        { id: 1, value: this.currentMinutesSecondDigit },
        { id: 2, value: ":" },
        { id: 3, value: this.currentSecondsFirstDigit },
        { id: 4, value: this.currentSecondsSecondDigit },
      ];
    },

    currentRound: function () {
      return this.config.rounds - this.actual.rounds;
    },
    currentCycle: function () {
      return this.config.cycles - this.actual.cycles;
    },

    pastMinutes: function () {
      return Math.floor(this.pastTime / 60);
    },
    pastSeconds: function () {
      return this.pastTime % 60;
    },
    futureTime: function () {
      return this.totalTime - this.pastTime;
    },
    futureMinutes: function () {
      return Math.floor(this.futureTime / 60);
    },
    futureSeconds: function () {
      return this.futureTime % 60;
    },
  },

  watch: {
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
      let music = document.getElementById("music");
      if (this.play) {
        music.play();
      } else {
        music.pause();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.test {
  display: inline-block;
  span {
    display: inline-block;
    width: 2.07rem;
    height: 6rem;
    background-color: orangered;
    font-size: 4rem;
    font-weight: 700;
  }
}

.fade-down-enter-active,
.fade-down-leave-active {
  transition: all 0.5s;
}
.fade-down-enter-from /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(-4rem);
}
.fade-down-leave-to /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(4rem);
}

.time-enter-active,
.time-leave-active {
  transition: all 0.5s;
}
.time-enter-from /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(-4rem);
}
.time-leave-to /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(4rem);
}

#svg circle {
  transition: stroke-dashoffset 1s linear;
}
/*#svg #bar {*/
/*  stroke: #ff9f1e;*/
/*}*/
/*#cont {*/
/*  display: block;*/
/*  height: 200px;*/
/*  width: 200px;*/
/*  margin: 2em auto;*/
/*  box-shadow: 0 0 1em black;*/
/*  border-radius: 100%;*/
/*  position: relative;*/
/*}*/
</style>

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
