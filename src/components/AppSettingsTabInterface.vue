<template>
  <div id="media-settings">
    <div>Медиа настройки</div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="minimal-mode"
        :checked="minimalMode"
        @click="minimalModeToggle"
      />
      <label class="form-check-label" for="minimal-mode"
        >Минималистичный интерфейс</label
      >
    </div>
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
        >Общий таймер</label
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
        >Цветовая индикация режимов</label
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
        >Запуск кликом по таймеру</label
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
        >Кнопки Пуск/Пауза</label
      >
    </div>
  </div>
</template>

<script>
export default {
  name: "AppSettingsTabInterface",
  props: ["config"],

  data() {
    return {
      disabledButtons: false,
    };
  },

  computed: {
    minimalMode() {
      return (
        !this.config.fullTimerDisplay &&
        !this.config.colorsDisplay &&
        this.config.timerClickability &&
        !this.config.controlsDisplay
      );
    },
  },

  methods: {
    minimalModeToggle() {
      if (this.minimalMode) {
        // this.disabledButtons = false;
        this.disabledButtons = !this.disabledButtons;
      } else {
        if (this.config.fullTimerDisplay) {
          this.$emit("full-timer-display-toggle");
        }
        if (this.config.colorsDisplay) {
          this.$emit("color-display-toggle");
        }
        if (!this.config.timerClickability) {
          this.$emit("timer-clickability-toggle");
        }
        if (this.config.controlsDisplay) {
          this.$emit("controls-display-toggle");
        }
        this.disabledButtons = true;
      }
    },
  },
};
</script>
