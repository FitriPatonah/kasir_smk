@if(session('welcome_toast'))
<div id="toast-welcome" class="toast-welcome-box">
    <div class="toast-icon">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
    </div>
    <div class="toast-content">
        <div class="toast-title">Login Berhasil</div>
        <div class="toast-message">{{ session('welcome_toast') }}</div>
    </div>
    <button class="toast-close" onclick="closeToastWelcome()">&times;</button>
</div>

<style>
.toast-welcome-box {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
    color: #1e293b;
    padding: 14px 18px;
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #2563eb;
    font-family: inherit;
    min-width: 280px;
    max-width: 380px;
    animation: toastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.toast-welcome-box.hide {
    animation: toastFadeOut 0.4s ease forwards;
}

.toast-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
}

.toast-message {
    font-size: 13px;
    color: #475569;
    font-weight: 500;
}

.toast-close {
    background: transparent;
    border: none;
    font-size: 20px;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
}

.toast-close:hover {
    color: #475569;
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes toastFadeOut {
    from {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateY(-15px) scale(0.95);
    }
}
</style>

<script>
    function closeToastWelcome() {
        const toast = document.getElementById('toast-welcome');
        if (toast) {
            toast.classList.add('hide');
            setTimeout(function() {
                if (toast && toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 400);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(closeToastWelcome, 3500);
        });
    } else {
        setTimeout(closeToastWelcome, 3500);
    }
</script>
@endif
