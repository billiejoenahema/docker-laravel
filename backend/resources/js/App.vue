<script setup>
import TheHeader from './components/TheHeader';
import ToastNotification from './components/ToastNotification';
</script>

<template>
  <header>
    <TheHeader />
  </header>
  <main>
    <ToastNotification />
    <router-view />
  </main>
</template>
