$(document).ready(function() {
    loadProfileDetails();
});

function loadProfileDetails() {
    $.ajax({
        type: 'GET',
        url: 'get_profile.php', 
        success: function(response) {
            $('#profileDetails').html(response);
        },
        error: function(error) {
            alert('Error fetching profile details. Please try again.');
            console.log(error);
        }
    });
}

function logout() {
    localStorage.clear();
    window.location.href = 'login.html';
}