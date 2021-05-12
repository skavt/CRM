<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Password Reset</h4>
        <br>
        <view-spinner :show="loading"/>
        <ValidationObserver v-if="!loading" v-slot="{ handleSubmit }">
          <b-form @keydown.enter.prevent="handleSubmit(onResetPasswordClick)">
            <input-widget :disabled="true" :model="model" :placeholder="true" attribute="email"/>
            <input-widget :model="model" :placeholder="true" attribute="password" type="password" :autofocus="true"/>
            <input-widget :model="model" :placeholder="`Repeat Password`" attribute="repeat_password" type="password"/>
            <div class="d-flex align-items-center justify-content-between">
              <b-button class="mr-2" variant="outline-light" @click="handleSubmit(onResetPasswordClick)">Submit
              </b-button>
              <router-link :to="{name: 'login'}" class="auth-link">Back to Login</router-link>
            </div>
          </b-form>
        </ValidationObserver>
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

const {mapActions} = createNamespacedHelpers('auth')
export default {
  name: "ResetPasswordForm",
  components: {InputWidget, ViewSpinner, RightSide},
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