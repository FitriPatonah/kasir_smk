<dialog class="logout-confirm-dialog" id="logout-confirm-dialog" tabindex="-1" aria-labelledby="logout-confirm-title" aria-describedby="logout-confirm-message" data-auto-open="{{ !empty($logoutConfirmationAutoOpen) ? 'true' : 'false' }}" data-initial-url="{{ $logoutConfirmationInitialUrl ?? '' }}" data-cancel-url="{{ $logoutConfirmationCancelUrl ?? '' }}">
    <div class="logout-confirm-content">
        <h2 id="logout-confirm-title">Konfirmasi Keluar</h2>
        <p id="logout-confirm-message">Apakah Anda yakin ingin keluar dari akun ini?</p>
        <div class="logout-confirm-actions">
            <button class="logout-confirm-cancel" id="logout-confirm-cancel" type="button">Tidak</button>
            <button class="logout-confirm-submit" id="logout-confirm-submit" type="button">Ya, Keluar</button>
        </div>
    </div>
</dialog>

<style>
    .logout-confirm-dialog { position: fixed; inset: 0; margin: auto; width: min(400px, calc(100vw - 32px)); max-height: calc(100vh - 32px); padding: 0; border: 0; border-radius: 10px; color: #222; box-shadow: 0 18px 48px rgba(15, 31, 52, .24); }
    .logout-confirm-dialog:focus { outline: none; }
    .logout-confirm-dialog::backdrop { background: rgba(18, 29, 43, .48); }
    .logout-confirm-content { padding: 24px; }
    .logout-confirm-content h2 { margin: 0; font-size: 19px; }
    .logout-confirm-content p { margin: 10px 0 24px; color: #657286; font-size: 14px; }
    .logout-confirm-actions { display: flex; justify-content: flex-end; gap: 8px; }
    .logout-confirm-actions button { min-height: 38px; padding: 0 14px; border: 1px solid #d8e0eb; border-radius: 6px; background: #fff; color: #344054; font: inherit; font-size: 14px; font-weight: 600; cursor: pointer; transition: background-color .15s ease, border-color .15s ease, color .15s ease; }
    .logout-confirm-actions button:hover { border-color: #1e3a5f; background: #1e3a5f; color: #fff; }
    .logout-confirm-actions button:focus-visible { outline: 2px solid #1e3a5f; outline-offset: 2px; }
</style>

<script>
(() => {
    const dialog = document.getElementById('logout-confirm-dialog');
    const cancelButton = document.getElementById('logout-confirm-cancel');
    const submitButton = document.getElementById('logout-confirm-submit');

    if (!dialog || !cancelButton || !submitButton) return;

    const openDialog = () => {
        dialog.showModal();
        dialog.focus({ preventScroll: true });
    };

    let logoutUrl = dialog.dataset.initialUrl || '';

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (!link) return;

        const url = new URL(link.href, window.location.href);
        if (!url.pathname.includes('/auth/logout')) return;

        event.preventDefault();
        logoutUrl = url.href;
        openDialog();
    });

    cancelButton.addEventListener('click', () => {
        if (dialog.dataset.cancelUrl) {
            window.location.assign(dialog.dataset.cancelUrl);
            return;
        }

        dialog.close();
    });
    submitButton.addEventListener('click', () => {
        if (logoutUrl) window.location.assign(logoutUrl);
    });
    dialog.addEventListener('close', () => { logoutUrl = ''; });

    if (dialog.dataset.autoOpen === 'true') openDialog();
})();
</script>