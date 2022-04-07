<script setup>
import { computed, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../consts/maxLength';
import { determineIsOver } from '../functions/determineIsOver';
import TagInput from './TagInput.vue';

const store = useStore();

const memo = reactive({
  title: '',
  content: '',
  tag_id: 0,
});

const tags = computed(() => store.getters['tags/data']);
const selected = ref(0);
const isOver = ref('');
const hasErrors = computed(() => store.getters['memos/hasErrors']);

const storeNewMemo = async () => {
  await store.dispatch('memos/post', memo);
  if (!hasErrors.value) {
    memo.title = '';
    memo.content = '';
    selected.value = 0;
    store.dispatch('memos/get');
  }
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
        <div class="text-length" :class="isOver">
          {{ memo.content.length ?? 0 }}
          /
          {{ MAX_LENGTH.memoContent }}字
        </div>
      </div>
      <select name="tags" class="tag-select" v-model="memo.tag_id">
        <option value="0">タグを選択</option>
        <option
          v-for="(tag, index) in tags"
          :key="index"
          :value="tag.id"
          :selected="selected"
        >
          {{ tag.name }}
        </option>
      </select>
      <TagInput />
      <button
        type="submit"
        @click.prevent="storeNewMemo()"
        v-show="memo.title !== ''"
        :disabled="isOver || memo.tag_id === 0"
      >
        メモを保存
      </button>
    </div>
  </div>
</template>
