<script setup>
import { ref, watchEffect } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const searchWord = ref('');
const search = () => {
  store.dispatch('memos/get', { search_word: searchWord.value });
};
watchEffect(() => {
  if (searchWord.value === '') {
    store.dispatch('memos/get');
  }
});
</script>

<template>
  <div class="search-input-area">
    <input
      class="search-input"
      type="search"
      v-model="searchWord"
      placeholder="検索ワードを入力"
    />
    <button class="search-button" @click="search()">検索</button>
  </div>
</template>
