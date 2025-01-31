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
            const petId = this.getAttribute('data-pet-id');
            if (confirm('Are you sure you want to delete this pet?')) {
                const form = document.getElementById('deletePetForm-' + petId);
                if (form) {
                    form.submit();
                } else {
                    console.error('Form not found for pet ID: ' + petId);
                }
            }
        });
    });
});
