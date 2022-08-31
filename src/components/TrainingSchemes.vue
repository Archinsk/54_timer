<template>
  <div id="training-schemes-navbar">
    <div class="row gx-0">
      <div v-for="scheme of schemes" :key="scheme.id" class="col-4">
        <input
          v-model="selectedScheme"
          class="btn-check"
          type="radio"
          name="scheme-buttons"
          :id="'scheme-button-' + scheme.id"
          :value="scheme.id"
        />
        <label
          class="scheme-item"
          :for="'scheme-button-' + scheme.id"
          @click="$emit('select-training-scheme', scheme)"
        >
          {{ scheme.name }}
        </label>
      </div>
      <div id="scheme-selector" :class="'position-' + selectedSchemeId"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TrainingSchemes",
  props: ["schemes", "selectedSchemeId"],

  data() {
    return {
      selectedScheme: this.selectedSchemeId,
    };
  },

  watch: {
    selectedSchemeId: function () {
      this.selectedScheme = this.selectedSchemeId;
    },
  },
};
</script>
