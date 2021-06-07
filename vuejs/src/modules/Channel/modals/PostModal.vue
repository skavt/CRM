<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget :model="model" attribute="title" :autofocus="true"/>
        <input-widget :model="model" attribute="body" :placeholder="`Description`"/>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import PostModel from "../models/PostModel";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "PostModal",
  components: {ViewSpinner, InputWidget},
  data() {
    return {
      model: new PostModel(),
      loading: false,
    }
  },
  computed: {
    ...mapState({
      modal: state => state.post.modal,
    }),
  },
  methods: {
    ...mapActions(['hidePostModal']),
    onSubmit() {

    },
    onHideModal() {
      this.hidePostModal()
    },
  },
}
</script>

<style scoped>

</style>