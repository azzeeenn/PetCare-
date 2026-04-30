function checkCompletion() {
    const checkboxes = document.querySelectorAll('.checkbox');
    const reward = document.getElementById('reward');

    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

    if (allChecked) {
        reward.classList.add('show');
    } else {
        reward.classList.remove('show');
    }
}
