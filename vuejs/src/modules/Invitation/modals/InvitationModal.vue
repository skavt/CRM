<template>
  <b-modal v-model="modal.show" title="Invite New User" @hidden="onHideModal">

  </b-modal>

</template>

<script>
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('invitation')
export default {
  name: "InvitationModal",
  computed: {
    ...mapState({
      modal: state => state.invitation.modal,
    }),
  },
  methods: {
    ...mapActions(['hideInvitationModal']),
    onHideModal() {
      this.hideInvitationModal()
    },
  },
}
</script>

<style scoped>

</style>