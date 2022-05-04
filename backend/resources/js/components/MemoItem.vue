<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
import MemoEditModal from './MemoEditModal';

const store = useStore();

const props = defineProps({
  memo: {
    type: Object,
    required: true,
  },
});

const isModalOpen = ref(false);
const isTrashIconShow = ref(false);
const closeModal = () => {
  isModalOpen.value = false;
  store.commit('tags/resetSelectedTags');
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
  <MemoEditModal
    v-if="isModalOpen"
    :currentMemo="memo"
    :closeModal="closeModal"
    :deleteMemo="deleteMemo"
  />
</template>
