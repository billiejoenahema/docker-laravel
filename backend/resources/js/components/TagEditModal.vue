<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';

const props = defineProps({
  tag: {
    id: 0,
    name: '',
  },
  closeModal: Function,
});
const tag = reactive({
  id: props.tag.id,
  name: props.tag.name,
});
const store = useStore();
const updateTag = async () => {
  await store.dispatch('tags/update', tag);
  store.dispatch('tags/get');
  props.closeModal();
};
</script>

<template>
  <div
    class="tag-edit-modal modal"
    v-if="isModalOpen"
    @click.self="isModalOpen = false"
  >
    <div class="tag-edit-area">
      <input class="tag-edit-input" v-model="tag.name" />
      <button class="tag-update-button" @click.prevent="updateTag()">
        更新する
      </button>
    </div>
  </div>
</template>
