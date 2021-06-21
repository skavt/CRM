<template>
  <div v-if="selectedContact" class="shadow-sm">
    <b-media class="p-3">
      <b-media-body class="d-flex justify-content-between">
        <div class="d-flex align-items-center">
          <b-img rounded="0" :src="selectedContact.avatar" width="32" height="32"/>
          <h5 class="mb-0 ml-2">{{ selectedContact.name }}</h5>
        </div>
        <div class="d-flex align-items-center">
          <b-button size="sm" variant="primary" @click="onStartCallClick">
            <i class="fas fa-video"/>
            Start video call
          </b-button>
        </div>
      </b-media-body>
    </b-media>
  </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('chat');
const {mapState: mapEmployeeState} = createNamespacedHelpers('employee');
export default {
  name: "MessageHeader",
  computed: {
    ...mapState(['selectedContact']),
    ...mapEmployeeState(['currentUser']),
  },
  methods: {
    onStartCallClick() {

    },
  },
}
</script>

<style scoped>

</style>