<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
onMounted(async () => {
  await store.dispatch('loginUser/loginUser');
  const isLogin = computed(() => store.getters['loginUser/isLogin']);
  if (!isLogin.value) {
    router.push('/login');
  }
});
</script>
<template>
  <div>Top Page</div>
</template>
