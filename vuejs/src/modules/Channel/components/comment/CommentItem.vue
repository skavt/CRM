<template>
  <b-media class="py-2">
    <template v-slot:aside>
      <b-img rounded="circle" :src="comment.createdBy.image_url  || '/assets/avatar.svg'" width="32" height="32"/>
    </template>
    <h6 class="mt-0 mb-0">
      <span class="user-name">
        {{ comment.createdBy.display_name }}
      </span>
      &sdot;&nbsp;{{ comment.updated_at | relativeDate }}&nbsp;
      <b-button
          v-permission="{'permission': 'leaveComment', channelId: channelId}" v-if="!isChild" size="sm" pill
          variant="light" :pressed.sync="showComments">
        <i class="fas fa-reply fa-lg"/>
        <b-badge class="ml-2" pill variant="secondary">
          {{ comment.childrenComments.length }}
        </b-badge>
      </b-button>
    </h6>
    <span class="comment-wrapper" v-html="comment.comment"/>
    <b-button v-if="canDeleteComment()" @click="onDelete" class="delete-comment" variant="link">
      <i class="far fa-trash-alt text-danger"/>
    </b-button>
    <add-comment :parent_id="comment.id" v-if="showComments" :current-user="currentUser" :channel-id="channelId"/>
    <b-card-body v-if="showComments" class="pt-1 pb-1">
      <comment-item v-for="(comment, index) in comment.childrenComments" :comment="comment" :index="index"
                    :is-child="true" :key="`child-comment-${index}`" :channel-id="channelId">
      </comment-item>
    </b-card-body>
  </b-media>
</template>

<script>
import AddComment from "./AddComment";
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('channel')
export default {
  name: "CommentItem",
  components: {AddComment},
  props: {
    currentUser: {
      type: Object,
    },
    comment: {
      type: Object,
      required: true
    },
    index: {
      type: Number,
      required: true
    },
    channelId: {
      type: Number,
      required: true
    },
    isChild: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {
      showComments: false,
    }
  },
  methods: {
    ...mapActions(['deleteComment']),
    async onDelete() {
      const confirm = await this.$confirm('Are you sure you want to delete following comment ?', 'Deleting Comment...')
      if (confirm) {
        const {success} = await this.deleteComment(this.comment);
        if (!success) {
          this.$toast(`Unable to delete comment`, 'danger');
        }
      }
    },
    canDeleteComment() {
      return this.comment.updated_by === this.currentUser.id
    },
  },
}
</script>

<style lang="scss" scoped>
.media {
  position: relative;
  border-bottom: 1px solid #f1f1f1;

  &:last-child {
    border-bottom: none;
  }
}

.comment-wrapper {
  font-weight: 400;

  & /deep/ img {
    width: 24px;
    margin: 0 1px;
  }
}

.user-name {
  color: #008BCA;
}

.delete-comment {
  position: absolute;
  right: 10px;
  top: 10px;
  color: #495057;
}
</style>