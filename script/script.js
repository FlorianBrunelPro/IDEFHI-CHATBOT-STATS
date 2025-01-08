document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var form = event.target;
    var formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            document.getElementById('username-input').style.borderColor = 'red';
            document.getElementById('pwd-input').style.borderColor = 'red';
        } else if (data.status === 'success') {
            window.location.href = "../home.php";
        }
    });

});
