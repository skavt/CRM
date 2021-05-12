<template>
  <b-card no-body>
    <no-content :show="localItems.length === 0"/>
    <b-table class="mb-0 pb-0" :fields="fields" :items="localItems" dark responsive="sm" small>

    </b-table>

    <table-pagination :total-rows="items.length" @on-pagination-change="onPaginationChange"/>
  </b-card>
</template>

<script>
import NoContent from "../../../core/components/no-content/NoContent";
import TablePagination from "../../../core/components/table-pagination/TablePagination";

export default {
  name: "UsersTable",
  components: {TablePagination, NoContent},
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
  data() {
    return {
      localItems: [],
    }
  },
  methods: {
    onPaginationChange(perPage, currentPage) {
      this.localItems = this.items.filter((item, index) => {
        return index >= (currentPage - 1) * perPage && index <= currentPage * perPage - 1
      })
    },
  },
  mounted() {
    this.localItems = [...this.items]
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