<template>
  <div v-if="project">
    <h1>{{ project.name }}</h1>
    <p>{{ project.description }}</p>
  </div>
  <div v-else>
    <p>Projet introuvable. Redirection...</p>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data() {
    return {
      project: null, // Projet correspondant à l'ID
    }
  },
  created() {
    // Exemple de liste de projets (à remplacer par une API ou une source réelle)
    const projects = [
      { id: '1', name: 'Projet A', description: 'Description du projet A' },
      { id: '2', name: 'Projet B', description: 'Description du projet B' },
    ]

    // Recherche du projet correspondant à l'ID
    this.project = projects.find((project) => project.id === this.id)

    // Redirection si le projet n'existe pas
    if (!this.project) {
      this.$router.push({ name: 'NotFound' })
    }
  },
}
</script>
