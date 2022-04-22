<template>
  <div class="position-absolute">
    <div class="d-flex flex-column align-items-end gap-2">
      <TransitionGroup name="list">
        <button
          v-for="scheme of renderedSchemes"
          :key="scheme.id"
          class="btn btn-outline-light"
          @click="$emit('set-training-mode', scheme)"
        >
          {{ scheme.prepTime }} + ( ({{ scheme.workTime }} /
          {{ scheme.restTime }}) x {{ scheme.rounds }} +
          {{ scheme.clearTime }} ) x {{ scheme.cycles }}
        </button>
      </TransitionGroup>
    </div>
  </div>
</template>

<script>
export default {
  name: "TrainingSchemes",
  props: ["schemes", "settingsMode"],

  data() {
    return {
      renderedSchemes: [],
    };
  },

  methods: {
    insert(scheme) {
      this.renderedSchemes.push(scheme);
    },
    remove() {
      this.renderedSchemes.pop();
    },
  },

  watch: {
    settingsMode: function () {
      if (this.settingsMode) {
        for (let i = 0; i < this.schemes.length; i++) {
          setTimeout(this.insert, 500 * i, this.schemes[i]);
        }
      } else {
        for (let i = 0; i < this.renderedSchemes.length; i++) {
          setTimeout(this.remove, 500 * i);
        }
      }
    },
  },
};
</script>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 2s;
}
.list-enter-from, .list-leave-to /* .list-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateX(100%);
}
</style>
