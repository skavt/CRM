<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('chat');
export default {
  name: 'App',
  methods: {
    ...mapActions(['socketUserList']),
  },
  sockets: {
    USER_LIST(contacts) {
      this.socketUserList(contacts);
    },
  },
}
</script>

<style>

html, body {
  height: 100%;
  margin: 0;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
