<template>
  <div class="row">
    <div class="col-md-4">
      <img src="../../assets/logo.png" alt=""/>
    </div>
    <div class="col-md-8 pl-5">
      <h4>Login to your account</h4>
      <br>
      <form v-on:submit.prevent="onLoginClick">
        <ValidationObserver ref="loginForm">
          <input-widget :model="model" attribute="email" :placeholder="true"/>
          <input-widget :model="model" attribute="password" type="password" :placeholder="true"/>
          <div class="d-flex align-items-center justify-content-between">
            <button class="btn btn-primary mr-2">
              Login
            </button>
            <b-button variant="link" @click="onResetPasswordClick">Request new password</b-button>
          </div>
        </ValidationObserver>
      </form>
    </div>
  </div>
</template>

<script>
import InputWidget from "../../core/components/input-widget/InputWidget";
import LoginModel from "./LoginModel";
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('auth')

export default {
  name: "Login",
  components: {InputWidget},
  data() {
    return {
      model: new LoginModel(),
    }
  },
  methods: {
    ...mapActions(['login', 'resetPassword']),
    async onLoginClick() {
      const {success, body} = await this.login({...this.model.toJSON()})
      if (success) {
        console.log(body)
      }
    },
    async onResetPasswordClick() {
      const {success, body} = await this.resetPassword({...this.model.toJSON()})
      if (success) {
        console.log(body)
      }
    },
  },
}
</script>

<style scoped>

</style>