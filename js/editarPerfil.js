// Toggle visibilidade da senha
        function togglePassword(inputId, iconId) {
            const pass = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (pass.type === 'password') {
                pass.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                pass.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // Força da senha
        document.getElementById('senha_nova').addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('strength-bar');
            const txt = document.getElementById('strength-text');

            let strength = 0;
            if (val.length >= 6) strength++;
            if (val.length >= 10) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const widths = ['0%', '20%', '40%', '60%', '80%', '100%'];
            const texts = ['Digite uma senha', 'Muito fraca', 'Fraca', 'Média', 'Forte', 'Muito forte'];
            const colors = ['#e2e8f0', '#ef4444', '#f59e0b', '#f59e0b', '#22c55e', '#22c55e'];

            const idx = Math.min(strength, 5);
            bar.style.width = widths[idx];
            bar.style.background = colors[idx];
            txt.textContent = texts[idx];
            txt.style.color = colors[idx];
        });

        // Loading no submit
        function handleSubmit(e) {
            const btn = document.getElementById('btn');
            const txt = document.getElementById('btnText');
            const loader = document.getElementById('btnLoader');

            btn.disabled = true;
            txt.style.display = 'none';
            loader.style.display = 'inline-flex';
            return true;
        }

        // Animações de entrada sequenciais
        const delays = [
            { id: 'container', delay: 100, class: 'loaded' },
            { id: 'header', delay: 350, class: 'loaded' },
            { id: 'logo', delay: 450, class: 'loaded' },
            { id: 'title', delay: 600, class: 'loaded' },
            { id: 'subtitle', delay: 720, class: 'loaded' },
            { id: 'form-card', delay: 500, class: 'loaded' },
            { id: 'fg-nome', delay: 750, class: 'loaded' },
            { id: 'fg-email', delay: 860, class: 'loaded' },
            { id: 'divider', delay: 920, class: 'loaded' },
            { id: 'fg-senha-atual', delay: 970, class: 'loaded' },
            { id: 'fg-senha-nova', delay: 1080, class: 'loaded' },
            { id: 'fg-senha-confirmar', delay: 1190, class: 'loaded' },
            { id: 'btn', delay: 1300, class: 'loaded' },
            { id: 'footer', delay: 1450, class: 'loaded' }
        ];

        delays.forEach(item => {
            setTimeout(() => {
                const el = document.getElementById(item.id);
                if (el) el.classList.add(item.class);
            }, item.delay);
        });

      