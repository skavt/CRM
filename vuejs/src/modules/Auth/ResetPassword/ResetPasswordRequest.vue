<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Request Password Reset</h4>
        <br>
        <view-spinner :show="loading"/>
        <auth-form :model="model" :loading="loading" :form-type="`requestPass`" :show-password="false"
                   @on-request-pass-click="onResetPasswordRequestClick">
        </auth-form>
      </div>
    </div>
    <right-side class="col-md-6 col-center"/>
  </div>
</template>

<script>
import InputWidget from "../../../core/components/input-widget/InputWidget";
import ResetPasswordRequestModel from "./ResetPasswordRequestModel";
import RightSide from "../components/RightSide";
import {createNamespacedHelpers} from "vuex";
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import AuthForm from "../components/AuthForm";

const {mapActions} = createNamespacedHelpers('auth')
export default {
  name: "ResetPasswordRequest",
  components: {AuthForm, ViewSpinner, RightSide},
  data() {
    return {
      model: new ResetPasswordRequestModel(),
      loading: false,
    }
  },
  methods: {
    ...mapActions(['resetPasswordRequest']),
    async onResetPasswordRequestClick() {
      this.loading = true
      this.model.resetErrors()
      const {success, body} = await this.resetPasswordRequest({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$toast(`Password Reset Link sent successfully. Check email.`)
        this.$router.push({name: 'login'})
      } else {
        this.model.setMultipleErrors([{field: 'email', message: body}])
      }
    },
  },
}
</script>

<style lang="scss" scoped>

</style>