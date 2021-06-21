<template>
  <div class="messenger">
    <div v-if="working">
      <contacts/>
      <messages/>
    </div>
    <div v-else class="messages-error-wrapper">
      <div class="alert alert-danger d-flex align-items-center">
        <i class="fas fa-exclamation-triangle mr-2" :size="'2x'"/>
        Chat is not available right now. Please contact our support.
      </div>
    </div>
  </div>
</template>

<script>
import Messages from "./Messages";
import Contacts from "./Contacts";
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('chat');
export default {
  name: "Chat",
  components: {Contacts, Messages},
  computed: {
    ...mapState(['working']),
  },
  methods: {
    ...mapActions(['getContacts']),
  },
  async mounted() {
    await this.getContacts()
  },
}
</script>

<style lang="scss" scoped>
.messenger {
  width: 100%;
  height: 100%;

  .messages-error-wrapper {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    background: #E8E8E8;

    .messages-error {
      width: 100%;
      left: 0;
      position: absolute;
    }
  }
}
</style>