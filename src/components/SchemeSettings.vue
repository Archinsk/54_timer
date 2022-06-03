<template>
  <div id="training-mode-settings">
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'prep'">-->
    <!--      <div class="col period-text">-->
    <!--        <div v-if="editMode" class="form-check form-switch">-->
    <!--          <input-->
    <!--            class="form-check-input"-->
    <!--            type="checkbox"-->
    <!--            role="switch"-->
    <!--            id="without-prep"-->
    <!--          />-->
    <!--          <label class="form-check-label" for="without-prep"-->
    <!--            >Без подготовки</label-->
    <!--          >-->
    <!--        </div>-->
    <!--        <div v-else class="period-title">Старт</div>-->
    <!--      </div>-->
    <!--      <div class="col period-counter">-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'prep'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ prepMin }} : {{ prepSec }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'prep'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'work'">-->
    <!--      <div class="col period-text">-->
    <!--        <div class="period-title">Работа</div>-->
    <!--      </div>-->
    <!--      <div-->
    <!--        :class="[-->
    <!--          'period-counter',-->
    <!--          editMode && selectedPeriod === 'work' ? 'col-12' : 'col',-->
    <!--        ]"-->
    <!--      >-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'work'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ workMin }} : {{ workSec }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'work'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'rest'">-->
    <!--      <div class="col period-text">-->
    <!--        <div v-if="editMode" class="form-check form-switch">-->
    <!--          <input-->
    <!--            class="form-check-input"-->
    <!--            type="checkbox"-->
    <!--            role="switch"-->
    <!--            id="without-rest"-->
    <!--          />-->
    <!--          <label class="form-check-label" for="without-rest">Без отдыха</label>-->
    <!--        </div>-->
    <!--        <div v-else class="period-title">Отдых</div>-->
    <!--      </div>-->
    <!--      <div class="col period-counter">-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'rest'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ restMin }} : {{ restSec }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'rest'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'clear'">-->
    <!--      <div class="col period-text">-->
    <!--        <div v-if="editMode" class="form-check form-switch">-->
    <!--          <input-->
    <!--            class="form-check-input"-->
    <!--            type="checkbox"-->
    <!--            role="switch"-->
    <!--            id="without-clear"-->
    <!--          />-->
    <!--          <label class="form-check-label" for="without-clear"-->
    <!--            >Без перерыва</label-->
    <!--          >-->
    <!--        </div>-->
    <!--        <div v-else class="period-title">Перерыв</div>-->
    <!--      </div>-->
    <!--      <div class="col period-counter">-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'clear'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ clearMin }} : {{ clearSec }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'clear'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'repeats'">-->
    <!--      <div class="col period-text">-->
    <!--        <div class="period-title">Повторы</div>-->
    <!--      </div>-->
    <!--      <div-->
    <!--        :class="[-->
    <!--          'period-counter',-->
    <!--          editMode && selectedPeriod === 'repeats' ? 'col-12' : 'col',-->
    <!--        ]"-->
    <!--      >-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'repeats'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ selectedScheme.rounds }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'repeats'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="period-setting row gx-3" @click="selectedPeriod = 'rounds'">-->
    <!--      <div class="col period-text">-->
    <!--        <div class="period-title">Раунды</div>-->
    <!--      </div>-->
    <!--      <div-->
    <!--        :class="[-->
    <!--          'period-counter',-->
    <!--          editMode && selectedPeriod === 'rounds' ? 'col-12' : 'col',-->
    <!--        ]"-->
    <!--      >-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'rounds'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">remove</span>-->
    <!--        </button>-->
    <!--        <span class="period-time">{{ selectedScheme.cycles }}</span>-->
    <!--        <button-->
    <!--          v-if="editMode && selectedPeriod === 'rounds'"-->
    <!--          class="btn btn-primary btn-icon-square rounded-circle"-->
    <!--        >-->
    <!--          <span class="material-icons">add</span>-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->

    <div class="row gx-0 w-100">
      <div class="col-3">
        <div class="period-title">Старт</div>
        <div class="period-title">Работа</div>
        <div class="period-title">Отдых</div>
      </div>
      <div class="col-3">
        <InputNumberRoundButtons
          :default-number="+selectedScheme.prepTime"
          :min="0"
          :max="90"
          :step="5"
          @change-value="$emit('change-prep-time', $event)"
        />
        <InputNumberRoundButtons
          :default-number="+selectedScheme.workTime"
          :min="5"
          :max="90"
          :step="5"
          @change-value="$emit('change-work-time', $event)"
        />
        <InputNumberRoundButtons
          :default-number="+selectedScheme.restTime"
          :min="0"
          :max="90"
          :step="5"
          @change-value="$emit('change-rest-time', $event)"
        />
      </div>
      <div class="col-3">
        <div class="period-title">Перерыв</div>
        <div class="period-title">Повторы</div>
        <div class="period-title">Раунды</div>
      </div>
      <div class="col-3">
        <InputNumberRoundButtons
          :default-number="+selectedScheme.clearTime"
          :min="0"
          :max="90"
          :step="5"
          @change-value="$emit('change-clear-time', $event)"
        />
        <InputNumberRoundButtons
          :default-number="+selectedScheme.rounds"
          :min="1"
          :max="90"
          :step="1"
          @change-value="$emit('change-rounds', $event)"
        />
        <InputNumberRoundButtons
          :default-number="+selectedScheme.cycles"
          :min="1"
          :max="90"
          :step="1"
          @change-value="$emit('change-cycles', $event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import InputNumberRoundButtons from "./universal/InputNumberRoundButtons";

export default {
  name: "SchemeSettings",
  components: { InputNumberRoundButtons },
  props: ["editMode", "selectedScheme"],

  data() {
    return {
      selectedPeriod: "work",
    };
  },

  computed: {
    prepMin() {
      return this.timeToPeriod(this.selectedScheme.prepTime, "min");
    },
    prepSec() {
      return this.timeToPeriod(this.selectedScheme.prepTime, "sec");
    },
    workMin() {
      return this.timeToPeriod(this.selectedScheme.workTime, "min");
    },
    workSec() {
      return this.timeToPeriod(this.selectedScheme.workTime, "sec");
    },
    restMin() {
      return this.timeToPeriod(this.selectedScheme.restTime, "min");
    },
    restSec() {
      return this.timeToPeriod(this.selectedScheme.restTime, "sec");
    },
    clearMin() {
      return this.timeToPeriod(this.selectedScheme.clearTime, "min");
    },
    clearSec() {
      return this.timeToPeriod(this.selectedScheme.clearTime, "sec");
    },
  },

  methods: {
    timeToPeriod(timeInSec, period) {
      if (period === "min") {
        return String(Math.floor(timeInSec / 60)).padStart(2, "0");
      }
      if (period === "sec") {
        return String(timeInSec % 60).padStart(2, "0");
      }
      return null;
    },
  },
};
</script>
