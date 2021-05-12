<template>
  <div>
    <no-content :show="items.length === 0"/>
    <b-table v-if="items.length > 0" :fields="fields" :items="items" dark responsive="sm" small>

    </b-table>
  </div>
</template>

<script>
import NoContent from "../../../core/components/no-content/NoContent";

export default {
  name: "UsersTable",
  components: {NoContent},
  props: {
    fields: {
      type: Array,
      require: true,
    },
    items: {
      type: Array,
      require: true,
    },
  },
}
</script>

<style lang="scss">

.table-responsive-sm {
  padding: 20px;

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