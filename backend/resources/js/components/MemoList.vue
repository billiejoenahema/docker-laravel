<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

store.dispatch('memos/get');
const memos = computed(() => store.getters['memos/data']);
</script>

<template>
  <div id="memo-list">
    <div class="list-title">メモ一覧</div>
    <ul class="list-body">
      <li v-for="(memo, index) in memos" :key="index">{{ memo.content }}</li>
    </ul>
  </div>
</template>
