<template>
  <div class="d-flex flex-column justify-content-center align-items-center auth-content">
    <div class="container">
      <div class="form-wrapper">
        <router-view/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AuthLayout"
}
</script>

<style scoped lang="scss">

.form-wrapper {
  padding: 25px;
  width: 100%;
  position: relative;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
  background: #e2e2e2;
}

.auth-content {
  top: 35%;
  left: 35%;
  position: absolute;
}
</style>