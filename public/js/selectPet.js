document.addEventListener('DOMContentLoaded', function() {
    const display = document.querySelector('.pet-select-display');
    const options = document.querySelector('.pet-options');
    const petOptions = document.querySelectorAll('.pet-option');

    display.addEventListener('click', function(e) {
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
    });

    // Zmiana obsługi kliknięcia - tylko dla checkboxów
    document.querySelectorAll('.pet-option input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            e.stopPropagation(); // Zatrzymaj propagację wydarzenia
            const optionElement = this.closest('.pet-option');
            optionElement.classList.toggle('selected');
            
            const selectedPets = Array.from(document.querySelectorAll('.pet-option.selected'))
                .map(opt => opt.querySelector('span').textContent);
            
            display.textContent = selectedPets.length > 0 ? selectedPets.join(', ') : 'Select pets';
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.pet-select-wrapper')) {
            options.style.display = 'none';
        }
    });
});
