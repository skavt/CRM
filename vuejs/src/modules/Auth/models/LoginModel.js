import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class LoginModel extends BaseModel {
  email = null
  password = null

  rules = {
    email: [
      {rule: 'required'},
      {rule: 'email'},
    ],
    password: 'required',
  }

  attributeLabels = {
    email: 'Email',
    password: 'Password',
  }

  constructor(data = {}) {
    super()
    Object.assign(this, {...data})
  }
}
