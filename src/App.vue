<template>
  <LoaderCustom v-if="isLoading" :loader-text="loaderText" full-screen />
  <div v-if="!isLoading" class="container">
    <div id="settings-panel">
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
          @sign-in="signIn"
          @sign-out="signOut"
        />
      </transition>
    </div>
    <div
      v-if="settingsMode"
      id="settings-backdrop"
      @click="settingsMode = false"
    ></div>
    <AppTimer
      :initial-timer-state="initialTimerState"
      :mode="mode"
      :mode-refresher="modeRefresher"
      :play="play"
      :settings-mode="settingsMode"
      :config="config"
      :actual="actual"
      :past-time="pastTime"
      @play-toggle="play = !play"
    />
    <AppControls
      v-if="config.interface.controlsDisplay && !settingsMode"
      :play="play"
      :mode="mode"
      :initial-timer-state="initialTimerState"
      @play-toggle="play = !play"
      @reset-timer="resetTimer"
    />
  </div>
  <div id="timer-background" :class="{ collapsed: settingsMode }"></div>
</template>

<script>
import LoaderCustom from "./components/universal/LoaderCustom";
import AppSettings from "./components/AppSettings";
import AppControls from "./components/AppControls";
import AppTimer from "./components/AppTimer";
import AppSettingsNavbar from "./components/AppSettingsNavbar";
import axios from "axios";

export default {
  name: "App",

  components: {
    LoaderCustom,
    AppSettingsNavbar,
    AppTimer,
    AppControls,
    AppSettings,
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
          workTime: 5,
          restTime: 5,
          clearTime: 5,
          repeats: 3,
          rounds: 3,
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
        prepTime: 5,
        workTime: 5,
        restTime: 5,
        clearTime: 5,
        repeats: 3,
        rounds: 3,
      },
      pastTime: 0,
      schemesEditMode: false,
      mode: "prep",
      modeRefresher: false,
      play: false,
      settingsMode: false,
      selectedSettingsTab: "trainings",
      selectedSignForm: "signin",
      loaderText: "Загрузка приложения",
      timerId: null,
    };
  },

  methods: {
    countdown() {
      if (this.mode === "prep") {
        // Таймер подготовки в штатном режиме
        this.actual.prepTime--;
        this.pastTime++;
        if (!this.actual.prepTime) {
          // Таймер подготовки дошел до нуля
          this.actual.repeats--;
          this.actual.rounds--;
          this.mode = "work";
          this.actual.prepTime = this.config.selectedTrainingScheme.prepTime;
          this.modeRefresher = !this.modeRefresher;
        }
      } else if (this.mode === "work") {
        // Таймер работы в штатном режиме
        this.actual.workTime--;
        this.pastTime++;
        if (!this.actual.workTime) {
          // Таймер работы дошел до нуля
          if (!this.actual.repeats) {
            // Закончились повторы
            if (!this.actual.rounds) {
              // Закончились раунды
              this.mode = "finish";
              this.play = false;
            } else {
              // Раунды продолжаются
              if (this.config.selectedTrainingScheme.clearTime) {
                // Установлен перерыв между раундами
                this.mode = "clear";
                this.modeRefresher = !this.modeRefresher;
              } else {
                // Без перерыва между раундами
                this.actual.repeats =
                  this.config.selectedTrainingScheme.repeats - 1;
                this.actual.rounds--;
                this.modeRefresher = !this.modeRefresher;
              }
              this.actual.workTime =
                this.config.selectedTrainingScheme.workTime;
            }
          } else {
            // Повторы продолжаются
            if (this.config.selectedTrainingScheme.restTime) {
              this.mode = "rest";
            } else {
              this.actual.repeats--;
            }
            this.actual.workTime = this.config.selectedTrainingScheme.workTime;
            this.modeRefresher = !this.modeRefresher;
          }
        }
      } else if (this.mode === "rest") {
        // Таймер отдыха в штатном режиме
        this.actual.restTime--;
        this.pastTime++;
        if (!this.actual.restTime) {
          // Таймер отдыха дошел до нуля
          this.actual.repeats--;
          this.mode = "work";
          this.actual.restTime = this.config.selectedTrainingScheme.restTime;
          this.modeRefresher = !this.modeRefresher;
        }
      } else if (this.mode === "clear") {
        // Таймер перерыва в штатном режиме
        this.actual.clearTime--;
        this.pastTime++;
        if (!this.actual.clearTime) {
          // Таймер перерыва дошел до нуля
          this.actual.repeats = this.config.selectedTrainingScheme.repeats - 1;
          this.actual.rounds--;
          this.mode = "work";
          this.actual.clearTime = this.config.selectedTrainingScheme.clearTime;
          this.modeRefresher = !this.modeRefresher;
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
      this.actual = Object.assign({}, this.config.selectedTrainingScheme);
      this.pastTime = 0;
      if (!this.config.selectedTrainingScheme.prepTime) {
        this.mode = "work";
        this.actual.repeats = this.config.selectedTrainingScheme.repeats - 1;
        this.actual.rounds = this.config.selectedTrainingScheme.rounds - 1;
      } else {
        this.mode = "prep";
      }
      this.modeRefresher = !this.modeRefresher;
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

    checkAuth() {
      axios
        .post(this.url + "checkauth.php", JSON.stringify({ id: 0 }))
        .then((response) => {
          if (response.data.user.id) {
            this.signIn();
          }
        });
    },

    signIn() {
      this.getSettings();
      this.authUser = true;
      this.selectedSettingsTab = "trainings";
    },

    signOut() {
      this.authUser = false;
      this.settingsMode = false;
      this.selectedSettingsTab = "trainings";
    },

    setSettings() {
      axios
        .post(this.url + "settingsupdate.php", JSON.stringify(this.config))
        .then((response) => {
          console.log(response);
        });
    },

    getSettings() {
      axios
        .post(this.url + "settingsread.php", JSON.stringify(this.config))
        .then((response) => {
          console.log(response);
          this.config = response.data.config;
          this.actual = Object.assign(
            {},
            response.data.config.selectedTrainingScheme
          );
        });
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

    settingsMode: function () {
      if (this.authUser && !this.settingsMode) {
        this.setSettings();
        this.loaderText = "Сохранение настроек";
        this.isLoading = true;
        setTimeout(this.loading, 3000);
      }
    },
  },

  created() {
    if (!this.config.selectedTrainingScheme.prepTime) {
      this.mode = "work";
      this.actual.repeats = this.config.selectedTrainingScheme.repeats - 1;
      this.actual.rounds = this.config.selectedTrainingScheme.rounds - 1;
    }
  },

  mounted() {
    setTimeout(this.loading, 3000);
    this.checkAuth();
  },
};
</script>
