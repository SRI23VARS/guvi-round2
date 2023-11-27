function login() {
    var formData = $('#loginForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'login_backend.php', 
        data: formData,
        success: function(response) {
            if (response === 'success') {
                alert('Login successful! Redirecting to the profile page.');
                window.location.href = 'profile.html'; 
            } else {
                alert('Login failed. Please check your credentials and try again.');
            }
        },
        error: function(error) {
            alert('Error during login. Please try again.');
            console.log(error);
        }
    });
}