<template>
  <ValidationProvider
      :name="`${attribute}-${uuid}`" :rules="model.getRules(attribute, rules || null)" tag="div"
      :customMessages="model.getMessages(attribute, rules || null)" v-slot="v" :vid="vid || attribute">

    <b-form-group v-if="isInput() || isTextarea()">
      <label v-if="computedLabel">
        {{ computedLabel }}
        <span v-if="v.required" class="text-danger">*</span>
      </label>
      <b-input-group v-if="isInput()" :prepend="prepend" :append="append" :size="size">
        <template v-slot:append v-if="appendQuestion">
          <b-tooltip :target="`question-mark-tooltip-${attribute}-${uuid}`" :title="appendQuestion"/>
          <b-input-group-text :id="`question-mark-tooltip-${attribute}-${uuid}`" class="hover-cursor">
            <i class="fas fa-question-circle"/>
          </b-input-group-text>
        </template>
        <b-form-input
            v-if="type === 'number'" v-model="model[attribute]" :id="inputId" ref="currentInput" :size="size"
            :type="type" :disabled="disabled" :placeholder="computedPlaceholder" :min="min" :readonly="readonly"
            :autofocus="autofocus" :name="`${attribute}-${uuid}`" :key="`${attribute}-${uuid}`" :state="getState(v)"
            @keyup="onKeyup" @change="onChange" @input="onInput" @keydown="onKeydown" @blur="onBlur">
        </b-form-input>
        <b-form-input
            v-else v-model="model[attribute]" :id="inputId" ref="currentInput" :size="size" :type="type"
            :disabled="disabled" :readonly="readonly" :autofocus="autofocus" :name="`${attribute}-${uuid}`"
            :key="`${attribute}-${uuid}`" :state="getState(v)" :placeholder="computedPlaceholder"
            @change="onChange" @input="onInput" @keydown="onKeydown" @keyup="onKeyup" @blur="onBlur">
        </b-form-input>
      </b-input-group>
      <b-form-textarea
          v-if="isTextarea()" v-model="model[attribute]" ref="currentInput" :type="type" :name="`${attribute}-${uuid}`"
          :key="`${attribute}-${uuid}`" :state="getState(v)" :placeholder="computedPlaceholder">
      </b-form-textarea>
      <b-form-invalid-feedback :state="getState(v)">
        {{ getError(v.errors) }}
      </b-form-invalid-feedback>
      <b-form-text v-if="computedHint">
        {{ computedHint }}
      </b-form-text>
    </b-form-group>

    <b-form-group v-if="isCheckbox()">
      <b-form-checkbox
          ref="currentInput" v-model="model[attribute]" :key="`${attribute}-${uuid}`" :disabled="disabled"
          :name="`${attribute}-${uuid}`" :switch="isSwitch" :size="size" :state="getState(v)" @change="onChange">
        <span v-if="computedLabel">
          {{ computedLabel }}
          <span v-if="v.required" class="text-danger">*</span>
        </span>
      </b-form-checkbox>
      <b-form-invalid-feedback :state="getState(v)">{{ getError(v.errors) }}
      </b-form-invalid-feedback>
      <b-form-text v-if="computedHint">
        {{ computedHint }}
      </b-form-text>
    </b-form-group>

    <b-form-group v-if="isFileUpload()">
      <label v-if="computedLabel">
        {{ computedLabel }}
        <span v-if="v.required" class="text-danger">*</span>
      </label>
      <b-form-file v-model="model[attribute]" :type="type" :placeholder="computedPlaceholder" :state="getState(v)"/>
      <b-form-invalid-feedback :state="getState(v)">
        {{ getError(v.errors) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group v-if="isMultiselect() || isSelect()">
      <label v-if="computedLabel">
        {{ computedLabel }}
        <span v-if="v.required" class="text-danger">*</span>
      </label>
      <b-input-group :prepend="prepend" :append="append" :size="size">
        <template v-slot:append v-if="appendQuestion">
          <b-tooltip :target="`question-mark-tooltip-${attribute}-${uuid}`" :title="appendQuestion"/>
          <b-input-group-text :id="`question-mark-tooltip-${attribute}-${uuid}`" class="hover-cursor">
            <i class="fas fa-question-circle"></i>
          </b-input-group-text>
        </template>

        <b-form-select
            v-if="isSelect()" v-model="model[attribute]" ref="currentInput" :id="inputId" :size="size"
            :disabled="disabled" :options="options" :value-field="valueField" :text-field="textField"
            :readonly="readonly" :autofocus="autofocus" :name="`${attribute}-${uuid}`" @keyup="onKeyup"
            :key="`${attribute}-${uuid}`" @change="onChange" @input="onInput" @keydown="onKeydown" @blur="onBlur"
            :state="getState(v)">
        </b-form-select>

        <multiselect
            v-if="isMultiselect()" v-model="model[attribute]" :id="inputId" ref="currentInput" :size="size"
            :key="`${attribute}-${uuid}`" :disabled="disabled" :readonly="readonly" :autofocus="autofocus"
            :name="`${attribute}-${uuid}`" :state="getState(v)" :tag-placeholder="placeholder" :options="options"
            :placeholder="computedPlaceholder" :multiple="true" track-by="value" label="text"
            :selectLabel="'Press enter to select'" :deselectLabel="'Press enter to remove'" :selectedLabel="'Selected'">
          <span slot="noOptions">List is empty.</span>
          <template slot="tag" slot-scope="{ option, remove }">
            <span class="multiselect__tag">
              <span>{{ option.text }}</span>
              <span class="multiselect__tag-icon" @click="remove(option)"></span>
            </span>
          </template>
        </multiselect>

        <b-form-invalid-feedback :state="getState(v)">
          {{ getError(v.errors) }}
        </b-form-invalid-feedback>
      </b-input-group>
    </b-form-group>
  </ValidationProvider>
</template>

<script>
import BaseModel from "./BaseModel";
import {uuid} from 'vue-uuid';

export default {
  name: 'InputWidget',
  props: {
    model: BaseModel,
    attribute: String,
    label: {
      type: [String, Boolean],
      default: true
    },
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: [String, Boolean],
      default: true
    },
    disabled: {
      type: Boolean,
      default: false
    },
    readonly: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'md'
    },
    hint: {
      type: [Boolean, String],
      default: false
    },
    prepend: {
      type: String,
      default: ''
    },
    append: {
      type: String,
      default: ''
    },
    autofocus: {
      type: Boolean,
      default: false,
    },
    rules: {
      type: [String, Object, Array],
      default: null,
      required: false
    },
    inputId: {
      type: String,
      default() {
        return `${this.attribute}-${uuid.v4()}`
      }
    },
    appendQuestion: {
      type: String,
      default: null
    },
    vid: {
      type: String,
      default: ''
    },
    min: {
      type: [String, Number],
      default: 0
    },
    isSwitch: {
      type: Boolean,
      default: false
    },
    options: {
      type: Array,
      default: Array,
    },
    valueField: {
      type: String,
      default: 'value',
    },
    textField: {
      type: String,
      default: 'text',
    },
  },
  data() {
    return {
      uuid: uuid.v4(),
    }
  },
  computed: {
    computedPlaceholder() {
      if (this.placeholder === false) {
        return '';
      } else if (this.placeholder === true) {
        return this.model.getAttributePlaceholder(this.attribute)
      } else {
        return this.placeholder;
      }
    },
    computedLabel() {
      if (this.label === false) {
        return '';
      } else if (this.label === true) {
        return this.model.getAttributeLabel(this.attribute)
      } else {
        return this.label;
      }
    },
    computedHint() {
      if (!this.hint || typeof this.hint === 'string') {
        return this.hint;
      }
      return this.model.getAttributeHint(this.attribute)
    },
  },
  methods: {
    getError(errors) {
      if (this.model.hasError(this.attribute)) {
        return this.model.getFirstError(this.attribute);
      }
      return errors[0];
    },
    getState(validator) {
      if (this.model.hasError(this.attribute)) {
        return false;
      }
      // Validate is set when validate function of vee validate is run
      if (validator.validated === true) {
        // return validator.valid;
        return validator.valid === true ? null : false;
      }
      if (!validator.touched) {
        return null;
      }
      // return !validator.touched ? null : validator.valid
      return validator.valid === true ? null : false;
    },
    focus() {
      this.$refs.currentInput.focus();
    },
    isInput() {
      return ['text', 'number', 'date', 'password', 'email', 'search', 'url', 'tel', 'time', 'range', 'color'].includes(this.type)
    },
    isTextarea() {
      return this.type === 'textarea';
    },
    isCheckbox() {
      return this.type === 'checkbox';
    },
    isFileUpload() {
      return this.type === 'file';
    },
    isSelect() {
      return this.type === 'select';
    },
    isMultiselect() {
      return this.type === 'multiselect';
    },
    onChange(val) {
      if (this.type === 'number' && val === '') {
        this.model[this.attribute] = null;
      }
      this.$emit('change', val);
    },
    onInput($event) {
      this.$emit('input', $event);
    },
    onBlur($event) {
      if (this.type === 'number' && $event.target.value === '') {
        this.model[this.attribute] = null;
      }
      this.$emit('blur', $event);
    },
    onKeydown($event) {
      this.$emit('keydown', $event);
    },
    onKeyup($event) {
      this.$emit('keyup', $event);
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss" scoped>
.invalid-feedback {
  font-size: 12px;
}
</style>
