(function () {
    'use strict';

    // ── Shared CSRF token ─────────────────────────────────────────────────
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    // ─────────────────────────────────────────────────────────────────────
    // Live clock (only present on the public scanner page)
    // ─────────────────────────────────────────────────────────────────────
    const clockEl = document.getElementById('scan-clock');
    if (clockEl) {
        const tickClock = () => {
            const now = new Date();
            clockEl.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        };
        tickClock();
        setInterval(tickClock, 1000);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Fullscreen toggle (public scanner page only)
    // ─────────────────────────────────────────────────────────────────────
    const btnFullscreen   = document.getElementById('btn-fullscreen');
    const fsIconExpand    = document.getElementById('fs-icon-expand');
    const fsIconCollapse  = document.getElementById('fs-icon-collapse');
    const fsLabel         = document.getElementById('fs-label');
    const fsSupported     = !!(document.fullscreenEnabled || document.webkitFullscreenEnabled);

    if (btnFullscreen) {
        if (!fsSupported) {
            // Graceful degradation: hide the button entirely when unsupported
            btnFullscreen.style.display = 'none';
        } else {
            const updateFsUI = (isFs) => {
                if (!fsIconExpand || !fsIconCollapse || !fsLabel) return;
                fsIconExpand.style.display  = isFs ? 'none' : '';
                fsIconCollapse.style.display = isFs ? '' : 'none';
                fsLabel.textContent          = isFs ? 'Keluar Fullscreen' : 'Fullscreen';
                btnFullscreen.dataset.fs     = isFs ? 'on' : 'off';
            };

            btnFullscreen.addEventListener('click', () => {
                const isCurrentlyFs = !!(document.fullscreenElement || document.webkitFullscreenElement);
                if (isCurrentlyFs) {
                    (document.exitFullscreen || document.webkitExitFullscreen)
                        .call(document)
                        .catch(() => {});
                } else {
                    const target = document.documentElement;
                    (target.requestFullscreen || target.webkitRequestFullscreen)
                        .call(target)
                        .catch(() => {});
                }
            });

            // Keep UI in sync when user presses Escape etc.
            const onFsChange = () => {
                const isFs = !!(document.fullscreenElement || document.webkitFullscreenElement);
                updateFsUI(isFs);
                // Re-focus scanner input after fullscreen toggle
                const anyInput = document.querySelector('[data-scanner-input]');
                if (anyInput) setTimeout(() => anyInput.focus({ preventScroll: true }), 120);
            };
            document.addEventListener('fullscreenchange', onFsChange);
            document.addEventListener('webkitfullscreenchange', onFsChange);
        }
    }

    // ─────────────────────────────────────────────────────────────────────
    // Scanner terminals — supports multiple [data-scanner-terminal] on page
    // ─────────────────────────────────────────────────────────────────────
    const terminals = document.querySelectorAll('[data-scanner-terminal]');
    if (!terminals.length) return;

    terminals.forEach((root) => {
        const form       = root.matches('form') ? root : root.querySelector('form');
        const input      = root.querySelector('[data-scanner-input]');
        const statusBox  = document.getElementById(root.dataset.statusId || 'scan-status');
        const resultBox  = document.getElementById(root.dataset.resultId || '');
        const modeInputs = root.querySelectorAll(`[name="${root.dataset.modeName || 'jenis_scan'}"]`);
        const endpoint   = root.dataset.endpoint;

        // For the public page the submit trigger is a plain button, not a form submit
        const btnManual = document.getElementById('btn-manual-submit');

        let locked = false;

        if (!input || !endpoint) return;

        // ── Status helper ────────────────────────────────────────────────
        const setStatus = (message, type = 'info') => {
            if (!statusBox) return;
            statusBox.textContent = message;
            statusBox.className   = `scan-status ${type}`;
        };

        // ── Mode helper ──────────────────────────────────────────────────
        const selectedMode = () => {
            const checked = Array.from(modeInputs).find((el) => el.checked);
            return checked?.value || 'otomatis';
        };

        // ── Focus management ─────────────────────────────────────────────
        const focusScanner = () => {
            if (document.activeElement !== input) {
                input.focus({ preventScroll: true });
            }
        };

        // ── Unlock after each attempt ────────────────────────────────────
        const unlock = (message = 'Siap scan kartu berikutnya.', type = 'info') => {
            locked        = false;
            input.value   = '';
            setStatus(message, type);
            focusScanner();
        };

        // ── Show result area (public page only) ──────────────────────────
        const showResult = (data) => {
            if (!resultBox) return;
            const nameEl  = document.getElementById('scan-result-name');
            const metaEl  = document.getElementById('scan-result-meta');
            const typeEl  = document.getElementById('scan-result-type');

            if (nameEl)  nameEl.textContent  = data.guru || '';
            if (typeEl) {
                const isMasuk = data.jenis_scan !== 'pulang';
                typeEl.textContent  = isMasuk ? 'Masuk' : 'Pulang';
                typeEl.className    = 'scan-result-type' + (isMasuk ? '' : ' pulang');
            }
            if (metaEl) {
                const parts = [];
                if (data.jam_masuk)  parts.push('Masuk: ' + data.jam_masuk);
                if (data.jam_pulang) parts.push('Pulang: ' + data.jam_pulang);
                metaEl.textContent = parts.join('  ·  ');
            }

            resultBox.classList.add('visible');

            // Collapse idle display while result is visible
            const idleDisplay = document.getElementById('scan-idle-display');
            if (idleDisplay) idleDisplay.style.display = 'none';

            // Auto-hide result after 4 seconds
            clearTimeout(root._resultTimer);
            root._resultTimer = setTimeout(() => {
                resultBox.classList.remove('visible');
                if (idleDisplay) idleDisplay.style.display = '';
            }, 4000);
        };

        // ── Core fetch scan logic ─────────────────────────────────────────
        const postScan = async () => {
            const qrCode = input.value.trim();
            if (!qrCode || locked) return;

            locked = true;
            setStatus(`Memproses presensi ${selectedMode()}...`, 'info');

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        qr_code:    qrCode,
                        jenis_scan: selectedMode(),
                    }),
                });

                // ── 419: session/CSRF expired ────────────────────────────
                if (response.status === 419) {
                    setStatus(
                        'Sesi scanner kedaluwarsa. Muat ulang halaman untuk melanjutkan.',
                        'error'
                    );
                    locked = false;
                    input.value = '';
                    focusScanner();
                    return;
                }

                // ── 429: rate-limited ────────────────────────────────────
                if (response.status === 429) {
                    setStatus('Terlalu banyak percobaan scan. Tunggu sebentar lalu coba lagi.', 'error');
                    setTimeout(() => unlock('Siap scan ulang kartu.', 'info'), 3000);
                    return;
                }

                let data;
                try {
                    data = await response.json();
                } catch (_) {
                    throw new Error('Respons server tidak valid.');
                }

                if (!response.ok) {
                    const firstError = data?.errors
                        ? Object.values(data.errors)[0]?.[0]
                        : null;
                    throw new Error(firstError || data?.message || 'QR tidak valid atau presensi tidak dapat diproses.');
                }

                // ── Success ──────────────────────────────────────────────
                setStatus(data.message || 'Scan berhasil.', 'success');
                showResult(data);
                setTimeout(() => unlock(), 1800);

            } catch (error) {
                // Generic network / parse errors — do not expose internals
                const safeMessage = error.message && error.message.length < 300
                    ? error.message
                    : 'Presensi gagal. Coba scan ulang.';
                setStatus(safeMessage, 'error');
                setTimeout(() => unlock('Siap scan ulang kartu.', 'info'), 2800);
            }
        };

        // ── Event bindings ────────────────────────────────────────────────
        if (form) {
            form.addEventListener('submit', (e) => { e.preventDefault(); postScan(); });
        }
        if (btnManual) {
            btnManual.addEventListener('click', postScan);
        }

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); postScan(); }
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
