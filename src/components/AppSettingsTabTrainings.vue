<template>
  <div id="settings-screen">
    <TrainingSchemes
      :schemes="config.schemes"
      :selected-scheme-id="config.selectedTrainingScheme.id"
      @select-training-scheme="$emit('select-training-scheme', $event)"
    />

    <div class="row gx-3">
      <div v-if="!authUser" class="col text-muted">
        Зарегистрированным пользователям доступно изменение и сохранение режимов
        таймера, выбор звуков, память последнего режима <br />
        <a @click.prevent="$emit('change-auth-form', 'signin')" href="#"
          >Войти</a
        >
        или
        <a @click.prevent="$emit('change-auth-form', 'signup')" href="#"
          >Зарегистрироваться</a
        >
      </div>
    </div>
    <div class="row">
      <div class="col">
        <SchemeSettings
          v-if="authUser"
          :edit-mode="editMode"
          :selected-scheme="config.selectedTrainingScheme"
        />
      </div>
    </div>
  </div>
</template>

<script>
import TrainingSchemes from "./TrainingSchemes";
import SchemeSettings from "./SchemeSettings";

export default {
  name: "AppSettingsTabTrainings",
  components: {
    SchemeSettings,
    TrainingSchemes,
  },
  props: ["authUser", "config"],
  data() {
    return {
      editMode: false,
    };
  },
};
</script>
