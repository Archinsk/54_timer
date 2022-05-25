<template>
  <div id="training-mode-settings">
    <div class="row">
      <div class="col">
        <div class="period-setting row gx-3" @click="selectedPeriod = 'prep'">
          <div class="col period-text">
            <div v-if="editMode" class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="without-prep"
              />
              <label class="form-check-label" for="without-prep"
                >Без подготовки</label
              >
            </div>
            <div v-else class="period-title">Старт</div>
          </div>
          <div class="col period-counter">
            <button
              v-if="editMode && selectedPeriod === 'prep'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ prepMin }} : {{ prepSec }}</span>
            <button
              v-if="editMode && selectedPeriod === 'prep'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>

        <div class="period-setting row gx-3" @click="selectedPeriod = 'work'">
          <div class="col period-text">
            <div class="period-title">Работа</div>
          </div>
          <div
            :class="[
              'period-counter',
              editMode && selectedPeriod === 'work' ? 'col-12' : 'col',
            ]"
          >
            <button
              v-if="editMode && selectedPeriod === 'work'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ workMin }} : {{ workSec }}</span>
            <button
              v-if="editMode && selectedPeriod === 'work'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>

        <div class="period-setting row gx-3" @click="selectedPeriod = 'rest'">
          <div class="col period-text">
            <div v-if="editMode" class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="without-rest"
              />
              <label class="form-check-label" for="without-rest"
                >Без отдыха</label
              >
            </div>
            <div v-else class="period-title">Отдых</div>
          </div>
          <div class="col period-counter">
            <button
              v-if="editMode && selectedPeriod === 'rest'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ restMin }} : {{ restSec }}</span>
            <button
              v-if="editMode && selectedPeriod === 'rest'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="period-setting row gx-3" @click="selectedPeriod = 'clear'">
          <div class="col period-text">
            <div v-if="editMode" class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="without-clear"
              />
              <label class="form-check-label" for="without-clear"
                >Без перерыва</label
              >
            </div>
            <div v-else class="period-title">Перерыв</div>
          </div>
          <div class="col period-counter">
            <button
              v-if="editMode && selectedPeriod === 'clear'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ clearMin }} : {{ clearSec }}</span>
            <button
              v-if="editMode && selectedPeriod === 'clear'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>

        <div
          class="period-setting row gx-3"
          @click="selectedPeriod = 'repeats'"
        >
          <div class="col period-text">
            <div class="period-title">Повторы</div>
          </div>
          <div
            :class="[
              'period-counter',
              editMode && selectedPeriod === 'repeats' ? 'col-12' : 'col',
            ]"
          >
            <button
              v-if="editMode && selectedPeriod === 'repeats'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ selectedScheme.rounds }}</span>
            <button
              v-if="editMode && selectedPeriod === 'repeats'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>

        <div class="period-setting row gx-3" @click="selectedPeriod = 'rounds'">
          <div class="col period-text">
            <div class="period-title">Раунды</div>
          </div>
          <div
            :class="[
              'period-counter',
              editMode && selectedPeriod === 'rounds' ? 'col-12' : 'col',
            ]"
          >
            <button
              v-if="editMode && selectedPeriod === 'rounds'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">remove</span>
            </button>
            <span class="period-time">{{ selectedScheme.cycles }}</span>
            <button
              v-if="editMode && selectedPeriod === 'rounds'"
              class="btn btn-primary btn-icon-square rounded-circle"
            >
              <span class="material-icons">add</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SchemeSettings",
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
