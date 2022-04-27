<template>
  <div id="training-mode-settings">
    <div class="period-setting row gx-3">
      <div class="col period-text">
        <span class="period-title">Подготовка</span>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">00 : 10</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>

    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="without-prep"
      />
      <label class="form-check-label" for="without-prep">Без подготовки</label>
    </div>

    <div class="period-setting row gx-3">
      <div class="col period-text">
        <span class="period-title">Работа</span>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">00 : 20</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>
    <div class="period-setting row gx-3">
      <div class="col period-text">
        <div class="period-title">Отдых</div>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">00 : 10</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>

    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="without-rest"
      />
      <label class="form-check-label" for="without-rest">Без отдыха</label>
    </div>

    <div class="period-setting row gx-3">
      <div class="col period-text">
        <span class="period-title">Перерыв</span>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">00 : 30</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>

    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="without-clear"
      />
      <label class="form-check-label" for="without-clear">Без перерыва</label>
    </div>

    <div class="period-setting row gx-3">
      <div class="col period-text">
        <span class="period-title">Повторов</span>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">3</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>
    <div class="period-setting row gx-3">
      <div class="col period-text">
        <span class="period-title">Раундов</span>
      </div>
      <div class="col period-counter">
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">remove</span>
        </button>
        <span class="period-time">3</span>
        <button class="btn btn-primary btn-icon-square rounded-circle">
          <span class="material-icons">add</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SchemeSettings",
};
</script>
