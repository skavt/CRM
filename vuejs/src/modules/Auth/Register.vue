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
import {createNamespacedHelpers} from "vuex";
import RightSide from "./components/RightSide";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import RegisterModel from "./models/RegisterModel";
import AuthForm from "./components/AuthForm";

const {mapActions} = createNamespacedHelpers('auth')
const {mapActions: mapInvitationActions} = createNamespacedHelpers('invitation')

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
    ...mapInvitationActions(['checkInvitationToken']),
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
  async mounted() {
    this.model.token = this.$route.params.token

    const {success, body} = await this.checkInvitationToken(this.model.token)
    if (success) {
      this.model.email = body
    } else {
      this.$toast(body, 'danger')
      this.$router.push({name: 'login'})
    }
  },
}
</script>

<style lang="scss" scoped>
.col-right {
  position: relative;
}
</style>