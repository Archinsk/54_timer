<template>
  <div id="interface-settings">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-6">
        <!--        Минималистичный режим вырезан из-за недостатка места на экране мобильных устройств-->
        <!--        <div class="form-check form-switch">-->
        <!--          <input-->
        <!--            class="form-check-input"-->
        <!--            type="checkbox"-->
        <!--            role="switch"-->
        <!--            id="minimal-mode"-->
        <!--            :checked="minimalMode"-->
        <!--            @click="minimalModeToggle"-->
        <!--          />-->
        <!--          <label class="form-check-label" for="minimal-mode"-->
        <!--            >Минималистичный режим</label-->
        <!--          >-->
        <!--        </div>-->
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="full-timer-display"
            :checked="config.fullTimerDisplay"
            :disabled="disabledButtons"
            @click="$emit('full-timer-display-toggle')"
          />
          <label class="form-check-label" for="full-timer-display"
            >Таймер общего времени</label
          >
        </div>
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="colors-display"
            :checked="config.colorsDisplay"
            :disabled="disabledButtons"
            @click="$emit('color-display-toggle')"
          />
          <label class="form-check-label" for="colors-display"
            >Многоцветный режим</label
          >
        </div>
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="timer-click-mode"
            :checked="config.timerClickability"
            :disabled="disabledButtons"
            @click="$emit('timer-clickability-toggle')"
          />
          <label class="form-check-label" for="timer-click-mode"
            >Пуск/пауза кликом по таймеру</label
          >
        </div>
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="controls-display"
            :checked="config.controlsDisplay"
            :disabled="disabledButtons"
            @click="$emit('controls-display-toggle')"
          />
          <label class="form-check-label" for="controls-display"
            >Кнопки «Пуск/Пауза»</label
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppSettingsTabInterface",
  props: ["config"],

  data() {
    return {
      // Минималистичный режим вырезан из-за недостатка места на экране мобильных устройств
      // disabledButtons: false,
    };
  },

  computed: {
    // Минималистичный режим вырезан из-за недостатка места на экране мобильных устройств
    // minimalMode() {
    //   return (
    //     !this.config.fullTimerDisplay &&
    //     !this.config.colorsDisplay &&
    //     this.config.timerClickability &&
    //     !this.config.controlsDisplay
    //   );
    // },
  },

  methods: {
    // Минималистичный режим вырезан из-за недостатка места на экране мобильных устройств
    // minimalModeToggle() {
    //   if (this.minimalMode && this.disabledButtons) {
    //     this.disabledButtons = false;
    //   } else if (!this.minimalMode) {
    //     if (this.config.fullTimerDisplay) {
    //       this.$emit("full-timer-display-toggle");
    //     }
    //     if (this.config.colorsDisplay) {
    //       this.$emit("color-display-toggle");
    //     }
    //     if (!this.config.timerClickability) {
    //       this.$emit("timer-clickability-toggle");
    //     }
    //     if (this.config.controlsDisplay) {
    //       this.$emit("controls-display-toggle");
    //     }
    //     this.disabledButtons = true;
    //   }
    // },
  },
};
</script>
