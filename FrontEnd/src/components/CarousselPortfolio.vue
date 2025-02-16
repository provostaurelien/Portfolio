<template>
  <div class="gallery">
    <transition-group name="carousel" tag="div" class="carousel-container">
      <div v-for="item in visibleItems" :key="item.id" class="gallery-item">
        <router-link
          :to="{ name: 'ProjectDetails', params: { id: item.id } }"
          class="carousel-link"
        >
          <img
            :src="`src/assets/pictures/projects/${item.image}`"
            :alt="item.title"
            class="carousel-image"
          />
        </router-link>
        <h3>{{ item.title }}</h3>
      </div>
    </transition-group>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [], // Stocke les données du JSON
      currentIndex: 0, // Index de l'image actuelle
    }
  },
  computed: {
    visibleItems() {
      // Vérifie si les données sont chargées avant d'accéder à l'élément actuel
      if (this.items.length === 0) {
        return []
      }
      return [this.items[this.currentIndex]]
    },
  },
  mounted() {
    // Charge les données depuis le fichier JSON
    this.fetchPortfolioData()
    this.startCarousel()
  },
  beforeUnmount() {
    clearInterval(this.carouselInterval)
  },
  methods: {
    async fetchPortfolioData() {
      try {
        const response = await fetch('src/data/portfolio.json') // Charge le fichier JSON
        if (!response.ok) {
          throw new Error(`Erreur HTTP : ${response.status}`)
        }
        this.items = await response.json() // Convertit la réponse en JSON
      } catch (error) {
        console.error('Erreur lors du chargement des données :', error)
      }
    },
    startCarousel() {
      this.carouselInterval = setInterval(() => {
        if (this.items.length > 0) {
          this.currentIndex = (this.currentIndex + 1) % this.items.length // Passe à l'image suivante
        }
      }, 3000) // Change toutes les 3 secondes
    },
  },
}
</script>

<style scoped>
.gallery-item {
  text-align: center;
  background-color: white; /* Fond blanc pour l'effet polaroid */
  padding: 20px; /* Espace entre l'image et la bordure */
  border: 1px solid #ccc; /* Bordure grise légère */
  border-radius: 5px; /* Coins légèrement arrondis */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre pour l'effet de profondeur */
  margin: 20px auto; /* Espacement entre les éléments */
  width: fit-content; /* Ajuste la largeur au contenu */
}

.carousel-image {
  width: 300px; /* Largeur de l'image */
  height: auto;
  object-fit: cover;
}

h3 {
  margin-top: 20px; /* Espacement entre l'image et le titre */
  font-size: 18px;
  font-weight: bold;
  color: black;
}
</style>
