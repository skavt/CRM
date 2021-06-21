<template>
  <div>
    <h5 class="pl-2 mt-4 mb-2 heading">{{ title }}</h5>
    <div v-if="!items.length" class="no-data">
      There are no {{ sectionName }}
    </div>
    <b-media class="contact align-items-center" :class="{'selected': contactSelected(contact)}"
             v-for="contact in items" :key="`${sectionName}-${contact.id}`" @click="selectContact(contact)">
      <template v-slot:aside>
        <b-img rounded="0" :src="contact.avatar" width="32" height="32" alt="placeholder"/>
      </template>
      <p class="m-0">{{ contact.name }}</p>
      <p v-if="contact.latestMessage.message" class="latest-message mb-0" v-html="contact.latestMessage.message"/>
      <span class="indicator-status" :class="{'online': contact.online}"/>
      <span v-if="contact.hasUnreadMessage" v-b-tooltip="'Unread Messages'" class="unread-message"/>
    </b-media>
  </div>
</template>

<script>
export default {
  name: "ChatSection",
  props: {
    items: {
      type: Array,
    },
    sectionName: {
      type: String,
    },
    title: {
      type: String,
    },
  },
  methods: {
    contactSelected(contact) {
      return !this.selectedContact ? false : this.selectedContact.id === contact.id;
    },
    selectContact(contact) {
      this.$emit('on-contact-select', contact)
    },
  },
}
</script>

<style lang="scss" scoped>
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

.heading {
  color: #949494;
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

.unread-message {
  position: absolute;
  right: -13px;
  top: -5px;
  border-radius: 50%;
  width: 10px;
  height: 10px;
  background-color: #ffba2a;
}
</style>