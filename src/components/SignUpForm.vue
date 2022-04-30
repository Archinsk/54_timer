<template>
  <div>
    Форма регистрации
    <form class="text-end">
      <div class="mb-2">
        <label for="sign-up-login" class="form-label">Логин</label>
        <input type="text" class="form-control" id="sign-up-login" />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-2">
        <label for="sign-up-password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="sign-up-password" />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-2">
        <label for="sign-up-password-repeat" class="form-label"
          >Повтор пароля</label
        >
        <input
          type="password"
          class="form-control"
          id="sign-up-password-repeat"
        />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-3">
        У меня есть аккаунт.
        <a @click.prevent="$emit('sign-mode-toggle')" href="#">Войти</a>
      </div>
      <div class="row gx-3">
        <div class="col">
          <button type="button" class="btn btn-primary btn-block">
            Отмена
          </button>
        </div>
        <div class="col">
          <button type="submit" class="btn btn-primary btn-block">
            Зарегистрироваться
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "SignUpForm",
};
</script>
