function afficherForm(formId) {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('s-inscrire-form').classList.add('hidden');
    document.getElementById(formId).classList.remove('hidden');
}

