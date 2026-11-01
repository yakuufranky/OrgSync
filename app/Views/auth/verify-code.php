<?php
/**
 * Organization Code Verification View (Officer & Member)
 */
$displayRole = ucfirst($role);
?>
<div class="form-header-nav">
    <a href="<?= BASE_URL ?>/register" class="btn-back" aria-label="Go back">
        <i data-lucide="chevron-left" class="icon-lucide"></i>
    </a>
    <div class="header-link">
        Already have an account? <a href="<?= BASE_URL ?>/login" class="link-bold">Log in</a>
    </div>
</div>

<!-- Step 1: Code Input State -->
<div id="verify-input-state">
    <div class="form-header">
        <h2 class="form-title">
            <?= htmlspecialchars($displayRole) ?> <span class="gradient-text">Registration</span>
        </h2>
        <p class="form-subtitle">Enter the Organization Code given by your President.</p>
    </div>

    <div id="verify-error-alert" class="alert alert-error <?= empty($error) ? 'hidden' : '' ?>">
        <i data-lucide="alert-circle" class="icon-lucide"></i>
        <span id="verify-error-msg"><?= htmlspecialchars($error ?? '') ?></span>
    </div>

    <form id="verify-code-form" class="auth-form" onsubmit="handleVerifyCode(event, '<?= htmlspecialchars($role) ?>')">
        <div class="form-group full-width">
            <label for="org_code_input" class="form-label">Organization Code:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="user" class="icon-lucide"></i>
                </span>
                <input 
                    type="text" 
                    id="org_code_input" 
                    name="org_code" 
                    class="form-control text-uppercase" 
                    placeholder="XXXXXXXXXX" 
                    required 
                    autocomplete="off"
                    value="QCU-IT-2026"
                >
            </div>
        </div>

        <div class="info-notice">
            <span class="info-notice-icon">
                <i data-lucide="alert-circle" class="icon-lucide" style="stroke: #6D28D9; width: 22px; height: 22px;"></i>
            </span>
            <div class="info-notice-text">
                Ask your organization's president for the code.
            </div>
        </div>

        <button type="submit" id="btn-verify-submit" class="btn btn-primary full-width">
            <span>Verify</span>
            <i data-lucide="arrow-right" class="icon-lucide"></i>
        </button>
    </form>
</div>

<!-- Step 2: Code Verified State (matches verify-organization.png) -->
<div id="verify-success-state" class="hidden text-center">
    <div class="success-icon-badge">
        <div class="icon-ring">
            <i data-lucide="check" class="icon-lucide" style="width: 38px; height: 38px; stroke: #6D28D9; stroke-width: 3;"></i>
        </div>
    </div>

    <div class="form-header text-center">
        <h2 class="form-title">
            Verify <span class="gradient-text">Organization</span>
        </h2>
        <p class="form-subtitle">Enter the Organization Code given by your President.</p>
    </div>

    <div class="org-found-card text-left">
        <span class="org-found-label">Organization Found:</span>
        <div class="org-found-box">
            <div class="org-found-icon">
                <i data-lucide="building-2" class="icon-lucide" style="stroke: #6D28D9; width: 24px; height: 24px;"></i>
            </div>
            <div class="org-found-details">
                <div id="found-org-name" class="org-name-text">ORGANIZATION NAME</div>
                <div id="found-org-type" class="org-type-text">ORGANIZATION TYPE</div>
            </div>
        </div>
    </div>

    <a id="btn-continue-registration" href="<?= BASE_URL ?>/register/<?= htmlspecialchars($role) ?>" class="btn btn-primary full-width">
        <span>Continue</span>
        <i data-lucide="arrow-right" class="icon-lucide"></i>
    </a>
</div>
