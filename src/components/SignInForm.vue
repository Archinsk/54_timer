<template>
  <form @submit.prevent="signIn(user)">
    <label for="sign-in-login" class="form-label">Логин</label>
    <input
      type="text"
      class="form-control"
      id="sign-in-login"
      placeholder="Введите логин"
      autocomplete="off"
      v-model.trim="user.login"
      @blur="signInLoginValidation(user.login, user.password)"
      @input="signInLoginValidation(user.login, user.password)"
    />
    <div v-if="errors.login.errorText" class="sign-error">
      {{ errors.login.errorText }}
    </div>

    <label for="sign-in-password" class="form-label">Пароль</label>
    <div class="input-group">
      <input
        :type="passwordHidden ? 'password' : 'text'"
        class="form-control"
        id="sign-in-password"
        placeholder="Введите пароль"
        autocomplete="off"
        v-model.trim="user.password"
        @blur="signInPasswordValidation(user.login, user.password)"
        @input="signInPasswordValidation(user.login, user.password)"
      />
      <button
        class="btn btn-icon-square btn-password-visibility"
        type="button"
        @click="this.passwordHidden = !this.passwordHidden"
      >
        <span class="material-icons">
          {{ passwordHidden ? "visibility_off" : "visibility" }}
        </span>
      </button>
    </div>
    <div
      v-if="errors.password.errorText && !errors.login.errorText"
      class="sign-error"
    >
      {{ errors.password.errorText }}
    </div>

    <div class="sign-comment">
      Eщё нет аккаунта?
      <a @click.prevent="$emit('change-auth-form')" href="#"
        >Зарегистрироваться</a
      >
    </div>

    <div class="row gx-3 sign-buttons">
      <div class="col">
        <button
          type="button"
          class="btn btn-primary btn-block"
          @click="$emit('select-settings-tab', 'trainings')"
        >
          Отмена
        </button>
      </div>
      <div class="col">
        <button
          type="submit"
          :class="['btn btn-primary btn-block', { disabled: !isValidForm }]"
        >
          Войти
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "SignInForm",
  props: ["url"],

  data() {
    return {
      user: {
        login: "",
        password: "",
      },
      passwordHidden: true,
      errors: {
        login: {
          id: "",
          type: "",
          errorText: "",
        },
        password: {
          id: "",
          type: "",
          errorText: "",
        },
      },
      serverErrors: {
        login: [],
        password: [],
      },
    };
  },

  computed: {
    isValidForm() {
      return (
        !this.errors.login.errorText &&
        !!this.user.login &&
        !this.errors.password.errorText &&
        !!this.user.password
      );
    },
  },

  methods: {
    signInLoginValidation(login, password) {
      if (!login) {
        this.errors.login = {
          id: "4",
          type: "login",
          errorText: "Не введён логин",
        };
      } else {
        if (this.serverErrors.login.length > 0) {
          if (this.serverErrors.login.indexOf(login) >= 0) {
            this.errors.login = {
              id: "1",
              type: "login",
              errorText: "Данный пользователь не зарегистрирован!",
            };
          } else {
            this.errors.login = {
              id: "",
              type: "",
              errorText: "",
            };
          }
        } else if (this.errors.login.errorText) {
          this.errors.login = {
            id: "",
            type: "",
            errorText: "",
          };
        }
        if (this.errors.password.errorText || password) {
          this.signInPasswordValidation(login, password);
        }
      }
    },

    signInPasswordValidation(login, password) {
      if (!password) {
        this.errors.password = {
          id: "5",
          type: "password",
          errorText: "Не введён пароль",
        };
      } else {
        if (this.serverErrors.password.length > 0) {
          if (
            this.serverErrors.password.find(
              (user) => user.login === login && user.password === password
            )
          ) {
            this.errors.password = {
              id: "2",
              type: "password",
              errorText: "Неверно введён пароль!",
            };
          } else {
            this.errors.password = {
              id: "",
              type: "",
              errorText: "",
            };
          }
        } else if (this.errors.password.errorText) {
          this.errors.password = {
            id: "",
            type: "",
            errorText: "",
          };
        }
      }
    },

    signIn(user) {
      axios
        .post(this.url + "signin.php", JSON.stringify(user))
        .then((response) => {
          this.signInResponseParsing(response.data, user);
        });
    },

    signInResponseParsing(response, user) {
      if (response.error) {
        this.signInErrorRecord(response.error, user);
      }
      if (response.user) {
        this.authUser();
      }
    },

    signInErrorRecord(error, user) {
      if (error.type === "login") {
        this.errors.login = error;
        this.errors.password = {};
        this.serverErrors.login.push(user.login);
      }
      if (error.type === "password") {
        this.errors.password = error;
        this.errors.login = {};
        let errorPasswordUser = {
          login: user.login,
          password: user.password,
        };
        this.serverErrors.password.push(errorPasswordUser);
      }
    },

    authUser() {
      this.errorsReset();
      this.$emit("sign-in");
    },

    errorsReset() {
      this.errors.login = {};
      this.errors.password = {};
      this.serverErrors.login = [];
      this.serverErrors.password = [];
    },
  },
};
</script>
