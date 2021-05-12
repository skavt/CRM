<template>
  <div class="row">
    <div class="col-md-6">
      <div class="auth-left">
        <h4>Login to your account</h4>
        <br>
        <view-spinner :show="loading"/>
        <ValidationObserver v-if="!loading" v-slot="{ handleSubmit }">
          <b-form @keydown.enter.prevent="handleSubmit(onLoginClick)">
            <input-widget :model="model" :placeholder="true" attribute="email" :disabled="true"/>
            <input-widget :model="model" :placeholder="`First Name`" attribute="first_name" :autofocus="true"/>
            <input-widget :model="model" :placeholder="`Last Name`" attribute="last_name"/>
            <input-widget :model="model" :placeholder="true" attribute="password" type="password"/>
            <input-widget :model="model" :placeholder="`Repeat Password`" attribute="repeat_password" type="password"/>
            <div class="d-flex align-items-center justify-content-between">
              <b-button class="mr-2" variant="outline-light" @click="handleSubmit(onLoginClick)">Register</b-button>
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
import InputWidget from "../../core/components/input-widget/InputWidget";
import LoginModel from "./LoginModel";
import {createNamespacedHelpers} from "vuex";
import RightSide from "./components/RightSide";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import RegisterModel from "./RegisterModel";

const {mapActions} = createNamespacedHelpers('auth')

export default {
  name: "Register",
  components: {ViewSpinner, RightSide, InputWidget},
  data() {
    return {
      model: new RegisterModel(),
      loading: false,
    }
  },
  methods: {
    ...mapActions(['register']),
    async onLoginClick() {
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