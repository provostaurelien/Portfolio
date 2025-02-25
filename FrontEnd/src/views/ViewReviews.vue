<template>
  <section :class="['ReviewPage', { dark: isDark }]">
    <AllReviews :is-dark="isDark" />
  </section>
</template>

<script>
// Importation du composant Reviews
import { ref } from 'vue'
import AllReviews from '@/components/ReviewsCall.vue'
import '../assets/styles/global.css'

export default {
  name: 'ViewReviews',
  props: {
    isDark: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    AllReviews, // Enregistrement du composant Reviews
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
  height: 100%;
  width: 100%;
  background-color: var(--secondary-color-light);
}

.ReviewPage.dark {
  background-color: var(--secondary-color-dark);
  color: var(--text-color-dark);
}

@media (max-width: 768px) {
  h1 {
    padding-top: 2rem;
  }
}
</style>
