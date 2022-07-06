<template>
  <div class="container">
    <AppLoader v-if="isLoading" />
    <AppSettingsNavbar
      :auth-user="authUser"
      :settings-mode="settingsMode"
      :selected-tab="selectedSettingsTab"
      :selected-sign-form="selectedSignForm"
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
        @select-sign-form="selectedSignForm = $event"
        @select-training-scheme="selectTrainingScheme($event)"
        @change-prep-time="changeTrainingSettings('prepTime', $event)"
        @change-work-time="changeTrainingSettings('workTime', $event)"
        @change-rest-time="changeTrainingSettings('restTime', $event)"
        @change-clear-time="changeTrainingSettings('clearTime', $event)"
        @change-repeats="changeTrainingSettings('repeats', $event)"
        @change-rounds="changeTrainingSettings('rounds', $event)"
        @full-timer-display-toggle="
          config.interface.fullTimerDisplay = !config.interface.fullTimerDisplay
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
        @sign-in="signIn"
        @sign-out="signOut"
      />
    </transition>
    <AppTimer
      :initial-timer-state="initialTimerState"
      :mode="mode"
      :play="play"
      :settings-mode="settingsMode"
      :config="config"
      :actual="actual"
      :past-time="actual.pastTime"
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
      isLoading: true,
      initialTimerState: true,
      authUser: false,
      config: {
        schemes: [
          {
            id: 1,
            name: "Легко",
            prepTime: 5,
            workTime: 20,
            restTime: 10,
            clearTime: 30,
            repeats: 5,
            rounds: 1,
          },
          {
            id: 2,
            name: "Норма",
            prepTime: 5,
            workTime: 20,
            restTime: 10,
            clearTime: 0,
            repeats: 8,
            rounds: 1,
          },
          {
            id: 3,
            name: "Тяжело",
            prepTime: 676,
            workTime: 15,
            restTime: 0,
            clearTime: 30,
            repeats: 10,
            rounds: 2,
          },
        ],
        selectedTrainingScheme: {
          id: 2,
          name: "Норма",
          prepTime: 5,
          workTime: 20,
          restTime: 10,
          clearTime: 0,
          repeats: 8,
          rounds: 1,
        },
        interface: {
          fullTimerDisplay: true,
          colorsDisplay: false,
          timerClickability: false,
          controlsDisplay: true,
        },
        sounds: {
          workMode: 2,
          restMode: 7,
        },
      },
      actual: {
        id: 2,
        name: "Норма",
        pastTime: 0,
        prepTime: 5,
        workTime: 20,
        restTime: 10,
        clearTime: 0,
        repeats: 8,
        rounds: 1,
      },
      schemesEditMode: false,
      mode: "prep",
      play: false,
      settingsMode: false,
      selectedSettingsTab: "trainings",
      selectedSignForm: "signin",
      timerId: null,
    };
  },

  methods: {
    countdown() {
      if (this.mode === "prep") {
        // Таймер подготовки в штатном режиме
        this.actual.prepTime--;
        this.actual.pastTime++;
        if (!this.actual.prepTime) {
          // Таймер подготовки дошел до нуля
          this.actual.repeats--;
          this.actual.rounds--;
          this.mode = "work";
        }
      } else if (this.mode === "work") {
        // Таймер работы в штатном режиме
        this.actual.workTime--;
        this.actual.pastTime++;
        if (!this.actual.workTime) {
          // Таймер работы дошел до нуля
          if (!this.actual.repeats) {
            // Закончились раунды
            if (!this.actual.rounds) {
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
                this.actual.repeats =
                  this.config.selectedTrainingScheme.repeats - 1;
                this.actual.rounds--;
              }
              this.actual.workTime =
                this.config.selectedTrainingScheme.workTime;
            }
          } else {
            // Раунды продолжаются
            if (this.config.selectedTrainingScheme.restTime) {
              this.mode = "rest";
            } else {
              this.actual.repeats--;
            }
            this.actual.workTime = this.config.selectedTrainingScheme.workTime;
          }
        }
      } else if (this.mode === "rest") {
        // Таймер отдыха в штатном режиме
        this.actual.restTime--;
        this.actual.pastTime++;
        if (!this.actual.restTime) {
          // Таймер отдыха дошел до нуля
          this.actual.repeats--;
          this.mode = "work";
          this.actual.restTime = this.config.selectedTrainingScheme.restTime;
        }
      } else if (this.mode === "clear") {
        // Таймер перерыва в штатном режиме
        this.actual.clearTime--;
        this.actual.pastTime++;
        if (!this.actual.clearTime) {
          // Таймер перерыва дошел до нуля
          this.actual.repeats = this.config.selectedTrainingScheme.repeats - 1;
          this.actual.rounds--;
          this.mode = "work";
          this.actual.clearTime = this.config.selectedTrainingScheme.clearTime;
        }
      }
    },

    selectTrainingScheme(scheme) {
      this.config.selectedTrainingScheme = Object.assign({}, scheme);
      this.actual = Object.assign({}, scheme);
    },

    changeTrainingSettings(mode, value) {
      this.config.schemes[this.config.selectedTrainingScheme.id - 1][mode] =
        value;
      this.config.selectedTrainingScheme[mode] = value;
      this.resetTimer();
    },

    resetTimer() {
      this.play = false;
      clearInterval(this.timerId);
      this.mode = "prep";
      this.actual = Object.assign({}, this.config.selectedTrainingScheme);
      this.actual.pastTime = 0;
      this.initialTimerState = true;
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

    signIn() {
      this.authUser = true;
      this.selectedSettingsTab = "trainings";
    },

    signOut() {
      this.authUser = false;
      this.settingsMode = false;
      this.selectedSettingsTab = "trainings";
    },
  },

  watch: {
    play: function () {
      if (this.play) {
        if (this.initialTimerState) {
          this.initialTimerState = false;
        }
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
