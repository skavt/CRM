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
    Object.assign(this, {...data})
  }
}