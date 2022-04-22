<template>
  <div
    :class="['timer-background bg-primary', settingsMode ? 'active ' : '']"
  ></div>
  <div id="app-container" class="container">
    <div v-if="isLoading" class="loader">
      <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div>Загрузка приложения</div>
    </div>
    <!--  <SchemeSettings />-->

    <div
      v-else
      class="loaded-app h-100 d-flex flex-column justify-content-center align-items-center"
    >
      <TrainingSchemes
        :schemes="schemes"
        :settingsMode="settingsMode"
        @set-training-mode="setTrainingMode"
      />
      <div
        class="btn btn-outline-light rounded-circle btn-settings btn-icon-square"
        @click="settingsToggle"
      >
        <span class="icon-anicons">A</span>
      </div>

      <Transition name="fade-up">
        <div
          v-if="!settingsMode"
          class="markers d-flex justify-content-between mb-4"
        >
          <div
            :class="[
              'border border-light btn btn-outline-light btn-icon-square rounded-circle',
              mode === 'work' ? 'disabled' : 'active',
            ]"
          >
            <span class="material-icons"> self_improvement </span>
          </div>
          <button class="btn btn-outline-light btn-icon-square rounded-circle">
            <span
              :class="['icon-anicons btn-play', play ? 'playing' : '']"
              @click="play = !play"
              >{{ mode === "finish" ? "d" : "H" }}</span
            >
          </button>
          <div
            :class="[
              'border border-light btn btn-outline-light btn-icon-square rounded-circle',
              mode === 'work' ? 'active' : 'disabled',
            ]"
          >
            <span class="material-icons"> directions_bike </span>
          </div>
        </div>
      </Transition>

      <div
        :class="[
          'timer-screen d-flex flex-column align-items-center',
          { 'settings-mode': settingsMode },
        ]"
      >
        <FitnessTimer
          :config="config"
          :actual="actual"
          :mode="mode"
          :play="play"
          :pastTime="pastTime"
        />

        <div class="repeats d-flex justify-content-between">
          <div>
            <div class="repeats-title text-muted">ПОВТОРЫ</div>
            <div class="repeats-value">
              {{ currentRound }} / {{ config.rounds }}
            </div>
          </div>
          <div>
            <div class="repeats-title text-muted">РАУНДЫ</div>
            <div class="repeats-value">
              {{ currentCycle }} / {{ config.cycles }}
            </div>
          </div>
        </div>
      </div>

      <Transition name="fade-up">
        <div v-if="!settingsMode" class="controls">
          <div class="row gx-3">
            <div class="col d-flex">
              <button
                class="btn btn-outline-light col fw-bold"
                @click="play = !play"
              >
                {{ play ? "Пауза" : "Старт" }}
              </button>
            </div>
            <div class="col d-flex">
              <button
                class="btn btn-outline-light col fw-bold"
                @click="resetTimer"
              >
                {{ mode === "finish" ? "Повтор" : "Сброс" }}
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </div>
</template>

<script>
import FitnessTimer from "./components/FitnessTimer.vue";
import TrainingSchemes from "./components/TrainingSchemes";
// import SchemeSettings from "./components/SchemeSettings";

