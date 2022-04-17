<template>
  <!--  <SchemeSettings />-->
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
</template>

<script>
import FitnessTimer from "./components/FitnessTimer.vue";
// import SchemeSettings from "./components/SchemeSettings";

export default {
  name: "App",

  components: {
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
      this.config = scheme;
      this.cycles = scheme.cycles;
      this.rounds = scheme.rounds;
      this.prepTime = scheme.prepTime;
      this.workTime = scheme.workTime;
      this.restTime = scheme.restTime;
      this.clearTime = scheme.clearTime;
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

<style lang="scss"></style>
