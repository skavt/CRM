<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Invite New User" :ok-disabled="isClicked"
             @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <error-content :show="showError" :error-message="errorMessage"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget :model="model" attribute="email" :autofocus="true" :placeholder="true" :label="true"/>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import {createNamespacedHelpers} from "vuex";
import InvitationModel from "../models/InvitationModel";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import ErrorContent from "../../../core/components/error-content/ErrorContent";

const {mapState, mapActions} = createNamespacedHelpers('invitation')
export default {
  name: "InvitationModal",
  components: {ErrorContent, ViewSpinner, InputWidget},
  data() {
    return {
      model: new InvitationModel(),
      loading: false,
      showError: false,
      errorMessage: '',
      isClicked: false,
    }
  },
  computed: {
    ...mapState({
      modal: state => state.invitation.modal,
    }),
  },
  methods: {
    ...mapActions(['hideInvitationModal', 'inviteUser']),
    onHideModal() {
      this.hideInvitationModal()
      this.model = new InvitationModel()
      this.showError = false
      this.isClicked = false
      this.errorMessage = ''
    },
    async onSubmit() {
      this.isClicked = true
      this.showError = false
      this.loading = true
      this.model.resetErrors()
      const {success, body} = await this.inviteUser({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$toast(`Email ${this.model.email} was successfully invited`)
        this.onHideModal()
      } else {
        this.showError = true
        this.isClicked = false
        this.errorMessage = body.map(error => error.message).join(' ')
      }
    },
  },
}
</script>

<style scoped>

</style>