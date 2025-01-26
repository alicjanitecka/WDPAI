// alert('petManagement.js loaded');
document.addEventListener('DOMContentLoaded', function() {
    console.log('Pet management script loaded');
    console.log('Attempting to load petManagement.js');
    // Bezpośrednia obsługa kliknięć
    document.addEventListener('click', function(e) {
        console.log('DOM loaded in petManagement.js');
        console.log('Clicked element:', e.target);
        
        // Obsługa przycisku Add Pet
        if (e.target.classList.contains('add-pet-btn')) {
            console.log('Add pet button clicked');
            const petForm = document.querySelector('.pet-form');
            if (petForm) {
                petForm.style.display = 'block';
                e.target.style.display = 'none';
            }
        }
        
        // Obsługa przycisku Cancel
        if (e.target.classList.contains('cancel-btn')) {
            console.log('Cancel button clicked');
            const petForm = document.querySelector('.pet-form');
            const addButton = document.querySelector('.add-pet-btn');
            if (petForm && addButton) {
                petForm.style.display = 'none';
                addButton.style.display = 'block';
            }
        }
    });

    // Obsługa formularza
    if (petForm) {
        const form = petForm.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
                
                const formData = new FormData(this);
                
                // Debug log
                for (let [key, value] of formData.entries()) {
                    console.log(`Sending: ${key} = ${value}`);
                }
    
                fetch('/addPet', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log('Server response:', data);
                    alert('Pet added successfully!');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding pet: ' + error.message);
                });
            });
        }
    }
    
    console.log('Script initialization complete');
});
