<template>
  <b-navbar type="dark" variant="dark">
    <b-navbar-brand>Customer Relationship Management</b-navbar-brand>
    <b-navbar-nav class="ml-auto">
      <b-nav-item @click="onChatClick">
        <i class="fab fa-facebook-messenger"/>
      </b-nav-item>
      <b-nav-item class="logout" @click="onLogoutClick">
        Logout
        <i class="fas fa-sign-out-alt"/>
      </b-nav-item>
    </b-navbar-nav>
  </b-navbar>
</template>

<script>
import authService from "../../services/authService";

export default {
  name: "Navbar",
  methods: {
    onLogoutClick() {
      authService.logout()
    },
    onChatClick() {
      this.$router.push({name: 'chat'})
    },
  },
}
</script>

<style lang="scss" scoped>

.navbar {
  padding: 15px;

  > .navbar-nav {
    > .nav-item {
      > .nav-link {
        color: white;
        font-size: 14px;
      }

      > .nav-link:hover {
        color: grey;
        font-size: 14px;
      }
    }
  }
}

</style>