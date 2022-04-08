<script setup>
import { reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../consts/maxLength';
import { determineIsOver } from '../functions/determineIsOver';
import InputCounter from './InputCounter';

const store = useStore();

const isOver = ref('');
const newTag = reactive({
  name: '',
});

const addNewTag = async () => {
  await store.dispatch('tags/post', newTag);
  await store.dispatch('tags/get');
  newTag.name = '';
};
watchEffect(() => {
  isOver.value = determineIsOver('tagName', newTag.name.length);
});
</script>

<template>
  <input
    type="text"
    name="new_tag"
    v-model="newTag.name"
    placeholder="新しいタグを入力"
    class="tag-input"
  />
  <InputCounter
    :isOver="isOver"
    :content="newTag.name"
    :maxLength="MAX_LENGTH.tagName"
  />
  <button @click.prevent="addNewTag" v-show="newTag.name !== ''">
    タグを追加する
  </button>
</template>
