<script setup>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
const props = defineProps({
  selectedTags: Array,
  submitSelectedTags: Function,
});
onMounted(() => {
  checkedTagIds.value = props.selectedTags.map((item) => item.id);
});
const tags = computed(() => store.getters['tags/data']);
const store = useStore();
const checkedTagIds = ref([]);
const handleClickSubmit = () => {
  store.commit('tags/setSelectedTags', checkedTagIds.value);
  props.submitSelectedTags();
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
