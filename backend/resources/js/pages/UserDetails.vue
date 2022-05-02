<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import TheHeader from '../components/TheHeader';
import ToastNotification from '../components/ToastNotification';

const store = useStore();
store.dispatch('loginUser/get');
const user = computed(() => store.getters['loginUser/loginUser']);
</script>

<template>
  <header>
    <TheHeader />
  </header>
  <main>
    <ToastNotification />
    <div class="user-container">
      <div class="user-info column">
        <div class="row">
          <div>ID:</div>
          <div>{{ user.id }}</div>
        </div>
        <div class="row">
          <div>Name:</div>
          <div>{{ user.name }}</div>
        </div>
        <div class="row">
          <div>Email:</div>
          <div>{{ user.email }}</div>
        </div>
        <div class="row">
          <div>RegistrationDate:</div>
          <div>{{ user.created_at }}</div>
        </div>
      </div>
    </div>
  </main>
</template>
