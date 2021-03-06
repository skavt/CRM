<template>
  <b-card no-body class="table-responsive mb-0">
    <no-content :show="!hasItems"/>
    <b-table v-if="hasItems" class="mb-0 pb-0" responsive="sm" small head-variant="dark"
             :fields="localFields" :items="localItems">
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
      <template v-slot:cell(activeStatus)="data">
        <b-form-checkbox v-if="data.item.activeStatus !== null" v-model="data.item.activeStatus" switch size="lg"
                         :disabled="!isAdmin" @change="onUserStatusChange(data.item)">
        </b-form-checkbox>
      </template>
      <template v-slot:cell(actions)="data">
        <i v-if="isInvitation()" style="visibility: hidden" class="disabled fas fa-pencil-alt mr-3"/>
        <span v-if="isEmployee()" v-b-tooltip.hover.top="'Edit User'">
          <i class="fas fa-pencil-alt mr-3 text-primary hover-pointer" @click="onUserEdit(data.item)"/>
        </span>
        <span v-b-tooltip.hover.top="'Delete User'">
          <i class="far fa-trash-alt mr-3 text-danger hover-pointer" @click="onUserDelete(data.item)"/>
        </span>
      </template>
    </b-table>

    <table-pagination
        ref="pagination" v-if="hasItems" :total-rows="items.length" @on-pagination-change="onPaginationChange">
    </table-pagination>
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
    type: {
      type: String,
      require: true,
    },
    isAdmin: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {
      localItems: [],
      perPage: null,
    }
  },
  computed: {
    hasItems() {
      return this.localItems.length > 0
    },
    localFields() {
      return this.isAdmin ? [...this.fields, {key: 'actions', label: 'Actions'}] : [...this.fields]
    },
  },
  watch: {
    items() {
      this.localItems = [...this.items]
      if (this.perPage) {
        this.onPaginationChange(this.perPage, 1)
        this.$refs.pagination.currentPage = 1
      }
    },
  },
  methods: {
    onPaginationChange(perPage, currentPage) {
      this.perPage = perPage
      this.localItems = this.items.filter((item, index) => {
        return index >= (currentPage - 1) * perPage && index <= currentPage * perPage - 1
      })
    },
    onUserDelete(item) {
      this.$emit('on-user-delete', item)
    },
    onUserEdit(item) {
      this.$emit('on-user-edit', item)
    },
    onUserStatusChange(item) {
      this.$nextTick(() => {
        this.$emit('on-user-status-change', item)
      })
    },
    isEmployee() {
      return this.type === 'employee'
    },
    isInvitation() {
      return this.type === 'invitation'
    },
  },
  mounted() {
    this.localItems = [...this.items]
  },
}
</script>

<style lang="scss">

.table-responsive {
  height: 100%;
}

.table-responsive-sm {
  height: 100%;
  overflow: auto;

  > table {
    > thead {
      > tr {
        > th {
          position: sticky;
          z-index: 10;
          top: 0;
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