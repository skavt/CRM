<template>
  <div class="messages-wrapper">
    <message-header/>
    <div class="messages-ctr" v-if="selectedContact">
      <div class="messages" ref="messages" @scroll="scrollChange">
        <message :message="message" v-for="message in messages" :key="message.id"/>
      </div>
      <button @click="scrollDown" class="unread-messages" v-if="hasUnreadMessages">
        Unread messages
      </button>
    </div>
    <div class="input-area" v-if="selectedContact">
      <b-form @submit="onSubmit">
        <b-input-group>
          <b-input v-model="message" placeholder="Write Message..."/>
          <b-input-group-append>
            <b-button class="btn-send" :disabled="!selectedContact" @click="onSendMessageClick">
              <i class="fas fa-paper-plane"/>
              Send
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>
    </div>
  </div>
</template>

<script>
import MessageHeader from "./MessageHeader";
import {createNamespacedHelpers} from "vuex";
import Message from "./Message";

const {mapState, mapGetters, mapActions} = createNamespacedHelpers('chat');
export default {
  name: "Messages",
  components: {Message, MessageHeader},
  data() {
    return {
      message: '',
    }
  },
  computed: {
    ...mapState(['selectedContact']),
    ...mapGetters(['messages', 'hasUnreadMessages']),
  },
  methods: {
    ...mapActions(['socketSendMessage']),
    scrollChange() {
      if (this.isScrollAtTheBottom()) {
        // this.setUnreadMessages(false);
      }
    },
    isScrollAtTheBottom() {
      const messages = this.$refs.messages;
      if (!messages) {
        return false;
      }
      return Math.ceil(messages.offsetHeight + messages.scrollTop) >= messages.scrollHeight;
    },
    scrollDown() {
      const messages = this.$refs.messages;
      if (messages) {
        messages.scrollTop = 10000000;
      }
    },
    onSubmit(event) {
      event.stopPropagation()
      event.preventDefault()
    },
    onSendMessageClick(event) {
      event.stopPropagation()
      event.preventDefault()
      if (!this.message.trim() || !this.selectedContact) {
        return
      }
      this.socketSendMessage(this.message)
      this.message = ''
    },
  },
}
</script>

<style lang="scss" scoped>
.messages-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.messages-ctr {
  flex: 1;
  overflow: auto;
  position: relative;
}

.input-area {
  padding: 20px;
  border-top: 1px solid #ebebeb;
}

.messages {
  height: 100%;
  overflow: auto;
  padding: 20px;
}

.unread-messages {
  position: absolute;
  bottom: 10px;
  left: 50%;
  width: 160px;
  text-align: center;
  margin-left: -80px;
  background-color: #ffffff;
  color: lighten(#3989c6, 5%);
  padding: 5px 10px;
  border-radius: 20px;
  border: 2px solid lighten(#3989c6, 5%);
  outline: 0;
  transition: all 0.3s;

  &:hover {
    color: white;
    background-color: lighten(#3989c6, 5%);
  }
}
</style>