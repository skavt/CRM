<template>
  <ValidationObserver ref="employee-modal" v-slot="{ handleSubmit}">
    <b-modal v-model="modal.show" :title="`Edit User ${modal.data.display_name}`" :ok-disabled="isClicked"
             @hidden="onHideModal" @ok.prevent="handleSubmit(onSubmit)">
      <view-spinner :show="loading"/>
      <error-content :show="showError" :error-message="errorMessage"/>
      <b-form v-if="!loading" @keydown.enter.prevent="handleSubmit(onSubmit)">
        <input-widget :model="model" attribute="email" :autofocus="true" :placeholder="true" :label="true"/>
      </b-form>
    </b-modal>
  </ValidationObserver>
</template>

<script>
import ViewSpinner from "../../../core/components/view-spinner/view-spinner";
import ErrorContent from "../../../core/components/error-content/ErrorContent";
import InputWidget from "../../../core/components/input-widget/InputWidget";
import EmployeeModel from "../models/EmployeeModel";
import {createNamespacedHelpers} from "vuex";
import {hideUserEditModal} from "../../../store/modules/employee/actions";

const {mapState, mapActions} = createNamespacedHelpers('employee')
export default {
  name: "EmployeeModal",
  components: {InputWidget, ErrorContent, ViewSpinner},
  data() {
    return {
      model: new EmployeeModel(),
      loading: false,
      showError: false,
      errorMessage: '',
      isClicked: false,
    }
  },
  computed: {
    ...mapState({
      modal: state => state.employee.modal
    }),
  },
  watch: {
    ['modal.data']() {
      this.model = new EmployeeModel(this.modal.data);
    }
  },
  methods: {
    ...mapActions(['hideUserEditModal']),
    onSubmit() {

    },
    onHideModal() {
      this.hideUserEditModal()
      this.model = new EmployeeModel()
      this.showError = false
      this.isClicked = false
      this.errorMessage = ''
    },
  },
}
</script>

<style scoped>

</style>