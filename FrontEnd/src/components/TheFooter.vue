<template>
  <footer :class="{ dark: isDark }" class="footer">
    <span>Designed by me @ 2025</span>
    <span class="footer-email">contact@monmail.com</span>
  </footer>
</template>

<script>
export default {
  name: 'TheFooter',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
}
</script>

<style scoped>
.footer {
  display: flex; /* Flexbox pour aligner les éléments horizontalement */
  justify-content: space-between; /* Espace entre les deux parties (mention et e-mail) */
  align-items: center; /* Centre verticalement les éléments */
  padding: 10px 20px 10px 17%;
  position: relative;
  background-color: inherit; /* Respecte les couleurs du mode clair/sombre */
  color: inherit;
  /*clip-path: path('M0,300 C150,400 3650,0 500,00 L500,00 L0,0 Z'); /* Forme de vague */
}

.light {
  background-color: white !important;
  color: black;
}
.dark .footer {
  background-color: #2c2c2c !important;
  color: white;
}

/* E-mail dans le footer */
.footer-email {
  text-align: right;
}
@media (max-width: 768px) {
  .footer {
    padding: 10px 20px;
    box-sizing: border-box; /* S'assure que les marges sont incluses dans la largeur/hauteur */
  }
}
</style>
