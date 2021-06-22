<template>
  <div class="chat">
    <view-spinner :show="loading"/>
    <div v-if="working && !loading" class="messenger">
      <contacts/>
      <messages/>
    </div>
    <div v-else-if="!working && !loading" class="messages-error-wrapper">
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
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

const {mapState, mapActions} = createNamespacedHelpers('chat');
export default {
  name: "Chat",
  components: {ViewSpinner, Contacts, Messages},
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    ...mapState(['working']),
  },
  methods: {
    ...mapActions(['getContacts', 'resetChatData']),
  },
  async mounted() {
    this.loading = true
    setTimeout(() => {
      this.loading = false
    }, 1000)
    await this.getContacts()
  },
  destroyed() {
    this.resetChatData();
  },
}
</script>

<style lang="scss" scoped>
.chat {
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

.messenger {
  width: 100%;
  height: 100%;
  background-color: white;
  border: 1px solid #ebebeb;
  display: flex;
}
</style>