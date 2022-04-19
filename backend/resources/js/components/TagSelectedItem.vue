<script setup>
import { defineProps, ref } from 'vue';
defineProps({
  tag: {
    type: Object,
    required: true,
  },
  removeTag: {
    type: Function,
    required: true,
  },
});
const isXmarkIconShow = ref(false);
</script>

<template>
  <mark
    class="tag-selected"
    @mouseover.self="isXmarkIconShow = true"
    @mouseleave.self="isXmarkIconShow = false"
  >
    {{ tag.name }}
    <div
      class="xmark-icon-wrapper"
      v-if="isXmarkIconShow"
      @click="removeTag(tag)"
    >
      <font-awesome-icon class="xmark-icon" icon="xmark" />
    </div>
  </mark>
</template>
