<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
store.dispatch('loginUser/loginUser');
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);
const logout = async () => {
  await store.dispatch('loginUser/logout');
  console.log(hasErrors.value);
  if (!hasErrors.value) {
    router.push('/');
    store.dispatch('loginUser/loginUser');
  }
};
</script>

<template>
  <div v-if="isLogin">あなたはログインしています。</div>
  <div v-else>あなたはログインしていません。</div>
  <router-link to="/login">Login</router-link>
  <button @click="logout">ログアウト</button>
</template>
