<template>
  <div id="status-bar">
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        initialState || mode === 'work' ? 'disabled' : 'active pulse',
      ]"
    >
      <span class="material-icons"> self_improvement </span>
    </div>
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        !initialState && mode === 'work' ? 'active pulse' : 'disabled',
      ]"
    >
      <span class="material-icons"> directions_bike </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "StatusBar",
  props: ["mode", "play"],
  data() {
    return {
      initialState: true,
    };
  },
  watch: {
    play: function () {
      if (this.initialState && this.play) {
        this.initialState = false;
      }
    },
    mode: function () {
      if (this.mode === "finish") {
        this.initialState = true;
      }
    },
  },
};
</script>
