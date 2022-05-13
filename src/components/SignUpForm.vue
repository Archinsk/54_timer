<template>
  <div>
    Форма регистрации
    <form @submit.prevent="signUp(user)" class="text-end">
      <div class="mb-2">
        <label for="sign-up-login" class="form-label">Логин</label>
        <input
          type="text"
          class="form-control"
          id="sign-up-login"
          placeholder="Введите логин"
          v-model.trim="user.login"
          @blur="signUpLoginValidation(user.login)"
          @input="signUpLoginValidation(user.login)"
        />
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-2">
        <label for="sign-up-password" class="form-label">Пароль</label>
        <div class="input-group">
          <input
            :type="passwordHidden ? 'password' : 'text'"
            class="form-control"
            id="sign-up-password"
            placeholder="Введите пароль"
            v-model.trim="user.password"
            @blur="signUpPasswordValidation(user.password, user.passwordRepeat)"
            @input="
              signUpPasswordValidation(user.password, user.passwordRepeat)
            "
          />
          <button
            class="btn btn-outline-light btn-icon-square"
            type="button"
            @click="togglePasswordVisibility"
          >
            <span class="material-icons">
              {{ passwordHidden ? "visibility_off" : "visibility" }}
            </span>
          </button>
        </div>
        <div class="form-text sign-error">Текст ошибки</div>
      </div>
      <div class="mb-2">
        <label for="sign-up-password-repeat" class="form-label"
          >Повтор пароля</label
        >
        <div class="input-group">
          <input
            :type="passwordRepeatHidden ? 'password' : 'text'"
            class="form-control"
            id="sign-up-password-repeat"
            placeholder="Пароль ещё раз"
            v-model.trim="user.passwordRepeat"
            @blur="
              signUpPasswordRepeatValidation(user.password, user.passwordRepeat)
            "
            @input="
              signUpPasswordRepeatValidation(user.password, user.passwordRepeat)
            "
          />
          <button
            class="btn btn-outline-light btn-icon-square"
            type="button"
            @click="togglePasswordRepeatVisibility"
          >
            <span class="material-icons">
              {{ passwordRepeatHidden ? "visibility_off" : "visibility" }}
            </span>
          </button>
        </div>
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
import axios from "axios";
export default {
  name: "SignUpForm",
  props: ["url"],

  data() {
    return {
      user: {
        login: "",
        password: "",
        passwordRepeat: "",
      },
      passwordHidden: true,
      passwordRepeatHidden: true,
      errors: {
        login: {},
        password: {},
        passwordRepeat: {},
      },
    };
  },

  computed: {
    isValidForm() {
      return (
        !this.signUpLoginError &&
        this.user.login &&
        !this.signUpPasswordError &&
        this.user.password &&
        !this.signUpPasswordRepeatError &&
        this.user.passwordRepeat
      );
    },
  },

  watch: {
    isAuthUser() {
      if (this.isAuthUser) {
        this.user = {
          login: "",
          password: "",
          passwordRepeat: "",
        };
      }
    },
  },

  methods: {
    togglePasswordVisibility() {
      this.passwordHidden = !this.passwordHidden;
    },
    togglePasswordRepeatVisibility() {
      this.passwordRepeatHidden = !this.passwordRepeatHidden;
    },
    signUp(user) {
      axios
        .post(this.url + "signup.php", JSON.stringify(user))
        .then((response) => {
          this.signUpResponseParsing(response.data, user);
        });
    },

    signUpResponseParsing(response, user) {
      if (response.error) {
        this.signUpErrorRecord(response.error);
        console.log(user);
        // this.serverErrors.signUp.login.push(user.login);
      }
      if (response.user) {
        this.authUser();
      }
    },

    signUpErrorRecord(error) {
      if (error.type === "login") {
        this.errors.signUp.login = error;
      }
      this.logGroup("Записана ошибка", error);
    },

    authUser() {
      this.errorsReset();
      this.$emit("sign-in");
    },

    errorsReset() {
      this.errors.login = {};
      this.errors.password = {};
      // this.serverErrors.signIn.login = [];
      // this.serverErrors.signIn.password = [];
    },
  },
};
</script>
