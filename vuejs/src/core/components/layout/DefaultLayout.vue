<template>
  <div id="menu-content-wrapper">
    <navbar/>
    <div id="content" class="d-flex justify-content-between">
      <sidebar/>
      <router-view/>
    </div>
  </div>
</template>

<script>
import Navbar from "../navbar/Navbar";
import Sidebar from "../sidebar/Sidebar";
import MenuService from "../sidebar/MenuService";
import MenuItem from "../sidebar/MenuItem";
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "DefaultLayout",
  components: {Sidebar, Navbar},
  computed: {
    ...mapState(['channel']),
  },
  watch: {
    ['channel.data']() {
      this.channel.data.forEach(function (w, i) {
        MenuService.addItem(new MenuItem(`channel-${w.id}`, {
          text: w.name,
          path: `/dashboard/channel/${w.id}/timeline`,
          weight: 101 + i,
          icon: 'fab fa-battle-net',
        }))
      })
    },
  },
  methods: {
    ...mapActions(['getChannelData']),
  },
  async mounted() {
    await this.getChannelData()
    MenuService.addItem(new MenuItem('Home', {
      text: 'Home',
      path: `/dashboard`,
      weight: 100,
      icon: 'fas fa-home',
    }));
    MenuService.addItem(new MenuItem('Invitation', {
      text: 'Invitation',
      path: `/dashboard/invitation`,
      weight: 100,
      icon: 'fas fa-user-plus',
    }));
    MenuService.addItem(new MenuItem('Channel', {
      text: 'Channel',
      path: `/dashboard/channel`,
      weight: 100,
      icon: 'fas fa-layer-group',
    }));
  }
}
</script>

<style lang="scss">

#app {
  height: 100%;
  display: flex;
  overflow: hidden;
  margin-top: 0;
}

#menu-content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

#content {
  flex: 1;
  position: relative;
  overflow: hidden;
  display: flex;
}
</style>