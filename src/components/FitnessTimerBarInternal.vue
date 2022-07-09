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
    // Для второго и последующих кругов текущей шкалы первое значение шкалы устанавливается через JS, иначе будет скачок с 0 на 2
    if (!this.initialTimerState) {
      let bar = document.getElementById("progress-bar-internal");
      let val = this.progressOfInternal;
      console.log(this.progressOfInternal);
      bar.setAttribute("stroke-dashoffset", val + "rem");
    }
  },
};
</script>
