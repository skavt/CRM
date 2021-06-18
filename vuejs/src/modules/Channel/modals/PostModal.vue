<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" :title="getTitle" @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget
            :model="model" :multiple="true" attribute="files" type="file" :format-names="formatNames" :label="false"
            :placeholder="'Choose files or drop here...'">
        </input-widget>
        <div class="mt-3 mb-3" v-if="model.files.length">
          <h5>Selected File{{ model.files.length > 1 ? 's' : '' }}:</h5>
          <div class="d-flex justify-content-between pl-2 pr-2 pb-1" v-for="file in model.files"
               :key="`post-file-${file.name}`">
            <span class="file-header mr-2">
              {{ file.name }}
            </span>
            <i class="fas fa-times text-danger remove-file" @click="onFileRemoveClick(file)"/>
          </div>
        </div>
        <div class="grow-wrap">
          <b-form-textarea
              v-model="model.body" placeholder="Description" :autofocus="true" name="text" id="text"
              onInput="this.parentNode.dataset.replicatedValue = this.value">
          </b-form-textarea>
        </div>
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
    getTitle() {
      return this.model.id ? 'Update Post' : 'Create New Post'
    },
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
    formatNames() {
      return this.model.files.length === 1 ? this.model.files[0].name : `${this.model.files.length} files selected`
    },
    onFileRemoveClick(file) {
      this.model.files = this.model.files.filter(f => f.name !== file.name)
    },
  },
}
</script>

<style lang="scss" scoped>
.remove-file {
  cursor: pointer;
  display: flex;
  align-items: center;
}

.file-header {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.grow-wrap {
  display: grid;
}

.grow-wrap::after {
  content: attr(data-replicated-value) " ";
  white-space: pre-wrap;
  visibility: hidden;
}

.grow-wrap > textarea {
  resize: none;
  overflow: hidden;
}

.grow-wrap > textarea,
.grow-wrap::after {
  padding: 0.5rem;
  font: inherit;
  grid-area: 1 / 1 / 2 / 2;
}
</style>