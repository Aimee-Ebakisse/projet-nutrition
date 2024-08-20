document.getElementById('mealForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('ajouter_repas.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('message').innerText = data.message;
        if (data.success) {
            this.reset();
            loadMeals(); // Recharge la liste des repas
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});

// Fonction pour charger les repas
function loadMeals() {
    fetch('lister_repas.php')
        .then(response => response.json())
        .then(data => {
            const mealTableBody = document.getElementById('mealTable').getElementsByTagName('tbody')[0];
            mealTableBody.innerHTML = ''; // Vide la table avant d'ajouter les nouveaux repas

            data.forEach(meal => {
                const row = mealTableBody.insertRow();
                row.insertCell(0).innerText = meal.nom;
                row.insertCell(1).innerText = meal.description;
                row.insertCell(2).innerText = meal.calories;
                row.insertCell(3).innerText = meal.type;
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}

// Charge les repas au chargement de la page
document.addEventListener('DOMContentLoaded', loadMeals);
