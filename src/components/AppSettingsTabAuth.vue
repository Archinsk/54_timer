<template>
  <SignInForm
    v-if="!authUser && signMode === 'signin'"
    :url="url"
    @sign-in="$emit('sign-in')"
    @sign-mode-toggle="$emit('open-auth-tab', 'signup')"
  />

  <SignUpForm
    v-if="!authUser && signMode === 'signup'"
    :url="url"
    @sign-in="$emit('sign-in')"
    @sign-mode-toggle="$emit('open-auth-tab', 'signin')"
  />

  <SignOutForm v-if="authUser" :url="url" @sign-out="$emit('sign-out')" />
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

  data() {
    return {};
  },
};
</script>
