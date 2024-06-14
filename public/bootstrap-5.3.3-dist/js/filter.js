// public/js/filter.js

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filterBtn').addEventListener('click', function() {
        var providerName = document.getElementById('providerName').value;
        var clientId = document.getElementById('clientId').value;

        // Make an AJAX request to the filter route
        axios.get('/filter', {
            params: {
                providerName: providerName,
                clientId: clientId
            }
        })
        .then(function(response) {
            // Handle the response (update UI, etc.)
            console.log(response.data); // For example, log the filtered clients
        })
        .catch(function(error) {
            console.error('Error occurred:', error);
        });
    });
});
