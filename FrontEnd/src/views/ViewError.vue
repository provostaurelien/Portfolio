<template>
  <section :class="['Main', { dark: isDark }]">
    <h1>Vous êtes perdu?</h1>
    <p>(Suivez le lapin blanc <span>😉</span>)</p>

    <!-- Ligne 1 des traces -->
    <div class="rabbit-traces">
      <span v-for="(trace, index) in topTraces" :key="'top-' + index" class="trace">🐾</span>
    </div>

    <!-- Ligne 2 des traces -->
    <div class="rabbit-traces">
      <span v-for="(trace, index) in bottomTraces" :key="'bottom-' + index" class="trace">🐾</span>
    </div>

    <!-- Lapin blanc cliquable -->
    <button
      v-if="showRabbit"
      class="rabbit-button"
      @click="goHome"
      aria-label="Retour à la page d'accueil"
    >
      🐇
    </button>
  </section>
</template>

<script>
import '../assets/styles/global.css'
export default {
  name: 'ViewError',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      topTraces: [], // Traces de la ligne du haut
      bottomTraces: [], // Traces de la ligne du bas
      showRabbit: false, // Affichage du lapin
    }
  },
  mounted() {
    this.animateTraces() // Démarre l'animation au montage du composant
  },
  methods: {
    animateTraces() {
      let count = 0
      const interval = setInterval(() => {
        if (count < 8) {
          if (count % 2 === 0) {
            this.topTraces.push('🐾') // Ajoute une trace à la ligne du haut
          } else {
            this.bottomTraces.push('🐾') // Ajoute une trace à la ligne du bas
          }
          count++
        } else {
          clearInterval(interval) // Arrête l'intervalle après 8 traces
          this.showRabbit = true // Affiche le lapin
        }
      }, 500) // Ajoute une trace toutes les 500ms
    },
    goHome() {
      // Redirige vers la page d'accueil (par exemple "/home")
      this.$router.push('/')
    },
  },
}
</script>

<style scoped>
.Main {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  height: 100%;
  width: 100%;
  background-color: var(--secondary-color-light);
}

.Main.dark {
  background-color: var(--secondary-color-dark);
  color: var(--text-color-dark);
}

.rabbit-traces {
  margin-top: 1rem;
}

.trace {
  font-size: 2rem;
}

.rabbit-button {
  margin-top: 1rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 3rem;
}
</style>
