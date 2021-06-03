import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ChangePasswordModel extends BaseModel {
  old_password = ''
  password = ''
  confirm_password = ''

  rules = {
    old_password: 'required',
    password: [
      {rule: 'required'},
      {rule: 'min', length: 6}
    ],
    confirm_password: [
      {rule: 'required'},
      {rule: 'confirmed', target: 'password'},
    ],
  }

  attributeLabels = {
    old_password: 'Old Password',
    password: 'Password',
    confirm_password: 'Confirm Password',
  }

  constructor(data) {
    super()
    Object.assign(this, {...data})
  }
}