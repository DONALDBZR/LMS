$(document).ready(function () {
    setInterval(clock, 1000);
});
// Clock function
function clock() {
    $.ajax({
        url: "http://stormysystem.ddns.net/LibraryManagementSystem/Clock.php",
        success: function (data) {
            $("#clock").html(data);
        },
    });
}
// Show Form function
function showForm(clickedButton) {
    // Storing HTML element
    const sendForm = document.getElementById("sendForm");
    // If-Statement to verify which button is clicked.
    if (clickedButton === "formSendButton") {
        // If-statement to verify if Send Form is being shown.
        if (sendForm.style.display === "none") {
            sendForm.style.display = "block";
        } else {
            sendForm.style.display = "block";
        }
    }
}
