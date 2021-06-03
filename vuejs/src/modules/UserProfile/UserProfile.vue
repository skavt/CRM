<template>
  <b-card no-body class="profile-card">
    <b-card-body class="profile-card-body">
      <view-spinner :show="loading"/>
      <div v-if="!loading" class="row">
        <div class="col-md-12 col-lg-7 mb-3">
          <ValidationObserver ref="profileForm" tag="div" v-slot="{ handleSubmit }">
            <form @keydown.enter.prevent="handleSubmit(onSubmit)">
              <b-card no-body>
                <b-card-header>
                  <h5 class="m-0">Personal Details</h5>
                </b-card-header>
                <b-card-body>
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <input-widget :model="userModel" attribute="first_name" :placeholder="'First Name'"/>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <input-widget :model="userModel" attribute="last_name" :placeholder="'Last Name'"/>
                    </div>
                  </div>
                  <input-widget :model="userModel" attribute="email"/>
                  <input-widget :model="userModel" attribute="phone"/>
                  <input-widget :model="userModel" attribute="position"/>
                  <input-widget :model="userModel" attribute="birthday" type="date"/>
                  <div class="text-right">
                    <b-button variant="info" @click.prevent="handleSubmit(onSubmit)">
                      Update
                    </b-button>
                  </div>
                </b-card-body>
              </b-card>
            </form>
          </ValidationObserver>
        </div>
        <div class="col-md-12 col-lg-5">
          <ValidationObserver ref="changePasswordForm" tag="div" v-slot="{ handleSubmit }">
            <form @keydown.enter.prevent="handleSubmit(onPasswordSubmit)">
              <b-card no-body>
                <b-card-header>
                  <h5 class="m-0">Change Password</h5>
                </b-card-header>
                <b-card-body>
                  <input-widget
                      :model="changePasswordModel" attribute="old_password" type="password"
                      :placeholder="'Old Password'">
                  </input-widget>
                  <input-widget
                      :model="changePasswordModel" attribute="password" type="password" :placeholder="'Password'">
                  </input-widget>
                  <input-widget
                      :model="changePasswordModel" attribute="confirm_password" type="password"
                      :placeholder="'Confirm Password'">
                  </input-widget>
                  <div class="text-right">
                    <b-button variant="primary" @click.prevent="handleSubmit(onPasswordSubmit)">
                      Change Password
                    </b-button>
                  </div>
                </b-card-body>
              </b-card>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </b-card-body>
  </b-card>
</template>

<script>
import InputWidget from "../../core/components/input-widget/InputWidget";
import EmployeeModel from "../Employee/models/EmployeeModel";
import ChangePasswordModel from "./models/ChangePasswordModel";
import {createNamespacedHelpers} from "vuex";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

const {mapState, mapActions} = createNamespacedHelpers('employee')
const {mapState: mapUserState} = createNamespacedHelpers('auth')
export default {
  name: "UserProfile",
  components: {ViewSpinner, InputWidget},
  data() {
    return {
      loading: false,
      userModel: new EmployeeModel(),
      changePasswordModel: new ChangePasswordModel(),
    }
  },
  computed: {
    ...mapUserState(['currentUser']),
  },
  watch: {
    currentUser() {
      this.userModel = new EmployeeModel(this.currentUser)
    },
  },
  methods: {
    ...mapActions(['updateUser']),
    async onSubmit() {
      let form = {...this.userModel.toJSON()}
      delete form.created_at
      delete form.updated_at
      form.status = form.status ? 1 : 2;

      this.loading = true
      const {success, body} = await this.updateUser(form)
      this.loading = false
      if (success) {
        this.$toast(`Your profile updated successfully`)
      } else {
        this.errorMessage = body.map(error => error.message).join(' ')
      }
    },
    onPasswordSubmit() {

    },
  },
  mounted() {
    this.loading = true
    this.userModel = new EmployeeModel(this.currentUser)
    this.loading = false
  },
}
</script>

<style scoped lang="scss">
.profile-card {
  width: 100%;
  height: 100%;
}

.profile-card-body {
  background: #E8E8E8;
}

.page-header {
  height: 60px;
  display: flex;
  justify-content: flex-end;

  button {
    align-self: center;
  }
}
</style>