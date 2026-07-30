document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('container');
    if (container) {
        requestAnimationFrame(() => container.classList.add('loaded'));
    }

    const select = document.getElementById('encaminhar');
    const btnEncaminhar = document.getElementById('btn-encaminhar');
    if (select && btnEncaminhar) {
        select.addEventListener('change', function() {
            btnEncaminhar.disabled = !select.value;
        });
    }
});