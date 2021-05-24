<template>
  <div class="d-flex flex-column flex-shrink-0 bg-light sidebar-column">
    <ul class="nav nav-pills flex-column mb-auto">
      <router-link class="menu-items-header" :style="sidebarTitleStyle(item)" v-for="item in menuItems"
                   :to="item.path || '#'" :key="item.text" tag="li" active-class="active">
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
  methods: {
    sidebarTitleStyle(item) {
      return item.weight > 100 ? {padding: '12px 30px 12px', 'font-size': '14px'} : {
        padding: '12px 24px 12px',
        'font-size': '16px'
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.sidebar-column {
  width: 250px;
}

.menu-item-icon {
  margin-right: 10px;
}

.menu-items-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-weight: bold;
  opacity: 0.8;
  color: #343A40;

  &:hover {
    cursor: pointer;
    color: #003349;
  }

  &.router-link-exact-active.active {
    position: relative;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    color: #003349;
    background-color: #ededed;

    &:after {
      content: "";
      position: absolute;
      right: 0;
      top: 50%;
      margin-top: -15px;
      height: 30px;
      width: 16px;
      border-width: 15px 10px;
      border-top: 15px solid transparent;
      border-bottom: 15px solid transparent;
      border-right: 10px solid #003349;
    }
  }
}


</style>