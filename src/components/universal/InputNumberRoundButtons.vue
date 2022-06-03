<template>
  <div class="input-number">
    <button
      :class="[
        'btn btn-primary btn-icon-square rounded-circle',
        { disabled: defaultNumber - step < min },
      ]"
      @click="$emit('change-value', defaultNumber - step)"
    >
      <span class="material-icons">remove</span>
    </button>
    <span class="period-time">{{ defaultNumber }}</span>
    <button
      :class="[
        'btn btn-primary btn-icon-square rounded-circle',
        { disabled: defaultNumber + step > max },
      ]"
      @click="$emit('change-value', defaultNumber + step)"
    >
      <span class="material-icons">add</span>
    </button>
  </div>
</template>

<script>
export default {
  name: "InputNumberRoundButtons",
  props: ["defaultNumber", "min", "max", "step"],
};
</script>
