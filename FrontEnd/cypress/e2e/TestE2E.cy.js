// https://on.cypress.io/api

describe('Test E2E', () => {
  it("Affichage de la page d'accueil", () => {
    cy.visit('http://localhost:5173/')
    cy.contains('h1', 'Mon portfolio')
  })
  it('Contrôle du défilement automatique du carrousel', () => {
    // Visite de la page
    cy.visit('http://localhost:5173/')

    // Vérifie que le carrousel est présent
    cy.get('.carousel-container').should('exist')

    // Vérifie que la première image est affichée
    cy.get('.carousel-image')
      .should('be.visible')
      .then(($img1) => {
        const firstImageSrc = $img1.attr('src') // Récupère la source de la première image

        // Attendre 3 secondes pour permettre au carrousel de défiler
        cy.wait(3000)

        // Vérifie que l'image a changé après le délai
        cy.get('.carousel-image')
          .should('be.visible')
          .and(($img2) => {
            const secondImageSrc = $img2.attr('src')
            expect(secondImageSrc).not.to.equal(firstImageSrc) // S'assure que l'image a changé
          })
      })
  })
  it('Contrôle du toogle', () => {
    cy.visit('http://localhost:5173/')

    // Vérifie que le titre est présent
    cy.get('.Title')
      .should('exist')
      .then(($title1) => {
        const colorLight = $title1.css('background-color')
        cy.get('.svg-inline--fa').click()
        cy.get('.Title')
          .should('exist')
          .then(($title2) => {
            // Récupère la nouvelle couleur du titre
            const colorDark = $title2.css('background-color')
            // S'assure que la couleur a changé
            expect(colorLight).not.to.equal(colorDark)
          })
      })
  })
  it('Affichage de la page projet', () => {
    cy.visit('http://localhost:5173/')
    cy.get('a[href="/projects"]').click()
    cy.url().should('eq', 'http://localhost:5173/projects')
    cy.contains('h1', 'Mes Projets')
  })
  it("Affichage d'un projet'", () => {
    cy.visit('http://localhost:5173/projects')
    const randomNumber = Math.floor(Math.random() * 5) + 1
    cy.get(`:nth-child(${randomNumber}) > .carousel-link > h2`).click()
    cy.url().should('eq', `http://localhost:5173/projects/${randomNumber}`)
    cy.get('img.Logo').should('exist') // Vérification de la présence d'une image vavec la classe logo propre à cette page.
  })
  // Les tests sur les messages d'erreurs ont déja été réalisé en unitaire front.
  it('Affichage de la page avis', () => {
    cy.visit('http://localhost:5173/')
    cy.get('a[href="/reviews"]').click()
    cy.url().should('eq', 'http://localhost:5173/reviews')
    cy.contains('h1', 'Avis des visiteurs')
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
  const randomName = generateRandomName()
  it("ajout et vérification d'un avis", () => {
    cy.visit('http://localhost:5173/reviews')
    cy.get('input[id="author"]').type(randomName)
    cy.get('textarea[id="content"]').type('Un très bon portfolio.')
    cy.get('input[id="score"]').type('5')
    cy.get('form > button').click()
    // Attendre l'apparition du message de confirmation avec un délai maximum de 8 secondes
    cy.contains('Votre avis a été ajouté avec succès !', { timeout: 8000 }).should('be.visible')

    // Vérifier que le nom aléatoire apparaît également dans la liste des avis
    cy.contains(randomName, { timeout: 8000 }).should('be.visible')
  })
  it('Affichage de la page contact', () => {
    cy.visit('http://localhost:5173/')
    cy.get('a[href="/contact"]').click()
    cy.url().should('eq', 'http://localhost:5173/contact')
    cy.contains('h1', 'Contactez-moi')
  })
  it('Vérification accès à Linkedin', () => {
    cy.visit('http://localhost:5173/contact')
    cy.get('a[href^="https://www.linkedin.com"]')
      .should('have.attr', 'href')
      .and('include', 'https://www.linkedin.com/in/aurélien-p-a1bb7b178')
  })
  it("envoi d'un formulaire de contact", () => {
    cy.visit('http://localhost:5173/contact')
    cy.get('input[id="name"]').type('Test')
    cy.get('input[id="email"]').type('testmail@test.fr')
    cy.get('textarea[id="message"]').type('Je souhaite prendre contact avec vous')
    cy.get('form > button').click()
    // Intercepter la requête POST vers /api/contact
    cy.intercept('POST', '/api/contact').as('sendContactForm')

    // Attendre que la requête POST soit terminée
    cy.wait('@sendContactForm', { timeout: 10000 }).its('response.statusCode').should('eq', 200)

    // Vérifier que le message de confirmation s'affiche
    cy.contains('Email envoyé avec succès').should('be.visible')
  })
})
