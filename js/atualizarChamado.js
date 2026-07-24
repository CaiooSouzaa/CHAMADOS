function handleSubmit(e) {
            const btn = document.getElementById('btn');
            const txt = document.getElementById('btnText');
            const loader = document.getElementById('btnLoader');
            btn.disabled = true;
            txt.style.display = 'none';
            loader.style.display = 'inline-flex';
            return true;
        }

        const desc = document.getElementById('descricao_chamado');
        const counter = document.getElementById('charCounter');
        desc.addEventListener('input', function() {
            const len = this.value.length;
            counter.textContent = len + ' / 2000 caracteres';
            counter.className = 'char-counter';
            if (len > 1800) counter.className = 'char-counter warning';
            if (len > 1950) counter.className = 'char-counter danger';
        });

        const delays = [
            { id: 'container', delay: 100, class: 'loaded' },
            { id: 'header', delay: 350, class: 'loaded' },
            { id: 'logo', delay: 450, class: 'loaded' },
            { id: 'title', delay: 600, class: 'loaded' },
            { id: 'subtitle', delay: 720, class: 'loaded' },
            { id: 'form-card', delay: 500, class: 'loaded' },
            { id: 'ticketInfo', delay: 600, class: 'loaded' },
            { id: 'fg-titulo', delay: 750, class: 'loaded' },
            { id: 'fg-descricao', delay: 860, class: 'loaded' },
            { id: 'btn', delay: 970, class: 'loaded' },
            { id: 'footer', delay: 1100, class: 'loaded' }
        ];

        delays.forEach(item => {
            setTimeout(() => {
                const el = document.getElementById(item.id);
                if (el) el.classList.add(item.class);
            }, item.delay);
        });