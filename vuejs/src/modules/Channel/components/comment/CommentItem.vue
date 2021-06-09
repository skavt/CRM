<template>
  <b-media class="py-2">
    <template v-slot:aside>
      <b-img rounded="circle" :src="comment.createdBy.image_url  || '/assets/img/avatar.svg'" width="32" height="32"/>
    </template>
    <h6 class="mt-0 mb-0">
      <span class="user-name">
        {{ comment.createdBy.display_name }}
      </span>
      &sdot;&nbsp;{{ comment.updated_at | relativeDate }}&nbsp;
      <b-button v-if="!isChild" size="sm" pill variant="light" :pressed.sync="showComments">
        <i class="fas fa-reply fa-lg"/>
        <b-badge class="ml-2" pill variant="secondary">
          {{ comment.childrenComments.length }}
        </b-badge>
      </b-button>
    </h6>
    <span class="comment-wrapper" v-html="comment.comment"/>
    <add-comment :parent_id="comment.id" v-if="showComments" :currentUser="currentUser"/>
    <b-card-body v-if="showComments" class="pt-1 pb-1">
      <comment-item v-for="(comment, index) in comment.childrenComments" :comment="comment" :index="index"
                    :is-child="true" :key="`child-comment-${index}`">
      </comment-item>
    </b-card-body>
  </b-media>
</template>

<script>
import AddComment from "./AddComment";

export default {
  name: "CommentItem",
  components: {AddComment},
  props: {
    currentUser: {
      type: Object,
      require: true
    },
    comment: {
      type: Object,
      require: true
    },
    index: {
      type: Number,
      require: true
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
</style>