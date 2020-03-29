<template>
<textarea
  :readonly="readonly"
  :value="value"
  @input="onChange($event)"
  @mousedown.stop
  ></textarea>
</template>

<script>
export default {
  props: ['initial', 'readonly', 'emitter', 'ikey', 'type', 'change', 'getData', 'putData'],
  data() {
    return {
      value: this.initial || "Bonjour!",
      showT: false,
    }
  },
  methods: {
    // parse(value) {
    //   return this.type === 'number' ? +value : value;
    // },
    onChange(e){
      this.value = e.target.value;
      this.update();
    },
    update() {
      if (this.ikey) {
        this.putData(this.ikey, this.value)
        this.change(this.value);
      }
      this.emitter.trigger('process');
    }
  },
  mounted() {
    // this.value = this.getData(this.ikey);
  }
}
</script>
<style scoped>
textarea{
    border: none;
    resize: none;
    border-radius: 3px;
    border: 2px solid blueviolet;
}
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  border-radius: 0;
}

::-webkit-scrollbar-thumb {
  margin: 2px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.2);
}
</style>

