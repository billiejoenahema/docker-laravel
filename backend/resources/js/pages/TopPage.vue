<script setup>
import MemoCreate from '../components/MemoCreate';
import MemoList from '../components/MemoList';
import TagList from '../components/TagList';
import TheHeader from '../components/TheHeader';
import ToastNotification from '../components/ToastNotification';
</script>

<template>
  <header>
    <TheHeader />
  </header>
  <main>
    <ToastNotification />
    <div class="container">
      <TagList />
      <MemoList />
      <MemoCreate />
    </div>
  </main>
</template>
