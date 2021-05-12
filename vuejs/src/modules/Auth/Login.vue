<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Login to your account</h4>
        <br>
        <view-spinner :show="loading"/>
        <auth-form :model="model" :loading="loading" :form-type="`login`" @on-login-click="onLoginClick"/>
      </div>
    </div>
    <right-side class="col-md-6 col-center"/>
  </div>
</template>

<script>
import LoginModel from "./models/LoginModel";
import {createNamespacedHelpers} from "vuex";
import RightSide from "./components/RightSide";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import AuthForm from "./components/AuthForm";

const {mapActions} = createNamespacedHelpers('auth')

export default {
  name: "Login",
  components: {AuthForm, ViewSpinner, RightSide},
  data() {
    return {
      model: new LoginModel(),
      loading: false,
    }
  },
  methods: {
    ...mapActions(['login']),
    async onLoginClick() {
      this.loading = true
      this.model.resetErrors()
      const {success, body} = await this.login({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$router.push({name: 'dashboard'});
      } else {
        this.model.setMultipleErrors([{field: 'password', message: body.password}])
      }
    },
  },
}
</script>

<style scoped lang="scss">
.col-right {
  position: relative;
}
</style>