export default {
  name: "App",

  components: {
    TrainingSchemes,
    // SchemeSettings,
    FitnessTimer,
  },

  data() {
    return {
      schemes: [
        {
          id: 1,
          cycles: 1,
          rounds: 5,
          prepTime: 5,
          workTime: 20,
          restTime: 10,
          clearTime: 30,
        },
        {
          id: 2,
          cycles: 2,
          rounds: 3,
          prepTime: 0,
          workTime: 20,
          restTime: 10,
          clearTime: 30,
        },
        {
          id: 3,
          cycles: 1,
          rounds: 3,
          prepTime: 5,
          workTime: 10,
          restTime: 0,
          clearTime: 0,
        },
        {
          id: 4,
          cycles: 1,
          rounds: 5,
          prepTime: 7,
          workTime: 620,
          restTime: 15,
          clearTime: 20,
        },
        {
          id: 5,
          cycles: 2,
          rounds: 10,
          prepTime: 10,
          workTime: 15,
          restTime: 0,
          clearTime: 30,
        },
      ],
      config: {
        cycles: 2,
        rounds: 3,
        prepTime: 5,
        workTime: 10,
        restTime: 10,
        clearTime: 20,
      },
      actual: {
        cycles: 2,
        rounds: 3,
        prepTime: 5,
        workTime: 10,
        restTime: 10,
        clearTime: 20,
      },

      mode: "prep",
      play: false,
      pastTime: 0,

      timerId: null,

      isLoading: true,
      settingsMode: false,
    };
  },

  computed: {
    currentRound: function () {
      return this.config.rounds - this.actual.rounds;
    },
    currentCycle: function () {
      return this.config.cycles - this.actual.cycles;
    },
  },

  methods: {
    countdown() {
      if (this.mode === "prep") {
        if (!this.actual.prepTime) {
          // Таймер подготовки дошел до нуля
          this.actual.rounds--;
          this.actual.cycles--;
          this.mode = "work";
        } else {
          // Таймер подготовки в штатном режиме
          this.actual.prepTime--;
          this.pastTime++;
        }
      } else if (this.mode === "work") {
        // Таймер работы в штатном режиме
        this.actual.workTime--;
        this.pastTime++;
        if (!this.actual.workTime) {
          // Таймер работы дошел до нуля
          if (!this.actual.rounds) {
            // Закончились раунды
            if (!this.actual.cycles) {
              // Закончились циклы
              this.mode = "finish";
              this.play = false;
            } else {
              // Циклы продолжаются
              if (this.config.clearTime) {
                // Установлен перерыв между циклами
                this.mode = "clear";
              } else {
                // Без перерыва между циклами
                this.actual.rounds = this.config.rounds - 1;
                this.actual.cycles--;
              }
              this.actual.workTime = this.config.workTime;
            }
          } else {
            // Раунды продолжаются
            if (this.config.restTime) {
              this.mode = "rest";
            } else {
              this.actual.rounds--;
            }
            this.actual.workTime = this.config.workTime;
          }
        }
      } else if (this.mode === "rest") {
        // Таймер отдыха в штатном режиме
        this.actual.restTime--;
        this.pastTime++;
        if (!this.actual.restTime) {
          // Таймер отдыха дошел до нуля
          this.actual.rounds--;
          this.mode = "work";
          this.actual.restTime = this.config.restTime;
        }
      } else if (this.mode === "clear") {
        // Таймер перерыва в штатном режиме
        this.actual.clearTime--;
        this.pastTime++;
        if (!this.actual.clearTime) {
          // Таймер перерыва дошел до нуля
          this.actual.cycles--;
          this.actual.rounds = this.config.rounds - 1;
          this.mode = "work";
          this.actual.clearTime = this.config.clearTime;
        }
      }
    },

    setTrainingMode(scheme) {
      this.config = Object.assign({}, scheme);
      this.actual = Object.assign({}, scheme);
    },

    resetTimer() {
      this.play = false;
      clearInterval(this.timerId);
      this.mode = "prep";
      this.actual = Object.assign({}, this.config);
      this.pastTime = 0;
    },

    loading() {
      this.isLoading = false;
    },

    settingsToggle() {
      this.settingsMode = !this.settingsMode;
      if (this.settingsMode) {
        this.play = false;
      }
    },
  },

  watch: {
    play: function () {
      if (this.play) {
        this.timerId = setInterval(this.countdown, 1000);
      } else {
        clearInterval(this.timerId);
      }
    },
  },

  mounted() {
    setTimeout(this.loading, 2000);
  },
};
</script>

