<template>
  <div id="controls" class="row gx-3">
    <div class="col">
      <button
        class="btn btn-outline-info rounded-pill btn-block btn-control"
        @click="$emit('play-toggle')"
      >
        {{ play ? "ПАУЗА" : "СТАРТ" }}
      </button>
    </div>
    <div class="col">
      <button
        class="btn btn-outline-info rounded-pill btn-block btn-control"
        @click="$emit('reset-timer')"
      >
        {{ mode === "finish" ? "ПОВТОР" : "СБРОС" }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppControls",
  props: ["play", "mode"],
};
</script>
