function validateForm() {
    const email = document.querySelector('input[type="email"]');
    if (email && !email.value.includes('@')) {
        alert("Please enter a valid email address.");
        return false;
    }
    const inputs = document.querySelectorAll('input[required]');
    for (const input of inputs) {
        if (!input.value.trim()) {
            alert("Please fill out all required fields.");
            return false;
        }
    }
    return true;
}