<style lang="scss">
@font-face {
  font-family: "Material Icons";
  font-style: normal;
  font-weight: 400;
  src: url(./assets/fonts/MaterialIcons-Regular.woff2) format("woff2");
}
#app-container {
  .material-icons {
    font-family: "Material Icons";
    font-weight: normal;
    font-style: normal;
    font-size: 24px; /* Preferred icon size */
    display: inline-block;
    line-height: 1;
    text-transform: none;
    letter-spacing: normal;
    word-wrap: normal;
    white-space: nowrap;
    direction: ltr;

    /* Support for all WebKit browsers. */
    -webkit-font-smoothing: antialiased;
    /* Support for Safari and Chrome. */
    text-rendering: optimizeLegibility;

    /* Support for Firefox. */
    -moz-osx-font-smoothing: grayscale;

    /* Support for IE. */
    font-feature-settings: "liga";
  }

  .icon-anicons {
    font-family: "Anicons", sans-serif;
    font-size: 24px;
    line-height: 1;
    font-variation-settings: "TIME" 1;
    transition: font-variation-settings 0.4s ease;

    &:hover {
      font-family: "Anicons", sans-serif;
      font-variation-settings: "TIME" 100;
    }

    &.btn-play {
      font-variation-settings: "TIME" 1;

      &.playing {
        font-variation-settings: "TIME" 100;
      }
    }
  }

  .btn-icon-square {
    line-height: 0.75;
    padding-left: 0.375rem;
    padding-right: 0.375rem;
  }
}

body {
  overflow: hidden;
}
#app-container {
  position: relative;
  height: 100vh;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;

  .btn-settings {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0.75rem;
  }

  .markers {
    width: 14.125rem;
  }

  .timer-screen {
    height: 21.875rem;
    transition: margin 1s;

    .primary-timer {
      font-size: 4rem;
      height: 6rem;
      transition: all 1s;

      .wrapper {
        display: inline-block;
        position: relative;
        width: 2.07rem;
        height: 6rem;
        transition: width 1s, height 1s;

        .main-digit-divider {
          left: 0.64rem;
          transition: left 1s;
        }
      }
    }

    .secondary-timer {
      font-size: 1.8rem;
      transition: all 1s;
    }

    #svg {
      width: 17rem;
      height: 17rem;
      transition: all 1s;

      circle {
        fill: transparent;
        cx: 8.5rem;
        cy: 8.5rem;
        stroke-width: 0.5rem;
      }

      #progress-track-external {
        stroke: #bc86ef;
        r: 8.25rem;
      }

      #progress-bar-external {
        stroke: var(--bs-light);
        r: 8.25rem;
      }

      #progress-track-internal {
        stroke: #bc86ef;
        r: 7.25rem;
      }

      #progress-bar-internal {
        stroke: var(--bs-light);
        r: 7.25rem;
      }
    }

    .repeats {
      width: 12.5rem;
      margin-top: 1.5rem;

      .repeats-title {
        font-size: 1rem;
        transition: all 1s;
      }

      .repeats-value {
        font-size: 1.25rem;
        transition: all 1s;
      }
    }

    &.settings-mode {
      height: 16.40625rem;
      margin-top: calc(
        100vh - 1.5rem - 16.40625rem - 50vh + 0.75rem + 16.40625rem
      );

      .primary-timer {
        font-size: 3rem;
        height: 4.5rem;

        .wrapper {
          display: inline-block;
          position: relative;
          width: 1.5525rem;
          height: 4.5rem;

          .main-digit-divider {
            left: 0.48rem;
          }
        }
      }

      .secondary-timer {
        font-size: 1.35rem;
      }

      #svg {
        width: 12.75rem;
        height: 12.75rem;
      }

      .repeats {
        transition: all 1s;
        width: 9.375rem;
        margin-top: 1.125rem;

        .repeats-title {
          font-size: 0.75rem;
        }

        .repeats-value {
          font-size: 0.9375rem;
        }
      }
    }
  }

  .controls {
    position: absolute;
    bottom: 0.75rem;
    width: calc(100% - 1.5rem);
  }
}

.timer-background {
  z-index: -1;
  position: absolute;
  bottom: 0;
  left: 0;
  height: 100vh;
  width: 100vw;
  transition: all 1s;

  &.active {
    left: 0.75rem;
    bottom: 0.75rem;
    border-radius: 1rem;
    height: calc(50vh - 0.75rem);
    width: calc(100vw - 1.5rem);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.fade-up-enter-active,
.fade-up-leave-active {
  transition: all 0.5s;
}
.fade-up-enter-from,
.fade-up-leave-to {
  opacity: 0;
  transform: translateY(4rem);
}

.fade-down-enter-active,
.fade-down-leave-active {
  transition: all 0.5s;
}
.fade-down-enter-from,
.fade-down-leave-to {
  opacity: 0;
  transform: translateY(-4rem);
}
</style>
