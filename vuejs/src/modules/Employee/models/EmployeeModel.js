import BaseModel from "../../../core/components/input-widget/BaseModel";
import UserChannelModel from "./UserChannelModel";

export default class EmployeeModel extends BaseModel {
  email = null
  first_name = null
  last_name = null
  phone = null
  birthday = null
  position = null
  status = false
  userChannels = [];

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
    position: 'Position',
    status: 'Activate User',
  };

  constructor(data = {}) {
    super()

    const userChannels = [];
    if (data.userChannels) {
      for (let userChannel of data.userChannels) {
        userChannels.push(new UserChannelModel({
          id: userChannel.id,
          user_id: userChannel.user_id,
          channel_id: userChannel.channel_id,
          role: userChannel.role,
        }))
      }
    }
    data.userChannels = userChannels;

    Object.assign(this, {...data})
  }
}