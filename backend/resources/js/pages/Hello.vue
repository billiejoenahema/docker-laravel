<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
store.dispatch('loginUser/loginUser');
const isLogin = computed(() => store.getters['loginUser/isLogin']);
</script>

<template>
  <div v-if="isLogin">あなたはログインしています。</div>
  <div v-else>あなたはログインしていません。</div>
  <router-link to="/login">Login</router-link>
</template>
