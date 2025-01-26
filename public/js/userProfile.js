alert('userProfile.js loaded');
document.addEventListener('DOMContentLoaded', function() {
    console.log('User profile script loaded');
    const navButtons = document.querySelectorAll('.nav-btn');
    const contentSections = document.querySelectorAll('.content-section');

    // Obsługa przycisków nawigacji
    navButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Navigation button clicked:', this.textContent);
            navButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            contentSections.forEach(section => section.classList.remove('active'));

            let sectionClass;
            switch(this.textContent.trim()) {
                case 'personal information':
                    sectionClass = 'personal-info';
                    break;
                case 'your pets':
                    sectionClass = 'pets-info';
                    break;
                case 'settings':
                    sectionClass = 'settings-info';
                    break;
            }
            
            const targetSection = document.querySelector(`.${sectionClass}`);
            if (targetSection) {
                targetSection.classList.add('active');
                if (sectionClass === 'pets-info') {
                    // Wywołaj inicjalizację przycisków z petManagement.js
                    if (typeof initializePetButtons === 'function') {
                        initializePetButtons();
                    }
                }
            }
        });
    });

    // Obsługa zapisywania profilu użytkownika
    const saveProfileBtn = document.querySelector('.saving button');
    if (saveProfileBtn) {
        saveProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Save profile clicked');
            
            const formData = new FormData();
            const inputs = document.querySelectorAll('.form-left input');
            
            inputs.forEach(input => {
                formData.append(input.name, input.value);
                console.log('Adding to form:', input.name, input.value);
            });

            fetch('/updateUserProfile', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text();
            })
            .then(data => {
                console.log('Response data:', data);
                alert('Profile updated successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating profile');
            });
        });
    }

});
