<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Password Reset</h4>
        <br>
        <view-spinner :show="loading"/>
        <auth-form :model="model" :loading="loading" :form-type="`resetPass`" :disabled-email="true"
                   :show-repeat-password="true" @on-reset-pass-click="onResetPasswordClick">
        </auth-form>
      </div>
    </div>
    <right-side class="col-md-6 col-center"/>
  </div>
</template>

<script>
import RightSide from "../components/RightSide";
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import ResetPasswordFormModel from "./ResetPasswordFormModel";
import {createNamespacedHelpers} from "vuex";
import {checkToken} from "../../../store/modules/auth/actions";
import AuthForm from "../components/AuthForm";

const {mapActions} = createNamespacedHelpers('auth')
export default {
  name: "ResetPasswordForm",
  components: {AuthForm, ViewSpinner, RightSide},
  data() {
    return {
      model: new ResetPasswordFormModel(),
      loading: false,
    }
  },
  methods: {
    ...mapActions(['resetPassword', 'checkToken']),
    async onResetPasswordClick() {
      this.model.resetErrors()
      this.loading = true
      delete this.model.repeat_password
      const {success, body} = await this.resetPassword({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$toast(`Password changed successfully`)
      } else {
        this.$toast(body, 'danger')
      }
      this.$router.push({name: 'login'})
    }
  },
  async mounted() {
    this.model.token = this.$route.params.token

    const {success, body} = await this.checkToken(this.model.token)
    if (success) {
      this.model.email = body
    } else {
      this.$toast(body, 'danger')
      this.$router.push({name: 'login'})
    }
  },
}
</script>

<style scoped>

</style>