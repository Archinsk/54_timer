<template>
  <div
    id="controls"
    :class="['row justify-content-center gx-2', { collapsed: settingsMode }]"
  >
    <div class="col-1"></div>
    <div class="col-6">
      <button
        class="btn btn-outline-light rounded-pill btn-block btn-control"
        @click="mainButtonAction"
      >
        {{ startButtonText }}
      </button>
    </div>
    <div class="col-1">
      <button
        v-if="!initialTimerState && !play && mode !== 'finish'"
        class="btn btn-outline-light btn-icon-square rounded-circle btn-control"
        @click="$emit('reset-timer')"
      >
        <span class="material-icons"> refresh </span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppControls",
  props: ["play", "mode", "initialTimerState", "settingsMode"],
  computed: {
    startButtonText: function () {
      if (this.initialTimerState) {
        return "Старт";
      } else {
        if (this.play) {
          return "Пауза";
        } else {
          if (this.mode === "finish") {
            return "Повторить";
          } else {
            return "Продолжить";
          }
        }
      }
    },
  },
  methods: {
    mainButtonAction() {
      if (this.mode === "finish") {
        this.$emit("reset-timer");
      } else {
        this.$emit("play-toggle");
      }
    },
  },
};
</script>
