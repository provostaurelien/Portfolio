<template>
  <div :class="['SendContact', { dark: isDark }]">
    <h1>Contactez-moi</h1>
    <form :class="{ dark: isDark }" @submit.prevent="submitContactForm">
      <div>
        <label for="name">Nom :</label>
        <input id="name" v-model="contactForm.name" type="text" placeholder="Votre nom" />
      </div>
      <div>
        <label for="email">Email :</label>
        <input id="email" v-model="contactForm.email" type="email" placeholder="Votre email" />
      </div>
      <div>
        <label for="message">Message :</label>
        <textarea id="message" v-model="contactForm.message" placeholder="Votre message"></textarea>
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
</template>

<script>
import { ref } from 'vue'
import { sendContactMessage } from '../api/Api.js' // Fonction API pour envoyer le message

export default {
  name: 'ContactForm',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  setup() {
    const contactForm = ref({
      name: '',
      email: '',
      message: '',
    })
    const isSubmitting = ref(false)
    const successMessage = ref('')
    const errorMessage = ref('')

    // Regex pour valider l'email et le nom
    const emailRegex =
      /^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/
    const nameRegex = /^[a-zA-ZÀ-ÿ _-]+$/

    const validateForm = () => {
      if (!contactForm.value.name || !nameRegex.test(contactForm.value.name)) {
        errorMessage.value =
          'Le nom est invalide. Utilisez uniquement des lettres, des espaces, des tirets ou des underscores.'
        return false
      }

      if (!contactForm.value.email || !emailRegex.test(contactForm.value.email)) {
        errorMessage.value = "L'email est invalide."
        return false
      }

      if (!contactForm.value.message) {
        errorMessage.value = 'Le message ne peut pas être vide.'
        return false
      }

      errorMessage.value = '' // Réinitialise le message d'erreur si tout est valide
      return true
    }

    const submitContactForm = async () => {
      if (!validateForm()) {
        return // Arrête l'envoi si la validation échoue
      }

      try {
        isSubmitting.value = true
        successMessage.value = ''

        // Appel à l'API pour envoyer les données
        const response = await sendContactMessage(contactForm.value)

        // Affichage d'un message de succès si tout s'est bien passé
        successMessage.value = response.message
        contactForm.value = { name: '', email: '', message: '' } // Réinitialisation du formulaire
      } catch (error) {
        console.error("Erreur lors de l'envoi du message", error)
        errorMessage.value = "Une erreur survint lors de l'envoi du message."
      } finally {
        isSubmitting.value = false
      }
    }

    return {
      contactForm,
      isSubmitting,
      successMessage,
      errorMessage,
      submitContactForm,
    }
  },
}
</script>

<style>
.error {
  color: red;
  margin-top: 10px;
}
.success {
  color: green;
  margin-top: 10px;
}
.SendContact {
  position: relative;
  padding: 1% 2% 6% 2%;
  color: #000000;
  background-color: #ffffff; /* Couleur par défaut */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.SendContact.dark {
  background-color: #2c2c2c; /* Gris anthracite */
  color: #ffffff;
}

.SendContact > * {
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

@media (max-width: 768px) {
  h1 {
    padding-top: 2rem;
  }
}
</style>
