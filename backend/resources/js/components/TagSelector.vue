<script setup>
import { defineProps } from 'vue';
defineProps({
  tags: {
    type: Array,
    required: true,
  },
  submit: {
    type: Function,
    required: true,
  },
});
</script>

<template>
  <div id="tag-select-modal" class="modal">
    <div class="tag-select-area">
      <div class="tag-select-list">
        <div class="tag-select-item" v-for="tag in tags" :key="tag.id">
          <label class="tag-label" :for="'tag' + tag.id">
            <input
              class="tag-checkbox"
              type="checkbox"
              :id="'tag' + tag.id"
              :value="tag.id"
              v-model="checkedTagIds"
            />
          </label>
          <div class="tag-select-name">
            {{ tag.name }}
          </div>
        </div>
      </div>
      <button class="tag-select-submit-button" @click="submit()">確定</button>
    </div>
  </div>
</template>
