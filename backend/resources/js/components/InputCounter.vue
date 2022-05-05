<script setup>
defineProps({
  isOver: String,
  content: String,
  maxLength: Number,
});
</script>

<template>
  <div class="text-length" :class="isOver">
    {{ content.length ?? 0 }}
    /
    {{ maxLength }}字
  </div>
</template>
