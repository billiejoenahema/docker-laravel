<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const user = reactive({
  name: '',
  email: '',
  password: '',
});
const newUser = reactive({
  name: '',
  email: '',
  password: '',
});
const showLoginForm = ref(true);

onMounted(() => {
  if (isLogin.value) {
    router.push('/');
  }
});

const isLogin = computed(() => store.getters['loginUser/isLogin']);
const hasErrors = computed(() => store.getters['loginUser/hasErrors']);
const login = async () => {
  await store.dispatch('loginUser/login', user);
  if (!hasErrors.value) {
    router.push('/');
  }
};
const register = async () => {
  await store.dispatch('loginUser/register', newUser);
  if (!hasErrors.value) {
    router.push('/');
  }
};
</script>

<template>
  <form class="column" v-if="showLoginForm">
    <div class="row"><h4>ログイン</h4></div>
    <div class="column">
      <label for="login-email">メールアドレス</label>
      <input v-model="user.email" id="login-email" type="email" />
    </div>
    <div class="column">
      <label for="login-password">パスワード</label>
      <input v-model="user.password" id="login-password" type="password" />
      <ul class="row">
        <li class="button submit" @click="login">ログイン</li>
      </ul>
    </div>
    <div @click="showLoginForm = false" class="login-message">
      アカウントをお持ちでない方はこちら新規登録
    </div>
  </form>

  <form class="column" v-else>
    <div class="row"><h4>新規登録</h4></div>
    <div class="column">
      <label for="register-name">ユーザー名</label>
      <input v-model="newUser.name" id="register-name" type="text" />
    </div>
    <div class="column">
      <label for="register-email">メールアドレス</label>
      <input v-model="newUser.email" id="register-email" type="email" />
    </div>
    <div class="column">
      <label for="register-password">パスワード</label>
      <input
        v-model="newUser.password"
        id="register-password"
        type="password"
      />
    </div>
    <ul class="row">
      <li class="button submit" @click="register">登録する</li>
    </ul>
    <div @click="showLoginForm = true" class="login-message">
      アカウントをお持ちの方はこちらからログイン
    </div>
  </form>
</template>
