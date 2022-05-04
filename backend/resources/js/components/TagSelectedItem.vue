<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
const props = defineProps({
  tag: {
    type: Object,
    required: true,
  },
  memoId: {
    type: Number,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
});
const store = useStore();
const isXmarkIconShow = ref(false);
const detachTag = async () => {
  await store.dispatch('tags/detach', {
    tagId: props.tag.id,
    memoId: props.memoId,
  });
  store.commit('tags/removeTag', props.index);
  store.dispatch('memos/get');
};
</script>

<template>
  <mark
    class="tag-selected"
    @mouseover.self="isXmarkIconShow = true"
    @mouseleave.self="isXmarkIconShow = false"
  >
    {{ tag.name }}
    <div
      class="xmark-icon-wrapper"
      v-if="isXmarkIconShow"
      @click="detachTag(tag.id)"
      title="タグを外す"
    >
      <font-awesome-icon class="xmark-icon" icon="xmark" />
    </div>
  </mark>
</template>
