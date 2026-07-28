document.addEventListener('DOMContentLoaded', function() {
    const delays = [
        { id: 'container', delay: 100, class: 'loaded' },
        { id: 'header', delay: 350, class: 'loaded' },
        { id: 'logo', delay: 450, class: 'loaded' },
        { id: 'title', delay: 600, class: 'loaded' },
        { id: 'subtitle', delay: 720, class: 'loaded' },
        { id: 'ticket-card', delay: 500, class: 'loaded' },
        { id: 'info-categoria', delay: 750, class: 'loaded' },
        { id: 'info-status', delay: 860, class: 'loaded' },
        { id: 'info-solicitante', delay: 970, class: 'loaded' },
        { id: 'info-responsavel', delay: 1080, class: 'loaded' },
        { id: 'info-data', delay: 1190, class: 'loaded' },
        { id: 'desc-section', delay: 1300, class: 'loaded' },
        { id: 'action-bar', delay: 1450, class: 'loaded' }
    ];

    delays.forEach(item => {
        setTimeout(() => {
            const el = document.getElementById(item.id);
            if (el) el.classList.add(item.class);
        }, item.delay);
    });
});