// Show Form function
function showForm(clickedButton) {
    // Storing HTML element
    var addForm = document.getElementById("addForm");
    var updateForm = document.getElementById("updateForm");
    // If-Statement to verify which button is clicked.
    if (clickedButton === "formAddButton") {
        // If-statement to verify if Add Form is being shown.
        if (addForm.style.display === "none") {
            addForm.style.display = "block";
        } else {
            addForm.style.display = "block";
        }
    } else if (clickedButton === "formUpdateButton") {
        // If-statement to verify if Update Form is being shown.
        if (updateForm.style.display === "none") {
            updateForm.style.display = "block";
        } else {
            updateForm.style.display = "block";
        }
    }
}
// Request Server Attention function
function requestServerAttention(clickedButton) {
    // Removing the ID that is used for styling the Remove Book button
    var isbn = clickedButton.replace("removeButton ", "");
    document.cookie = "isbn=" + isbn;
}
