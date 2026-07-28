document.addEventListener('DOMContentLoaded', function() {
    const delays = [
        { id: 'container', delay: 80, class: 'loaded' },
        { id: 'header', delay: 250, class: 'loaded' },
        { id: 'logo', delay: 350, class: 'loaded' },
        { id: 'title', delay: 450, class: 'loaded' },
        { id: 'subtitle', delay: 550, class: 'loaded' },
        { id: 'ticket-card', delay: 350, class: 'loaded' },
        { id: 'info-categoria', delay: 500, class: 'loaded' },
        { id: 'info-status', delay: 580, class: 'loaded' },
        { id: 'info-solicitante', delay: 660, class: 'loaded' },
        { id: 'info-responsavel', delay: 740, class: 'loaded' },
        { id: 'info-data', delay: 820, class: 'loaded' },
        { id: 'desc-section', delay: 900, class: 'loaded' },
        { id: 'action-bar', delay: 1000, class: 'loaded' }
    ];

    delays.forEach(item => {
        setTimeout(() => {
            const el = document.getElementById(item.id);
            if (el) el.classList.add(item.class);
        }, item.delay);
    });
});