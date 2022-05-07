<script setup>
import { computed, onMounted, ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useStore } from 'vuex';
import MemoItem from './MemoItem';
import MemoSearch from './MemoSearch';

const store = useStore();

onMounted(async () => {
  isLoading.value = true;
  await store.dispatch('memos/get');
  isLoading.value = false;
});
const isLoading = ref(false);
const memos = computed(() => store.getters['memos/data']);
const sortCondition = ref('');
const sortMemos = () => {
  store.dispatch('memos/get', { sort: sortCondition.value });
};
</script>

<template>
  <vue-element-loading
    :active="isLoading"
    color="#fff"
    background-color="rgba(255, 255, 255, 0)"
    is-full-screen
  />
  <div id="memo-list">
    <div class="list-title">メモ一覧</div>
    <div class="list-body">
      <MemoSearch />
      <div class="sort-selector">
        <label for="sort-selector">表示順</label>
        <select
          name="sort"
          id="sort-selector"
          v-model="sortCondition"
          @change="sortMemos()"
        >
          <option value="">登録日が新しい</option>
          <option value="-created_at">登録日が古い</option>
          <option value="+updated_at">更新日が新しい</option>
          <option value="-updated_at">更新日が古い</option>
        </select>
      </div>
      <ul>
        <li v-for="(memo, index) in memos" :key="index">
          <MemoItem :memo="memo" />
        </li>
        <li v-if="memos.length === 0">メモがありません。</li>
      </ul>
    </div>
  </div>
</template>
