<template>
  <div class="contacts">
    <div class="m-2 chat-header">
      Chats
    </div>
    <div class="p-2">
      <b-form-input size="lg" v-model="keyword" placeholder="Search Chat"/>
    </div>
    <div class="contacts-ctr">
      <chat-section :items="filteredChats" :section-name="`chat`" :title="`Recent Chat`"
                    :selected-contact="selectedContact" @on-contact-select="onContactSelect">
      </chat-section>
      <chat-section :items="filteredContacts" :section-name="`contacts`" :title="`Contacts`"
                    :selected-contact="selectedContact" @on-contact-select="onContactSelect">
      </chat-section>
    </div>
  </div>
</template>

<script>

import {createNamespacedHelpers} from "vuex";
import ChatSection from "./components/ChatSection";

const {mapState, mapGetters, mapActions} = createNamespacedHelpers('chat');
export default {
  name: "Contacts",
  components: {ChatSection},
  data() {
    return {
      keyword: '',
      tabIndex: 0,
    }
  },
  computed: {
    ...mapGetters(['hasUnreadMessages', 'contacts']),
    ...mapState(['selectedContact']),
    filteredContacts() {
      let keyword = this.keyword.toLowerCase()
      return keyword ? this.contacts.filter(c => c.latestMessage.time === null &&
          (c.email.toLowerCase().includes(keyword) || c.name.toLowerCase().includes(keyword))) :
          this.contacts.filter(c => c.latestMessage.time === null)
    },
    filteredChats() {
      let keyword = this.keyword.toLowerCase()
      return keyword ? this.contacts.filter(c => c.latestMessage.time !== null &&
          (c.email.toLowerCase().includes(keyword) || c.name.toLowerCase().includes(keyword))) :
          this.contacts.filter(c => c.latestMessage.time !== null)
    },
  },
  methods: {
    ...mapActions(['selectContact']),
    contactSelected(contact) {
      return !this.selectedContact ? false : this.selectedContact.id === contact.id;
    },
    onContactSelect(contact) {
      this.selectContact(contact)
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

  .chat-header {
    font-size: 24px;
    font-weight: bold;
  }

  .contacts-ctr {
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
  }
}
</style>