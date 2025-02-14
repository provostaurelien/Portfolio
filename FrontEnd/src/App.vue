<template>
  <h1>Bonjour {{ firstName.toUpperCase() }}</h1>
  <p>Comment allez vous??</p>
</template>

<script setup>
const firstName = 'John'
</script>

<style>
h1 {
  color: red;
}
</style>
