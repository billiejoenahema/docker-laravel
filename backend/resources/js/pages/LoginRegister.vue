<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const user = reactive({
  email: '',
  password: '',
});

const hasErrors = computed(() => store.getters['loginUser/hasErrors']);

const login = async () => {
  await store.dispatch('loginUser/login', user);
  if (!hasErrors.value) {
    router.push('/');
  }
};
</script>

<template>
  <form class="column">
    <div class="row"><h4>ログイン</h4></div>
    <div class="column">
      <label for="login-email">Email</label>
      <input v-model="user.email" id="login-email" type="email" />
    </div>
    <div class="column">
      <label for="login-password">Password</label>
      <input v-model="user.password" id="login-password" type="password" />
    </div>
    <ul class="row">
      <li class="button submit" @click="login">ログイン</li>
    </ul>
  </form>
</template>
