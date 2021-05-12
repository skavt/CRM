import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class RegisterModel extends BaseModel {
  email = null
  first_name = null
  last_name = null
  password = null
  repeat_password = null

  rules = {
    first_name: 'required',
    last_name: 'required',
    email: [
      {rule: 'required'},
      {rule: 'email', message: 'This must be valid email'},
    ],
    password: [
      {rule: 'required'},
      {rule: 'min', length: 6},
    ],
    repeat_password: [
      {rule: 'required'},
      {rule: 'confirmed', target: 'password'},
    ],
  }

  attributeLabels = {
    email: 'Email',
    first_name: 'First Name',
    last_name: 'Last Name',
    password: 'Password',
    repeat_password: 'Repeat Password',
  }

  constructor(data = {}) {
    super()
    Object.assign(this, {...data})
  }
}
