<template>
  <b-card no-body class="table-responsive mb-0">
    <no-content :show="!hasItems"/>
    <b-table v-if="hasItems" class="mb-0 pb-0" responsive="sm" small head-variant="dark"
             :fields="fields" :items="localItems">
      <template v-slot:cell(created_at)="data">
        {{ new Date(data.item.created_at) | toDatetime }}
      </template>
      <template v-slot:cell(created_by)="data">
        {{ data.item.createdBy.display_name }}
      </template>
      <template v-slot:cell(statusLabel)="data">
        <span class="badge"
              :class="{'badge-warning': data.item.status === 2,'badge-info': data.item.status === 1,'badge-success': data.item.status === 3}">
          {{ data.value }}
        </span>
      </template>
      <template v-slot:cell(actions)="data">
        <i style="visibility: hidden" class="disabled fas fa-pencil-alt mr-3"/>
        <span v-b-tooltip.hover.top="'Delete user'">
          <i class="far fa-trash-alt mr-3 text-danger hover-pointer" @click="onInvitedUserDelete(data.item)"/>
        </span>
      </template>
    </b-table>

    <table-pagination v-if="hasItems" :total-rows="items.length" @on-pagination-change="onPaginationChange"/>
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
  computed: {
    hasItems() {
      return this.localItems.length > 0
    },
  },
  watch: {
    items() {
      this.localItems = [...this.items]
    },
  },
  methods: {
    onPaginationChange(perPage, currentPage) {
      this.localItems = this.items.filter((item, index) => {
        return index >= (currentPage - 1) * perPage && index <= currentPage * perPage - 1
      })
    },
    onInvitedUserDelete(item) {
      this.$emit('on-invited-user-delete', item)
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
          padding: 6px;
          white-space: nowrap;

          &:focus {
            outline: none;
          }
        }
      }
    }

    > tbody {
      > tr {
        > td {
          padding: 8px;
          max-width: 150px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }
      }
    }
  }
}

</style>