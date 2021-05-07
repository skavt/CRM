import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ResetPasswordRequestModel extends BaseModel {
  email = null

  rules = {
    email: [
      {rule: 'required'},
      {rule: 'email', message: 'This must be valid email'},
    ],
  }

  attributeLabels = {
    email: 'Email',
  }

  constructor(data = {}) {
    super();
    Object.assign(this, {...data});
  }
}
