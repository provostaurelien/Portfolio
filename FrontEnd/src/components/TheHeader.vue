<template>
  <div :class="['header', isDarkMode ? 'dark' : 'light']">
    <!-- Logo -->
    <div class="logo">
      <img :src="isDarkMode ? darkLogo : lightLogo" alt="Logo du site" />
    </div>

    <!-- Liens de navigation -->
    <nav class="nav-links">
      <router-link
        v-for="link in links"
        :key="link.name"
        :to="link.path"
        class="nav-link"
        :class="{ active: $route.path === link.path }"
      >
        {{ link.name }}
      </router-link>
    </nav>
  </div>
</template>

<script>
import darkLogo from '@/assets/logo/WhiteLogo.png'
import lightLogo from '@/assets/logo/BlackLogo.png'

export default {
  data() {
    return {
      isMobile: window.innerWidth <= 768, // Détection mobile
      isDarkMode: window.matchMedia('(prefers-color-scheme: dark)').matches, // Mode sombre
      darkLogo,
      lightLogo,
      links: [
        { name: 'Accueil', path: '/' },
        { name: 'Projets', path: '/projects' },
        { name: 'Avis', path: '/reviews' },
        { name: 'Contact', path: '/contact' },
      ],
    }
  },
  methods: {
    updateViewport() {
      this.isMobile = window.innerWidth <= 768
    },
    updateDarkMode(e) {
      this.isDarkMode = e.matches
    },
  },
  mounted() {
    // Écoute des changements de taille d'écran
    window.addEventListener('resize', this.updateViewport)

    // Écoute des changements de mode sombre
    window
      .matchMedia('(prefers-color-scheme: dark)')
      .addEventListener('change', this.updateDarkMode)
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.updateViewport)
    window
      .matchMedia('(prefers-color-scheme: dark)')
      .removeEventListener('change', this.updateDarkMode)
  },
}
</script>

<style scoped>
/* Styles globaux */
.header {
  display: flex; /* Flexbox pour aligner les éléments */
  height: 100vh; /* Hauteur forcée pour desktop */
}

/* Mode sombre et clair */
.light {
  background-color: white;
  color: black;
}
.dark {
  background-color: #2c2c2c;
  color: white;
}

/* Logo */
.logo img {
  max-width: 100%; /* Logo responsive */
}

/* Liens de navigation */
.nav-links {
  display: flex; /* Par défaut, les liens sont alignés horizontalement */
  flex-direction: column; /* Empile les liens verticalement (desktop sidebar) */
  margin-top: 20px;
}

/* Style des liens */
.nav-link {
  display: block;
  margin-bottom: 10px;
  text-decoration: none; /* Supprime le style par défaut des liens HTML */
  color: inherit; /* Adapte la couleur au mode clair/sombre */
}
.nav-link:hover {
  text-decoration: underline; /* Soulignement au survol */
}
.nav-link.active {
  font-weight: bold; /* Lien actif en gras */
}

/* Sidebar Desktop */
@media (min-width: 768px) {
  .header {
    width: 15%; /* Sidebar occupe une largeur fixe en desktop */
    padding: 20px;
    font-size: 30px;
    border-right: 1px solid rgba(0, 0, 0, 0.1); /* Délimiteur visuel */
    display: flex;
    flex-direction: column;
    border-right: 1px solid rgba(0, 0, 0, 0.1); /* Délimiteur */
    box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1); /* Ombre */
  }

  /* Contenu principal (pour router-view) */
  .main-content {
    flex-grow: 1; /* Le contenu principal occupe tout l'espace restant */
  }
}

/* Header Mobile */
@media (max-width: 768px) {
  /* Header en vue mobile */
  .header {
    flex-direction: row; /* Aligne les enfants horizontalement (logo + liens) */
    height: auto; /* Ajuste automatiquement la hauteur selon le contenu */
    padding: 10px; /* Ajoute un espacement autour du header mobile */
    align-items: center; /* Centre verticalement le logo et les liens */
  }

  .logo img {
    max-width: 100px; /* Taille fixe pour le logo dans la vue mobile */
  }

  .nav-links {
    flex-direction: row; /* Aligne les liens horizontalement en mobile */
    gap: 15px; /* Ajoute un espacement uniforme entre les liens */
    margin-top: 0; /* Supprime l'espacement vertical par défaut en mobile */
  }
}
</style>
