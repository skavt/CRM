import BaseModel from "../../../core/components/input-widget/BaseModel";

export default class PostModel extends BaseModel {
  channel_id = null;
  body = ''
  files = [];
  file_url = '';
  action = null;

  rules = {}

  attributeLabels = {
    files: 'Select Files',
    body: 'Description',
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