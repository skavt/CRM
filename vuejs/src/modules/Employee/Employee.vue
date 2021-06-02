<template>
  <b-card no-body class="invitation-card">
    <b-card-body class="invitation-card-body">
      <view-spinner :show="loading"/>
      <users-table v-if="!loading" :fields="fields" :items="items" @on-user-status-change="onUserStatusChange">
      </users-table>
    </b-card-body>
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import UsersTable from "../Invitation/components/UsersTable";
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('employee')
const {mapActions: mapAuthActions} = createNamespacedHelpers('auth')
export default {
  name: "Employee",
  components: {UsersTable, ViewSpinner},
  data() {
    return {
      loading: false,
      fields: [
        {key: 'id', label: 'ID', sortable: true},
        {key: 'display_name', label: 'Name', sortable: true},
        {key: 'email', label: 'Email', sortable: true},
        {key: 'activeStatus', label: 'User Status', sortable: true},
        {key: 'actions', label: 'Actions'},
      ],
      items: [],
    }
  },
  computed: {
    ...mapState(['employee']),
  },
  methods: {
    ...mapActions(['getEmployeeList']),
    ...mapAuthActions(['updateUserStatus']),
    async onUserStatusChange(item) {
      const {success, body} = await this.updateUserStatus({id: item.id, status: item.activeStatus});
      if (success) {
        this.$toast(`Status changed successfully`);
      } else {
        this.$toast(body.message, 'danger');
      }
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