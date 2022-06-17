<template>
  <circle
    id="progress-bar-internal"
    :stroke-dasharray="strokeLength + 'rem'"
    :stroke-dashoffset="strokeOffset + 'rem'"
    :class="modeColor"
  ></circle>
</template>

<script>
export default {
  name: "FitnessTimerBarInternal",
  props: [
    "initialTimerState",
    "strokeLength",
    "strokeOffset",
    "modeColor",
    "progressOfInternal",
  ],

  mounted() {
    if (!this.initialTimerState) {
      let bar = document.getElementById("progress-bar-internal");
      let val = this.progressOfInternal;
      console.log("до изменения");
      console.log(bar.getAttribute("stroke-dashoffset"));
      bar.setAttribute("stroke-dashoffset", val + "rem");
      console.log("после изменения");
      console.log(bar.getAttribute("stroke-dashoffset"));
    }
  },
};
</script>

<style scoped></style>
