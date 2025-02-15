<template>
  <div id="app" class="app-container">
    <!-- Conteneur principal (sidebar + contenu) -->
    <div class="content-wrapper">
      <!-- Sidebar -->
      <TheHeader />
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
import TheFooter from './components/Thefooter.vue' // Import du footer

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
}

/* Contenu principal */
.main-content {
  flex-grow: 1; /* Le contenu principal occupe tout l'espace restant */
  padding: 20px;
}

/* Footer */
.footer {
  text-align: center;
  padding: 10px;
}

/* Responsivité pour mobile */
@media (max-width: 768px) {
  .content-wrapper {
    flex-direction: column; /* Passe à une structure verticale en mobile */
    height: auto; /* Ajuste automatiquement la hauteur selon le contenu */
  }

  .content-wrapper > *:first-child {
    width: 95%; /* La sidebar occupe toute la largeur en mobile */
  }
}
</style>
