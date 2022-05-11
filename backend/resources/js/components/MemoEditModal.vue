<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import TagSelectedItem from '../components/TagSelectedItem';
import TagSelector from './TagSelector';

const store = useStore();
const props = defineProps({
  currentMemo: {
    id: 0,
    title: '',
    content: '',
    tags: [],
    created_at: null,
    updated_at: null,
  },
  closeModal: Function,
  deleteMemo: Function,
});
onMounted(() => {
  const tagIds = props.currentMemo.tags.map((item) => {
    return item.id;
  });
  store.commit('tags/setSelectedTags', tagIds);
});
const memo = reactive({
  id: props.currentMemo.id,
  title: props.currentMemo.title,
  content: props.currentMemo.content,
  tags: props.currentMemo.tags,
  created_at: props.currentMemo.created_at,
  updated_at: props.currentMemo.updated_at,
});
const isShowTagSelector = ref(false);
const selectedTags = computed(() => store.getters['tags/selectedTags']);
const hasErrors = computed(() => store.getters['memos/hasErrors']);
const submitSelectedTags = () => {
  isShowTagSelector.value = false;
  memo.tags = selectedTags.value;
  store.dispatch('memos/update', memo);
};
const updateMemo = async () => {
  await store.dispatch('memos/update', memo);
  if (!hasErrors.value) {
    store.dispatch('memos/get');
    props.closeModal();
  }
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="memo-edit-area">
      <div class="memo-edit-xmark-area">
        <div class="memo-edit-xmark-wrapper">
          <font-awesome-icon
            class="xmark-icon"
            icon="xmark"
            title="モーダルを閉じる"
            @click="closeModal()"
          />
        </div>
      </div>
      <div class="trash-icon-wrapper" @click="deleteMemo()" title="メモを削除">
        <font-awesome-icon class="trash-icon" icon="trash" />
      </div>
      <div class="tag-selected-item-area">
        <TagSelectedItem
          v-for="(tag, index) in selectedTags"
          :key="tag.id"
          :tag="tag"
          :memoId="memo.id"
          :index="index"
        />
        <div
          class="plus-icon-wrapper"
          @click="isShowTagSelector = true"
          title="タグを追加"
        >
          <font-awesome-icon class="plus-icon" icon="plus" />
        </div>
        <TagSelector
          v-if="isShowTagSelector"
          @click.self="isShowTagSelector = false"
          :selectedTags="memo.tags"
          :submitSelectedTags="submitSelectedTags"
        />
      </div>
      <div class="date-area">
        <div class="date">作成日時: {{ memo.created_at }}</div>
        <div class="date">更新日時: {{ memo.updated_at }}</div>
      </div>
      <input class="memo-title-edit-input" v-model="memo.title" />
      <textarea v-model="memo.content" rows="12"></textarea>
      <button class="edit-button" @click="updateMemo()">更新する</button>
    </div>
  </div>
</template>
