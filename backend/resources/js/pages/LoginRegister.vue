<script setup></script>

<template>
  <form class="column">
    <div class="row">
      <label for="login-email">Email</label>
      <input id="login-email" type="email" />
    </div>
    <div class="row">
      <label for="login-password">Password</label>
      <input id="login-password" type="password" />
    </div>
    <ul class="row">
      <li class="button submit">ログイン</li>
    </ul>
  </form>
</template>

<style>
.column {
  display: flex;
  flex-direction: column;
  width: 100%;
}
.row {
  display: flex;
  flex-direction: row;
  width: 100%;
}

.button {
  height: 2rem;
  width: 100% !important;
  cursor: pointer;
}
.button:hover {
  opacity: 0.8;
}
li.button.submit {
  background: #0d47a1;
}
</style>
