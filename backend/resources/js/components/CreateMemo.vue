<script setup>
import { computed, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const memo = reactive({
  content: '',
  tag_id: 0,
});
const newTag = reactive({
  name: '',
});
const MAX_LENGTH = {
  content: 200,
  tag: 20,
};
const tags = computed(() => store.getters['tags/data']);
const selected = ref(0);
const errors = computed(() => store.getters['memos/errors']);
const addNewTag = async () => {
  await store.dispatch('tags/post', newTag);
  await store.dispatch('tags/get');
  const addedTag = computed(() => store.getters['tags/addedTag']);
  selected.value = addedTag.value.id;
  newTag.name = '';
};
const storeNewMemo = async () => {
  await store.dispatch('memos/post', memo);
  if (!errors.value.length) {
    memo.content = '';
    selected.value = 0;
    store.dispatch('memos/get');
  }
};
const isOver = ref(false);
watchEffect(() => {
  if (MAX_LENGTH.content < memo.content.length) {
    isOver.value = true;
  } else {
    isOver.value = false;
  }
});
</script>
<template>
  <div id="create-memo">
    <div class="list-title">新規メモ作成</div>
    <div class="list-body">
      <div class="memo-input-area">
        <textarea
          name="content"
          rows="3"
          placeholder="ここにメモを入力"
          v-model="memo.content"
        ></textarea>
        <div class="text-length" :class="{ error: isOver }">
          {{ memo.content.length ?? 0 }}
          /
          {{ MAX_LENGTH.content }}
        </div>
      </div>
      <select name="tags" v-model="memo.tag_id">
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
      <input
        type="text"
        name="new_tag"
        v-model="newTag.name"
        placeholder="新しいタグを入力"
      />
      <button @click.prevent="addNewTag" v-show="newTag.name !== ''">
        タグを追加する
      </button>
      <button
        type="submit"
        @click.prevent="storeNewMemo()"
        v-show="memo.content !== ''"
        :disabled="isOver || memo.tag_id === 0"
      >
        メモを保存
      </button>
    </div>
  </div>
</template>
