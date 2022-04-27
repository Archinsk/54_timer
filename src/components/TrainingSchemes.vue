<template>
  <!--  <div class="position-absolute">-->
  <div id="settings-screen" class="row gx-3">
    <div class="col text-muted">
      Зарегистрированным пользователям доступно изменение и сохранение режимов
      таймера, выбор звуков, память последнего режима
    </div>
    <div class="col">
      <!--      <TransitionGroup name="list">-->
      <button
        v-for="scheme of renderedSchemes"
        :key="scheme.id"
        class="btn btn-outline-light btn-training-mode"
        @click="$emit('set-training-mode', scheme)"
      >
        {{ scheme.name }}
      </button>
      <!--      </TransitionGroup>-->
    </div>
  </div>
  <!--  </div>-->
</template>

<script>
export default {
  name: "TrainingSchemes",
  props: ["schemes", "settingsMode"],

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
