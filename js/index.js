 // Toggle visibilidade da senha
        function togglePassword() {
            const pass = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pass.type === 'password') {
                pass.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                pass.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // Loading no submit
        function handleSubmit(e) {
            const btn = document.getElementById('btn');
            const txt = document.getElementById('btnText');
            const loader = document.getElementById('btnLoader');
            
            btn.disabled = true;
            txt.style.display = 'none';
            loader.style.display = 'inline-flex';
            
            // O form continua normalmente — o PHP processa
            return true;
        }

        // Animações de entrada sequenciais
        const delays = [
            { id: 'card', delay: 100, class: 'loaded' },
            { id: 'header', delay: 350, class: 'loaded' },
            { id: 'logo', delay: 450, class: 'loaded' },
            { id: 'title', delay: 600, class: 'loaded' },
            { id: 'subtitle', delay: 720, class: 'loaded' },
            { id: 'fg-email', delay: 850, class: 'loaded' },
            { id: 'fg-pass', delay: 960, class: 'loaded' },
            { id: 'fg-remember', delay: 1070, class: 'loaded' },
            { id: 'btn', delay: 1200, class: 'loaded' },
            { id: 'footer', delay: 1350, class: 'loaded' }
        ];

        delays.forEach(item => {
            setTimeout(() => {
                const el = document.getElementById(item.id);
                if (el) el.classList.add(item.class);
            }, item.delay);
        });