<script setup>
import { defineProps, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  memo: {
    id: 0,
    content: '',
  },
});
const isModalOpen = ref(false);
const updateMemo = () => {
  store.dispatch('memo/update', props.memo);
  isModalOpen.value = false;
};
</script>

<template>
  <div class="memo-item" @click="isModalOpen = true">
    {{ memo.content }}
  </div>
  <div class="modal" v-if="isModalOpen" @click.self="isModalOpen = false">
    <div class="memo-edit-area">
      <textarea v-model="memo.content" rows="16"></textarea>
      <div class="edit-button-area">
        <button class="edit-button" @click="updateMemo()">更新する</button>
      </div>
    </div>
  </div>
</template>
