// Show Form function
function showForm(clickedButton) {
    // Storing HTML element
    var studentRegistrationForm = document.getElementById(
        "studentRegistrationForm"
    );
    var staffRegistrationForm = document.getElementById(
        "staffRegistrationForm"
    );
    // If-statement to verify which button is clicked
    if (clickedButton === "studentFormButton") {
        // If-statement to verify the visibility of the forms
        if (
            studentRegistrationForm.style.display === "none" &&
            staffRegistrationForm.style.display === "none"
        ) {
            studentRegistrationForm.style.display = "block";
            staffRegistrationForm.style.display = "none";
        } else if (
            studentRegistrationForm.style.display === "none" &&
            staffRegistrationForm.style.display === "block"
        ) {
            studentRegistrationForm.style.display = "block";
            staffRegistrationForm.style.display = "none";
        } else {
            studentRegistrationForm.style.display = "block";
            staffRegistrationForm.style.display = "none";
        }
    } else if (clickedButton === "staffFormButton") {
        // If-statement to verify the visibility of the forms
        if (
            studentRegistrationForm.style.display === "none" &&
            staffRegistrationForm.style.display === "none"
        ) {
            studentRegistrationForm.style.display = "none";
            staffRegistrationForm.style.display = "block";
        } else if (
            studentRegistrationForm.style.display === "block" &&
            staffRegistrationForm.style.display === "none"
        ) {
            studentRegistrationForm.style.display = "none";
            staffRegistrationForm.style.display = "block";
        } else {
            studentRegistrationForm.style.display = "none";
            staffRegistrationForm.style.display = "block";
        }
    } else {
        studentRegistrationForm.style.display = "none";
        staffRegistrationForm.style.display = "none";
    }
}
// Request Server Attention function
function requestServerAttention(clickedButton) {
    // Removing the Type that is used for styling the Register button
    var type = clickedButton;
    document.cookie = "type=" + type;
}
