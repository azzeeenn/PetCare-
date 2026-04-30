// JavaScript functions for calling and texting the vet
function callVet(phoneNumber) {
    window.location.href = 'tel:' + phoneNumber;
}

function textVet(phoneNumber) {
    window.location.href = 'sms:' + phoneNumber;
}
