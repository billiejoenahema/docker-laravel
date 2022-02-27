<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const isLogin = computed(() => store.getters['loginUser/isLogin']);
</script>
<template>
  <div>Top Page</div>
  <div>{{ isLogin }}</div>
</template>
