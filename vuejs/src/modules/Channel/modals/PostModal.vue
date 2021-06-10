<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" title="Add New Channel" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget
            :model="model" :multiple="true" attribute="files" type="file" :format-names="formatNames"
            :placeholder="'Choose files or drop here...'">
        </input-widget>
        <div class="mt-3" v-if="model.files.length">
          <h6 v-for="file in model.files" :key="`post-file-${file.name}`">
            {{ file.name }}
          </h6>
        </div>
        <input-widget
            :model="model" attribute="body" :placeholder="`Description`" :autofocus="true"
            :type="`textarea`" :objStyle="{'min-height': '200px', 'max-height': '700px'}">
        </input-widget>
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
  watch: {
    ['modal.data']() {
      if (this.modal.data) {
        this.model = new PostModel(this.modal.data);
      }
    },
  },
  methods: {
    ...mapActions(['hidePostModal', 'createNewPost', 'updatePost']),
    async onSubmit() {
      this.model.resetErrors()
      let form = {...this.model.toJSON()}
      form.channel_id = this.$route.params.channelId

      this.loading = true
      let res
      if (!form.id) {
        res = await this.createNewPost(form)
      } else {
        res = await this.updatePost(form)
      }
      this.loading = false

      if (res.success) {
        if (!form.id) {
          this.$toast(`Post created successfully`)
        } else {
          this.$toast(`Post updated successfully`)
        }
        this.onHideModal()
      } else {
        this.model.setMultipleErrors(res.body);
      }
    },
    onHideModal() {
      this.hidePostModal()
      this.model = new PostModel()
    },
    formatNames(files) {
      return files.length === 1 ? files[0].name : `${files.length} files selected`
    },
  },
}
</script>

<style scoped>

</style>