<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const loginUser = computed(() => store.getters['loginUser/loginUser']);
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);

onMounted(async () => {
  await store.dispatch('loginUser/get');
  if (isLogin.value) {
    router.push('/');
  } else {
    router.push('/login');
  }
});

const logout = async () => {
  await store.dispatch('auth/logout');
  if (!hasErrors.value) {
    router.push('/login');
  }
};
const toHome = () => {
  router.push('/');
};
</script>

<template>
  <nav>
    <a href="#" @click.prevent.stop="toHome">MemoApp</a>
    <a href="#" v-if="isLogin" @click.prevent.stop>{{ loginUser.name }}</a>
    <a href="#" v-if="isLogin" @click.prevent.stop="logout"> ログアウト </a>
  </nav>
</template>
