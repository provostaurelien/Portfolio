<template>
  <section class="Avis">
    <div :class="['SendReview', { dark: isDark }]">
      <h1>Avis des visiteurs</h1>
      <p>Si vous le souhaitez, vous pouvez laisser votre avis sur mon portfolio. Merci!</p>

      <h2>Ajouter un avis</h2>
      <form :class="{ dark: isDark }" @submit.prevent="submitReview">
        <div>
          <label for="author">Nom :</label>
          <input id="author" v-model="newReview.author" type="text" placeholder="Votre nom" />
        </div>
        <div>
          <label for="content">Avis :</label>
          <textarea
            id="content"
            v-model="newReview.content"
            placeholder="Votre avis (au moins 10 caractères)"
          ></textarea>
        </div>
        <div>
          <label for="score">Note :</label>
          <input
            id="score"
            v-model.number="newReview.score"
            type="number"
            min="0"
            max="5"
            placeholder="Score (entre 0 et 5)"
          />
        </div>

        <!-- Affichage des messages pour le POST -->
        <div v-if="postErrorMessage" class="error">{{ postErrorMessage }}</div>
        <div v-if="postSuccessMessage" class="success">{{ postSuccessMessage }}</div>

        <!-- Bouton d'envoi -->
        <button type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Envoi en cours...' : 'Envoyer' }}
        </button>
      </form>
    </div>

    <div :class="['GetReviews', { dark: isDark }]">
      <h2>Avis précédents</h2>

      <!-- Affichage des messages pour le GET -->
      <div v-if="getErrorMessage" class="error">{{ getErrorMessage }}</div>

      <!-- Indicateur de chargement -->
      <p v-if="isLoading">Chargement des avis...</p>

      <!-- Liste des avis ou message si aucun avis -->
      <ul v-else-if="reviewList.length > 0">
        <li v-for="review in reviewList" :key="review.id">
          <strong>{{ review.author }}</strong> - Score: {{ review.score }}/5
          <br />
          {{ review.content }}
        </li>
      </ul>

      <!-- Message si liste vide et aucune erreur -->
      <p v-else>Soyez le premier à laisser votre avis !!!</p>
    </div>
  </section>
</template>

<script>
import { ref, onMounted } from 'vue'
import { getReviews, addReview } from '../api/Api.js'
import { useReCaptcha } from 'vue-recaptcha-v3'

export default {
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  setup() {
    const { executeRecaptcha } = useReCaptcha() // Utilisation de reCAPTCHA
    const reviewList = ref([]) // Liste des avis
    const newReview = ref({
      author: '',
      content: '',
      score: null,
    })
    const isSubmitting = ref(false)
    const isLoading = ref(true) // Indique si les avis sont en cours de chargement
    const postSuccessMessage = ref('')
    const postErrorMessage = ref('')
    const getErrorMessage = ref('')

    // Regex pour valider le nom de l'auteur
    const nameRegex = /^[a-zA-ZÀ-ÿ _-]+$/

    // Validation du formulaire
    const validateReviewForm = () => {
      if (!newReview.value.author || !nameRegex.test(newReview.value.author)) {
        postErrorMessage.value =
          'Le nom est invalide. Utilisez uniquement des lettres, des espaces, des tirets ou des underscores.'
        return false
      }

      if (!newReview.value.content || newReview.value.content.length < 10) {
        postErrorMessage.value = "Le contenu de l'avis doit contenir au moins 10 caractères."
        return false
      }

      if (
        newReview.value.score === null ||
        newReview.value.score < 0 ||
        newReview.value.score > 5
      ) {
        postErrorMessage.value = 'La note doit être un nombre compris entre 0 et 5.'
        return false
      }

      postErrorMessage.value = '' // Réinitialise le message d'erreur si tout est valide
      return true
    }

    // Récupération des avis (GET)
    const fetchReviews = async () => {
      isLoading.value = true // Début du chargement
      try {
        const response = await getReviews()
        reviewList.value = response // Stockage des avis
      } catch (error) {
        console.error('Erreur de récupération des avis', error)
        getErrorMessage.value =
          'Impossible de récupérer les avis pour le moment. Veuillez réessayer plus tard.'
        reviewList.value = []
      } finally {
        isLoading.value = false // Fin du chargement
      }
    }

    // Soumission d'un nouvel avis (POST)
    const submitReview = async () => {
      if (!validateReviewForm()) {
        return // Arrête l'envoi si la validation échoue
      }

      try {
        isSubmitting.value = true
        postSuccessMessage.value = ''
        postErrorMessage.value = ''

        // Exécuter reCAPTCHA avec une action spécifique (par ex. "submit_review")
        const recaptchaToken = await executeRecaptcha('submit_review')
        if (!recaptchaToken) {
          throw new Error('Échec de la validation reCAPTCHA.')
        }

        // Ajouter un nouvel avis avec le token reCAPTCHA
        await addReview({ ...newReview.value, recaptchaToken })

        // Afficher un message de succès et réinitialiser le formulaire
        postSuccessMessage.value = 'Votre avis a été ajouté avec succès !'
        newReview.value = { author: '', content: '', score: null } // Réinitialisation du formulaire

        // Rafraîchir la liste des avis
        fetchReviews()
      } catch (error) {
        console.error("Erreur lors de l'ajout de l'avis", error)
        postErrorMessage.value =
          "Une erreur est survenue lors de l'ajout de votre avis. Veuillez réessayer."
      } finally {
        isSubmitting.value = false
      }
    }

    onMounted(fetchReviews)

    return {
      reviewList,
      newReview,
      isSubmitting,
      isLoading,
      postSuccessMessage,
      postErrorMessage,
      getErrorMessage,
      submitReview,
    }
  },
}
</script>

<style scoped>
.error {
  color: red;
  margin-top: 10px;
}
.success {
  color: green;
  margin-top: 10px;
}

.GetReviews {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #b0e0e6; /* Bleu pastel */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.GetReviews.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}

/* Correction pour le contenu interne */
.GetReviews > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

.SendReview {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #ffffff; /* Couleur par défaut */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.SendReview.dark {
  background-color: #2c2c2c; /* Gris anthracite */
  color: #ffffff;
}

.SendReview > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

h1 {
  padding-top: 6rem;
}

@media (max-width: 768px) {
  h1 {
    padding-top: 2rem;
  }
}
</style>
