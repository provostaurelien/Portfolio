<template>
  <div class="gallery">
    <div class="carousel-container" @mouseover="stopCarousel" @mouseleave="startCarousel">
      <transition name="slide-fade" mode="out-in">
        <div v-if="visibleItems.length > 0" :key="visibleItems[0].id" class="gallery-item">
          <router-link
            :to="{ name: 'ProjectDetails', params: { id: visibleItems[0].id } }"
            class="carousel-link"
          >
            <img
              :src="`src/assets/pictures/projects/${visibleItems[0].image}`"
              :alt="visibleItems[0].title"
              class="carousel-image"
            />
          </router-link>
          <h3>{{ visibleItems[0].title }}</h3>
        </div>
      </transition>
    </div>
    <!-- Compteur -->
    <div :class="['carousel-counter', { dark: isDark }]">
      {{ currentIndex + 1 }}/{{ items.length }}
    </div>
  </div>
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
  data() {
    return {
      items: [], // Stocke les données du JSON
      currentIndex: 0, // Index de l'image actuelle
      carouselInterval: null, // Référence au timer du carrousel
    }
  },
  computed: {
    visibleItems() {
      if (this.items.length === 0) {
        return []
      }
      return [this.items[this.currentIndex]]
    },
  },
  mounted() {
    this.fetchPortfolioData()
    this.startCarousel()
  },
  beforeUnmount() {
    this.stopCarousel()
  },
  methods: {
    //Gestion des erreurs
    async fetchPortfolioData() {
      try {
        const response = await fetch('src/data/portfolio.json')
        if (!response.ok) {
          throw new Error(`Erreur HTTP : ${response.status}`)
        }
        this.items = await response.json()
      } catch (error) {
        console.error('Erreur lors du chargement des données :', error)
      }
    },
    startCarousel() {
      this.stopCarousel() // Arrête tout timer existant avant d'en démarrer un nouveau
      // Gestion du défilement automatique
      this.carouselInterval = setInterval(() => {
        if (this.items.length > 0) {
          this.currentIndex = (this.currentIndex + 1) % this.items.length
        }
      }, 3000)
    },
    stopCarousel() {
      clearInterval(this.carouselInterval)
    },
  },
}
</script>

<style scoped>
.gallery-item {
  text-align: center;
  background-color: white; /* Fond blanc pour l'effet polaroid */
  padding: 20px; /* Espace entre l'image et la bordure */
  border: 1px solid #ccc;
  border-radius: 5px; /* Coins légèrement arrondis */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre pour l'effet de profondeur */
  margin: auto;
}

.carousel-image {
  width: 300px;
  height: auto;
  object-fit: cover;
}

h3 {
  margin-top: 20px;
  font-size: 36px;
  font-family: 'Caveat', sans-serif !important;
  color: black;
}

/* Transition pour le fondu et le glissement */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.5s ease;
  position: relative;
}

.slide-fade-enter {
  opacity: 0;
  transform: translateX(100%); /* L'image entre depuis la droite */
}

.slide-fade-enter-to {
  opacity: 1;
  transform: translateX(0);
}

.slide-fade-leave {
  opacity: 1;
  transform: translateX(0);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(100%); /* L'image sort vers la gauche */
}
.carousel-counter {
  text-align: center;
  margin-top: 10px;
  font-size: 16px;
  color: var(--text-color-light);
}

.carousel-counter.dark {
  color: var(--text-color-dark);
}
.carousel-container:hover .carousel-image {
  cursor: pointer;
}
</style>
