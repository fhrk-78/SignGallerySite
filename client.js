function copyURL() {
    const myURL = document.getElementById('myURL');
    navigator.clipboard.writeText(myURL.value);
    const urlCopyButton = document.getElementById('urlCopyButton');
    urlCopyButton.innerText = "コピー完了！";
}
