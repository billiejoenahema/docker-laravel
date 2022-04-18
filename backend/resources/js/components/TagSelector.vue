<script setup>
import { computed, defineProps, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
const props = defineProps({
  tags: {
    type: Array,
    required: true,
  },
  submit: {
    type: Function,
    required: true,
  },
});
const selectedTagIds = computed(() => store.getters['tags/selectedTagIds']);
onMounted(() => {
  checkedTagIds.value = selectedTagIds.value;
});
const store = useStore();
const checkedTagIds = ref([]);
const handleClickSubmit = () => {
  store.commit('tags/setSelectedTags', checkedTagIds.value);
  props.submit();
};
</script>

<template>
  <div id="tag-select-modal" class="modal">
    <div class="tag-select-area">
      <div class="tag-select-list">
        <div class="tag-select-item" v-for="tag in tags" :key="tag.id">
          <label class="tag-label" :for="'tag' + tag.id">
            <input
              class="tag-checkbox"
              type="checkbox"
              :id="'tag' + tag.id"
              :value="tag.id"
              v-model="checkedTagIds"
            />
          </label>
          <div class="tag-select-name">
            {{ tag.name }}
          </div>
        </div>
      </div>
      <button
        class="tag-select-submit-button"
        @click.prevent="handleClickSubmit()"
      >
        確定
      </button>
    </div>
  </div>
</template>
