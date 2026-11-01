/**
 * OrgSync Client-Side Authentication Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggles();
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

/**
 * Initialize password visibility toggles
 */
function initPasswordToggles() {
    const toggleButtons = document.querySelectorAll('.btn-toggle-password');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const wrapper = btn.closest('.input-wrapper');
            if (!wrapper) return;

            const input = wrapper.querySelector('input');
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (!input) return;

            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');

            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle('hidden', isPassword);
                eyeClosed.classList.toggle('hidden', !isPassword);
            }
        });
    });
}

/**
 * Handle live AJAX organization code verification
 *
 * @param {Event} event
 * @param {string} role
 */
async function handleVerifyCode(event, role) {
    event.preventDefault();

    const input = document.getElementById('org_code_input');
    const submitBtn = document.getElementById('btn-verify-submit');
    const errorAlert = document.getElementById('verify-error-alert');
    const errorMsg = document.getElementById('verify-error-msg');

    if (!input) return;

    const code = input.value.trim().toUpperCase();
    if (!code) {
        showVerifyError('Please enter an organization code.');
        return;
    }

    const baseUrl = window.ORG_SYNC_BASE_URL || '';
    const originalBtnText = submitBtn ? submitBtn.innerHTML : '';

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Verifying...</span>';
    }

    try {
        const formData = new FormData();
        formData.append('org_code', code);

        const response = await fetch(`${baseUrl}/verify-code`, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            showVerifyError(data.message || 'Organization code not found.');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
            return;
        }

        // Populate verified state elements
        const nameEl = document.getElementById('found-org-name');
        const typeEl = document.getElementById('found-org-type');
        const continueBtn = document.getElementById('btn-continue-registration');

        if (nameEl) nameEl.textContent = data.organization.name;
        if (typeEl) typeEl.textContent = data.organization.type;
        if (continueBtn) {
            continueBtn.href = `${baseUrl}/register/${encodeURIComponent(role)}`;
        }

        // Transition UI to verified state
        const inputState = document.getElementById('verify-input-state');
        const successState = document.getElementById('verify-success-state');

        if (inputState) inputState.classList.add('hidden');
        if (successState) {
            successState.classList.remove('hidden');
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

    } catch (err) {
        showVerifyError('Network error while verifying organization. Please try again.');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    }
}

/**
 * Display verification error alert
 *
 * @param {string} message
 */
function showVerifyError(message) {
    const errorAlert = document.getElementById('verify-error-alert');
    const errorMsg = document.getElementById('verify-error-msg');

    if (errorAlert && errorMsg) {
        errorMsg.textContent = message;
        errorAlert.classList.remove('hidden');
    } else {
        alert(message);
    }
}

/**
 * Copy organization code to clipboard
 */
function copyOrgCode() {
    const codeEl = document.getElementById('org-code-text');
    if (!codeEl) return;

    const text = codeEl.textContent.trim();
    if (!text) return;

    navigator.clipboard.writeText(text).then(() => {
        const copyBtns = document.querySelectorAll('.btn-copy-code');
        copyBtns.forEach(btn => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#16A34A" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            `;
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 2000);
        });
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('Organization code copied to clipboard!');
    });
}
