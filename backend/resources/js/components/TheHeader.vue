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
const loginUser = computed(() => store.getters['loginUser/loginUser']);
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const isLogin = computed(() => store.getters['loginUser/isLogin']);
const logout = async () => {
  await store.dispatch('loginUser/logout');
  if (!hasErrors.value) {
    store.dispatch('loginUser/loginUser');
    router.push('/');
  }
};
</script>

<template>
  <nav>
    <a href="#" v-if="isLogin" @click.prevent.stop>{{ loginUser.name }}</a>
    <a href="#" v-if="isLogin" @click.prevent.stop="logout"> ログアウト </a>
  </nav>
</template>
