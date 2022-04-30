<template>
  <div id="training-mode-settings">
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
        <div v-else class="period-title">Подготовка</div>
      </div>
      <div class="col period-counter">
        <button
          v-if="editMode && selectedPeriod === 'prep'"
          class="btn btn-primary btn-icon-square rounded-circle"
        >
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">00 : 10</span>
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
        <span class="period-time">00 : 20</span>
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
          <label class="form-check-label" for="without-rest">Без отдыха</label>
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
        <span class="period-time">00 : 10</span>
        <button
          v-if="editMode && selectedPeriod === 'rest'"
          class="btn btn-primary btn-icon-square rounded-circle"
        >
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>

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
        <span class="period-time">00 : 30</span>
        <button
          v-if="editMode && selectedPeriod === 'clear'"
          class="btn btn-primary btn-icon-square rounded-circle"
        >
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>

    <div class="period-setting row gx-3" @click="selectedPeriod = 'repeats'">
      <div class="col period-text">
        <div class="period-title">Повторов</div>
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
        <span class="period-time">3</span>
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
        <div class="period-title">Раундов</div>
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
        <span class="period-time">3</span>
        <button
          v-if="editMode && selectedPeriod === 'rounds'"
          class="btn btn-primary btn-icon-square rounded-circle"
        >
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SchemeSettings",
  props: ["editMode"],

  data() {
    return {
      selectedPeriod: "work",
    };
  },
};
</script>
