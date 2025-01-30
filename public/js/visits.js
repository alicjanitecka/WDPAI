function confirmVisit(visitId) {
    if (confirm('Are you sure you want to confirm this visit?')) {
        fetch('/confirmVisit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ visit_id: visitId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); 
            } else {
                alert('Failed to confirm visit: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while confirming the visit');
        });
    }
}

function cancelVisit(visitId) {
    if (confirm('Are you sure you want to cancel this visit?')) {
        fetch('/cancelVisit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ visit_id: visitId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to cancel visit: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while canceling the visit');
        });
    }
}
