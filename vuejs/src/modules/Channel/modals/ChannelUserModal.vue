<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" size="lg" @hidden="onHideModal"
             @ok.prevent="handleSubmit(onSubmit)" :ok-disabled="model.selectedUsers.length === 0">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <div class="row">
          <div class="col-9">
            <input-widget
                :model="model" attribute="selectedUsers" type="multiselect" :options="userOptions"
                :placeholder="'Search users...'">
            </input-widget>
          </div>
          <div class="col-3">
            <input-widget size="lg" :model="model" attribute="role" type="select" :options="userRoles"/>
          </div>
        </div>
        <input-widget :model="model" attribute="allUser" type="checkbox" :label="true"/>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";
import {addNewUsersInChannel, hideChannelUserModal} from "../../../store/modules/channel/actions";
import ChannelUserModel from "../models/ChannelUserModel";
import InputWidget from "../../../core/components/input-widget/InputWidget";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "ChannelUserModal",
  components: {InputWidget, ViewSpinner},
  data() {
    return {
      model: new ChannelUserModel(),
      loading: false,
      userRoles: [
        {value: 'user', text: 'User'},
        {value: 'admin', text: 'Admin'},
        {value: 'channelAdmin', text: 'Channel Admin'},
      ]
    }
  },
  computed: {
    ...mapState({
      modal: state => state.channel.userModal,
    }),
    userOptions() {
      return this.modal.users.map(user => ({text: user.display_name, value: user.id}))
    },
  },
  watch: {
    ['model.allUser']() {
      if (this.model.allUser) {
        this.model.selectedUsers = [...this.userOptions]
      } else {
        this.model.selectedUsers = [];
      }
    }
  },
  methods: {
    ...mapActions(['hideChannelUserModal', 'addNewUsersInChannel']),
    async onSubmit() {
      this.loading = true
      this.model.resetErrors()
      let params = {
        channel_id: this.modal.data.id,
        role: this.model.role,
        selectedUsers: this.model.selectedUsers.map(s => s.value)
      }
      if (this.model.selectedUsers.length > 0) {
        const {success, body} = await this.addNewUsersInChannel(params)
        if (success) {
          this.$toast(`User(s) added successfully`);
          this.onHideModal();
        } else {
          this.$toast(body, 'danger');
        }
      }
      this.loading = false
    },
    onHideModal() {
      this.hideChannelUserModal()
      this.model = new ChannelUserModel()
    },
  },
}
</script>

<style scoped>

</style>