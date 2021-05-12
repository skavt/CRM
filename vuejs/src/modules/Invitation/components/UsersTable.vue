<template>
  <b-table :fields="fields" dark responsive="sm" small>

  </b-table>
</template>

<script>
export default {
  name: "UsersTable",
  props: {
    fields: {
      type: Array,
      require: true,
    },
  },
}
</script>

<style lang="scss">

.table-responsive-sm {
  padding-right: 8rem;
  padding-left: 8rem;

  > table {
    > thead {
      > tr {
        > th {
          white-space: nowrap;

          &:focus {
            outline: none;
          }
        }
      }
    }
  }
}

</style>