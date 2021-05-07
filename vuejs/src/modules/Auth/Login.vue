<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Login to your account</h4>
        <br>
        <view-spinner :show="loading"/>
        <ValidationObserver v-if="!loading" v-slot="{ handleSubmit }">
          <b-form v-on:submit.prevent="handleSubmit(onLoginClick)">
            <input-widget :model="model" attribute="email" :placeholder="true"/>
            <input-widget :model="model" attribute="password" type="password" :placeholder="true"/>
            <div class="d-flex align-items-center justify-content-between">
              <button class="btn btn-outline-light mr-2">
                Login
              </button>
              <router-link :to="{name: 'reset-password-request'}" class="reset-password-link">
                Request new password
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
import InputWidget from "../../core/components/input-widget/InputWidget";
import LoginModel from "./LoginModel";
import {createNamespacedHelpers} from "vuex";
import RightSide from "./components/RightSide";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

const {mapActions} = createNamespacedHelpers('auth')

export default {
  name: "Login",
  components: {ViewSpinner, RightSide, InputWidget},
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
        console.log(body)
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

.reset-password-link {
  color: white;
}
</style>