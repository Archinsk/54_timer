<template>
  <!--  <SchemeSettings />-->
  <TrainingSchemes
    :schemes="schemes"
    :settingsMode="settingsMode"
    @set-training-mode="setTrainingMode"
  />
  <div
    class="btn btn-outline-light rounded-circle btn-settings"
    @click="settingsMode = !settingsMode"
  >
    <span class="icon">A</span>
  </div>

  <FitnessTimer
    :config="config"
    :actual="actual"
    :mode="mode"
    :play="play"
    :pastTime="pastTime"
  />

  <button class="btn btn-light fw-bold mx-2" @click="play = !play">
    {{ play ? "Пауза" : "Старт" }}
  </button>
  <button class="btn btn-outline-light fw-bold mx-2" @click="resetTimer">
    {{ mode === "finish" ? "Повтор" : "Сброс" }}
  </button>
  <div :class="[settingsMode ? 'active ' : '', 'trans ']"></div>
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
          prepTime: 5,
          workTime: 40,
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

      settingsMode: false,
    };
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
};
</script>

<style lang="scss">
body {
  background: radial-gradient(
    circle,
    rgba(138, 43, 226, 1) 0%,
    rgba(86, 20, 148, 1) 100%
  ) !important;
  overflow: hidden;
}

.btn-settings {
  position: absolute;
  top: 0;
  right: 0;

  .icon {
    font-family: "Anicons", sans-serif;
    font-variation-settings: "TIME" 1;
    transition: font-variation-settings 0.4s ease;
  }
  .icon:hover {
    font-family: "Anicons", sans-serif;
    font-variation-settings: "TIME" 100;
  }
}

.trans {
  z-index: -1;
  position: absolute;
  bottom: 0;
  left: 0;
  background-color: darkblue;
  width: 100%;
  height: 100%;
  transition: all 2s;

  &.active {
    left: 12%;
    bottom: 5%;
    border-radius: 2rem;
    height: 50%;
    width: 76%;
  }
}
</style>
