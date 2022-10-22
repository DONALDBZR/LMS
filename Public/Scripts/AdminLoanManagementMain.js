// Request Server Attention function
function requestServerAttention(clickedButton) {
    // Removing the ID that is used for styling the Remove Book button
    var id = clickedButton.replace("ID ", "");
    document.cookie = "id=" + id;
}
