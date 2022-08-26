<template>
  <div id="training-mode-settings" class="row gx-0">
    <div class="col">
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'prep' },
        ]"
        @click="selectedItem = 'prep'"
      >
        <div class="col"><div class="period-title">Старт</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.prepTime"
            :min="0"
            :max="90"
            :step="5"
            @change-value="$emit('change-prep-time', $event)"
          />
        </div>
      </div>
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'work' },
        ]"
        @click="selectedItem = 'work'"
      >
        <div class="col"><div class="period-title">Работа</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.workTime"
            :min="5"
            :max="90"
            :step="5"
            @change-value="$emit('change-work-time', $event)"
          />
        </div>
      </div>
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'rest' },
        ]"
        @click="selectedItem = 'rest'"
      >
        <div class="col"><div class="period-title">Отдых</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.restTime"
            :min="0"
            :max="90"
            :step="5"
            @change-value="$emit('change-rest-time', $event)"
          />
        </div>
      </div>
    </div>
    <div class="col">
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'clear' },
        ]"
        @click="selectedItem = 'clear'"
      >
        <div class="col"><div class="period-title">Перерыв</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.clearTime"
            :min="0"
            :max="90"
            :step="5"
            @change-value="$emit('change-clear-time', $event)"
          />
        </div>
      </div>
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'repeats' },
        ]"
        @click="selectedItem = 'repeats'"
      >
        <div class="col"><div class="period-title">Повторы</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.repeats"
            :min="1"
            :max="90"
            :step="1"
            @change-value="$emit('change-repeats', $event)"
          />
        </div>
      </div>
      <div
        :class="[
          'row gx-2 training-settings-item',
          { active: selectedItem === 'rounds' },
        ]"
        @click="selectedItem = 'rounds'"
      >
        <div class="col"><div class="period-title">Раунды</div></div>
        <div class="col col-sm-5">
          <InputNumberRoundButtons
            :default-number="+selectedScheme.rounds"
            :min="1"
            :max="90"
            :step="1"
            @change-value="$emit('change-rounds', $event)"
          />
        </div>
      </div>
    </div>
    <div :class="['training-settings-selector', selectorPositionClass]"></div>
  </div>
</template>

<script>
import InputNumberRoundButtons from "./universal/InputNumberRoundButtons";

export default {
  name: "SchemeSettings",
  components: { InputNumberRoundButtons },
  props: ["selectedScheme"],

  data() {
    return {
      selectedItem: "",
    };
  },

  computed: {
    selectorPositionClass: function () {
      if (this.selectedItem === "prep") {
        return "position-1";
      } else if (this.selectedItem === "work") {
        return "position-2";
      } else if (this.selectedItem === "rest") {
        return "position-3";
      } else if (this.selectedItem === "clear") {
        return "position-4";
      } else if (this.selectedItem === "repeats") {
        return "position-5";
      } else if (this.selectedItem === "rounds") {
        return "position-6";
      } else {
        return "";
      }
    },
  },
};
</script>
