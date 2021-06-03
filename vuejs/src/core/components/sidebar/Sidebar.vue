<template>
  <div class="flex-column flex-shrink-0 bg-light sidebar-column">
    <router-link class="sidebar-header d-flex align-items-center" :to="{name: 'user-profile'}">
      <div class="avatar p-2">
        <b-img src="/assets/avatar.svg" class="img-fluid rounded-circle" width="70px" height="70px"/>
      </div>
      <div class="title">
        <h1 class="h4">{{ currentUser.display_name }}</h1>
        <p>{{ currentUser.position }}</p>
      </div>
    </router-link>
    <hr class="mt-1 mb-0"/>
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
import {createNamespacedHelpers, mapGetters} from 'vuex';

const {mapState, mapActions} = createNamespacedHelpers('employee')
export default {
  name: "Sidebar",
  computed: {
    ...mapGetters(['menuItems']),
    ...mapState(['currentUser']),
  },
  methods: {
    ...mapActions(['getCurrentUser']),
    sidebarTitleStyle(item) {
      return item.weight > 100 ? {padding: '12px 30px 12px', 'font-size': '14px'} : {
        padding: '12px 24px 12px',
        'font-size': '16px'
      }
    },
  },
  async mounted() {
    await this.getCurrentUser()
  },
}
</script>

<style lang="scss" scoped>
.title {
  padding-top: 18px;
  color: #343A40;
}

.sidebar-header {
  text-decoration: none;
}

.sidebar-column {
  overflow: auto;
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