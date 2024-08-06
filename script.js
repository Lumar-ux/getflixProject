document.addEventListener('DOMContentLoaded', function () {
    const closeAlertButton = document.getElementById('close-alert');
    const alertBox = document.getElementById('alert-box');
    const sadMessage = document.getElementById('sad-message');

    if (closeAlertButton) {
        closeAlertButton.addEventListener('click', function () {
            alertBox.style.display = 'none';
            sadMessage.style.display = 'block';
        });
    }
});
