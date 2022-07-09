<template>
  <div id="controls" class="row gx-3">
    <div class="col">
      <button
        class="btn btn-outline-info rounded-pill btn-block btn-control"
        @click="$emit('play-toggle')"
      >
        {{ startButtonText }}
      </button>
    </div>
    <div class="col">
      <button
        class="btn btn-outline-info rounded-pill btn-block btn-control"
        @click="$emit('reset-timer')"
      >
        {{ mode === "finish" ? "Повтор" : "Сброс" }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppControls",
  props: ["play", "mode", "initialTimerState"],
  computed: {
    startButtonText: function () {
      if (this.initialTimerState) {
        return "Старт";
      } else {
        if (this.play) {
          return "Пауза";
        } else {
          if (this.mode === "finish") {
            return "Повтор";
          } else {
            return "Продолжить";
          }
        }
      }
    },
  },
};
</script>
