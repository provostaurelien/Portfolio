<template>
  <div>
    <!-- Icône pour basculer entre les modes -->
    <button
      @click="$emit('dark-mode-changed', !isDark)"
      class="dark-mode-toggle"
      :aria-label="isDark ? 'Activer le mode clair' : 'Activer le mode sombre'"
    >
      <!-- Icône Font Awesome avec classe conditionnelle -->
      <font-awesome-icon
        :icon="['fas', 'circle-half-stroke']"
        :class="{ 'dark-icon': isDark, 'light-icon': !isDark }"
      />
    </button>
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCircleHalfStroke } from '@fortawesome/free-solid-svg-icons'
import '../assets/styles/global.css'

library.add(faCircleHalfStroke)

export default {
  name: 'DarkModeHandler',
  components: {
    FontAwesomeIcon,
  },
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

/* Style de base pour l'icône */
.dark-mode-toggle .fa-circle-half-stroke {
  transition: color 0.3s ease; /* Animation douce lors du changement */
}

/* Couleur pour le mode sombre */
.dark-icon {
  color: var(--text-color-dark);
}

/* Couleur pour le mode clair */
.light-icon {
  color: var(--text-color-light);
}
/* Placement du toogle en haut à droite en vue mobile*/
@media (max-width: 768px) {
  .dark-mode-toggle {
    right: 0.5rem;
    top: 0.8rem;
    left: auto; /* Supprime la valeur de `left` pour éviter les conflits */
  }
}
</style>
