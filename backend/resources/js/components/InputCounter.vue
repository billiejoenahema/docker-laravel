<script setup>
import { defineProps } from 'vue';

defineProps({
  isOver: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  maxLength: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="text-length" :class="isOver">
    {{ content.length ?? 0 }}
    /
    {{ maxLength }}字
  </div>
</template>
