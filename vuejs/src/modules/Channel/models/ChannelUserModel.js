import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class ChannelUserModel extends BaseModel {
  selectedUsers = [];
  allUser = false;
  role = 'user';

  rules = {}

  attributeLabels = {
    selectedUsers: 'Users',
    allUser: 'Select all registered user',
    role: 'Role',
  }

  constructor(data = {}) {
    super()
    Object.assign(this, {...data})
  }
}