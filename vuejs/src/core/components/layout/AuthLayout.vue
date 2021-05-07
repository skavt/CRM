<template>
  <div class="auth-layout">
    <div class="auth">
      <div class="container">
        <div class="form-wrapper">
          <router-view/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AuthLayout"
}
</script>

<style lang="scss" scoped>

.auth-layout {
  display: flex;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.auth {
  width: 680px;
  margin: 0 auto;
  display: flex;
  align-items: center;


  .form-wrapper {
    padding: 25px;
    width: 100%;
    position: relative;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
    background: #003349;
  }

  & /deep/ .auth-left {
    text-align: center;
    color: #fff;
    margin-top: 4%;
    flex: 1;
    padding: 30px 20px;

    img {
      margin-top: 15%;
      margin-bottom: 5%;
      width: 50%;
    }
  }

  & /deep/ .col-center {
    display: flex;
    align-items: center;
  }

  & /deep/ .auth-right {
    flex: 1;
  }

  & /deep/ .auth-link {
    color: white;
  }
}

</style>