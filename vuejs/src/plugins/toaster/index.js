import Vue from 'vue';
import BootstrapVue from '../bootstrap-vue';

const vueBootstrap = new (Vue.extend(BootstrapVue));

function getVariant(variant) {
  const availableVariants = ['secondary', 'primary', 'danger', 'warning', 'success', 'info', 'default'];
  return availableVariants.includes(variant) ? variant : 'default';
}

function getTitle(variant) {
  if (variant === 'success') {
    return 'Success'
  } else if (variant === 'danger') {
    return 'Error'
  } else {
    return 'Info'
  }
}

const Toaster = {
  install(Vue) {
    Vue.prototype.$toast = (message, variant = 'success') => {
      vueBootstrap.$bvToast.toast(message, {
        title: getTitle(variant),
        autoHideDelay: 5000,
        appendToast: false,
        variant: getVariant(variant)
      });
    }
  }
};

Vue.use(Toaster);

export default Toaster;