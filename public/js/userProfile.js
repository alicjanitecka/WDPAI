document.addEventListener('DOMContentLoaded', function() {
    const navButtons = document.querySelectorAll('.nav-btn');
    const contentSections = document.querySelectorAll('.content-section');

    function showSection(tabName) {
        contentSections.forEach(section => {
            section.classList.toggle('active', section.dataset.tab === tabName);
        });
    }

    navButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.textContent.trim().toLowerCase().replace(' ', '-');
            navButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            showSection(tabName);
        });
    });

    const defaultTab = 'personal-information';
    showSection(defaultTab);
    navButtons.forEach(btn => {
        if (btn.textContent.trim().toLowerCase().replace(' ', '-') === defaultTab) {
            btn.classList.add('active');
        }
    });

    const editBtn = document.querySelector('.edit-btn');
    const saveBtn = document.querySelector('.save-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const inputs = document.querySelectorAll('.form-left input, .form-right textarea');

    console.log('Edit button:', editBtn);
    console.log('Save button:', saveBtn);
    console.log('Cancel button:', cancelBtn);
    console.log('Inputs:', inputs);

    if (editBtn && saveBtn && cancelBtn) {
        editBtn.addEventListener('click', function() {
            console.log('Edit button clicked');
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                console.log('Removed readonly from:', input);
            });
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'inline-block';
        });

        cancelBtn.addEventListener('click', function() {
            console.log('Cancel button clicked');
            inputs.forEach(input => {
                input.setAttribute('readonly', 'readonly');
                console.log('Added readonly to:', input);
            });
            editBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        });
    } else {
        console.log('One or more buttons not found');
    }
});