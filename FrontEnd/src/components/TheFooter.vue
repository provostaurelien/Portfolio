<template>
  <footer :class="{ dark: isDark }" class="footer">
    <span>Designed by me @ 2025</span>
    <div class="footer-links">
      <a @click="redirectToContact" class="footer-link">
        <span class="footer-email">Contact</span>
      </a>
      <a
        href="https://www.linkedin.com/in/aurélien-p-a1bb7b178"
        target="_blank"
        class="footer-link linkedin-link"
      >
        LinkedIn
      </a>
    </div>
  </footer>
</template>

<script>
import '../assets/styles/global.css'
export default {
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    redirectToContact() {
      this.$router.push({ name: 'Contact' }) // Redirige vers la route nommée "Contact"
    },
  },
}
</script>

<style scoped>
.footer {
  display: flex; /* Flexbox pour aligner les éléments horizontalement */
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px 10px 17%;
  position: relative;
  background-color: inherit;
  color: inherit;
  /*clip-path: path('M0,300 C150,400 3650,0 500,00 L500,00 L0,0 Z'); /* Forme de vague */
}

.footer.dark {
  background-color: var(--primary-color-dark); /* Couleur sombre */
  color: var(--text-color-dark);
}

.footer-links {
  display: flex;
  gap: 15px; /* Espacement entre les liens */
}

.footer-link {
  text-decoration: none;
  color: inherit;
  cursor: pointer;
}

.footer-link:hover {
  color: inherit;
  text-decoration: underline;
}

@media (max-width: 768px) {
  .footer {
    padding: 10px 20px;
    box-sizing: border-box; /* S'assure que les marges sont incluses dans la largeur/hauteur */
    font-size: 14px;
  }
}
</style>
