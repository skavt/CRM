import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ResetPasswordFormModel extends BaseModel {
  password = null
  repeat_password = null
  token = ''

  rules = {
    password: 'required',
    repeat_password: [
      {rule: 'required'},
      {rule: 'confirmed', target: 'password'},
    ],
  }

  attributeLabels = {
    password: 'Password',
    repeat_password: 'Repeat Password',
  }

  constructor(password = '') {
    super();
    this.password = password
  }
}
