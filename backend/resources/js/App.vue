<script setup></script>

<template>
  <main>
    <router-view />
  </main>
</template>

<style>
.column {
  display: flex;
  flex-direction: column;
  width: 100%;
}
.column label,
.column input {
  width: 100%;
}
.row {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
  padding: 0;
}

.button {
  height: 2rem;
  margin: 0;
  width: 100% !important;
  cursor: pointer;
  text-align: center;
}
.button:hover {
  opacity: 0.8;
}
li.button.submit {
  background: #0d47a1;
}
</style>
