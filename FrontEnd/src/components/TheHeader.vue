<template>
  <div :class="{ dark: isDark }">
    <!-- Logo -->
    <div class="logo">
      <img :src="isDark ? darkLogo : lightLogo" alt="Logo du site" />
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
import '../assets/styles/global.css'

export default {
  name: 'TheHeader',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
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
}
</script>

<style>
.header {
  display: flex; /* Flexbox pour aligner les éléments */
  height: 100vh; /* Hauteur forcée pour desktop */
  z-index: 150;
}

/* Mode sombre et clair */
.header {
  background-color: var(--third-color-light) !important;
  color: var(--text-color-light);
}
.dark .header {
  background-color: var(--third-color-dark) !important;
  color: var(--text-color-dark);
}

/* Logo */
.logo img {
  max-width: 100%; /* Logo responsive */
}

/* Liens de navigation */
.nav-links {
  display: flex;
  flex-direction: column;
  margin-top: 20px;
}

/* Style des liens */
.nav-link {
  margin-bottom: 30px;
  text-decoration: none; /* Supprime le style par défaut des liens HTML */
  color: inherit;
}
.nav-link:hover {
  text-decoration: underline; /* Soulignement au survol */
}
.nav-link.active {
  font-weight: 800; /* Lien actif en gras */
}

/* Sidebar Desktop */
@media (min-width: 768px) {
  .header {
    position: fixed; /* Fixe la sidebar sur le côté gauche */
    top: 0;
    left: 0;
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
  .header {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 100;
    height: 60px;
    display: flex;
    align-items: center;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }

  .logo img {
    max-width: 100px; /* Taille fixe pour le logo dans la vue mobile */
  }

  .nav-links {
    flex-direction: row;
    gap: 15px;
    margin-top: 20;
  }
}
</style>
