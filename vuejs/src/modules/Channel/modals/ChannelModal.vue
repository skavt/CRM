<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget :model="model" attribute="name" :autofocus="true"/>
        <input-widget :model="model" attribute="description"/>
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
  watch: {
    ['modal.data']() {
      if (this.modal.data) {
        this.model = new ChannelModel(this.modal.data);
      }
    }
  },
  methods: {
    ...mapActions(['hideChannelModal', 'createNewChannel', 'updateChannel']),
    async onSubmit() {
      this.loading = true
      this.model.resetErrors()
      let action = 'create'
      if (this.model.id) {
        action = 'update'
      }
      let res
      if (action === 'create') {
        res = await this.createNewChannel({...this.model.toJSON()})
      } else {
        res = await this.updateChannel({...this.model.toJSON()})
      }
      this.loading = false
      if (res.success) {
        if (action === 'create') {
          this.$toast(`Channel ${this.model.name} created successfully`)
        } else {
          this.$toast(`Channel ${this.model.name} updated successfully`)
        }
        this.onHideModal()
      } else {
        this.model.setMultipleErrors(res.body);
      }
    },
    onHideModal() {
      this.hideChannelModal()
      this.model = new ChannelModel()
    },
  },
}
</script>

<style scoped>

</style>