<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
onMounted(() => {
  store.dispatch('loginUser/loginUser');
  if (!isLogin.value) {
    router.push('/login');
  }
});
const isLogin = computed(() => store.getters['loginUser/isLogin']);
</script>

<template>
  <div>Top Page</div>
</template>
