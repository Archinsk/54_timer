<template>
  <div id="sign-out-screen">
    <div>
      <div class="text-muted">
        Вы действительно хотите <br />
        выйти из учетной записи?
      </div>
      <div class="btn btn-primary sign-out-button" @click="signOut">Выйти</div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SignOutForm",
  props: ["url"],

  methods: {
    signOut() {
      axios.post(this.url + "signout.php").then(() => {
        this.$emit("sign-out");
      });
    },
  },
};
</script>
