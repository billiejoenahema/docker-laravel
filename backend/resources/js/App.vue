<script setup></script>

<template>
  <main>
    <router-view />
  </main>
</template>

<style>
form {
  background-color: #37474f;
  padding: 3rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  border-radius: 5px;
}
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
  display: flex;
  align-items: center;
  height: 2.5rem;
  width: 100%;
  margin: 0;
  cursor: pointer;
  justify-content: center;
  border: none;
  border-radius: 5px;
  color: #fff;
}
.button:hover {
  opacity: 0.8;
}
li.button.submit {
  background: #1565c0;
}
input {
  border: none;
}
</style>
