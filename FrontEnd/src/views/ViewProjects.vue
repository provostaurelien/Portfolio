<template>
  <section :class="['ProjectsPage', { dark: isDark }]">
    <div :class="['ProjectPresentation', { dark: isDark }]">
      <h1>Mes Projets</h1>
      <p>
        Voici mes différents projets réalisés à ce jour en termes de développement et tests
        logiciels.<br />
        Lors de mes projets d'études présentés ci-dessous, j'ai toujours voulu réaliser une chose en
        plus par rapport à l'exercice demandé. Je vous laisse découvrir ces différents projets en
        détail.
      </p>
    </div>
    <div :class="['ProjectList', { dark: isDark }]">
      <!-- Boucle sur les projets récupérés -->
      <div v-for="project in items" :key="project.id" :class="['ProjectCard', { dark: isDark }]">
        <router-link
          :to="{ name: 'ProjectDetails', params: { id: project.id } }"
          class="carousel-link"
        >
          <div class="ImageContainer">
            <img
              :src="`src/assets/pictures/projects/${project.image}`"
              :alt="'Logo de ' + project.title"
            />
          </div>
          <h2>{{ project.title }}</h2>
          <p>{{ project.Description }}</p>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import '../assets/styles/global.css'
export default {
  name: 'ViewProjects',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      items: [], // Stocke les données des projets
    }
  },
  methods: {
    async fetchPortfolioData() {
      try {
        const response = await fetch('src/data/portfolio.json') // Chemin vers le fichier JSON
        if (!response.ok) {
          throw new Error(`Erreur HTTP : ${response.status}`)
        }
        this.items = await response.json() // Stockage des données dans items
      } catch (error) {
        console.error('Erreur lors du chargement des données :', error)
      }
    },
  },
  mounted() {
    this.fetchPortfolioData() // Appel de la méthode lors du montage du composant
  },
}
</script>

<style scoped>
.ProjectsPage {
  display: flex;
  flex-direction: column;
  height: 100%;
  width: 100%;
  background-color: var(--secondary-color-light);
}

.ProjectsPage.dark {
  background-color: var(--secondary-color-dark);
  color: var(--text-color-dark);
}

.ProjectPresentation {
  position: relative;
  padding: 1% 2% 6% 2%;
  background-color: var(--primary-color-light);
  color: var(--text-color-light);
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.ProjectPresentation.dark {
  background-color: var(--primary-color-dark);
  color: var(--text-color-dark);
}

.ProjectPresentation > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

/* Flexbox pour les cartes */
.ProjectList {
  padding: 40px 0px;
  display: flex;
  flex-wrap: wrap; /* Permet le retour à la ligne */
  gap: 20px; /* Espacement entre les cartes */
  justify-content: center; /* Centre les éléments si une seule carte sur la dernière ligne */
  height: 100%; /* Prend toute la hauteur disponible */
  width: 100%; /* Prend toute la largeur disponible */
  background-color: var(--secondary-color-ligh);
}

.ProjectList.dark {
  background-color: var(--secondary-color-dark);
  color: var(--text-color-dark);
}

.ProjectCard {
  flex: 1 1 calc(50% - 60px); /* Deux cartes par ligne (50% - espace entre les cartes) */
  max-width: calc(50% - 60px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center; /* Centre verticalement le contenu */
  background-color: var(--primary-color-light);
  color: var(--test-color-light);
  border-radius: 8px;
  padding: 20px;
  box-shadow:
    rgba(0, 0, 0, 0.1) 0px 4px 6px,
    rgba(0, 0, 0, 0.05) -1px -1px;
}

.ProjectCard.dark {
  background-color: var(--primary-color-dark);
  color: var(--test-color-dark);
}

/* Conteneur pour centrer l'image */
.ImageContainer {
  display: flex;
  justify-content: center;
}

.ImageContainer img {
  max-height: 300px; /* Bloque la hauteur à un maximum de pixels */
}

/* Centrage du texte */
.ProjectCard h2,
.ProjectCard p {
  text-align: center;
  color: var(--text-color-light);
}

.ProjectCard.dark h2,
.ProjectCard.dark p {
  text-align: center;
  color: var(--text-color-dark);
}

/* Suppression de l'héritage CSS des liens */
.carousel-link {
  text-decoration: none; /* Supprime le soulignement */
}

.carousel-link:hover h2,
.carousel-link:hover p {
  color: #ff6600;
}

/* Responsive : une seule colonne sur mobile */
@media (max-width: 768px) {
  .ProjectCard {
    flex-basis: calc(100% - 0px); /* Une seule carte par ligne sur mobile */
    max-width: calc(100% - 30px);
    margin: auto;
  }
  h1 {
    padding-top: 2rem;
  }
}
</style>
