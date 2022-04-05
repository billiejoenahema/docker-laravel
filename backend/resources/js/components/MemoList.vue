<script setup>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';
import MemoItem from './MemoItem';

const store = useStore();

store.dispatch('memos/get');
const memos = computed(() => store.getters['memos/data']);
const searchWord = ref('');
const search = () => {
  store.dispatch('memos/get', { search_word: searchWord.value });
};
</script>

<template>
  <div id="memo-list">
    <div class="list-title">メモ一覧</div>
    <div class="list-body">
      <div class="search-input-area">
        <input class="search-input" type="search" v-model="searchWord" />
        <button class="search-button" @click="search()">検索</button>
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
