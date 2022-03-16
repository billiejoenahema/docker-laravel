<script setup>
import { defineProps, ref } from 'vue';
defineProps({
  memo: {
    type: Object,
    required: true,
  },
});
const isModalOpen = ref(false);
</script>

<template>
  <div class="memo-item" @click="isModalOpen = true">
    {{ memo.content }}
  </div>
  <div class="modal" v-if="isModalOpen" @click.self="isModalOpen = false">
    <div class="memo-edit-area">
      <textarea v-model="memo.content" rows="16"></textarea>
      <div class="edit-button-area">
        <button class="edit-button">更新する</button>
      </div>
    </div>
  </div>
</template>
