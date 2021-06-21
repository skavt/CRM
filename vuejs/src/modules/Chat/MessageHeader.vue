<template>
  <div v-if="selectedContact" class="contact-details p-2 shadow-sm">
    <b-media class="align-items-center">
      <template v-slot:aside>
        <b-img rounded="0" :src="selectedContact.avatar" width="32" height="32"/>
      </template>
      <div class="d-flex justify-content-between">
        <div class="left">
          <h5>
            <template>{{ selectedContact.name }}</template>
          </h5>
        </div>
        <div class="right">
          <div>
            <div class="buttons-wrapper d-flex align-items-center">
              <b-button size="sm" variant="primary" @click="onStartCallClick">
                <i class="fas fa-video"/>
                Start video call
              </b-button>
            </div>
          </div>
        </div>
      </div>
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