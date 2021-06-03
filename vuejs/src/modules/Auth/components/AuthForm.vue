<template>
  <ValidationObserver v-if="!loading" v-slot="{ handleSubmit }">
    <b-form @keydown.enter.prevent="handleSubmit(onSubmit)">
      <input-widget :model="model" attribute="email" :autofocus="true" :disabled="disabledEmail" :label="false"/>
      <input-widget
          v-if="isRegister()" :model="model" :placeholder="`First Name`" attribute="first_name" :autofocus="true"
          :label="false">
      </input-widget>
      <input-widget v-if="isRegister()" :model="model" :placeholder="`Last Name`" attribute="last_name" :label="false"/>
      <input-widget v-if="showPassword" :model="model" attribute="password" type="password" :label="false"/>
      <input-widget v-if="showRepeatPassword" :model="model" :placeholder="`Repeat Password`"
                    attribute="repeat_password" type="password" :label="false">
      </input-widget>
      <div class="d-flex align-items-center justify-content-between">
        <b-button class="mr-2" variant="outline-light" @click="handleSubmit(onSubmit)">{{ getButtonName() }}</b-button>
        <router-link :to="{name: getLinkPath()}" class="auth-link">{{ getLinkName() }}</router-link>
      </div>
    </b-form>
  </ValidationObserver>
</template>

<script>
import InputWidget from "../../../core/components/input-widget/InputWidget";

export default {
  name: "AuthForm",
  components: {InputWidget},
  props: {
    model: Object,
    loading: Boolean,
    formType: String,
    showPassword: {
      type: Boolean,
      default: true,
    },
    showRepeatPassword: {
      type: Boolean,
      default: false,
    },
    disabledEmail: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    getButtonName() {
      return this.isLogin() ? 'Login' : this.isRegister() ? 'Register' : 'Submit'
    },
    getLinkPath() {
      return this.isLogin() ? 'reset-password-request' : 'login'
    },
    getLinkName() {
      return this.isLogin() ? 'Request New Password' : 'Back to Login'
    },
    onSubmit() {
      if (this.isLogin()) {
        this.$emit('on-login-click')
      } else if (this.isRequestPass()) {
        this.$emit('on-request-pass-click')
      } else if (this.isResetPass()) {
        this.$emit('on-reset-pass-click')
      } else if (this.isRegister()) {
        this.$emit('on-register-click')
      }
    },
    isLogin() {
      return this.formType === 'login'
    },
    isRequestPass() {
      return this.formType === 'requestPass'
    },
    isResetPass() {
      return this.formType === 'resetPass'
    },
    isRegister() {
      return this.formType === 'register'
    },
  },
}
</script>

<style scoped>

</style>