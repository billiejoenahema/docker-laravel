<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import MemoItem from './MemoItem';
import MemoSearch from './MemoSearch';

const store = useStore();

store.dispatch('memos/get');
const memos = computed(() => store.getters['memos/data']);
</script>

<template>
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
