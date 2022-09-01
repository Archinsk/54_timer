<template>
  <div id="auth-settings" class="row">
    <div class="col col-sm-7 auth-settings-container">
      <template v-if="!authUser">
        <transition name="fade-in-right" mode="out-in">
          <SignInForm
            v-if="signMode === 'signin'"
            :url="url"
            @sign-in="$emit('sign-in')"
            @change-auth-form="$emit('change-auth-form', 'signup')"
            @select-settings-tab="$emit('select-settings-tab', $event)"
          />

          <SignUpForm
            v-else
            :url="url"
            @sign-up="$emit('sign-up')"
            @change-auth-form="$emit('change-auth-form', 'signin')"
            @select-settings-tab="$emit('select-settings-tab', $event)"
          />
        </transition>
      </template>

      <SignOutForm v-else :url="url" @sign-out="$emit('sign-out')" />
    </div>
  </div>
</template>

<script>
import SignInForm from "./SignInForm";
import SignUpForm from "./SignUpForm";
import SignOutForm from "./SignOutForm";

export default {
  name: "AppSettingsTabAuth",
  components: {
    SignOutForm,
    SignUpForm,
    SignInForm,
  },
  props: ["authUser", "url", "signMode"],
};
</script>
