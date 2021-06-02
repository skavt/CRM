<template>
  <ValidationObserver ref="employee-modal" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" :title="`Edit User ${modal.data.display_name}`" :ok-disabled="isClicked" size="lg"
             @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)" @shown="onModalShown">
      <view-spinner :show="loading"/>
      <error-content :show="showError" :error-message="errorMessage"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <input-widget :model="model" attribute="email" :autofocus="true" :placeholder="true" :label="true"/>
              </div>
              <div class="col-md-6">
                <input-widget :model="model" attribute="first_name" :placeholder="true" :label="true"/>
              </div>
              <div class="col-md-6">
                <input-widget :model="model" attribute="last_name" :placeholder="true" :label="true"/>
              </div>
              <div class="col-md-6">
                <input-widget :model="model" attribute="phone" :placeholder="true" :label="true"/>
              </div>
              <div class="col-md-6">
                <input-widget :model="model" attribute="birthday" type="date" :placeholder="true" :label="true"/>
              </div>
            </div>
          </div>
        </div>
        <b-card class="form-cards mb-3">
          <template v-slot:header>
            <div class="d-flex align-items-center">
              <h5 class="mb-0"> Channels </h5>
              <b-button size="sm" type="button" @click="addUserChannel" variant="success" class="ml-auto">
                <i class="fa fa-plus-circle "/>
                Add New
              </b-button>
            </div>
          </template>
          <div class="mb-3" v-for="(channel, index) in model.userChannels" :key="`channel-${index}`">
            <div class="row">
              <div class="col-sm-1 col-1 align-items-center pt-1">
                <b-button v-b-tooltip title="Remove Channel" pill @click="removeUserChannel(index)"
                          variant="outline-danger" size="sm">
                  <i class="fa fa-times"/>
                </b-button>
              </div>
              <div class="col-11">
                <div class="row">
                  <div class="col-sm-12 col-md-8">
                    <input-widget :model="channel" attribute="channel_id" type="select" :options="channelOptions"/>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <input-widget :model="channel" attribute="role" type="select" :options="userRoles"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <no-content :show="!model.userChannels.length" text="User is not part of any channel"/>
        </b-card>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import ErrorContent from "../../../core/components/error-content/ErrorContent";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import EmployeeModel from "../models/EmployeeModel";
import {createNamespacedHelpers} from "vuex";
import {getChannels, hideUserEditModal} from "../../../store/modules/employee/actions";
import NoContent from "../../../core/components/no-content/NoContent";
import UserChannelModel from "../models/UserChannelModel";
import Vue from "vue"

const {mapState, mapActions} = createNamespacedHelpers('employee')
export default {
  name: "EmployeeModal",
  components: {NoContent, InputWidget, ErrorContent, ViewSpinner},
  data() {
    return {
      model: new EmployeeModel(),
      loading: false,
      showError: false,
      errorMessage: '',
      isClicked: false,
      userRoles: [
        {value: null, text: 'Select Role', disabled: true},
        {value: 'user', text: 'User'},
        {value: 'admin', text: 'Admin'},
        {value: 'channelAdmin', text: 'Channel Admin'},
      ],
      channelOptions: [],
    }
  },
  computed: {
    ...mapState({
      modal: state => state.employee.modal
    }),
  },
  watch: {
    ['modal.data']() {
      this.model = new EmployeeModel(this.modal.data);
    }
  },
  methods: {
    ...mapActions(['hideUserEditModal', 'getChannels']),
    onSubmit() {
      console.log(this.model)
    },
    onHideModal() {
      this.hideUserEditModal()
      this.model = new EmployeeModel()
      this.showError = false
      this.isClicked = false
      this.errorMessage = ''
    },
    async onModalShown() {
      const {success, body} = await this.getChannels(this.model.id)
      this.channelOptions = success ? [...body.map(channel => ({value: channel.id, text: channel.name}))] : [];
      this.channelOptions.unshift({value: null, text: 'Select Channel', disabled: true})
    },
    addUserChannel() {
      this.model.userChannels.push(new UserChannelModel());
    },
    removeUserChannel(index) {
      Vue.delete(this.model.userChannels, index)
    },
  },
}
</script>

<style scoped>

</style>