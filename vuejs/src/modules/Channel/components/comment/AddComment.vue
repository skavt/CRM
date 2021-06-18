<template>
  <b-card-body
      v-permission="{'permission': 'leaveComment', channelId: channelId}" class="pt-1"
      :class="!parent_id ? 'bg-light' : ''">
    <ValidationObserver ref="form" v-slot="{ handleSubmit}">
      <b-media>
        <template v-slot:aside>
          <b-img rounded="circle" :src="currentUser.image_url || '/assets/avatar.svg'" width="32" height="32"/>
        </template>
        <b-form @submit.prevent="handleSubmit(onAdd)" @keydown="onKeydown">
          <div class="grow-wrap">
            <b-form-textarea
                v-model="comment" :placeholder="parent_id ? 'Write a replay...' : 'Leave Comment...'"
                :autofocus="isChild"
                name="text" id="text" onInput="this.parentNode.dataset.replicatedValue = this.value">
            </b-form-textarea>
            <b-button @click="onAdd" class="add-comment" variant="link" size="lg">
              <i class="fas fa-paper-plane"/>
            </b-button>
          </div>
        </b-form>
      </b-media>
    </ValidationObserver>
  </b-card-body>
</template>

<script>
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('channel')

export default {
  name: "AddComment",
  props: {
    currentUser: {
      type: Object
    },
    post_id: {
      type: Number,
    },
    parent_id: {
      type: Number
    },
    channelId: {
      type: Number,
      required: true
    },
    isChild: {
      type: Boolean
    },
  },
  data() {
    return {
      comment: '',
    }
  },
  methods: {
    ...mapActions(['addComment']),
    onKeydown(event) {
      if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault()
        if (this.comment.trim()) {
          this.onAdd()
        }
      }
    },
    async onAdd() {
      if (this.comment.trim()) {
        let params = {
          comment: this.comment,
          parent_id: this.parent_id,
          post_id: this.post_id,
        }

        const {success} = await this.addComment(params);
        if (!success) {
          this.$toast(`This comment not saved`, 'danger');
        }
        this.comment = ''
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.media {
  position: relative;
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
  border-radius: 15px;
  grid-area: 1 / 1 / 2 / 2;
}

.add-comment {
  position: absolute;
  bottom: 0;
  right: 0;
}
</style>