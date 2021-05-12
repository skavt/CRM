<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Login to your account</h4>
        <br>
        <view-spinner :show="loading"/>
        <auth-form :model="model" :loading="loading" :form-type="`register`" :show-repeat-password="true"
                   :disabled-email="true" @on-register-click="onRegisterClick">
        </auth-form>
      </div>
    </div>
    <right-side class="col-md-6 col-center"/>
  </div>
</template>

<script>
import InputWidget from "../../core/components/input-widget/InputWidget";
import LoginModel from "./LoginModel";
import {createNamespacedHelpers} from "vuex";
import RightSide from "./components/RightSide";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import RegisterModel from "./RegisterModel";
import AuthForm from "./components/AuthForm";

const {mapActions} = createNamespacedHelpers('auth')

export default {
  name: "Register",
  components: {AuthForm, ViewSpinner, RightSide},
  data() {
    return {
      model: new RegisterModel(),
      loading: false,
    }
  },
  methods: {
    ...mapActions(['register']),
    async onRegisterClick() {
      this.loading = true
      this.model.resetErrors()
      delete this.model.repeat_password
      const {success, body} = await this.register({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$toast(`Your account will be reviewed by admin and you will receive login instructions`)
        this.$router.push({name: 'login'})
      } else {
        this.$toast(body, 'danger')
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.col-right {
  position: relative;
}
</style>