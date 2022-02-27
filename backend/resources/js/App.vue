<script setup>
import TheFooter from './components/TheFooter';
import TheHeader from './components/TheHeader';
</script>

<template>
  <header>
    <TheHeader />
  </header>
  <main>
    <router-view />
  </main>
  <footer><TheFooter /></footer>
</template>
