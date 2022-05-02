<script setup>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const loginUser = computed(() => store.getters['loginUser/loginUser']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);

onMounted(async () => {
  await store.dispatch('loginUser/get');
  if (!isLogin.value) {
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
    <a href="/" title="ホーム">MemoApp</a>
    <a href="" v-if="isLogin" @click.prevent.stop="logout" title="ログアウト"
      >logout</a
    >
    <a href="/user" v-if="isLogin" title="プロフィール">{{ loginUser.name }}</a>
  </nav>
</template>
