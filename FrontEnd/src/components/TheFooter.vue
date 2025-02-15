<template>
  <footer :class="isDarkMode ? 'dark' : 'light'" class="footer">
    <span>Designed by me @ 2025</span>
    <span class="footer-email">contact@monmail.com</span>
  </footer>
</template>

<script>
export default {
  name: 'TheFooter',
  data() {
    return {
      isDarkMode: window.matchMedia('(prefers-color-scheme: dark)').matches, // Détection du mode sombre
    }
  },
  methods: {
    updateDarkMode(e) {
      this.isDarkMode = e.matches // Met à jour la variable en cas de changement
    },
  },
  mounted() {
    // Écoute des changements de mode sombre
    window
      .matchMedia('(prefers-color-scheme: dark)')
      .addEventListener('change', this.updateDarkMode)
  },
  beforeUnmount() {
    // Supprime l'écouteur pour éviter les fuites de mémoire
    window
      .matchMedia('(prefers-color-scheme: dark)')
      .removeEventListener('change', this.updateDarkMode)
  },
}
</script>

<style scoped>
.footer {
  display: flex; /* Flexbox pour aligner les éléments horizontalement */
  justify-content: space-between; /* Espace entre les deux parties (mention et e-mail) */
  align-items: center; /* Centre verticalement les éléments */
  padding: 10px 20px;
  position: relative;
  background-color: inherit; /* Respecte les couleurs du mode clair/sombre */
  color: inherit;
  clip-path: path('M0,300 C150,400 3650,0 500,00 L500,00 L0,0 Z'); /* Forme de vague */
}

.light {
  background-color: white;
  color: black;
}
.dark {
  background-color: #2c2c2c;
  color: white;
}

/* E-mail dans le footer */
.footer-email {
  text-align: right;
}
</style>
