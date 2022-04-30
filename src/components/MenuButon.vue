<template>
  <button
    id="btn-settings"
    class="btn border border-light btn-icon-square rounded-circle"
    @click="action"
  >
    <span
      :class="[
        'anicons-icons',
        { 'settings-mode': closeMode },
        { 'arrow-mode': mode === 'arrowMode' },
      ]"
      >{{ digit }}</span
    >
  </button>
</template>

<script>
export default {
  name: "MenuButon",
  props: ["settingsMode", "mode"],
  computed: {
    digit() {
      return this.mode === "burgerMode" ? "A" : "C";
    },

    closeMode() {
      return this.mode === "burgerMode" && this.settingsMode;
    },
  },
  methods: {
    action() {
      if (this.mode === "burgerMode") {
        this.$emit("settings-toggle");
      }
      if (this.mode === "arrowMode") {
        this.$emit("open-training");
        console.log("training");
      }
    },
  },
};
</script>
