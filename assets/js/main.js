// Liste des animaux
const animals = [
  { name: "Lion de l'Atlas", species: "Lion", country: "Maroc", image: "images/lion.jpg" },
  { name: "Crocodile", species: "Crocodylus", country: "Afrique", image: "images/crocodile.jpg" },
  { name: "Hippopotame", species: "Hippopotamus", country: "Afrique", image: "images/hippo.jpg" },
];

const animalsList = document.getElementById("animals-list");
if(animalsList){
  animals.forEach(animal => {
    const card = document.createElement("div");
    card.className = "bg-white rounded shadow p-4";
    card.innerHTML = `
      <img src="${animal.image}" alt="${animal.name}" class="w-full h-40 object-cover rounded mb-2">
      <h3 class="text-xl font-bold">${animal.name}</h3>
      <p>${animal.species} - ${animal.country}</p>
    `;
    animalsList.appendChild(card);
  });
}

// Liste des visites guidées
const visits = [
  { title: "Parcours Mammifères Asiatiques", date: "2025-12-20", duration: "2h", price: "50DH", language: "FR" },
  { title: "Découverte des Oiseaux Exotiques", date: "2025-12-21", duration: "1h30", price: "40DH", language: "FR" }
];

const visitsList = document.getElementById("visits-list");
if(visitsList){
  visits.forEach(visit => {
    const card = document.createElement("div");
    card.className = "bg-white rounded shadow p-4";
    card.innerHTML = `
      <h3 class="text-xl font-bold">${visit.title}</h3>
      <p>Date: ${visit.date}</p>
      <p>Durée: ${visit.duration}</p>
      <p>Prix: ${visit.price}</p>
      <p>Langue: ${visit.language}</p>
    `;
    visitsList.appendChild(card);
  });
}
