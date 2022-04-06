<script setup>
import { computed, onMounted, ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useStore } from 'vuex';
import MemoItem from './MemoItem';
import MemoSearch from './MemoSearch';

const store = useStore();

const isLoading = ref(false);
onMounted(async () => {
  isLoading.value = true;
  await store.dispatch('memos/get');
  isLoading.value = false;
});
const memos = computed(() => store.getters['memos/data']);
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
      <ul>
        <li v-for="(memo, index) in memos" :key="index">
          <MemoItem :memo="memo" />
        </li>
        <li v-if="memos.length === 0">メモがありません。</li>
      </ul>
    </div>
  </div>
</template>
