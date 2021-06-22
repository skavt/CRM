<template>
  <b-media class="message" :class="{'sender-me': message.sender === 'me', 'action': message.action}">
    <template v-slot:aside v-if="message.sender !== 'me' && !message.action">
      <b-img rounded="0" width="32" height="32" :src="message.avatar"/>
    </template>
    <div class="text">
      <pre v-if="!message.action" v-html="message.message" class="message-wrapper"/>
      <div class="action-wrapper" v-if="message.action === 'JITSI_CALL'">
        <b-button size="md" variant="primary">
          <i class="fas fa-video"/>
          Click to join video call!
        </b-button>
      </div>
      <span class="time">{{ message.time | relativeDate }}</span>
    </div>
  </b-media>
</template>

<script>
export default {
  name: "Message",
  props: {
    message: {
      type: Object,
    },
  },
}
</script>

<style lang="scss" scoped>
.message {
  word-break: break-word;
  margin-top: 5px;

  .time {
    display: block;
    font-size: 75%;
    font-style: italic;
  }

  .text {
    margin-right: 15%;
    background-color: lighten(#3989c6, 5%);
    color: white;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-block;

    .message-wrapper {
      & /deep/ img {
        width: 24px;
        margin: 0 4px;
      }
    }
  }

  &.sender-me {
    .text {
      margin-right: 0;
      margin-left: 15%;
      background-color: #8a8a8a;
    }

    .media-body {
      display: flex;
      justify-content: flex-end;
    }
  }

  &.action {
    .text {
      width: calc(100% - 15%);
      background-color: transparent;

      .action-wrapper {
        text-align: center;
      }
    }

    .time {
      color: lighten(#3989c6, 5%);
      text-align: center;
    }
  }
}

.text {
  pre {
    white-space: normal;
    font-size: 100%;
    color: white;
    font-family: Arial;
    margin-bottom: 0;
  }
}
</style>