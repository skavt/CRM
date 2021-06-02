import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class UserChannelModel extends BaseModel {
  id = null
  user_id = null
  channel_id = null
  role = 'user'

  rules = {
    channel_id: 'required',
    role: 'required',
  }

  attributeLabels = {
    id: ' ',
    user_id: 'User',
    channel_id: 'Channel',
    role: 'Role',
  }

  constructor(data) {
    super()
    Object.assign(this, {...data})
  }
}