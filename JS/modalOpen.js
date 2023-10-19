// Check if the modal should stay open
document.addEventListener('DOMContentLoaded', function () {
    var modalShouldStayOpen = sessionStorage.getItem('modalShouldStayOpen');
    if (modalShouldStayOpen === 'true') {
        $('#historyModal').modal('show');
    }
});

document.getElementById('History').addEventListener('click', function () {
    // Set the flag to keep the modal open in session storage
    sessionStorage.setItem('modalShouldStayOpen', 'true');
});


document.getElementById('CloseModal').addEventListener('click', function () {
    // Remove the flag from local storage when the specific button is clicked
    sessionStorage.removeItem('modalShouldStayOpen');
});

document.getElementById('CloseModalPayment').addEventListener('click', function () {
    // Remove the flag from local storage when the specific button is clicked
    sessionStorage.removeItem('modalShouldStayOpen');
});

document.getElementById('CloseModalCancel').addEventListener('click', function () {
    // Remove the flag from local storage when the specific button is clicked
    sessionStorage.removeItem('modalShouldStayOpen');
});
