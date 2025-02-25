import { mount } from '@vue/test-utils'
import Avis from '../src/components/ReviewsCall.vue'

// Mock du module vue-recaptcha-v3
vi.mock('vue-recaptcha-v3', () => ({
  useReCaptcha: () => ({
    executeRecaptcha: vi.fn(() => Promise.resolve('mocked-token')), // Simule un token reCAPTCHA
  }),
}))

describe('Avis.vue', () => {
  it('valide les champs du formulaire avant soumission', async () => {
    const wrapper = mount(Avis, {
      props: { isDark: false },
    })

    // Soumettre le formulaire sans remplir les champs
    await wrapper.find('form').trigger('submit.prevent')
    await wrapper.vm.$nextTick()

    // Rechercher l'élément contenant l'erreur
    const errorMessageDiv = wrapper.find('.error') // Rechercher l'élément avec la classe "error"

    expect(errorMessageDiv.exists()).toBe(true) // Vérifier que l'élément existe
    expect(errorMessageDiv.text()).toBe(
      'Le nom est invalide. Utilisez uniquement des lettres, des espaces, des tirets ou des underscores.',
    ) // Vérifier son contenu

    // Remplir uniquement le champ "Nom"
    await wrapper.find('#author').setValue('Jean Dupont')
    await wrapper.find('form').trigger('submit.prevent')
    await wrapper.vm.$nextTick()
    expect(wrapper.text()).toContain("Le contenu de l'avis doit contenir au moins 10 caractères.")

    // Remplir tous les champs avec des données valides sauf la note
    await wrapper.find('#content').setValue('Un très bon portfolio.')
    await wrapper.find('#score').setValue(6) // Note invalide (supérieure à 5)
    await wrapper.find('form').trigger('submit.prevent')
    await wrapper.vm.$nextTick()
    expect(wrapper.text()).toContain('La note doit être un nombre compris entre 0 et 5.')
  })

  function generateRandomName() {
    const letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    const nameLength = Math.floor(Math.random() * 10) + 5 // Longueur entre 5 et 15
    let randomName = ''
    for (let i = 0; i < nameLength; i++) {
      randomName += letters.charAt(Math.floor(Math.random() * letters.length))
    }
    return randomName
  }

  it("ajoute un nouvel avis et l'affiche dans la liste", async () => {
    const wrapper = mount(Avis, {
      props: { isDark: false },
    })
    vi.mock('vue-recaptcha-v3', () => ({
      useReCaptcha: () => ({
        executeRecaptcha: vi.fn(() => Promise.resolve('mocked-token')), // Simule un token reCAPTCHA
      }),
    }))

    const randomName = generateRandomName() // Générer un nom aléatoire
    // Remplir le formulaire avec des données valides
    await wrapper.find('#author').setValue(randomName)
    await wrapper.find('#content').setValue('Un très bon portfolio.')
    await wrapper.find('#score').setValue(5)

    // Soumettre le formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre la mise à jour du DOM après la soumission
    await new Promise((resolve) => setTimeout(resolve, 2000))
    await wrapper.vm.$nextTick()

    // Vérifier que l'avis ajouté est affiché
    expect(wrapper.text()).toContain(randomName) // La liste est rafraîchie avec les ajoutées
  })
})
