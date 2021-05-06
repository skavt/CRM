import Vue from "vue";
import _ from "lodash";

Vue.use(_)
Object.defineProperty(Vue.prototype, '$_', {value: _})
