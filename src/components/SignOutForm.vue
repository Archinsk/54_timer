<template>
  <div class="text-muted">
    Вы действительно хотите <br />
    выйти из учетной записи?
  </div>
  <div class="btn btn-primary" @click="signOut">Выйти</div>
</template>

<script>
import axios from "axios";

export default {
  name: "SignOutForm",
  props: ["url"],

  methods: {
    signOut() {
      let qwert = this;
      console.log("Выход");
      axios.post(this.url + "signout.php").then(() => {
        this.$emit("sign-out");
        console.log(this);
        console.log(qwert);
        // this.initApp();
        // this.$router.push("/");
      });
    },
  },
};
</script>
