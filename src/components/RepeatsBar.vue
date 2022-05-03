<template>
  <div id="repeats-bar">
    <div>
      <div class="repeats-title">Повторы</div>
      <div class="repeats-value">{{ currentRepeat }} / {{ totalRepeats }}</div>
    </div>
    <div>
      <div class="repeats-title">Раунды</div>
      <div class="repeats-value">{{ currentRound }} / {{ totalRounds }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "RepeatsBar",
  props: ["currentRepeat", "totalRepeats", "currentRound", "totalRounds"],
};
</script>
