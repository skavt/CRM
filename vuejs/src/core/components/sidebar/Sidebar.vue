<template>
  <div class="d-flex flex-column flex-shrink-0 bg-light sidebar-column">
    <ul class="nav nav-pills flex-column mb-auto">
      <router-link class="menu-items-header" v-for="item in menuItems" :to="item.path || '#'" :key="item.text" tag="li"
                   active-class="active">
        <div>
          <i class="menu-item-icon" :class="item.icon"/>
          <span>{{ item.text }}</span>
        </div>
      </router-link>
    </ul>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: "Sidebar",
  computed: {
    ...mapGetters(['menuItems']),
  },
}
</script>

<style lang="scss" scoped>
.sidebar-column {
  width: 280px;
}

.menu-item-icon {
  margin-right: 10px;
}

.menu-items-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 24px 16px;
  font-size: 16px;
  font-weight: bold;
  opacity: 0.8;
  color: #343A40;

  &:hover {
    cursor: pointer;
    color: #003349;
  }

  &.router-link-exact-active.active {
    background: #343A40;
    color: #fff;
    border-left: 4px solid #003349;
  }
}


</style>