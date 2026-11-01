<?php
/**
 * Login View
 */
?>
<div class="form-header-nav">
    <span></span>
    <div class="header-link">
        Already have an account? <a href="<?= BASE_URL ?>/register" class="link-bold">Sign up</a>
    </div>
</div>

<div class="form-header">
    <h2 class="form-title">Welcome <span class="gradient-text">Back</span></h2>
    <p class="form-subtitle">Enter your credentials to access your organization.</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <i data-lucide="alert-circle" class="icon-lucide"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <i data-lucide="check-circle-2" class="icon-lucide"></i>
        <span><?= htmlspecialchars($success) ?></span>
    </div>
<?php endif; ?>

<form action="<?= BASE_URL ?>/login" method="POST" class="auth-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="form-group full-width">
        <label for="email" class="form-label">Email:</label>
        <div class="input-wrapper">
            <span class="input-icon">
                <i data-lucide="mail" class="icon-lucide"></i>
            </span>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control" 
                placeholder="you@company.com" 
                required 
                autocomplete="email"
                value="president@qcu.edu.ph"
            >
        </div>
    </div>

    <div class="form-group full-width">
        <label for="password" class="form-label">Password:</label>
        <div class="input-wrapper">
            <span class="input-icon">
                <i data-lucide="lock" class="icon-lucide"></i>
            </span>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="Enter your password" 
                required 
                autocomplete="current-password"
                value="password123"
            >
            <button type="button" class="btn-toggle-password" aria-label="Toggle password visibility">
                <i data-lucide="eye" class="icon-lucide eye-open"></i>
                <i data-lucide="eye-off" class="icon-lucide eye-closed hidden"></i>
            </button>
        </div>
    </div>

    <div class="form-row-utility">
        <label class="checkbox-label">
            <input type="checkbox" name="remember" value="1">
            <span>Remember me</span>
        </label>
        <a href="#" class="link-subtle" onclick="alert('Demo notice: Contact system administrator to reset credentials.'); return false;">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn-primary full-width">
        <span>Log in</span>
        <i data-lucide="arrow-right" class="icon-lucide"></i>
    </button>
</form>
