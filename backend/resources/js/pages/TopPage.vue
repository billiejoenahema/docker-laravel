<script setup>
import CreateMemo from '../components/CreateMemo';
import MemoList from '../components/MemoList';
import TagList from '../components/TagList';
</script>
<template>
  <div class="container">
    <TagList />
    <MemoList />
    <CreateMemo />
  </div>
</template>
