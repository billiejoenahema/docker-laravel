<script setup>
import { computed } from '@vue/reactivity';
import { reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const props = defineProps({
  currentMemo: {
    id: 0,
    title: '',
    content: '',
    created_at: null,
    updated_at: null,
  },
  closeModal: {
    type: Function,
    required: true,
  },
});
const memo = reactive({
  id: props.currentMemo.id,
  title: props.currentMemo.title,
  content: props.currentMemo.content,
  created_at: props.currentMemo.created_at,
  updated_at: props.currentMemo.updated_at,
});
const hasErrors = computed(() => store.getters['memos/hasErrors']);
const updateMemo = async () => {
  await store.dispatch('memos/update', memo);
  if (!hasErrors.value) {
    store.dispatch('memos/get');
    props.closeModal();
  }
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="memo-edit-area">
      <div class="date-area">
        <div class="date">作成日時: {{ memo.created_at }}</div>
        <div class="date">更新日時: {{ memo.updated_at }}</div>
      </div>
      <input class="memo-title-edit-input" v-model="memo.title" />
      <textarea v-model="memo.content" rows="12"></textarea>
      <div class="edit-button-area">
        <button class="edit-button" @click="updateMemo()">更新する</button>
      </div>
    </div>
  </div>
</template>
