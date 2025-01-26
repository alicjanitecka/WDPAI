document.addEventListener('DOMContentLoaded', function() {
    const navButtons = document.querySelectorAll('.nav-btn');
    const contentSections = document.querySelectorAll('.content-section');

    // Obsługa przycisków nawigacji
    navButtons.forEach(button => {
        button.addEventListener('click', function() {
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
                if (sectionClass === 'pets-info' && typeof initializePetButtons === 'function') {
                    initializePetButtons();
                }
            }
        });
    });
});
