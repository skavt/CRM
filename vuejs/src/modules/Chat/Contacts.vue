<template>
  <div class="contacts">
    <div class="m-2 chat-header" style="position: relative">
      Chats
      <span v-b-tooltip="`Unread Messages`" class="unread-message" v-if="hasUnreadMessages"/>
    </div>
    <div class="p-2">
      <b-form-input size="lg" v-model="keyword" placeholder="Search Chat"/>
    </div>
    <div class="contacts-ctr">
      <h5 class="pl-2 mt-4 mb-2 heading">Recent Chats</h5>
      <div v-if="!filteredChats.length" class="no-data">
        There are no chats
      </div>
      <b-media class="contact align-items-center" :class="{'selected': contactSelected(contact)}"
               v-for="contact in filteredChats" :key="`chat-${contact.id}`" @click="selectContact(contact)">
        <template v-slot:aside>
          <b-img rounded="0" :src="contact.avatar" width="32" height="32" alt="placeholder"/>
        </template>

        <p class="m-0">{{ contact.name }}</p>
        <p v-if="contact.latestMessage.message" class="latest-message mb-0"
           v-html="contact.latestMessage.message">
        </p>
        <span v-if="contact.isUser" class="indicator-status" :class="{'online': contact.online}"></span>
        <span v-b-tooltip="'Unread Messages'" class="unread-message" v-if="contact.hasUnreadMessage"></span>
      </b-media>
      <h5 class="pl-2 mt-4 mb-2 heading">Contacts</h5>
      <div v-if="!filteredContacts.length" class="no-data">
        There are no contacts
      </div>
      <b-media @click="selectContact(contact)" class="contact align-items-center"
               v-for="(contact, index) in filteredContacts"
               :key="index"
               :class="{'selected': contactSelected(contact)}">
        <template v-slot:aside>
          <b-img v-if="contact.isUser" rounded="0" :src="contact.avatar" width="32" height="32" alt="placeholder"/>
          <b-avatar v-else class="chat-avatar" variant="info" icon="people-fill" square/>
        </template>

        <p class="m-0">{{ contact.name }}</p>
        <span v-if="contact.isUser" class="indicator-status" :class="{'online': contact.online}"></span>
      </b-media>
    </div>
  </div>
</template>

<script>

import {createNamespacedHelpers} from "vuex";

const {mapState, mapGetters, mapActions} = createNamespacedHelpers('chat');
export default {
  name: "Contacts",
  data() {
    return {
      keyword: '',
      tabIndex: 0,
    }
  },
  computed: {
    ...mapGetters(['hasUnreadMessages', 'contacts']),
    filteredContacts() {
      let keyword = this.keyword.toLowerCase()
      return keyword ? this.contacts.filter(c =>
          c.email.toLowerCase().includes(keyword) ||
          c.name.toLowerCase().includes(keyword) &&
          c.latestMessage.time === null) :
          this.contacts.filter(c => c.latestMessage.time === null)
    },
    filteredChats() {
      let keyword = this.keyword.toLowerCase()
      return keyword ? this.contacts.filter(c =>
          c.email.toLowerCase().includes(keyword) ||
          c.name.toLowerCase().includes(keyword) &&
          c.latestMessage.time !== null) :
          this.contacts.filter(c => c.latestMessage.time !== null)
    },
  },
  methods: {
    contactSelected(contact) {
      return !this.selectedContact ? false : this.selectedContact.id === contact.id;
    },
    selectContact() {

    },
  },
}
</script>

<style lang="scss" scoped>
.contacts {
  width: 280px;
  min-width: 280px;
  display: flex;
  flex-direction: column;
  border-right: 1px solid #ebebeb;

  & > > > .nav-item {
    position: relative;
  }

  .chat-header {
    font-size: 24px;
    font-weight: bold;
  }

  .contacts-ctr, .groups-ctr {
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
  }

  .contact {
    position: relative;
    padding: 10px 15px;
    cursor: pointer;

    .latest-message {
      height: 20px;
      overflow: hidden;

      img {
        width: 14px;
        margin: 0 2px;
      }
    }

    .unread-message {
      right: 10px;
      top: 16px;
    }

    &:nth-child(2n+1) {
      background-color: whitesmoke;
    }

    &:hover {
      background-color: #eaeaea;
    }

    &.selected,
    &.selected:hover,
    {
      background-color: #3989c6;
      color: #fff;
    }

  }

  .indicator-status {
    position: absolute;
    left: 10px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #6b6b6b;
    border: 2px solid white;

    &.online {
      background-color: #00cb78;
    }
  }

  .unread-message {
    position: absolute;
    right: -13px;
    top: -5px;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    background-color: #ffba2a;
  }

  .heading {
    color: #949494;
  }

  .chat-avatar {
    width: 32px;
    height: 32px;
  }
}

.no-data {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  flex-direction: column;
  color: #b6b6b6;
  font-weight: bold;
  text-shadow: 1px 1px 0 #FFFFFF;
  font-size: 1.275rem;
}
</style>