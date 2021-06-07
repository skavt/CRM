<template>
  <b-button @click="onLikeClick" size="sm" pill :variant="liked ? 'info' : 'light'">
    <i class="far fa-thumbs-up fa-lg"/>
    Like
    <b-badge v-if="item" class="ml-2" v-b-popover.hover.top.html="updateLikes()" pill variant="secondary">
      {{ item.length }}
    </b-badge>
  </b-button>
</template>

<script>
export default {
  name: "LikeUnlikeButton",
  props: {
    item: {
      type: Array,
    },
    liked: {
      type: Boolean,
      require: true
    },
  },
  methods: {
    onLikeClick() {
      this.$emit('on-like-click')
    },
    updateLikes() {
      this.likes = "";
      let limit = 10;
      let currentLimit = (this.item.length < limit) ? this.item.length : limit;
      for (let i = 0; i < currentLimit; i++) {
        this.likes += this.item[i].createdBy.display_name + "<br>"
      }
      if (this.item.length > limit) {
        this.likes += `And ${this.item.length - limit} other(s)`;
      }

      return {
        content: this.likes
      }
    },
  },
}
</script>

<style scoped>

</style>