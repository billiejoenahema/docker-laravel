<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
defineProps({
  tag: {
    type: Object,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
});
const store = useStore();
const isXmarkIconShow = ref(false);
const removeTag = (index) => {
  store.commit('tags/removeTag', index);
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
      @click="removeTag(index)"
    >
      <font-awesome-icon class="xmark-icon" icon="xmark" />
    </div>
  </mark>
</template>
