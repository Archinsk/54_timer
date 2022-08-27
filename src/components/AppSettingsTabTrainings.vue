<template>
  <div id="training-settings">
    <TrainingSchemes
      :schemes="config.schemes"
      :selected-scheme-id="config.selectedTrainingScheme.id"
      @select-training-scheme="$emit('select-training-scheme', $event)"
    />
    <div class="training-settings-container">
      <div v-if="!authUser" class="auth-info">
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
      <SchemeSettings
        v-else
        :selected-scheme="config.selectedTrainingScheme"
        @change-prep-time="$emit('change-prep-time', $event)"
        @change-work-time="$emit('change-work-time', $event)"
        @change-rest-time="$emit('change-rest-time', $event)"
        @change-clear-time="$emit('change-clear-time', $event)"
        @change-repeats="$emit('change-repeats', $event)"
        @change-rounds="$emit('change-rounds', $event)"
      />
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
};
</script>
