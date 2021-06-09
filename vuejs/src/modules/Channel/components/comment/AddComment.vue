<template>
  <b-card-body
      v-permission="{'permission': 'leaveComment', channelId: channelId}" class="pt-1"
      :class="!parent_id ? 'bg-light' : ''">
    <b-media>
      <template v-slot:aside>
        <b-img rounded="circle" :src="currentUser.image_url  || '/assets/avatar.svg'" width="32" height="32"/>
      </template>
      <b-form @submit.prevent="onAdd">
        <b-input-group>
          <b-form-input v-model="comment" :placeholder="parent_id ? 'Write a replay' : 'Leave Comment'"/>
          <b-input-group-append>
            <b-button @click="onAdd" variant="info">
              Comment
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>
    </b-media>
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
  },
  data() {
    return {
      comment: '',
    }
  },
  methods: {
    ...mapActions(['addComment']),
    async onAdd() {
      if (this.comment) {
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

<style scoped>

</style>