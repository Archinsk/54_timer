<template>
  <div id="status-bar">
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        initialTimerState ||
        mode === 'work' ||
        mode === 'finish' ||
        settingsMode
          ? 'disabled'
          : 'active pulse',
      ]"
    >
      <span class="material-icons"> self_improvement </span>
    </div>
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        !initialTimerState && mode === 'work' && !settingsMode
          ? 'active pulse'
          : 'disabled',
      ]"
    >
      <span class="material-icons"> directions_bike </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "StatusBar",
  props: ["mode", "play", "settingsMode", "initialTimerState"],
};
</script>
