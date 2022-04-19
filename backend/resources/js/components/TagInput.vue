<script setup>
import { computed } from '@vue/reactivity';
import { reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../consts/maxLength';
import { determineIsOver } from '../functions/determineIsOver';
import { determineIsSame } from '../functions/determineIsSame';
import InputCounter from './InputCounter';

const store = useStore();

const isOver = ref('');
const isSame = ref(false);
const newTag = reactive({
  name: '',
});
const tags = computed(() => store.getters['tags/data']);

const addNewTag = async () => {
  await store.dispatch('tags/post', newTag);
  await store.dispatch('tags/get');
  newTag.name = '';
};
watchEffect(() => {
  isOver.value = determineIsOver('tagName', newTag.name.length);
  isSame.value = determineIsSame(newTag.name, tags.value);
});
</script>

<template>
  <div class="create-tag-pane">
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
    <button
      class="tag-submit-button"
      @click.prevent="addNewTag"
      v-show="newTag.name !== ''"
      :disabled="isSame || isOver === 'error'"
    >
      タグを追加する
    </button>
  </div>
</template>
