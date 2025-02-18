<template>
  <section :class="['ReviewPage', { dark: isDark }]">
    <Reviews :is-dark="isDark" />
  </section>
</template>

<script>
// Importation du composant Reviews
import { ref } from 'vue'
import Reviews from '@/components/Reviews.vue'

export default {
  name: 'ViewReviews',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    Reviews, // Enregistrement du composant Reviews
  },
  setup() {
    const reviewsComponent = ref(null)

    return {
      reviewsComponent,
    }
  },
}
</script>

<style scoped>
.ReviewPage {
  display: flex;
  flex-direction: column;
  height: 100%; /* Prend toute la hauteur disponible */
  width: 100%; /* Prend toute la largeur disponible */
  background-color: #b0e0e6; /* Bleu pastel */
}

.ReviewPage.dark {
  background-color: #001f3f; /* Bleu marine */
  color: white;
}
</style>
