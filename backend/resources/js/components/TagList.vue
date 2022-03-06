<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

store.dispatch('tags/get');
const tags = computed(() => store.getters['tags/data']);
</script>
<template>
  <div id="tag-list">
    <div class="list-title">タグ一覧</div>
    <ul class="list-body">
      <li v-for="(tag, index) in tags" :key="index">{{ tag.name }}</li>
    </ul>
  </div>
</template>
