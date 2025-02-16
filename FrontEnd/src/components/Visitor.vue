<script>
import { ref, onMounted } from 'vue'
import { getVisitorCount, incrementVisitorCount } from '@/api/Api.js' // Fonctions API pour gérer les visiteurs

export default {
  name: 'VisitorTracker',
  setup() {
    const visitorCount = ref(0) // Stocke le nombre total de visiteurs
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
    onMounted(() => {
      fetchVisitorCount() // Récupère le compteur actuel
      incrementVisitor() // Incrémente si c'est la première visite
    })

    return {
      visitorCount,
    }
  },
}
</script>

<template>
  {{ visitorCount }}
</template>

<style></style>
