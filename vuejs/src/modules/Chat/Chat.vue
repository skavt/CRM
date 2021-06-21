<template>
  <div class="messenger">
    <contacts/>
    <messages/>
  </div>
</template>

<script>
import Messages from "./Messages";
import Contacts from "./Contacts";
export default {
  name: "Chat",
  components: {Contacts, Messages},
}
</script>

<style scoped>
.messenger {
  width: 100%;
  height: 100%;
}
</style>