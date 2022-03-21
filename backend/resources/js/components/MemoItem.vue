<script setup>
import { defineProps, reactive, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  memo: {
    id: 0,
    content: '',
  },
});
const memo = reactive({
  id: props.memo.id,
  content: props.memo.content,
});
const isModalOpen = ref(false);
const isTrashIconShow = ref(false);
const updateMemo = async () => {
  await store.dispatch('memos/update', props.memo);
  store.dispatch('memos/get');
  isModalOpen.value = false;
};
</script>

<template>
  <div class="row memo-item">
    <div
      @click="isModalOpen = true"
      @mouseover="isTrashIconShow = true"
      @mouseleave="isTrashIconShow = false"
    >
      {{ memo.content }}
    </div>
    <font-awesome-icon v-if="isTrashIconShow" icon="trash" />
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
