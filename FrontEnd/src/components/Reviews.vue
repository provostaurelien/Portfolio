<template>
  <section class="Avis">
    <div :class="['SendReview', { dark: isDark }]">
      <h1>Avis des visiteurs</h1>
      <p>Si vous le souhaitez, vous pouvez laisser votre avis sur mon portfolio. Merci!</p>
      <h2>Ajouter un avis</h2>
      <form @submit.prevent="submitReview">
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

        <!-- Affichage des messages -->
        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
        <div v-if="successMessage" class="success">{{ successMessage }}</div>

        <!-- Bouton d'envoi -->
        <button type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Envoi en cours...' : 'Envoyer' }}
        </button>
      </form>
    </div>
    <div :class="['GetReviews', { dark: isDark }]">
      <h2>Avis précédents</h2>
      <ul>
        <li v-for="review in reviews" :key="review.id">
          <strong>{{ review.author }}</strong> - Score: {{ review.score }}/5 <br />
          {{ review.content }}
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
import { ref, onMounted } from 'vue'
import { getReviews, addReview } from '@/api/Api.js'

export default {
  name: 'ViewReviews',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  setup() {
    const reviews = ref([])
    const newReview = ref({
      author: '',
      content: '',
      score: null,
    })
    const isSubmitting = ref(false)
    const successMessage = ref('')
    const errorMessage = ref('')

    // Regex pour valider le nom de l'auteur
    const nameRegex = /^[a-zA-ZÀ-ÿ _-]+$/

    const validateReviewForm = () => {
      if (!newReview.value.author || !nameRegex.test(newReview.value.author)) {
        errorMessage.value =
          'Le nom est invalide. Utilisez uniquement des lettres, des espaces, des tirets ou des underscores.'
        return false
      }

      if (!newReview.value.content || newReview.value.content.length < 10) {
        errorMessage.value = "Le contenu de l'avis doit contenir au moins 10 caractères."
        return false
      }

      if (
        newReview.value.score === null ||
        newReview.value.score < 0 ||
        newReview.value.score > 5
      ) {
        errorMessage.value = 'La note doit être un nombre compris entre 0 et 5.'
        return false
      }

      errorMessage.value = '' // Réinitialise le message d'erreur si tout est valide
      return true
    }

    const fetchReviews = async () => {
      try {
        const response = await getReviews() // Appel à l'API
        reviews.value = response // L'API renvoie directement un tableau d'avis
      } catch (error) {
        console.error('Erreur de récupération des avis', error)
        errorMessage.value =
          'Impossible de récupérer les avis pour le moment. Veuillez réessayer plus tard.'
        reviews.value = [] // Définit une liste vide en cas d'échec
      }
    }

    const submitReview = async () => {
      if (!validateReviewForm()) {
        return // Arrête l'envoi si la validation échoue
      }

      try {
        isSubmitting.value = true
        successMessage.value = ''

        // Appel à l'API pour ajouter un nouvel avis
        await addReview(newReview.value)

        // Affichage d'un message de succès si tout s'est bien passé
        successMessage.value = 'Votre avis a été ajouté avec succès !'
        newReview.value = { author: '', content: '', score: null } // Réinitialisation du formulaire

        // Rafraîchit la liste des avis
        fetchReviews()
      } catch (error) {
        console.error("Erreur lors de l'ajout de l'avis", error)
        errorMessage.value =
          "Une erreur est survenue lors de l'ajout de votre avis. Veuillez réessayer."
      } finally {
        isSubmitting.value = false
      }
    }

    onMounted(fetchReviews)

    return {
      reviews,
      newReview,
      isSubmitting,
      successMessage,
      errorMessage,
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
    padding-top: 1rem;
  }
}
</style>
