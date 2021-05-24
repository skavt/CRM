<template>
  <b-card no-body class="post-card">
    <b-card-header>
      <b-button variant="light" class="mr-3" @click="$router.go(-1)">
        <i class="fas fa-chevron-left"/>
        Back
      </b-button>
      <b-button class="float-right" variant="secondary" size="sm" @click="onCreatePostClick">
        <i class="fas fa-plus"/>
        Create Post
      </b-button>
    </b-card-header>

    <b-card-body class="post-card-body">
      <view-spinner :show="loading"/>
      <div v-if="!loading" class="page-content">

      </div>
    </b-card-body>
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

export default {
  name: "Post",
  components: {ViewSpinner},
  data() {
    return {
      loading: false,
    }
  },
  computed: {},
  methods: {
    onCreatePostClick() {

    },
  },
  mounted() {
    this.loading = true
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>

.post-card {
  height: 100%;
  width: 100%;
}

.post-card-body {
  background: #E8E8E8;
  padding: 0;
  overflow-x: hidden;
  overflow-y: auto;
}

.page-content {
  position: relative;
}

</style>