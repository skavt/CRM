<template>
  <UsersTable :fields="fields"/>
</template>

<script>
import UsersTable from "./components/UsersTable";

export default {
  name: "Invitation",
  components: {UsersTable},
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
    }
  },
}
</script>

<style scoped>

</style>