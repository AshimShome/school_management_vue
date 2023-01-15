<template>
    <div>
        <textarea class="form-control" :rows="rows" :value="value" :readonly="readonly" :id="fieldId"
            :placeholder="placeholderText" :class="[{ 'is-invalid': form.errors.has(field) }, classes]"
            @input="handleInput" />
        <has-error :form="form" :field="field"></has-error>
  </div>
</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      required: true
    },
    field: {
      type: String,
      required: true
    },
    value: {
      type: String,
      default: ''
    },
    id:{
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    rows: {
      type: Number,
      default: 3
    },
    readonly: {
      type: Boolean,
      default: false
    },
    classes: {
      type: String,
      default: '',
    },
  },
  methods: {
    handleInput(e) {
      this.$emit('input', e.target.value);
    },
  },
  computed:{
    fieldId(){
       return this.id !== '' ? this.id : this.field
    },
    placeholderText(){
        return this.placeholder !== '' ? this.placeholder : `Enter ${this.field.replace("_", " ")}`
    }
  }
};
</script>

<style></style>
