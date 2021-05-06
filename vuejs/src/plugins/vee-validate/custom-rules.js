import {extend} from "vee-validate";

extend('password', {
  validate(value) {
    if (!value) return true;
    const match = value.match(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/);
    return !!match;
  },
  message: `Should contain at least 1 lower case, 1 upper case, 1 digit and min length of 8`
});