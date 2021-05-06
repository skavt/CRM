import BaseModel from "../../core/components/input-widget/BaseModel";

export default class LoginModel extends BaseModel {
  email = null;
  password = null;

  rules = {
    email: [
      {rule: 'required'},
      {rule: 'email', message: 'This must be valid email'},
    ],
    password: 'required',
  };

  attributeLabels = {
    email: 'Email',
    password: 'Password',
  };

  constructor(email = '', password = '') {
    super();
    this.email = email;
    this.password = password;
  }
}
