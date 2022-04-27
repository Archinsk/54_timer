<template>
  <Transition name="fade-down">
    <!--    v-if="!settingsMode"-->
    <div id="status-bar">
      <div
        :class="[
          'border border-light btn btn-outline-light btn-icon-square rounded-circle',
          mode === 'work' ? 'disabled' : 'active',
        ]"
      >
        <span class="material-icons"> self_improvement </span>
      </div>
      <button
        id="btn-play"
        class="btn border border-light btn-icon-square rounded-circle"
      >
        <span
          :class="['anicons-icons', play ? 'playing' : '']"
          @click="$emit('play-toggle')"
          >{{ mode === "finish" ? "d" : "H" }}</span
        >
      </button>
      <div
        :class="[
          'border border-light btn btn-outline-light btn-icon-square rounded-circle',
          mode === 'work' ? 'active' : 'disabled',
        ]"
      >
        <span class="material-icons"> directions_bike </span>
      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  name: "StatusBar",
  props: ["mode", "play", "settingsMode"],
};
</script>
