<template>
  <b-card no-body class="invitation-card">
    <b-card-header>
      <b-button class="float-right" variant="secondary" size="sm" @click="onUserInviteClick">
        <i class="fas fa-plus"/>
        Invite User
      </b-button>
    </b-card-header>
    <view-spinner :show="loading"/>
    <users-table v-if="!loading" :fields="fields" :items="items" @on-invited-user-delete="onInvitedUserDelete"/>
    <invitation-modal/>
  </b-card>
</template>

<script>
import UsersTable from "./components/UsersTable";
import InvitationModal from "./modals/InvitationModal";
import {createNamespacedHelpers} from "vuex";
import {getInvitedUsers} from "../../store/modules/invitation/actions";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

const {mapState, mapActions} = createNamespacedHelpers('invitation')
export default {
  name: "Invitation",
  components: {ViewSpinner, InvitationModal, UsersTable},
  data() {
    return {
      fields: [
        {key: 'id', label: 'ID', sortable: true},
        {key: 'email', label: 'Email', sortable: true},
        {key: 'created_at', label: 'Invitation Date', sortable: true},
        {key: 'created_by', label: 'Invited By', sortable: true},
        {key: 'token_used_date', label: 'Registration Date', sortable: true},
        {key: 'statusLabel', label: 'Status', sortable: true},
        {key: 'actions', label: 'Actions'},
      ],
      loading: false,
      items: [],
    }
  },
  computed: {
    ...mapState(['invitation']),
  },
  watch: {
    ['invitation.data']() {
      this.items = [...this.invitation.data]
    }
  },
  methods: {
    ...mapActions(['showInvitationModal', 'getInvitedUsers', 'deleteInvitedUser']),
    onUserInviteClick() {
      this.showInvitationModal()
    },
    async onInvitedUserDelete(item) {
      const result = await this.$confirm(`Are you sure you want to delete ${item.email} user?`, `Deleting Invited User...`)
      if (result) {
        const {success, body} = await this.deleteInvitedUser(item)
        if (success) {
          this.$toast(`User deleted successfully`)
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
  },
  async mounted() {
    this.loading = true
    await this.getInvitedUsers()
    this.items = [...this.invitation.data]
    this.loading = false
  },
}
</script>

<style lang="scss">

.invitation-card {
  margin-right: 8rem;
  margin-left: 8rem;
}

</style>