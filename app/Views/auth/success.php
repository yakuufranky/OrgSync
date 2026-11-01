<?php
/**
 * Registration Success View
 */
$isPresident = ($info['role'] ?? '') === 'President';
?>
<div class="registration-success-container text-center">
    <div class="success-icon-badge">
        <div class="icon-ring">
            <i data-lucide="check" class="icon-lucide" style="width: 40px; height: 40px; stroke: #6D28D9; stroke-width: 3;"></i>
        </div>
    </div>

    <div class="form-header text-center">
        <h2 class="form-title">Registration <span class="gradient-text">Successful</span></h2>
        <?php if (!$isPresident): ?>
            <p class="form-subtitle">Your Organization Code:</p>
        <?php endif; ?>
    </div>

    <?php if ($isPresident): ?>
        <div class="org-found-card text-left">
            <div class="org-found-box">
                <div class="org-found-icon">
                    <i data-lucide="building-2" class="icon-lucide" style="stroke: #6D28D9; width: 24px; height: 24px;"></i>
                </div>
                <div class="org-found-details">
                    <div class="org-name-text"><?= htmlspecialchars($info['org_name'] ?? 'ORGANIZATION') ?></div>
                    <div class="org-type-text"><?= htmlspecialchars($info['org_type'] ?? 'Academic') ?></div>
                </div>
            </div>
        </div>

        <div class="info-notice">
            <span class="info-notice-icon">
                <i data-lucide="alert-circle" class="icon-lucide" style="stroke: #6D28D9; width: 22px; height: 22px;"></i>
            </span>
            <div class="info-notice-text">
                Keep the code private and share it only with trusted members.
            </div>
        </div>

        <div class="code-display-group">
            <span class="code-label">Organization Code:</span>
            <div class="code-value-box">
                <span id="org-code-text" class="code-text"><?= htmlspecialchars($info['org_code'] ?? 'XXXXXXXXXX') ?></span>
                <button type="button" class="btn-copy-code" onclick="copyOrgCode()" title="Copy to clipboard">
                    <i data-lucide="copy" class="icon-lucide" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="code-display-block">
            <span id="org-code-text" class="code-large"><?= htmlspecialchars($info['org_code'] ?? 'XXXXXXXXXX') ?></span>
            <button type="button" class="btn-copy-code" onclick="copyOrgCode()" title="Copy to clipboard">
                <i data-lucide="copy" class="icon-lucide" style="width: 20px; height: 20px;"></i>
            </button>
        </div>

        <p class="role-instruction-text">
            Share this code to your organization members so they can join.
        </p>

        <div class="info-notice">
            <span class="info-notice-icon">
                <i data-lucide="alert-circle" class="icon-lucide" style="stroke: #6D28D9; width: 22px; height: 22px;"></i>
            </span>
            <div class="info-notice-text">
                Keep this code private and share it only with trusted members.
            </div>
        </div>
    <?php endif; ?>

    <a href="<?= BASE_URL ?>/login" class="btn btn-primary full-width">
        <span>Go to Home</span>
        <i data-lucide="arrow-right" class="icon-lucide"></i>
    </a>
</div>
