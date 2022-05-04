<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
const props = defineProps({
  tag: {
    id: 0,
    name: '',
  },
  memoId: Number,
  index: Number,
});
const store = useStore();
const isXmarkIconShow = ref(false);
const removeTag = async () => {
  if (props.memoId > 0) {
    await store.dispatch('tags/detach', {
      tagId: props.tag.id,
      memoId: props.memoId,
    });
  }
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
      @click="removeTag()"
      title="タグを外す"
    >
      <font-awesome-icon class="xmark-icon" icon="xmark" />
    </div>
  </mark>
</template>
