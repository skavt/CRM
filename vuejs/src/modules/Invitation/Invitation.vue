<template>
  <b-card no-body class="invitation-card">
    <b-card-header>
      <b-button class="float-right" variant="secondary" size="sm" @click="onUserInviteClick">
        <i class="fas fa-plus"/>
        Invite User
      </b-button>
    </b-card-header>
    <users-table :fields="fields" :items="items"/>
    <invitation-modal/>
  </b-card>
</template>

<script>
import UsersTable from "./components/UsersTable";
import InvitationModal from "./modals/InvitationModal";
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('invitation')
export default {
  name: "Invitation",
  components: {InvitationModal, UsersTable},
  data() {
    return {
      fields: [
        {key: 'id', label: 'ID', sortable: true},
        {key: 'email', label: 'Email', sortable: true},
        {key: 'statusLabel', label: 'Status', sortable: true},
        {key: 'created_at', label: 'Invitation Date', sortable: true},
        {key: 'created_by', label: 'Invited By', sortable: true},
        {key: 'token_used_date', label: 'Registration Date', sortable: true},
        {key: 'actions', label: 'Actions'},
      ],
      items: [],
    }
  },
  methods: {
    ...mapActions(['showInvitationModal']),
    onUserInviteClick() {
      this.showInvitationModal()
    },
  },
}
</script>

<style lang="scss">

.invitation-card {
  margin-right: 8rem;
  margin-left: 8rem;
}

</style>