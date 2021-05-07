<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Request Password Reset</h4>
        <br>
        <ValidationObserver v-slot="{ handleSubmit }">
          <b-form v-on:submit.prevent="handleSubmit(onResetPasswordClick)">
            <input-widget :model="model" attribute="email" :placeholder="true"/>
            <div class="d-flex align-items-center justify-content-between">
              <button class="btn btn-outline-light mr-2">
                Submit
              </button>
              <router-link :to="{name: 'login'}" class="back-to-login-link">
                Back to Login
              </router-link>
            </div>
          </b-form>
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

const {mapActions} = createNamespacedHelpers('auth')
export default {
  name: "ResetPasswordRequest",
  components: {RightSide, InputWidget},
  data() {
    return {
      model: new ResetPasswordRequestModel(),
    }
  },
  methods: {
    ...mapActions(['resetPassword']),
    async onResetPasswordClick() {
      const {success, body} = await this.resetPassword({...this.model.toJSON()})
      if (success) {
        console.log(body)
      } else {
        this.model.setMultipleErrors([{field: 'email', message: body}]);
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.back-to-login-link {
  color: white;
}
</style>