<template>
  <section :class="['ContactPage', { dark: isDark }]">
    <Contact :is-dark="isDark" />
    <div :class="['MoreContact', { dark: isDark }]">
      <h2>Moyen de contact supplémentaire</h2>
      <div class="LogoContact">
        <a
          :href="'https://www.linkedin.com/in/aurélien-p-a1bb7b178'"
          target="_blank"
          rel="noopener noreferrer"
        >
          <img :src="isDark ? lightLinkedin : darkLinkedIn" alt="LinkedIn" />
        </a>
      </div>
    </div>
  </section>
</template>

<script>
// Importation du composant Reviews
import { ref } from 'vue'
import Contact from '@/components/Contact.vue'
import darkLinkedIn from '@/assets/pictures/contact/Linkedin.png'
import lightLinkedin from '@/assets/pictures/contact/LinkedinLight.png'
import darkMail from '@/assets/pictures/contact/Email.png'
import lightMail from '@/assets/pictures/contact/EmailLight.png'
import '../assets/styles/global.css'

export default {
  name: 'ViewContact',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    Contact, // Enregistrement du composant Reviews
  },
  setup() {
    const reviewsComponent = ref(null)

    return {
      reviewsComponent,
      darkLinkedIn,
      lightLinkedin,
      darkMail,
      lightMail,
    }
  },
}
</script>

<style scoped>
.ContactPage {
  display: flex;
  flex-direction: column;
  height: 100%; /* Prend toute la hauteur disponible */
  width: 100%; /* Prend toute la largeur disponible */
  background-color: var(--secondary-color-light); /* Bleu pastel */
}

.ContactPage.dark {
  background-color: var(--secondary-color-dark); /* Bleu marine */
  color: var(--text-color-dark);
}

.MoreContact {
  position: relative;
  display: flex;
  flex-direction: column;
  padding: 1% 2% 6% 2%;
  color: var(--text-color-light);
  background-color: var(--secondary-color-light); /* Bleu pastel */
  transform: skewY(5deg); /* Inclinaison vers le haut */
  transform-origin: top right;
}

.MoreContact.dark {
  background-color: var(--secondary-color-dark); /* Bleu marine */
  color: var(--text-color-dark);
}

/* Correction pour le contenu interne */
.MoreContact > * {
  transform: skewY(-5deg); /* Annule l'inclinaison pour le contenu */
}

.LogoContact {
  padding-top: 20px;
  display: block;
}

img {
  height: 60px;
}
</style>
