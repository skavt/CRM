<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Request Password Reset</h4>
        <br>
        <view-spinner :show="loading"/>
        <ValidationObserver v-if="!loading" v-slot="{ handleSubmit }">
          <input-widget :model="model" :placeholder="true" attribute="email"/>
          <div class="d-flex align-items-center justify-content-between">
            <b-button class="mr-2" variant="outline-light" @click="handleSubmit(onResetPasswordRequestClick)">
              Submit
            </b-button>
            <router-link :to="{name: 'login'}" class="auth-link">Back to Login</router-link>
          </div>
        </ValidationObserver>
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

const {mapActions} = createNamespacedHelpers('auth')
export default {
  name: "ResetPasswordRequest",
  components: {ViewSpinner, RightSide, InputWidget},
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