import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class EmployeeModel extends BaseModel {
  email = null
  first_name = null
  last_name = null
  phone = null
  birthday = null
  status = false

  rules = {
    first_name: 'required',
    last_name: 'required',
    email: [
      {rule: 'required'},
      {rule: 'email'},
    ],
  }

  attributeLabels = {
    email: 'Email',
    first_name: 'First Name',
    last_name: 'Last Name',
    phone: 'Phone',
    birthday: 'Birthday',
    status: 'Activate User',
  };

  constructor(data = {}) {
    super()
    Object.assign(this, {...data})
  }
}