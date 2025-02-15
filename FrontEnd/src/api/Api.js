const BASE_URL = '/api' // Base URL pour vos routes API

// API pour ContactForm.vue

/**
 * Envoie un message de contact via l'API.
 * @param {Object} data - Données du formulaire de contact (name, email, message).
 * @returns {Promise<Object>} - Réponse de l'API.
 */
export const sendContactMessage = async (data) => {
  try {
    const response = await fetch(`${BASE_URL}/contact`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json', // Indique que les données envoyées sont au format JSON
      },
      body: JSON.stringify(data), // Convertit les données en JSON
    })

    if (!response.ok) {
      throw new Error("Erreur lors de l'envoi du message.")
    }

    return await response.json() // Retourne la réponse JSON
  } catch (error) {
    console.error(error)
    throw error
  }
}

// API pour UserReviews.vue

/**
 * Récupère la liste des avis via l'API.
 * @returns {Promise<Array>} - Liste des avis.
 */
export const getReviews = async () => {
  try {
    const response = await fetch(`${BASE_URL}/reviews`)

    // Gestion des erreurs spécifiques renvoyées par le backend Symfony
    if (!response.ok) {
      const errorData = await response.json() // Récupère les détails de l'erreur renvoyée par le backend

      if (response.status === 400) {
        throw new Error(errorData.error || 'Champs manquants ou invalides.')
      }

      throw new Error("Erreur inattendue lors de l'ajout de l'avis.")
    }

    return await response.json() // Retourne la réponse JSON après ajout
  } catch (error) {
    console.error(error)
    throw error
  }
}

/**
 * Ajoute un nouvel avis via l'API.
 * @param {Object} review - Données de l'avis (author, content, score).
 * @returns {Promise<Object>} - Réponse de l'API après ajout.
 */
export const addReview = async (review) => {
  try {
    const response = await fetch(`${BASE_URL}/reviews`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json', // Indique que les données envoyées sont au format JSON
      },
      body: JSON.stringify(review), // Convertit les données en JSON
    })

    // Gestion des erreurs spécifiques renvoyées par le backend Symfony
    if (!response.ok) {
      const errorData = await response.json() // Récupère les détails de l'erreur renvoyée par le backend

      if (response.status === 400) {
        throw new Error(errorData.error || 'Champs manquants ou invalides.')
      }

      if (response.status === 422) {
        throw new Error(errorData.error || 'Le score doit être un entier entre 1 et 5.')
      }

      throw new Error("Erreur inattendue lors de l'ajout de l'avis.")
    }

    return await response.json() // Retourne la réponse JSON après ajout
  } catch (error) {
    console.error(error)
    throw error
  }
}

// API pour Visitor.vue

/**
 * Récupère le nombre total de visiteurs via l'API.
 * @returns {Promise<Object>} - Nombre total de visiteurs ({ count }).
 */
export const getVisitorCount = async () => {
  try {
    const response = await fetch(`${BASE_URL}/visitor`)

    if (!response.ok) {
      throw new Error('Erreur lors de la récupération du compteur de visiteurs.')
    }

    return await response.json() // Retourne le compteur actuel
  } catch (error) {
    console.error(error)
    throw error
  }
}

/**
 * Incrémente le compteur de visiteurs via l'API.
 * @returns {Promise<Object>} - Nouveau compteur après incrémentation ({ count }).
 */
export const incrementVisitorCount = async () => {
  try {
    const response = await fetch(`${BASE_URL}/visitor/increment`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json', // Même si aucune donnée n'est envoyée, on peut garder cette convention
      },
    })

    if (!response.ok) {
      throw new Error("Erreur lors de l'incrémentation du compteur de visiteurs.")
    }

    return await response.json() // Retourne le nouveau compteur après incrémentation
  } catch (error) {
    console.error(error)
    throw error
  }
}
