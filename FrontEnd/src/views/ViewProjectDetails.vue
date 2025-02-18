<template>
  <div v-if="project" :class="['ProjectDetails', { dark: isDark }]">
    <!-- Première partie : Logo + Titre + Lien -->
    <section :class="['Title', { dark: isDark }]">
      <img
        :src="`/src/assets/pictures/projects/${project.image}`"
        :alt="project.title"
        class="Logo"
      />
      <div class="Title-section">
        <h2>{{ project.title }}</h2>
        <a v-if="project.link" :href="project.link" target="_blank">Voir le projet</a>
      </div>
    </section>

    <!-- Deuxième partie : Description + Détails + Plus -->
    <section :class="['Description', { dark: isDark }]">
      <p><strong>Description :</strong> {{ project.Description }}</p>
      <p><strong>Détails :</strong> {{ project.Details }}</p>
      <p v-if="project.Plus"><strong>Le petit plus :</strong> {{ project.Plus }}</p>

      <!-- Fichiers supplémentaires -->
      <div v-if="project.FichierSup1 || project.FichierSup2" class="files">
        <div v-if="project.FichierSup1">
          <template v-if="isVideo(project.FichierSup1)">
            <video controls :src="project.FichierSup1"></video>
          </template>
          <template v-else>
            <a :href="project.FichierSup1" download>Télécharger Fichier 1</a>
          </template>
        </div>

        <div v-if="project.FichierSup2">
          <template v-if="isVideo(project.FichierSup2)">
            <video controls :src="project.FichierSup2"></video>
          </template>
          <template v-else>
            <a :href="project.FichierSup2" download>Télécharger Fichier 2</a>
          </template>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
// Importation des données JSON
import projectsData from '@/data/portfolio.json'

export default {
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      project: null, // Projet spécifique chargé
    }
  },
  methods: {
    isVideo(file) {
      return file.endsWith('.mp4')
    },
  },
  mounted() {
    // Récupérer l'id depuis les paramètres de la route
    const projectId = parseInt(this.$route.params.id)

    // Chercher le projet correspondant dans les données JSON
    this.project = projectsData.find((proj) => proj.id === projectId)

    // Si aucun projet n'est trouvé, rediriger vers la page d'erreur
    if (!this.project) {
      this.$router.push({ name: 'NotFound' }) // Redirection vers la route "NotFound"
    }
  },
}
</script>

<style scoped>
.ProjectDetails {
  height: 100%;
  width: 100%;
  background-color: #b0e0e6; /* Bleu pastel */
}

.ProjectDetails.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

.Title {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #ffffff; /* Couleur par défaut */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.Logo,
h1 {
  padding-top: 6rem;
}

.Title-section {
  display: flex;
  flex-direction: column; /* Aligne les enfants verticalement */
  align-items: center; /* Centre horizontalement */
  text-align: center; /* Centre le texte */
  margin-left: 16px;
}

.Title.dark {
  background-color: #2c2c2c; /* Gris anthracite */
  color: #ffffff;
}

.Title > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

.Description {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #b0e0e6; /* Bleu pastel */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.Description.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

/* Correction pour le contenu interne */
.Description > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

.Logo {
  width: 300px;
}
.Title-section {
  margin-left: 16px;
}
.body p {
  margin: 8px 0;
}
.files video {
  width: 100%;
}
.files a {
  display: block;
}

@media (max-width: 768px) {
  .Logo,
  h1 {
    padding-top: 1rem;
  }
  .Title {
    flex-direction: column;
  }
}
</style>
