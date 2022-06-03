<template>
  <div class="container">
    <AppLoader v-if="isLoading" />

    <div>
      <AppSettingsNavbar
        :settings-mode="settingsMode"
        :selectedTab="selectedSettingsTab"
        @settings-toggle="settingsToggle"
        @select-settings-tab="selectedSettingsTab = $event"
      />

      <transition name="fade-in-up">
        <AppSettings
          v-if="settingsMode"
          :url="url"
          :auth-user="authUser"
          :config="config"
          :selectedTab="selectedSettingsTab"
          @select-settings-tab="selectedSettingsTab = $event"
          @full-timer-display-toggle="
            config.interface.fullTimerDisplay =
              !config.interface.fullTimerDisplay
          "
          @color-display-toggle="
            config.interface.colorsDisplay = !config.interface.colorsDisplay
          "
          @timer-clickability-toggle="
            config.interface.timerClickability =
              !config.interface.timerClickability
          "
          @controls-display-toggle="
            config.interface.controlsDisplay = !config.interface.controlsDisplay
          "
          @set-work-mode-sound="config.sounds.workMode = $event"
          @set-rest-mode-sound="config.sounds.restMode = $event"
          @select-training-scheme="selectTrainingScheme($event)"
          @sign-in="signIn"
          @sign-out="signOut"
          @change-prep-time="config.selectedTrainingScheme.prepTime = $event"
          @change-work-time="config.selectedTrainingScheme.workTime = $event"
          @change-rest-time="config.selectedTrainingScheme.restTime = $event"
          @change-clear-time="config.selectedTrainingScheme.clearTime = $event"
          @change-rounds="config.selectedTrainingScheme.rounds = $event"
          @change-cycles="config.selectedTrainingScheme.cycles = $event"
        />
      </transition>
    </div>
    <AppTimer
      :mode="mode"
      :play="play"
      :settings-mode="settingsMode"
      :config="config"
      :actual="actual"
      :past-time="pastTime"
      :current-repeat="currentRound"
      :current-round="currentCycle"
      @play-toggle="play = !play"
    />
    <AppControls
      v-if="config.interface.controlsDisplay"
      :play="play"
      :mode="mode"
      @play-toggle="play = !play"
      @reset-timer="resetTimer"
    />
  </div>
</template>

<script>
import AppLoader from "./components/AppLoader";
import AppSettings from "./components/AppSettings";
import AppControls from "./components/AppControls";
import AppTimer from "./components/AppTimer";
import AppSettingsNavbar from "./components/AppSettingsNavbar";

export default {
  name: "App",

  components: {
    AppSettingsNavbar,
    AppTimer,
    AppControls,
    AppSettings,
    AppLoader,
  },

  data() {
    return {
      url: "https://www.d-skills.ru/54_timer/php/",
      config: {
        cycles: 2,
        rounds: 3,
        prepTime: 5,
        workTime: 10,
        restTime: 10,
        clearTime: 20,

        schemes: [
          {
            id: 1,
            name: "Легко",
            cycles: 1,
            rounds: 5,
            prepTime: 5,
            workTime: 20,
            restTime: 10,
            clearTime: 30,
          },
          {
            id: 2,
            name: "Норма",
            cycles: 1,
            rounds: 8,
            prepTime: 5,
            workTime: 20,
            restTime: 10,
            clearTime: 0,
          },
          {
            id: 3,
            name: "Тяжело",
            cycles: 2,
            rounds: 10,
            prepTime: 676,
            workTime: 15,
            restTime: 0,
            clearTime: 30,
          },
        ],
        selectedTrainingScheme: {
          id: 2,
          name: "Норма",
          cycles: 1,
          rounds: 8,
          prepTime: 5,
          workTime: 20,
          restTime: 10,
          clearTime: 0,
        },
        interface: {
          fullTimerDisplay: true,
          colorsDisplay: false,
          timerClickability: false,
          controlsDisplay: true,
        },
        sounds: {
          workMode: 2,
          restMode: 8,
        },
      },
      actual: {
        id: 3,
        name: "Нормальный",
        cycles: 1,
        rounds: 8,
        prepTime: 5,
        workTime: 20,
        restTime: 10,
        clearTime: 0,
      },

      mode: "prep",
      play: false,
      pastTime: 0,

      timerId: null,

      isLoading: true,
      settingsMode: false,
      authUser: false,
      selectedSetting: "training",
      signMode: "signin",
      schemesEditMode: false,
      selectedSettingsTab: "trainings",
    };
  },

  computed: {
    currentRound: function () {
      return this.config.selectedTrainingScheme.rounds - this.actual.rounds;
    },
    currentCycle: function () {
      return this.config.selectedTrainingScheme.cycles - this.actual.cycles;
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
              if (this.config.selectedTrainingScheme.clearTime) {
                // Установлен перерыв между циклами
                this.mode = "clear";
              } else {
                // Без перерыва между циклами
                this.actual.rounds =
                  this.config.selectedTrainingScheme.rounds - 1;
                this.actual.cycles--;
              }
              this.actual.workTime =
                this.config.selectedTrainingScheme.workTime;
            }
          } else {
            // Раунды продолжаются
            if (this.config.selectedTrainingScheme.restTime) {
              this.mode = "rest";
            } else {
              this.actual.rounds--;
            }
            this.actual.workTime = this.config.selectedTrainingScheme.workTime;
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
          this.actual.restTime = this.config.selectedTrainingScheme.restTime;
        }
      } else if (this.mode === "clear") {
        // Таймер перерыва в штатном режиме
        this.actual.clearTime--;
        this.pastTime++;
        if (!this.actual.clearTime) {
          // Таймер перерыва дошел до нуля
          this.actual.rounds = this.config.selectedTrainingScheme.rounds - 1;
          this.actual.cycles--;
          this.mode = "work";
          this.actual.clearTime = this.config.selectedTrainingScheme.clearTime;
        }
      }
    },

    selectTrainingScheme(scheme) {
      this.config.selectedTrainingScheme = Object.assign({}, scheme);
      this.actual = Object.assign({}, scheme);
    },

    resetTimer() {
      this.play = false;
      clearInterval(this.timerId);
      this.mode = "prep";
      this.actual = Object.assign({}, this.config.selectedTrainingScheme);
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

    openProfile(signMode) {
      this.selectedSetting = "profile";
      this.signMode = signMode;
    },

    signIn() {
      this.authUser = true;
      this.settingsMode = false;
    },

    signOut() {
      this.authUser = false;
      this.settingsMode = false;
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
