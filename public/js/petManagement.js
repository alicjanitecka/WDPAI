document.addEventListener('DOMContentLoaded', function() {
    const addPetBtn = document.getElementById('add-pet-btn');
    const addPetForm = document.getElementById('add-pet-form');
    const cancelAddPetBtn = document.getElementById('cancel-add-pet');

    if (addPetBtn && addPetForm) {
        addPetBtn.addEventListener('click', function() {
            addPetForm.style.display = 'block';
            addPetBtn.style.display = 'none';
        });

        cancelAddPetBtn.addEventListener('click', function() {
            addPetForm.style.display = 'none';
            addPetBtn.style.display = 'block';
        });
    }

    document.querySelectorAll('.edit-pet-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const petCard = this.closest('.pet-card');
            const petId = petCard.dataset.petId;
            
            const editForm = document.querySelector(`.edit-pet-form[data-pet-id="${petId}"]`);
    
            if (editForm) {
                editForm.style.display = 'block'; 
                petCard.style.display = 'none'; 
            }
        });
    });

    document.querySelectorAll('.delete-pet-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this pet?')) {
                const petCard = this.closest('.pet-card');
                const petId = petCard.dataset.petId;
                // Tutaj możesz dodać kod do wysłania żądania usunięcia do serwera
                petCard.remove(); // Usuwa kartę zwierzęcia z DOM
            }
        });
    });
});
