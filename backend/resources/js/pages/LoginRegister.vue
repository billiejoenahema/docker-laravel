<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const user = reactive({
  email: '',
  password: '',
});
const newUser = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

onMounted(async () => {
  await store.dispatch('loginUser/get');
  if (isLogin.value) {
    router.push('/');
  }
});

const showLoginForm = ref(true);
const isLogin = computed(() => store.getters['loginUser/isLogin']);
const hasErrors = computed(() => store.getters['auth/hasErrors']);
const errors = computed(() => store.getters['auth/errors']);

const login = async () => {
  await store.dispatch('auth/login', user);
  await store.dispatch('loginUser/get');
  if (!hasErrors.value) {
    router.push('/');
  }
};
const register = async () => {
  await store.dispatch('auth/register', newUser);
  if (!hasErrors.value) {
    router.push('/');
  }
};
</script>

<template>
  <div class="container">
    <form class="column login-form" v-if="showLoginForm">
      <div class="row"><h4>ログイン</h4></div>
      <div class="column">
        <label for="login-email">メールアドレス</label>
        <input
          v-model="user.email"
          id="login-email"
          name="email"
          type="email"
        />
      </div>
      <div class="column">
        <label for="login-password">パスワード</label>
        <input
          v-model="user.password"
          id="login-password"
          name="password"
          type="password"
        />
        <div v-for="(error, index) in errors" :key="index">
          {{ !error.includes('401') ? error : '' }}
        </div>
        <ul class="row">
          <li class="button submit" @click.prevent.stop="login">ログイン</li>
        </ul>
      </div>
      <div @click="showLoginForm = false" class="login-message">
        アカウントをお持ちでない方はこちら新規登録
      </div>
    </form>

    <form class="column register-form" v-else>
      <div class="row"><h4>新規登録</h4></div>
      <div class="column">
        <label for="register-name">ユーザー名</label>
        <input
          v-model="newUser.name"
          id="register-name"
          name="name"
          type="text"
        />
      </div>
      <div class="column">
        <label for="register-email">メールアドレス</label>
        <input
          v-model="newUser.email"
          id="register-email"
          name="email"
          type="email"
        />
      </div>
      <div class="column">
        <label for="register-password">パスワード</label>
        <input
          v-model="newUser.password"
          id="register-password"
          name="password"
          type="password"
        />
      </div>
      <div class="column">
        <label for="register-password-confirm">パスワード確認</label>
        <input
          v-model="newUser.password_confirmation"
          id="register-password-confirm"
          name="password_confirmation"
          type="password"
        />
      </div>
      <ul class="row">
        <li class="button submit" @click.prevent.stop="register">登録する</li>
      </ul>
      <div @click="showLoginForm = true" class="login-message">
        アカウントをお持ちの方はこちらからログイン
      </div>
    </form>
  </div>
</template>
