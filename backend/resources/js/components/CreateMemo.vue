<script setup>
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const memo = reactive({
  content: '',
  tag_id: null,
});
const newTag = reactive({
  name: '',
});
const tags = computed(() => store.getters['tags/data']);
const selected = ref(0);
const isDisabled = ref(true);
const addNewTag = async () => {
  await store.dispatch('tags/post', newTag);
  await store.dispatch('tags/get');
  const addedTag = computed(() => store.getters['tags/addedTag']);
  selected.value = addedTag.value.id;
  newTag.value = [];
};
const storeNewMemo = () => {
  store.dispatch('memos/post');
};
</script>
<template>
  <div id="create-memo">
    <div class="list-title">新規メモ作成</div>
    <div class="list-body">
      <textarea
        name="content"
        rows="3"
        placeholder="ここにメモを入力"
        v-model="memo.content"
      ></textarea>
      <div class="alert alert-danger"></div>
      <div>
        <label for="tag-select">Choose a tag:</label>
        <select name="tags" id="tag-select">
          <option value="">タグを選択</option>
          <option
            v-for="(tag, index) in tags"
            :key="index"
            :value="tag.id"
            :selected="selected"
          >
            {{ tag.name }}
          </option>
        </select>
      </div>
      <input
        type="text"
        name="new_tag"
        v-model="newTag.name"
        placeholder="新しいタグを入力"
      />
      <button @click.prevent="addNewTag" :disabled="newTag.name === ''">
        タグを追加する
      </button>
      <button
        type="submit"
        @click.prevent="storeNewMemo()"
        :disabled="isDisabled"
      >
        メモを保存
      </button>
    </div>
  </div>
</template>
