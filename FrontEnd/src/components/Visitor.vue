<template>
  <span v-if="!isLoading">{{ visitorCount }}</span>
  <span v-else>..</span>
</template>

<script>
import { ref, onMounted } from 'vue'
import { getVisitorCount, incrementVisitorCount } from '@/api/Api.js' // Fonctions API pour gérer les visiteurs

export default {
  name: 'VisitorTracker',
  setup() {
    const visitorCount = ref(0) // Stocke le nombre total de visiteurs
    const isLoading = ref(true) // Indique si les données sont en cours de chargement
    const sessionKey = 'hasVisited' // Clé utilisée dans le sessionStorage pour suivre la visite

    /**
     * Récupère le nombre total de visiteurs depuis l'API.
     */
    const fetchVisitorCount = async () => {
      try {
        const response = await getVisitorCount()
        visitorCount.value = response.count // Met à jour la valeur locale avec le compteur reçu
      } catch (error) {
        console.error('Erreur lors de la récupération du compteur de visiteurs :', error)
      } finally {
        isLoading.value = false // Fin du chargement
      }
    }

    /**
     * Incrémente le compteur de visiteurs si l'utilisateur n'a pas encore visité la page.
     */
    const incrementVisitor = async () => {
      if (!sessionStorage.getItem(sessionKey)) {
        try {
          const response = await incrementVisitorCount()
          visitorCount.value = response.count // Met à jour la valeur locale après incrémentation
          sessionStorage.setItem(sessionKey, 'true') // Marque cette session comme ayant déjà visité
        } catch (error) {
          console.error("Erreur lors de l'incrémentation du compteur de visiteurs :", error)
        }
      }
    }

    /**
     * Initialisation : Récupère les données et incrémente si nécessaire.
     */
    onMounted(async () => {
      await fetchVisitorCount() // Récupère le compteur actuel avant tout autre action
      await incrementVisitor() // Incrémente si c'est la première visite
    })

    return {
      visitorCount,
      isLoading,
    }
  },
}
</script>

<style></style>
