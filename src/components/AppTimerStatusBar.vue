<template>
  <div id="status-bar">
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        mode === 'work' ? 'disabled' : 'active',
      ]"
    >
      <span class="material-icons"> self_improvement </span>
    </div>
    <div
      :class="[
        'btn btn-outline-light btn-icon-square rounded-circle',
        mode === 'work' ? 'active' : 'disabled',
      ]"
    >
      <span class="material-icons"> directions_bike </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "StatusBar",
  props: ["mode"],
};
</script>
