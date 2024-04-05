document.getElementById("register-form").addEventListener("submit", function(event){
    event.preventDefault();
    var formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        if (data == 1) {
            document.getElementById("register-form").reset();
            console.log("form sent successfully");
        } else {
            console.log("error when sending the form");
        }
    })
    .catch(error => {
        console.error('error when sending the form:', error);
    });
});