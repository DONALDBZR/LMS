// Reserve Book Cookie function
function reserveBookCookie(clickedButton) {
    // Removing the ID that is used for styling the Reserve Book button
    var isbn = clickedButton.replace("reserveButton ", "");
    document.cookie = "isbn= " + isbn;
}
// Borrow Book Cookie function
function borrowBookCookie(clickedButton) {
    // Removing the ID that is used for styling the Borrow Book button
    var isbn = clickedButton.replace("borrowButton ", "");
    document.cookie = "isbn= " + isbn;
}
