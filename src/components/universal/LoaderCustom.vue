<template>
  <div :class="'loader ' + loaderClass">
    <div>
      <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div>{{ loaderText }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoaderCustom",
  props: { loaderText: String, fullScreen: Boolean },

  computed: {
    loaderClass: function () {
      let cssClass = "";
      if (this.fullScreen) {
        cssClass +=
          "position-absolute w-100 h-100 d-flex justify-content-center align-items-center";
      }
      return cssClass;
    },
  },
};
</script>
