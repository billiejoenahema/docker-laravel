<script setup>
import { computed, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../consts/maxLength';
import { determineIsOver } from '../functions/determineIsOver';
import InputCounter from './InputCounter';
import TagInput from './TagInput';
import TagSelector from './TagSelector.vue';

const store = useStore();

const memo = reactive({
  title: '',
  content: '',
  tag_ids: [],
});
const tags = computed(() => store.getters['tags/data']);
const selectedTags = computed(() => store.getters['tags/selectedTags']);
const isOver = ref('');
const hasErrors = computed(() => store.getters['memos/hasErrors']);
const isModalOpen = ref(false);
const isXmarkIconShow = ref(false);
const selectedTagIds = computed(() => store.getters['tags/selectedTagIds']);

const storeNewMemo = async () => {
  await store.dispatch('memos/post', memo);
  if (!hasErrors.value) {
    store.dispatch('memos/get');
    store.dispatch('tags/get');
    resetSates();
  }
};
const resetSates = () => {
  memo.title = '';
  memo.content = '';
  memo.tag_ids = [];
  store.mutation('tags/setSelectedTags', []);
};
const removeTag = () => {};
const submit = () => {
  isModalOpen.value = false;
  memo.tag_ids = selectedTagIds;
};
watchEffect(() => {
  isOver.value = determineIsOver('memoContent', memo.content.length);
});
</script>

<template>
  <div id="create-memo">
    <div class="list-title">新規メモ作成</div>
    <div class="create-memo-pane">
      <div class="memo-input-area">
        <input
          type="text"
          name="title"
          v-model="memo.title"
          placeholder="メモのタイトルを入力"
          class="tag-input"
          :class="{ error: isOver }"
        />
        <textarea
          name="content"
          rows="3"
          placeholder="メモの内容を入力"
          v-model="memo.content"
        ></textarea>
        <InputCounter
          :isOver="isOver"
          :content="memo.content"
          :maxLength="MAX_LENGTH.memoContent"
        />
      </div>
      <div>
        <mark
          class="tag-selected"
          v-for="(tag, index) in selectedTags"
          :key="tag.id"
          @mouseover.self="isXmarkIconShow = true"
          @mouseleave.self="isXmarkIconShow = false"
        >
          {{ tag.name
          }}<font-awesome-icon
            class="xmark-icon"
            v-show="isXmarkIconShow"
            icon="xmark"
            @click="removeTag(selectedTags[index])"
        /></mark>
      </div>
      <div class="button-area">
        <TagSelector
          v-if="isModalOpen"
          @click.self="isModalOpen = false"
          :tags="tags"
          :submit="submit"
        />
        <button @click="isModalOpen = true">タグを選択する</button>
        <button
          type="submit"
          @click.prevent="storeNewMemo()"
          v-show="memo.title !== ''"
          :disabled="isOver || memo.tag_ids.length === 0"
        >
          メモを保存
        </button>
      </div>
    </div>
    <div class="create-tag-pane">
      <TagInput />
    </div>
  </div>
</template>
