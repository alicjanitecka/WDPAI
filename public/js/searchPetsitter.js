document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');
    const servicesContainer = document.querySelector('.services-container');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        servicesContainer.style.display = 'none';
        
        const data = {
            start_date: document.querySelector('input[name="start_date"]').value,
            end_date: document.querySelector('input[name="end_date"]').value,
            care_type: document.querySelector('select[name="care_type"]').value,
            pets: Array.from(document.querySelectorAll('input[name="pets[]"]:checked')).map(input => input.value)
        };

        fetch('/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.length === 0) {
                searchResults.innerHTML = '<p>No petsitters found</p>';
            } else {
                let html = '';
                data.forEach(function(petsitter) {
                    console.log('Petsitter data:', petsitter);
                    html += `
                        <div class="petsitter-card">
                            <div class="petsitter-info">
                                <div class="petsitter-details">
                                    <h3>${petsitter.first_name} ${petsitter.last_name}</h3>
                                    <p>${petsitter.city || 'Location not specified'}</p>
                                    <p>Price: $${petsitter.hourly_rate || '0'}/hour</p>
                                </div>
                            </div>
                            <button class="book-button" onclick="bookPetsitter(${petsitter.id})">Book</button>
                        </div>
                    `;
                });
                searchResults.innerHTML = html;
            }
            searchResults.style.display = 'block';
        })
        .catch(function(error) {
            searchResults.innerHTML = '<p>An error occurred</p>';
            servicesContainer.style.display = 'flex';
        });
    });

      
        window.bookPetsitter = function(petsitterId) {
            const requestData = {
                petsitter_id: parseInt(petsitterId),
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
                care_type: document.querySelector('select[name="care_type"]').value,
                pets: Array.from(document.querySelectorAll('input[name="pets[]"]:checked')).map(input => parseInt(input.value))
            };
        
            if (confirm('Are you sure you want to book this petsitter?')) {
                fetch('/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        alert('Booking successful!');
                    } else {
                        alert('Booking failed: ' + data.message);
                    }
                })
                .catch(function(error) {
                    alert('An error occurred while booking');
                });
            }
        };
        
        
        
        
        
    
    });
        