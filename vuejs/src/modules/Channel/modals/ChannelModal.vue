<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget :model="model" attribute="name" :autofocus="true" :placeholder="true" :label="true"/>
        <input-widget :model="model" attribute="description" :placeholder="true" :label="true"/>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import ChannelModel from "../models/ChannelModel";
import {createNamespacedHelpers} from "vuex";
import {createNewChannel, hideChannelModal} from "../../../store/modules/channel/actions";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "ChannelModal",
  components: {InputWidget, ViewSpinner},
  data() {
    return {
      model: new ChannelModel(),
      loading: false,
    }
  },
  computed: {
    ...mapState({
      modal: state => state.channel.modal,
    }),
  },
  methods: {
    ...mapActions(['hideChannelModal', 'createNewChannel']),
    async onSubmit() {
      this.loading = true
      this.model.resetErrors()
      const {success, body} = await this.createNewChannel({...this.model.toJSON()})
      this.loading = false
      if (success) {
        this.$toast(`Channel ${this.model.name} created successfully`)
        this.onHideModal()
      } else {
        this.model.setMultipleErrors(body);
      }
    },
    onHideModal() {
      this.hideChannelModal()
    },
  },
}
</script>

<style scoped>

</style>