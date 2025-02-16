<template>
  <div id="app" class="app-container">
    <!-- Conteneur principal (sidebar + contenu) -->
    <div class="content-wrapper">
      <!-- Sidebar -->
      <TheHeader class="header" />
      <!-- Contenu principal -->
      <main class="main-content">
        <router-view />
      </main>
    </div>

    <!-- Footer -->
    <TheFooter />
  </div>
</template>

<script>
import TheHeader from './components/TheHeader.vue' // Import du header
import TheFooter from './components/TheFooter.vue' // Import du footer

export default {
  components: { TheHeader, TheFooter }, // Enregistrement des composants
}
</script>

<style scoped>
/* Layout global */
.app-container {
  display: flex;
  flex-direction: column; /* Empile les enfants verticalement (contenu + footer) */
  height: 100vh; /* La hauteur occupe tout l'écran */
}

/* Conteneur principal (sidebar + contenu) */
.content-wrapper {
  display: flex; /* Aligne la sidebar et le contenu principal côte à côte */
  flex-grow: 1; /* Occupe tout l'espace disponible entre le header et le footer */
}

/* Sidebar/Header */
.content-wrapper > *:first-child {
  width: 15%; /* Sidebar occupe une largeur fixe en desktop */
  flex-shrink: 0; /* Empêche la sidebar de rétrécir */
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}
/* Compensation de sidebar fixed */
.main-content {
  padding-left: 15%;
}

/* Footer */
.footer {
  text-align: center;
  /* Compensation de sidebar fixed */
  padding-left: 18%;
}

/* Responsivité pour mobile */
@media (max-width: 768px) {
  .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
  }
  /* Compensation du décalage par rapport à la position fixed */
  .main-content {
    padding-top: 100px;
    padding-left: 0;
  }
  .content-wrapper {
    flex-direction: column; /* Passe à une structure verticale en mobile */
    height: auto; /* Ajuste automatiquement la hauteur selon le contenu */
  }

  .content-wrapper > *:first-child {
    width: 100%; /* La sidebar occupe toute la largeur en mobile */
  }
  .footer {
    padding-left: 10px;
  }
}
</style>
