import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class InvitationModel extends BaseModel {
  email = null

  rules = {
    email: [
      {rule: 'required'},
      {rule: 'email'},
    ],
  }

  attributeLabels = {
    email: 'Email',
  }

  constructor(data = {}) {
    super()
    Object.assign(this, {...data})
  }
}