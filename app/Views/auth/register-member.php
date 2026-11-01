<?php
/**
 * Member Registration Form View
 */
?>
<div class="form-header-nav">
    <a href="<?= BASE_URL ?>/register/verify?role=member" class="btn-back" aria-label="Go back">
        <i data-lucide="chevron-left" class="icon-lucide"></i>
    </a>
    <div class="header-link">
        Already have an account? <a href="<?= BASE_URL ?>/login" class="link-bold">Log in</a>
    </div>
</div>

<div class="form-header">
    <h2 class="form-title">Member <span class="gradient-text">Registration</span></h2>
    <p class="form-subtitle">Fill your details to create your organization and account.</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <i data-lucide="alert-circle" class="icon-lucide"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="org-badge-attached">
    <span class="badge-label">Joining:</span>
    <strong><?= htmlspecialchars($org['name']) ?></strong> (<?= htmlspecialchars($org['org_code']) ?>)
</div>

<form action="<?= BASE_URL ?>/register/member" method="POST" class="auth-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="form-grid-2col">
        <!-- Full Name -->
        <div class="form-group">
            <label for="full_name" class="form-label">Full Name:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="user" class="icon-lucide"></i>
                </span>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    class="form-control" 
                    placeholder="Enter your full name" 
                    required
                    value="<?= htmlspecialchars($old['full_name'] ?? '') ?>"
                >
            </div>
        </div>

        <!-- Course -->
        <div class="form-group">
            <label for="course" class="form-label">Course:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="graduation-cap" class="icon-lucide"></i>
                </span>
                <select id="course" name="course" class="form-control select-custom" required>
                    <option value="" disabled selected>Select your course</option>
                    <option value="BS Information Technology">BS Information Technology</option>
                    <option value="BS Computer Science">BS Computer Science</option>
                    <option value="BS Electronics Engineering">BS Electronics Engineering</option>
                    <option value="BS Industrial Engineering">BS Industrial Engineering</option>
                    <option value="BS Business Administration">BS Business Administration</option>
                    <option value="BS Entrepreneurship">BS Entrepreneurship</option>
                    <option value="BS Accountancy">BS Accountancy</option>
                    <option value="Information System">BS Information System</option>
                </select>
            </div>
        </div>

        <!-- Department Committee -->
        <div class="form-group">
            <label for="department_committee" class="form-label">Department Committee:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="users" class="icon-lucide"></i>
                </span>
                <select id="department_committee" name="department_committee" class="form-control select-custom" required>
                    <option value="" disabled selected>Select department</option>
                    <option value="General Membership">General Membership</option>
                    <option value="Academics & Training">Academics & Training</option>
                    <option value="Creatives & Media">Creatives & Media</option>
                    <option value="Logistics & Events">Logistics & Events</option>
                    <option value="Finance & Records">Finance & Records</option>
                    <option value="Membership & Community">Membership & Community</option>
                </select>
            </div>
        </div>

        <!-- Position -->
        <div class="form-group">
            <label for="position" class="form-label">Position:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="briefcase" class="icon-lucide"></i>
                </span>
                <input 
                    type="text" 
                    id="position" 
                    name="position" 
                    class="form-control" 
                    value="Member" 
                    readonly
                >
            </div>
        </div>
    </div>

    <!-- Email -->
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
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            >
        </div>
    </div>

    <!-- Password -->
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
            >
            <button type="button" class="btn-toggle-password" aria-label="Toggle password visibility">
                <i data-lucide="eye" class="icon-lucide eye-open"></i>
                <i data-lucide="eye-off" class="icon-lucide eye-closed hidden"></i>
            </button>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="form-group full-width">
        <label for="confirm_password" class="form-label">Confirm Password:</label>
        <div class="input-wrapper">
            <span class="input-icon">
                <i data-lucide="lock" class="icon-lucide"></i>
            </span>
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                class="form-control" 
                placeholder="Confirm your password" 
                required
            >
            <button type="button" class="btn-toggle-password" aria-label="Toggle password visibility">
                <i data-lucide="eye" class="icon-lucide eye-open"></i>
                <i data-lucide="eye-off" class="icon-lucide eye-closed hidden"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary full-width">
        <span>Create account</span>
        <i data-lucide="arrow-right" class="icon-lucide"></i>
    </button>
</form>
