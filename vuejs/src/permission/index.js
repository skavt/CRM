import Vue from 'vue';
import store from '../store';

function checkPermission(el, binding, vnode) {
  if (binding.value) {

    let hasPermission = false;

    if (binding.value.channelId) {
      hasPermission = store.getters['channel/hasPermission'](binding.value.permission, binding.value.channelId);
    } else {
      hasPermission = store.getters['employee/hasPermission'](binding.value);
    }
    if (!hasPermission) {
      el.style.display = 'none';
    } else {
      el.style.display = '';
    }
  } else {
    console.error('You must specify a permission ID')
  }
}

Vue.directive('permission', {
  inserted: checkPermission,
  updated: checkPermission,
  componentUpdated: checkPermission
});
