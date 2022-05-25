<template>
  <div id="training-schemes-navbar">
    <div v-for="scheme of schemes" :key="scheme.id">
      <input
        class="btn-check"
        type="radio"
        name="scheme-buttons"
        :id="'scheme-button-' + scheme.id"
      />
      <label
        :class="[
          'col settings-navbar-item btn btn-block rounded-pill',
          scheme.id === selectedSchemeId ? 'btn-primary' : '',
        ]"
        :for="'scheme-button-' + scheme.id"
        @click="$emit('select-training-scheme', scheme)"
      >
        {{ scheme.name }}
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: "TrainingSchemes",
  props: ["schemes", "selectedSchemeId"],

  data() {
    return {
      renderedSchemes: this.schemes,
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

  // watch: {
  //   settingsMode: function () {
  //     if (this.settingsMode) {
  //       for (let i = 0; i < this.schemes.length; i++) {
  //         setTimeout(this.insert, 500 * i, this.schemes[i]);
  //       }
  //     } else {
  //       for (let i = 0; i < this.renderedSchemes.length; i++) {
  //         setTimeout(this.remove, 500 * i);
  //       }
  //     }
  //   },
  // },
};
</script>
