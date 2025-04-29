function generateRandomString() {
    var randomString = Math.random().toString(36).substring(2, 32);
    document.getElementById('name').value = randomString;
};
window.generateRandomString = generateRandomString;
