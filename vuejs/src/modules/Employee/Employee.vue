<template>
  <b-card no-body class="invitation-card">
    <b-card-body class="invitation-card-body">
      <view-spinner :show="loading"/>
      <users-table v-if="!loading" :fields="fields" :items="items" :type="`employee`"
                   @on-user-status-change="onUserStatusChange" @on-user-delete="onUserDelete"
                   @on-user-edit="onUserEdit">
      </users-table>
      <employee-modal/>
    </b-card-body>
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import UsersTable from "../Invitation/components/UsersTable";
import {createNamespacedHelpers} from "vuex";
import EmployeeModal from "./modals/EmployeeModal";

const {mapState, mapActions} = createNamespacedHelpers('employee')
const {mapActions: mapAuthActions} = createNamespacedHelpers('auth')
export default {
  name: "Employee",
  components: {EmployeeModal, UsersTable, ViewSpinner},
  data() {
    return {
      loading: false,
      fields: [
        {key: 'id', label: 'ID', sortable: true},
        {key: 'display_name', label: 'Name', sortable: true},
        {key: 'email', label: 'Email', sortable: true},
        {key: 'phone', label: 'Phone', sortable: true},
        {key: 'birthday', label: 'Birthday', sortable: true},
        {key: 'position', label: 'Position', sortable: true},
        {key: 'activeStatus', label: 'User Status', sortable: true},
        {key: 'actions', label: 'Actions'},
      ],
      items: [],
    }
  },
  computed: {
    ...mapState(['employee']),
  },
  watch: {
    ['employee.data']() {
      this.items = [...this.employee.data]
    },
  },
  methods: {
    ...mapActions(['getEmployeeList', 'deleteUser', 'showUserEditModal']),
    ...mapAuthActions(['updateUserStatus']),
    async onUserStatusChange(item) {
      const {success, body} = await this.updateUserStatus({id: item.id, status: item.activeStatus});
      if (success) {
        this.$toast(`Status changed successfully`);
      } else {
        this.$toast(body.message, 'danger');
      }
    },
    async onUserDelete(item) {
      const result = await this.$confirm(`Are you sure you want to delete ${item.display_name} user?`, `Deleting User...`)
      if (result) {
        const {success, body} = await this.deleteUser(item)
        if (success) {
          this.$toast(`User deleted successfully`)
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
    onUserEdit(item) {
      this.showUserEditModal(item)
    },
  },
  async mounted() {
    this.loading = true
    await this.getEmployeeList()
    this.items = [...this.employee.data]
    this.loading = false
  },
}
</script>

<style scoped>

</style>