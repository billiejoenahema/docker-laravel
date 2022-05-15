<script setup>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';
import TagEditModal from './TagEditModal';

const store = useStore();

store.dispatch('tags/get');
const tags = computed(() => store.getters['tags/data']);
const checkedTagIds = ref([]);
const isModalOpen = ref(false);
const isIconShow = ref(false);
const hoverItemIndex = ref(0);
const tagEditIndex = ref(null);
const editTag = (index) => {
  isModalOpen.value = true;
  tagEditIndex.value = index;
};
const deleteTag = async (tagId) => {
  if (window.confirm('タグを削除しますか？')) {
    await store.dispatch('tags/delete', tagId);
    store.dispatch('tags/get');
    store.dispatch('memos/get');
  }
};
const mouseoverTagItem = (index) => {
  isIconShow.value = true;
  hoverItemIndex.value = index;
};
const narrowDownMemos = () => {
  store.dispatch('memos/get', { tag_ids: checkedTagIds.value });
};
const resetChecked = () => {
  checkedTagIds.value = [];
  store.dispatch('memos/get');
};
const closeModal = () => {
  isModalOpen.value = false;
};
</script>

<template>
  <div id="tag-list">
    <div class="list-title">タグ一覧</div>
    <form class="list-body">
      <button class="reset-button" type="reset" @click="resetChecked()">
        選択を解除
      </button>
      <ul>
        <li v-for="(tag, index) in tags" :key="tag.id">
          <div
            class="tag-item"
            @mouseover="mouseoverTagItem(index)"
            @mouseleave="isIconShow = false"
          >
            <div class="tag-checkbox-area">
              <label class="tag-label" :for="'tag' + tag.id">
                <input
                  class="tag-checkbox"
                  type="checkbox"
                  :id="'tag' + tag.id"
                  :value="tag.id"
                  v-model="checkedTagIds"
                  @change="narrowDownMemos()"
                />
              </label>
              <div class="tag-name" @click="editTag(index)">
                {{ tag.name }}
              </div>
            </div>
            <font-awesome-icon
              class="trash-icon"
              v-if="isIconShow && index === hoverItemIndex"
              icon="trash"
              @click="deleteTag(tag.id)"
            />
          </div>
        </li>
        <TagEditModal
          v-if="isModalOpen"
          :tag="tag"
          @click.self="closeModal()"
          :closeModal="closeModal"
        />
      </ul>
    </form>
  </div>
</template>
