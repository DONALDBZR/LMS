// Request Server Attention function
function requestServerAttention(clickedButton) {
    const id = clickedButton;
    document.cookie = "id=" + id;
}