<template>
  <div class="container">
    <div
      :class="['timer-background bg-primary', settingsMode ? 'active ' : '']"
    ></div>

    <button
      id="btn-settings"
      class="btn border border-light btn-icon-square rounded-circle"
      @click="settingsToggle"
    >
      <span :class="['anicons-icons', { 'settings-mode': settingsMode }]"
        >A</span
      >
    </button>

    <SchemeSettings />

    <SignInForm />

    <SignUpForm />
    <!--  <div id="app-container" class="container">-->
    <!--    <div v-if="isLoading" class="loader">-->
    <!--      <div class="spinner-border text-light" role="status">-->
    <!--        <span class="visually-hidden">Loading...</span>-->
    <!--      </div>-->
    <!--      <div>Загрузка приложения</div>-->
    <!--    </div>-->

    <!--    <div-->
    <!--      v-else-->
    <!--      class="loaded-app h-100 d-flex flex-column justify-content-center align-items-center"-->
    <!--    >-->
    <TrainingSchemes
      :schemes="schemes"
      :settingsMode="settingsMode"
      @set-training-mode="setTrainingMode"
    />

    <div id="timer-full">
      <StatusBar
        :mode="mode"
        :play="play"
        :settings-mode="settingsMode"
        @play-toggle="play = !play"
      />

      <!--        <div-->
      <!--          :class="[-->
      <!--            'timer-screen d-flex flex-column align-items-center',-->
      <!--            { 'settings-mode': settingsMode },-->
      <!--          ]"-->
      <!--        >-->
      <FitnessTimer
        :config="config"
        :actual="actual"
        :mode="mode"
        :play="play"
        :pastTime="pastTime"
      />

      <RepeatsBar
        :current-repeat="currentRound"
        :total-repeats="config.rounds"
        :currentRound="currentCycle"
        :totalRounds="config.cycles"
      />
    </div>
    <!--      </div>-->

    <!--      <Transition name="fade-up">-->

    <!--    v-if="!settingsMode"-->
    <div id="controls" class="row gx-3">
      <div class="col">
        <button class="btn btn-outline-light btn-control" @click="play = !play">
          {{ play ? "ПАУЗА" : "СТАРТ" }}
        </button>
      </div>
      <div class="col">
        <button class="btn btn-outline-light btn-control" @click="resetTimer">
          {{ mode === "finish" ? "ПОВТОР" : "СБРОС" }}
        </button>
      </div>
    </div>

    <!--    <div class="container">-->
    <!--      <div class="row row-cols-2 gx-2">-->
    <!--        <button class="btn btn-primary col" type="button">Кнопка</button>-->
    <!--        <button class="btn btn-primary col" type="button">Кнопка</button>-->
    <!--      </div>-->
    <!--    </div>-->

    <!--      </Transition>-->
    <!--    </div>-->
    <!--  </div>-->
  </div>
</template>

<script>
import SchemeSettings from "./components/SchemeSettings";
import TrainingSchemes from "./components/TrainingSchemes";
import StatusBar from "./components/StatusBar";
import FitnessTimer from "./components/FitnessTimer.vue";
import RepeatsBar from "./components/RepeatsBar";
import SignInForm from "./components/SignInForm";
import SignUpForm from "./components/SignUpForm";

export default {
  name: "App",

  components: {
    SchemeSettings,
    SignUpForm,
    SignInForm,
    TrainingSchemes,
    StatusBar,
    FitnessTimer,
    RepeatsBar,
  },

  data() {
    return {
      schemes: [
        {
          id: 1,
          name: "ЛЁГКИЙ",
          cycles: 1,
          rounds: 5,
          prepTime: 5,
          workTime: 20,
          restTime: 10,
          clearTime: 30,
        },
        {
          id: 2,
          name: "ОБЛЕГЧЁННЫЙ",
          cycles: 2,
          rounds: 3,
          prepTime: 0,
          workTime: 20,
          restTime: 10,
          clearTime: 30,
        },
        {
          id: 3,
          name: "НОРМАЛЬНЫЙ",
          cycles: 1,
          rounds: 3,
          prepTime: 5,
          workTime: 10,
          restTime: 0,
          clearTime: 0,
        },
        {
          id: 4,
          name: "УТЯЖЕЛЕННЫЙ",
          cycles: 1,
          rounds: 5,
          prepTime: 7,
          workTime: 620,
          restTime: 15,
          clearTime: 20,
        },
        {
          id: 5,
          name: "ТЯЖЕЛЫЙ",
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
      settingsMode: true,
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
