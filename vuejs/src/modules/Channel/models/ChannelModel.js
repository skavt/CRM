import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ChannelModel extends BaseModel {
  name = ''
  description = ''

  rules = {
    name: 'required',
  }

  attributeLabels = {
    name: 'Name',
    description: 'Description',
  }

  constructor(data = {}) {
    super()
    if (data.created_at > 1e10) {
      data.created_at = data.created_at / 1000;
      data.updated_at = data.updated_at / 1000;
    }
    Object.assign(this, {...data})
  }
}