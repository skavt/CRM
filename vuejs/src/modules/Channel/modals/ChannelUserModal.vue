<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <h1>Test</h1>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";
import {hideChannelUserModal} from "../../../store/modules/channel/actions";
import ChannelUserModel from "../models/ChannelUserModel";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "ChannelUserModal",
  components: {ViewSpinner},
  data() {
    return {
      model: new ChannelUserModel(),
      loading: false,
    }
  },
  computed: {
    ...mapState({
      modal: state => state.channel.userModal,
    }),
  },
  methods: {
    ...mapActions(['hideChannelUserModal']),
    async onSubmit() {
      this.loading = true
      this.model.resetErrors()
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