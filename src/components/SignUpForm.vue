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
          autocomplete="off"
          v-model.trim="user.login"
          @blur="signUpLoginValidation(user.login)"
          @input="signUpLoginValidation(user.login)"
        />
        <div v-if="errors.login.errorText" class="form-text sign-error">
          {{ errors.login.errorText }}
        </div>
      </div>
      <div class="mb-2">
        <label for="sign-up-password" class="form-label">Пароль</label>
        <div class="input-group">
          <input
            :type="passwordHidden ? 'password' : 'text'"
            class="form-control"
            id="sign-up-password"
            placeholder="Введите пароль"
            autocomplete="off"
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
        <div v-if="errors.password.errorText" class="form-text sign-error">
          {{ errors.password.errorText }}
        </div>
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
            autocomplete="off"
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
        <div
          v-if="errors.passwordRepeat.errorText"
          class="form-text sign-error"
        >
          {{ errors.passwordRepeat.errorText }}
        </div>
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
          <button
            type="submit"
            :class="['btn btn-primary btn-block', { disabled: !isValidForm }]"
          >
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
        passwordRepeat: {
          id: "",
          type: "",
          errorText: "",
        },
      },
      serverErrors: {
        login: [],
      },
    };
  },

  computed: {
    isValidForm() {
      return (
        !this.errors.login.errorText &&
        !!this.user.login &&
        !this.errors.password.errorText &&
        !!this.user.password &&
        !this.errors.passwordRepeat.errorText &&
        !!this.user.passwordRepeat
      );
    },
  },

  methods: {
    togglePasswordVisibility() {
      this.passwordHidden = !this.passwordHidden;
    },

    togglePasswordRepeatVisibility() {
      this.passwordRepeatHidden = !this.passwordRepeatHidden;
    },

    signUpLoginValidation(login) {
      if (!login) {
        this.errors.login = {
          id: "6",
          type: "login",
          errorText: "Введите логин",
        };
      } else {
        if (this.serverErrors.login.length > 0) {
          if (this.serverErrors.login.indexOf(login) >= 0) {
            console.log("Совпадение найдено");
            this.errors.login = {
              id: "3",
              type: "login",
              errorText: "Логин уже занят",
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
      }
    },

    signUpPasswordValidation(password, passwordRepeat) {
      if (!password) {
        this.errors.password = {
          id: "7",
          type: "password",
          errorText: "Введите пароль",
        };
      } else {
        if (this.errors.password.errorText) {
          this.errors.password = {
            id: "",
            type: "",
            errorText: "",
          };
        }
        if (this.errors.passwordRepeat.errorText || passwordRepeat) {
          this.signUpPasswordRepeatValidation(password, passwordRepeat);
        }
      }
    },

    signUpPasswordRepeatValidation(password, passwordRepeat) {
      if (!passwordRepeat) {
        this.errors.passwordRepeat = {
          id: "8",
          type: "passwordRepeat",
          errorText: "Введите пароль ещё раз",
        };
      } else {
        if (!password) {
          this.signUpPasswordValidation(password, passwordRepeat);
        } else {
          if (passwordRepeat !== password) {
            this.errors.passwordRepeat = {
              id: "9",
              type: "passwordRepeat",
              errorText: "Повтор не совпадает с паролем",
            };
          } else if (this.errors.passwordRepeat.errorText) {
            this.errors.passwordRepeat = {
              id: "",
              type: "",
              errorText: "",
            };
          }
        }
      }
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
        this.serverErrors.login.push(user.login);
      }
      if (response.user) {
        this.authUser();
      }
    },

    signUpErrorRecord(error) {
      if (error.type === "login") {
        this.errors.login = error;
      }
    },

    authUser() {
      this.errorsReset();
      this.$emit("sign-in");
    },

    errorsReset() {
      this.errors.login = {};
      this.errors.password = {};
      this.errors.passwordRepeat = {};
      this.serverErrors.login = [];
    },
  },
};
</script>
