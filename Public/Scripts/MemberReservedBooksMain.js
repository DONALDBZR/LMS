// Cancel Reservation Cookie function
function cancelReservationCookie(clickedButton) {
    // Removing the ID that is used for styling the Cancel button
    var id = clickedButton.replace("cancelButton ", "");
    document.cookie = "id= " + id;
}
