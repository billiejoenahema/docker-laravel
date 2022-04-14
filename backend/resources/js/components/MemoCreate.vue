<script setup>
import { computed, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../consts/maxLength';
import { determineIsOver } from '../functions/determineIsOver';
import InputCounter from './InputCounter';
import TagInput from './TagInput';

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
const checkedTagIds = ref([]);

const storeNewMemo = async () => {
  await store.dispatch('memos/post', memo);
  if (!hasErrors.value) {
    resetSates();
    store.dispatch('memos/get');
  }
};
const resetSates = () => {
  memo.title = '';
  memo.content = '';
  memo.tag_ids = [];
  checkedTagIds.value = [];
};
const removeTag = () => {};
const submit = () => {
  isModalOpen.value = false;
  memo.tag_ids = checkedTagIds;
  store.commit('tags/setAddedTags', checkedTagIds.value);
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
      <button @click="isModalOpen = true">タグを選択する</button>
      <TagInput />
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
  <!-- タグ選択モーダル -->
  <div
    id="tag-select-modal"
    class="modal"
    v-if="isModalOpen"
    @click.self="isModalOpen = false"
  >
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
      <button class="tag-select-submit-button" @click="submit()">確定</button>
    </div>
  </div>
</template>
