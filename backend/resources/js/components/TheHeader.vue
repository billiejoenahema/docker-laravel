<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
const loginUser = computed(() => store.getters['loginUser/loginUser']);
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);
const logout = async () => {
  await store.dispatch('loginUser/logout');
  if (!hasErrors.value) {
    router.push('/login');
  }
};
</script>

<template>
  <nav>
    <a href="#" v-if="isLogin" @click.prevent.stop>{{ loginUser.name }}</a>
    <a href="#" v-if="isLogin" @click.prevent.stop="logout"> ログアウト </a>
  </nav>
</template>
