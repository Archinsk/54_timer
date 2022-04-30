<template>
  <div>
    Форма авторизации
    <form class="text-start">
      <div class="mb-2">
        <label for="sign-in-login" class="form-label">Логин</label>
        <input type="text" class="form-control" id="sign-in-login" />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-2">
        <label for="sign-in-password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="sign-in-password" />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-3">
        У меня еще нет аккаунта.
        <a @click.prevent="$emit('sign-mode-toggle')" href="#"
          >Зарегистрироваться</a
        >
      </div>
      <div class="row gx-3">
        <div class="col">
          <button type="button" class="btn btn-primary btn-block">
            Отмена
          </button>
        </div>
        <div class="col">
          <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "SignInForm",
};
</script>
