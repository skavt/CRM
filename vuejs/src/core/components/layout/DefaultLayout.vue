<template>
  <div id="menu-content-wrapper">
    <navbar/>
    <div id="content" class="mt-3">
      <router-view/>
    </div>
  </div>
</template>

<script>
import Navbar from "../navbar/Navbar";

export default {
  name: "DefaultLayout",
  components: {Navbar},
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
  flex-direction: column;
}
</style>