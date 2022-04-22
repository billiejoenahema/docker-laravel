<script setup>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const loginUser = computed(() => store.getters['loginUser/loginUser']);
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);

onMounted(async () => {
  await store.dispatch('loginUser/get');
  if (isLogin.value && !hasErrors.value) {
    router.push('/');
  } else {
    router.push('/login');
  }
});

const logout = async () => {
  await store.dispatch('auth/logout');
  router.push('/login');
};
</script>

<template>
  <nav>
    <a href="/">MemoApp</a>
    <a href="" v-if="isLogin" @click.prevent.stop="logout">logout</a>
    <a href="" v-if="isLogin" @click.prevent.stop>{{ loginUser.name }}</a>
  </nav>
</template>
