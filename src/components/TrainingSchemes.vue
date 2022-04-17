<template>
  <button
    v-for="scheme of schemes"
    :key="scheme.id"
    @click="setTrainingMode(scheme)"
  >
    {{ scheme.prepTime }} + ( ({{ scheme.workTime }} / {{ scheme.restTime }}) x
    {{ scheme.rounds }} + {{ scheme.clearTime }} ) x {{ scheme.cycles }}
  </button>
</template>

<script>
export default {
  name: "TrainingSchemes",
};
</script>

<style scoped></style>
