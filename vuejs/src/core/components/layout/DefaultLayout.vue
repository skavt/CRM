<template>
  <div id="menu-content-wrapper">
    <navbar/>
    <div id="content" class="d-flex justify-content-between">
      <sidebar/>
      <router-view class="mt-3"/>
    </div>
  </div>
</template>

<script>
import Navbar from "../navbar/Navbar";
import Sidebar from "../sidebar/Sidebar";
import MenuService from "../sidebar/MenuService";
import MenuItem from "../sidebar/MenuItem";

export default {
  name: "DefaultLayout",
  components: {Sidebar, Navbar},
  mounted() {
    MenuService.addItem(new MenuItem('Home', {
      text: 'Home',
      path: `/dashboard`,
      weight: 100,
      icon: 'fas fa-home',
    }));
    MenuService.addItem(new MenuItem('Invitation', {
      text: 'Invitation',
      path: `/dashboard/invitation`,
      weight: 101,
      icon: 'fas fa-user-plus',
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