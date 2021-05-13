import Vue from 'vue';

const ConfirmModal = {
  install(Vue) {
    Vue.prototype.$confirm = function (message, title = 'Please Confirm') {
      return new Promise((resolve, reject) => {
        this.$bvModal.msgBoxConfirm(message, {
          title: title,
          okVariant: 'danger',
          okTitle: 'Yes',
          cancelTitle: 'Cancel',
          footerClass: 'p-2',
          hideHeaderClose: false,
        })
          .then(value => {
            resolve(value)
          })
          .catch(err => {
            reject(err);
          })
      })
    }
  }
};

Vue.use(ConfirmModal);
