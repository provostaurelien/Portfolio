<template>
  <div :class="['Home', { dark: isDark }]">
    <section :class="['Title', { dark: isDark }]">
      <h1>Mon portfolio</h1>
      <br />
      <!-- appel api get visitor -->
      <h2>
        Bienvenue <VisitorTracker />ème visiteur, je te laisse visiter mon portfolio de testeur
        logiciel Q/A
      </h2>
    </section>

    <section :class="['APropos', { dark: isDark }]">
      <div class="APropos-container">
        <!-- Image à gauche -->
        <div class="APropos-image">
          <img :src="AvatarSrc" alt="avatar homme" />
        </div>
        <!-- Titre et texte à droite -->
        <div class="APropos-content">
          <h2>A propos de moi</h2>
          <p>
            Je m'appelle Aurélien Provost, j'ai {{ age }} ans et je suis domicilié du côté d'Alès
            dans le Gard. Je suis passionné d'informatique depuis mon enfance. J'ai un parcours
            professionnel très varié : J'ai exercé 10 ans en tant qu'infirmier sur Nîmes, puis je
            suis devenu consultant formateur IT dans le domaine sanitaire et social pendant 5 ans.
            J'ai ensuite évolué vers un poste de consultant en interopérabilité dans le milieu
            médico-social. À force d'acquérir des compétences dans l'organisation de tests,
            l'écriture de fonctionnalités et de bugs, l'automatisation de processus et l'utilisation
            des bases de données, j'ai décidé de me former en Développeur / testeur Q/A. Ce site est
            le fruit de mes études et de mes expériences passées.
          </p>
        </div>
      </div>
    </section>
    <div :class="['Home', { dark: isDark }]">
      <section :class="['Skills', { dark: isDark }]" id="skills">
        <h2>Mes compétences</h2>
        <div class="skills-grid">
          <!-- Rendu dynamique des cartes -->
          <div v-for="(skill, index) in skills" :key="index" class="card">
            <div class="card-body">
              <img
                :src="'src/assets/pictures/skills/' + skill.image"
                :alt="'Image représentant ' + skill.title"
                class="card-image"
              />
              <h3 class="card-title">{{ skill.title }}</h3>
            </div>
          </div>
        </div>
      </section>
    </div>
    <section :class="['Projects', { dark: isDark }]">
      <h2>Mes projets</h2>
      <div class="Caroussel">
        <!-- Utilisation du composant -->
        <CarousselPortfolio />
      </div>
    </section>
  </div>
</template>

<script>
// Importation des composants api et images
import VisitorTracker from '@/components/Visitor.vue'
import Avatar from '@/assets/pictures/avatar.png'
import skillsData from '@/data/skills.json'
import CarousselPortfolio from '@/components/CarousselPortfolio.vue'

export default {
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    VisitorTracker, // Enregistrement du composant
    CarousselPortfolio, //Enregistrement du composant caroussel
  },
  data() {
    return {
      birthDate: new Date(1987, 11, 6), // Votre date de naissance (mois indexé à partir de 0)
      AvatarSrc: Avatar,
      skills: [], // Liste réactive des compétences
    }
  },
  computed: {
    age() {
      const today = new Date()
      let age = today.getFullYear() - this.birthDate.getFullYear()
      const monthDiff = today.getMonth() - this.birthDate.getMonth()
      const dayDiff = today.getDate() - this.birthDate.getDate()

      // Ajuste l'âge si l'anniversaire n'est pas encore passé cette année
      if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--
      }

      return age
    },
  },
  methods: {
    loadSkills() {
      this.skills = skillsData // Charge les données JSON dans la liste réactive
    },
  },

  mounted() {
    // Charge les compétences depuis le fichier JSON
    this.loadSkills()
  },
}
</script>

<style scoped>
/* Section "title" et Skills */
.Title,
.Skills {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #ffffff; /* Couleur par défaut */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
  transition:
    background-color 0.3s ease,
    color 0.3s ease;
}

.Title.dark,
.Skills.dark {
  background-color: #2c2c2c; /* Gris anthracite */
  color: #ffffff;
}

/* Correction pour le contenu interne */
.Title > *,
.Skills > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

/* Section Title */
h1 {
  padding-top: 6rem;
}

/* Section skills */

/* Styles pour les cartes */
/* Grille des cartes */
.skills-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Trois colonnes */
  gap: 1.5rem; /* Espacement entre les cartes */
  padding-top: 30px;
}

/* Styles pour les cartes */
.card {
  border-radius: 8px; /* Coins arrondis */
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Ombre légère */
  overflow: hidden;
  display: flex;
  flex-direction: column; /* Aligne les éléments verticalement */
  align-items: center; /* Centre horizontalement les éléments */
  padding: 1rem;
}

.card-body {
  display: flex;
  flex-direction: column;
  align-items: center; /* Centre horizontalement le contenu */
}

.card-image {
  width: auto; /* Laisse l'image s'adapter automatiquement */
  height: 150px; /* Conserve les proportions de l'image */
  object-fit: contain;
}

.card-title {
  font-size: 1.25rem;
  font-weight: bold;
  margin-top: 1rem; /* Espacement au-dessus du titre */
}

.card-text {
  font-size: 1rem;
  text-align: center; /* Centre le texte */
}

/* Section "APropos" et "Projects" */
.APropos,
.Projects {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #b0e0e6; /* Bleu pastel */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.APropos.dark,
.Projects.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

/* Correction pour le contenu interne */
.APropos > *,
.Projects > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

/* Section APropos */
.APropos-container {
  display: flex; /* Utilisation de Flexbox */
  align-items: center; /* Aligne verticalement au centre */
  gap: 2rem; /* Espacement entre les colonnes */
}

.APropos-image img {
  width: 200px; /* Largeur fixe pour l'image */
  height: auto; /* Garde les proportions */
  border-radius: 50%; /* Rend l'image circulaire */
  object-fit: cover; /* Ajuste l'image si nécessaire */
}

.APropos-content {
  flex: 1; /* Prend tout l'espace disponible */
}

.APropos-content h2 {
  margin-bottom: 1rem;
}

.APropos-content p {
  line-height: 1.6; /* Améliore la lisibilité du texte */
}

/* section "Projects" */
.Caroussel {
  padding: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Gestion du background pour le triangle restant en bas à droite */

.Home {
  background-color: #b0e0e6; /* Bleu pastel */
}

.Home.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

/* Supprime tout espace entre les sections */
.title,
.APropos,
.Skills,
.Projects {
  margin: 0;
}

/* Reponsive mobile */

@media (max-width: 768px) {
  .APropos-container {
    display: block; /* Utilisation de Flexbox */
    align-items: center; /* Aligne verticalement au centre */
  }
  .APropos-image {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .skills-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr); /* Trois colonnes */
    gap: 1.5rem; /* Espacement entre les cartes */
  }
  .card-image {
    width: auto; /* Laisse l'image s'adapter automatiquement */
    height: 100px; /* Conserve les proportions de l'image */
    object-fit: contain;
  }
  h1 {
    padding-top: 2rem;
  }
}
</style>
