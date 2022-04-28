<template>
  <div id="media-settings">
    <div>Медиа настройки</div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="minimal-mode"
      />
      <label class="form-check-label" for="minimal-mode"
        >Минималистичный интерфейс</label
      >
    </div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="full-timer-display"
      />
      <label class="form-check-label" for="full-timer-display"
        >Общий таймер</label
      >
    </div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="colors-display"
      />
      <label class="form-check-label" for="colors-display"
        >Цветовая индикация режимов</label
      >
    </div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="timer-click-mode"
      />
      <label class="form-check-label" for="timer-click-mode"
        >Запуск кликом по таймеру</label
      >
    </div>
    <div class="form-check form-switch">
      <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="controls-display"
      />
      <label class="form-check-label" for="controls-display"
        >Кнопки Пуск/Пауза</label
      >
    </div>
  </div>
</template>

<script>
export default {
  name: "InterfaceSettings",
};
</script>
