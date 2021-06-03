import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ChangePasswordModel extends BaseModel {
  old_password = ''
  password = ''
  confirm_password = ''

  rules = {
    old_password: 'required',
    password: 'required',
    confirm_password: 'required',
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