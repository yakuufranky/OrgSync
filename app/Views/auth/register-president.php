<?php
/**
 * President & Organization Registration View
 */
?>
<div class="form-header-nav">
    <a href="<?= BASE_URL ?>/register" class="btn-back" aria-label="Go back">
        <i data-lucide="chevron-left" class="icon-lucide"></i>
    </a>
    <div class="header-link">
        Already have an account? <a href="<?= BASE_URL ?>/login" class="link-bold">Log in</a>
    </div>
</div>

<div class="form-header">
    <h2 class="form-title">Create your <span class="gradient-text">account</span></h2>
    <p class="form-subtitle">Fill your details to create your organization and account.</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <i data-lucide="alert-circle" class="icon-lucide"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<form action="<?= BASE_URL ?>/register/president" method="POST" class="auth-form">
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

        <!-- School Name -->
        <div class="form-group">
            <label for="school_name" class="form-label">School Name:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="school" class="icon-lucide"></i>
                </span>
                <input 
                    type="text" 
                    id="school_name" 
                    name="school_name" 
                    class="form-control" 
                    placeholder="Enter your school name" 
                    value="<?= htmlspecialchars($old['school_name'] ?? 'Quezon City University') ?>"
                    required
                >
            </div>
        </div>

        <!-- Position -->
        <div class="form-group">
            <label for="position" class="form-label">Position:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="user" class="icon-lucide"></i>
                </span>
                <select id="position" name="position" class="form-control select-custom" required>
                    <option value="President" selected>President</option>
                </select>
            </div>
        </div>

        <!-- Organization Name -->
        <div class="form-group">
            <label for="org_name" class="form-label">Organization Name:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="users" class="icon-lucide"></i>
                </span>
                <input 
                    type="text" 
                    id="org_name" 
                    name="org_name" 
                    class="form-control" 
                    placeholder="Enter your organization name" 
                    required
                    value="<?= htmlspecialchars($old['org_name'] ?? '') ?>"
                >
            </div>
        </div>

        <!-- Organization Type -->
        <div class="form-group">
            <label for="org_type" class="form-label">Organization Type:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i data-lucide="tag" class="icon-lucide"></i>
                </span>
                <select id="org_type" name="org_type" class="form-control select-custom" required>
                    <option value="" disabled selected>Select organization type</option>
                    <option value="Academic">Academic</option>
                    <option value="Non-Academic">Non-Academic</option>
                </select>
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
