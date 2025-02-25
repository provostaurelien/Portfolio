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
        <h1>{{ project.title }}</h1>
        <br />
        <a
          v-if="project.link"
          :href="project.link"
          target="_blank"
          :class="['project-button', { dark: isDark }]"
        >
          Découvrir le projet
          <span class="arrow">→</span>
        </a>
      </div>
    </section>

    <!-- Deuxième partie : Description + Détails + Plus -->
    <section :class="['Description', { dark: isDark }]">
      <p><strong>Description :</strong> {{ project.Description }}</p>
      <p><strong>Détails :</strong> <span v-html="project.Details"></span></p>
      <p v-if="project.Plus"><strong>Le petit plus :</strong> {{ project.Plus }}</p>

      <!-- Fichiers supplémentaires -->
      <div v-if="additionalFiles.length" :class="['files', { dark: isDark }]">
        <!-- Boucle sur les fichiers supplémentaires -->
        <div v-for="(file, index) in additionalFiles" :key="index">
          <template v-if="isVideo(file)">
            <video controls :src="file"></video>
          </template>
          <template v-else-if="isImage(file)">
            <img :src="file" alt="Image supplémentaire" />
          </template>
          <template v-else>
            <a :href="file" download> Télécharger la ressource : {{ getFileName(file) }} </a>
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
  computed: {
    additionalFiles() {
      // Filtrer les fichiers supplémentaires non nuls
      return [
        this.project?.FichierSup1,
        this.project?.FichierSup2,
        this.project?.FichierSup3,
      ].filter((file) => !!file)
    },
  },
  methods: {
    isVideo(file) {
      return file.endsWith('.mp4')
    },
    isImage(file) {
      const imageExtensions = ['.png', '.jpg', '.jpeg', '.gif']
      return imageExtensions.some((ext) => file.endsWith(ext))
    },
    getFileName(filePath) {
      return filePath.split('/').pop() // Récupère tout après le dernier '/'
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

.Logo {
  padding-top: 6rem;
}

h1 {
  padding-top: 2rem;
}

.Title-section {
  display: flex;
  flex-direction: column; /* Aligne les enfants verticalement */
  align-items: center; /* Centre horizontalement */
  text-align: center; /* Centre le texte */
  padding-top: 20px;
  margin-left: 16px;
}

.project-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 20px;
  font-size: 1.2rem;
  font-weight: bold;
  color: black;
  background-color: #b0e0e6;
  border: none;
  border-radius: 25px;
  text-decoration: none;
  transition: all 0.3s ease-in-out;
  position: relative;
  overflow: hidden;
}

.project-button.dark {
  color: white;
  background-color: #001f3f;
}

.project-button:hover {
  background-color: #4da8c6;
  transform: scale(1.05); /* Légère mise en avant */
}

.project-button.dark:hover {
  background-color: #007198;
}

.project-button .arrow {
  margin-left: 10px;
  transition: transform 0.3s ease-in-out;
}

.project-button:hover .arrow {
  transform: translateX(5px); /* Déplacement de la flèche vers la droite */
}

/* Effet d'ondulation lors du clic */
.project-button::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 300%;
  height: 300%;
  background-color: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  transform: translate(-50%, -50%) scale(0);
  transition: transform 0.5s ease-out;
}

.project-button:active::after {
  transform: translate(-50%, -50%) scale(1);
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
.Description p {
  margin: 30px;
}

.files {
  display: flex; /* Active Flexbox */
  flex-direction: column; /* Empile les éléments verticalement */
  align-items: center; /* Centre horizontalement les vidéos */
  justify-content: center; /* Centre verticalement si le conteneur a une hauteur définie */
  width: 100%; /* S'assure que le conteneur prend toute la largeur */
  padding: 20px 0; /* Ajoute de l'espace autour des vidéos */
}
.files video,
.files img {
  display: block; /* Nécessaire pour utiliser margin:auto */
  width: 70%; /* Ajustez la largeur selon vos besoins */
  margin: 20px auto; /* Centre horizontalement chaque vidéo */
}

.files a {
  display: block;
  text-decoration: none; /* Supprime le soulignement */
  color: #000000;
  padding: 20px 0px;
}

.files.dark a {
  color: white;
}

.files a:hover {
  color: #ff6600; /* Couleur au survol */
}

@media (max-width: 768px) {
  .Title {
    flex-direction: column;
  }
  .Logo,
  h1 {
    padding-top: 2rem;
  }
}
</style>
