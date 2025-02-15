import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/ViewHome.vue'
import Projects from '../views/ViewProjects.vue'
import ProjectDetails from '../views/ViewProjectDetails.vue'
import Reviews from '../views/ViewReviews.vue'
import Contact from '../views/ViewContact.vue'
import Error from '../views/ViewError.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/projects', name: 'Projects', component: Projects },
  { path: '/projects/:id', name: 'ProjectDetails', component: ProjectDetails, props: true },
  { path: '/reviews', name: 'Reviews', component: Reviews },
  { path: '/contact', name: 'Contact', component: Contact },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: Error },
]

// Permet la création de l'adresse de la route
const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
