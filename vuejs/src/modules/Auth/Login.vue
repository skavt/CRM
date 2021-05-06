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
            <router-link :to="{name: 'request-password-reset'}">Request new password</router-link>
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
    ...mapActions(['login']),
    async onLoginClick() {
      const {success, body} = await this.login({...this.model.toJSON()})
      if (success) {
        console.log(body)
      }
    },
  },
}
</script>

<style scoped>

</style>