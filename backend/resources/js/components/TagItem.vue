<script setup>
import { defineProps, reactive, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  tag: {
    id: 0,
    name: '',
  },
});
const tag = reactive({
  id: props.tag.id,
  name: props.tag.name,
});
const isModalOpen = ref(false);
const isEditIconShow = ref(false);
const updateTag = async () => {
  console.log(tag);
  await store.dispatch('tags/update', tag);
  store.dispatch('tags/get');
  isModalOpen.value = false;
};
</script>

<template>
  <div
    class="tag-item"
    @mouseover="isEditIconShow = true"
    @mouseleave="isEditIconShow = false"
  >
    <div class="tag-checkbox-area">
      <label :for="'tag' + tag.id">
        <input type="checkbox" :id="'tag' + tag.id" class="tag-checkbox" />
        {{ tag.name }}
      </label>
    </div>
    <font-awesome-icon
      v-if="isEditIconShow"
      icon="pen-to-square"
      @click="isModalOpen = true"
    />
  </div>
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
