<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
const isLogin = computed(() => store.getters['loginUser/isLogin']);
onMounted(() => {
  if (!isLogin.value) {
    router.push('/login');
  }
});
</script>
<template>
  <div>Top Page</div>
  <div>{{ isLogin }}</div>
</template>
