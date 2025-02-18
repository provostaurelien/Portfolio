<template>
  <div :class="{ dark: isDarkMode }">
    <!-- Bouton global pour basculer entre les modes -->
    <DarkModeHandler :is-dark="isDarkMode" @dark-mode-changed="handleDarkModeChange" />

    <!-- Conteneur principal (sidebar + contenu) -->
    <div id="app" class="app-container">
      <div class="content-wrapper">
        <!-- Sidebar -->
        <TheHeader :is-dark="isDarkMode" class="header" />
        <!-- Contenu principal -->
        <main class="main-content">
          <router-view :is-dark="isDarkMode" />
        </main>
      </div>

      <!-- Footer -->
      <TheFooter :is-dark="isDarkMode" />
    </div>
  </div>
</template>

<script>
import DarkModeHandler from '@/components/DarkModeHandler.vue'
import TheHeader from './components/TheHeader.vue'
import TheFooter from './components/TheFooter.vue'

export default {
  name: 'App',
  components: { DarkModeHandler, TheHeader, TheFooter },
  data() {
    return {
      isDarkMode: false, // État global pour le mode sombre
    }
  },
  methods: {
    handleDarkModeChange(isDark) {
      this.isDarkMode = isDark
    },
    toggleDarkMode() {
      this.isDarkMode = !this.isDarkMode
    },
  },
}
</script>

<style scoped>
/* Layout global */
.app-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.content-wrapper {
  display: flex;
  flex-grow: 1;
}

.main-content {
  margin-left: 15%; /* Compense la largeur de la sidebar */
  flex-grow: 1;
  height: 100%;
}

@media (max-width: 768px) {
  .content-wrapper {
    display: block;
    flex-grow: 1;
  }
  .main-content {
    margin-left: 0%; /* Compense la largeur de la sidebar */
    height: 86%; /* Laisse le contenu s'étendre naturellement */
  }
}
</style>
