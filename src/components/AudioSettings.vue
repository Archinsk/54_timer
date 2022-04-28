<template>
  <div id="audio-settings">Настройки звука</div>
  <div class="row gx-3">
    <div class="col">
      <button class="btn btn-block">Работа</button>
    </div>
    <div class="col">
      <button class="btn btn-block">Отдых</button>
    </div>
  </div>

  <div id="sound-selector-work">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-work"
        id="melody-1"
        value="option1"
        checked
      />
      <label class="form-check-label" for="melody-1"> Мелодия №1 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-work"
        id="melody-2"
        value="option2"
      />
      <label class="form-check-label" for="melody-2"> Мелодия №2 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-work"
        id="melody-3"
        value="option2"
      />
      <label class="form-check-label" for="melody-3"> Мелодия №3 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-work"
        id="melody-4"
        value="option2"
      />
      <label class="form-check-label" for="melody-4"> Мелодия №4 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-work"
        id="melody-5"
        value="option2"
      />
      <label class="form-check-label" for="melody-5"> Мелодия №5 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
  </div>

  <div id="sound-selector-rest">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-rest"
        id="melody-6"
        value="option1"
        checked
      />
      <label class="form-check-label" for="melody-6"> Мелодия №6 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-rest"
        id="melody-7"
        value="option2"
      />
      <label class="form-check-label" for="melody-7"> Мелодия №7 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-rest"
        id="melody-8"
        value="option2"
      />
      <label class="form-check-label" for="melody-8"> Мелодия №8 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-rest"
        id="melody-9"
        value="option2"
      />
      <label class="form-check-label" for="melody-9"> Мелодия №9 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="melody-selector-rest"
        id="melody-10"
        value="option2"
      />
      <label class="form-check-label" for="melody-10"> Мелодия №10 </label>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">play_arrow</span>
      </button>
      <button class="btn btn-primary btn-icon-square rounded-circle">
        <span class="material-icons">stop</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AudioSettings",
};
</script>
