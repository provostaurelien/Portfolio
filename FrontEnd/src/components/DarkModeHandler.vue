<template>
  <div>
    <!-- Icône pour basculer entre les modes -->
    <button
      @click="$emit('dark-mode-changed', !isDark)"
      class="dark-mode-toggle"
      :aria-label="isDark ? 'Activer le mode clair' : 'Activer le mode sombre'"
    >
      <span v-if="isDark">🌞</span>
      <!-- Icône soleil pour le mode clair -->
      <span v-else>🌙</span>
      <!-- Icône lune pour le mode sombre -->
    </button>
  </div>
</template>

<script>
export default {
  name: 'DarkModeHandler',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
}
</script>

<style scoped>
.dark-mode-toggle {
  position: fixed;

  top: 0.5rem;
  left: 0.5rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.5rem;
  z-index: 1000;
}
/* Placement du toogle en haut à droite en vue mobile*/
@media (max-width: 768px) {
  .dark-mode-toggle {
    right: 0.5rem;
    top: 0.5rem;
    left: auto; /* Supprime la valeur de `left` pour éviter les conflits */
  }
}
</style>
