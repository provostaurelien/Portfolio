<template>
  <section :class="['Main', { dark: isDark }]">
    <h1>Vous êtes perdu?</h1>
    <p>(Suivez le lapin blanc <span>😀</span>)</p>

    <!-- Affichage des traces de lapin -->
    <div class="rabbit-traces">
      <span v-for="(trace, index) in traces" :key="index" class="trace">🐾</span>
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
      traces: [], // Liste des traces de lapin
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
          this.traces.push('🐾') // Ajoute une trace
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
  background-color: #b0e0e6; /* Bleu pastel */
}

.Main.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

.rabbit-traces {
  margin-top: 1rem;
}

.trace {
  font-size: 2rem; /* Taille des traces */
}

.rabbit-button {
  margin-top: 1rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 3rem; /* Taille du lapin */
}
</style>
