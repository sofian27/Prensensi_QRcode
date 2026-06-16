(function () {
    const terminals = document.querySelectorAll('[data-scanner-terminal]');

    if (! terminals.length) {
        return;
    }

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    terminals.forEach((root) => {
        const form = root.matches('form') ? root : root.querySelector('form');
        const input = root.querySelector('[data-scanner-input]');
        const statusBox = document.getElementById(root.dataset.statusId || 'scan-status');
        const modeInputs = root.querySelectorAll(`[name="${root.dataset.modeName || 'jenis_scan'}"]`);
        const endpoint = root.dataset.endpoint || form?.action;
        let locked = false;

        if (! form || ! input || ! endpoint) {
            return;
        }

        const setStatus = (message, type = 'info') => {
            if (! statusBox) return;

            statusBox.textContent = message;
            statusBox.className = `scan-status ${type}`;
        };

        const selectedMode = () => {
            const checked = Array.from(modeInputs).find((item) => item.checked);
            return checked?.value || 'masuk';
        };

        const focusScanner = () => {
            if (document.activeElement !== input) {
                input.focus({ preventScroll: true });
            }
        };

        const unlock = (message = 'Siap scan kartu berikutnya.', type = 'info') => {
            locked = false;
            input.value = '';
            setStatus(message, type);
            focusScanner();
        };

        const postScan = async () => {
            const qrCode = input.value.trim();

            if (! qrCode || locked) {
                return;
            }

            locked = true;
            setStatus(`Memproses presensi ${selectedMode()}...`, 'info');

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        qr_code: qrCode,
                        jenis_scan: selectedMode(),
                    }),
                });
                const data = await response.json();

                if (! response.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
                    throw new Error(firstError || data.message || 'QR tidak valid.');
                }

                setStatus(data.message || 'Scan berhasil.', 'success');
                setTimeout(() => unlock(), 1800);
            } catch (error) {
                setStatus(error.message || 'Presensi gagal disimpan.', 'error');
                setTimeout(() => unlock('Siap scan ulang kartu.', 'info'), 2400);
            }
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            postScan();
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                postScan();
            }
        });

        input.addEventListener('blur', () => {
            window.setTimeout(focusScanner, 60);
        });

        root.addEventListener('click', focusScanner);
        window.addEventListener('load', focusScanner);
        window.setInterval(focusScanner, 1200);
        setStatus('Scanner siap. Scan kartu QR guru.', 'info');
        focusScanner();
    });
})();
