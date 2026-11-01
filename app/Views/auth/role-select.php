<?php
/**
 * Role Selection View (Kind of Account to Create)
 */
?>
<div class="role-select-container">
    <div class="form-header text-center">
        <h2 class="form-title">
            First, tell us <span class="gradient-text">what kind of account</span> you want to create.
        </h2>
    </div>

    <div class="role-cards-grid">
        <!-- President Card (Featured) -->
        <div class="role-card role-card-featured">
            <div class="role-card-icon">
                <i data-lucide="network" class="icon-lucide" style="width: 44px; height: 44px; stroke: #4C1D95; stroke-width: 2.2;"></i>
            </div>
            <a href="<?= BASE_URL ?>/register/president" class="btn btn-primary role-btn">
                <span>Register as President</span>
            </a>
        </div>

        <div class="role-cards-subgrid">
            <!-- Officer Card -->
            <div class="role-card">
                <div class="role-card-icon">
                    <i data-lucide="user" class="icon-lucide" style="width: 40px; height: 40px; stroke: #4C1D95; stroke-width: 2;"></i>
                </div>
                <p class="role-card-desc">Description</p>
                <a href="<?= BASE_URL ?>/register/verify?role=officer" class="btn btn-secondary role-btn">
                    <span>Register as Officer</span>
                </a>
            </div>

            <!-- Member Card -->
            <div class="role-card">
                <div class="role-card-icon">
                    <i data-lucide="users" class="icon-lucide" style="width: 40px; height: 40px; stroke: #4C1D95; stroke-width: 2;"></i>
                </div>
                <p class="role-card-desc">Description</p>
                <a href="<?= BASE_URL ?>/register/verify?role=member" class="btn btn-muted role-btn">
                    <span>Register as Member</span>
                </a>
            </div>
        </div>
    </div>

    <div class="form-footer-nav text-center">
        Already have an account? 
        <a href="<?= BASE_URL ?>/login" class="link-bold">
            Log in &rarr;
        </a>
    </div>
</div>
