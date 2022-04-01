<script setup>
import { defineProps, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  memo: {
    id: 0,
    title: '',
    content: '',
  },
});

const isModalOpen = ref(false);
const isTrashIconShow = ref(false);
const updateMemo = async () => {
  await store.dispatch('memos/update', props.memo);
  store.dispatch('memos/get');
  isModalOpen.value = false;
};
const deleteMemo = async () => {
  if (window.confirm('メモを削除しますか？')) {
    await store.dispatch('memos/delete', props.memo.id);
    store.dispatch('memos/get');
  }
};
</script>

<template>
  <div
    class="row memo-item"
    @mouseover="isTrashIconShow = true"
    @mouseleave="isTrashIconShow = false"
  >
    <div class="memo-content" @click="isModalOpen = true">
      {{ memo.title }}
    </div>
    <font-awesome-icon
      class="trash-icon"
      v-if="isTrashIconShow"
      icon="trash"
      @click="deleteMemo()"
    />
  </div>
  <div class="modal" v-if="isModalOpen" @click.self="isModalOpen = false">
    <div class="memo-edit-area">
      <input class="memo-title-edit-input" v-model="memo.title" />
      <textarea v-model="memo.content" rows="16"></textarea>
      <div class="edit-button-area">
        <button class="edit-button" @click="updateMemo()">更新する</button>
      </div>
    </div>
  </div>
</template>
