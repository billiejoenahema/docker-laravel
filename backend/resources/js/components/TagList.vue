<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import TagItem from './TagItem.vue';

const store = useStore();

store.dispatch('tags/get');
const tags = computed(() => store.getters['tags/data']);
</script>

<template>
  <div id="tag-list">
    <div class="list-title">タグ一覧</div>
    <form class="list-body">
      <ul>
        <li v-for="(tag, index) in tags" :key="index">
          <TagItem :tag="tag" />
        </li>
      </ul>
      <button type="reset">選択を解除</button>
    </form>
  </div>
</template>
