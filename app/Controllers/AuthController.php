<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Organization;
use App\Models\User;

/**
 * Authentication and Registration Controller
 */
class AuthController extends Controller
{
    private User $userModel;
    private Organization $orgModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->orgModel = new Organization();
    }

    /**
     * Render Login View
     */
    public function showLogin(): void
    {
        if (Session::has('user')) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/login', [
            'pageTitle' => 'Log in to OrgSync',
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
            'csrf' => Session::csrfToken(),
        ]);
    }

    /**
     * Handle Login Authentication
     */
    public function login(): void
    {
        if (!Session::validateCsrf($_POST['csrf_token'] ?? null)) {
            Session::setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect('/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            Session::setFlash('error', 'Please enter your email and password.');
            $this->redirect('/login');
        }

        $user = $this->userModel->verifyCredentials($email, $password);
        if ($user === null) {
            Session::setFlash('error', 'Invalid email or password.');
            $this->redirect('/login');
        }

        Session::set('user', $user);
        Session::setFlash('success', "Welcome back, {$user['full_name']}!");
        $this->redirect('/dashboard');
    }

    /**
     * Render Account Type Selection
     */
    public function showRoleSelect(): void
    {
        $this->view('auth/role-select', [
            'pageTitle' => 'Create Account - Select Role',
        ]);
    }

    /**
     * Render President & Organization Registration Form
     */
    public function showRegisterPresident(): void
    {
        $this->view('auth/register-president', [
            'pageTitle' => 'Create Organization & President Account',
            'error' => Session::getFlash('error'),
            'old' => Session::getFlash('old') ?? [],
            'csrf' => Session::csrfToken(),
        ]);
    }

    /**
     * Process President & Organization Creation
     */
    public function registerPresident(): void
    {
        if (!Session::validateCsrf($_POST['csrf_token'] ?? null)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirect('/register/president');
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $schoolName = trim($_POST['school_name'] ?? 'Quezon City University');
        $orgName = trim($_POST['org_name'] ?? '');
        $orgType = trim($_POST['org_type'] ?? 'Academic');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($fullName === '' || $course === '' || $orgName === '' || $email === '' || $password === '') {
            Session::setFlash('error', 'Please fill in all required fields.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/president');
        }

        if ($password !== $confirmPassword) {
            Session::setFlash('error', 'Passwords do not match.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/president');
        }

        if (strlen($password) < 6) {
            Session::setFlash('error', 'Password must be at least 6 characters long.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/president');
        }

        if ($this->userModel->findByEmail($email) !== null) {
            Session::setFlash('error', 'An account with this email address already exists.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/president');
        }

        $org = $this->orgModel->create([
            'name' => $orgName,
            'type' => $orgType,
            'school_name' => $schoolName,
        ]);

        $userId = $this->userModel->create([
            'organization_id' => $org['id'],
            'full_name' => $fullName,
            'email' => $email,
            'password' => $password,
            'course' => $course,
            'department_committee' => 'Executive Committee',
            'role' => 'President',
            'position' => 'President',
            'status' => 'Active',
        ]);

        Session::set('registration_success', [
            'org_name' => $orgName,
            'org_type' => $orgType,
            'org_code' => $org['org_code'],
            'role' => 'President',
            'full_name' => $fullName,
        ]);

        $this->redirect('/register/success');
    }

    /**
     * Render Organization Code Verification View
     */
    public function showVerifyCode(): void
    {
        $role = $_GET['role'] ?? 'officer';
        $role = in_array(strtolower($role), ['officer', 'member'], true) ? strtolower($role) : 'officer';

        $this->view('auth/verify-code', [
            'pageTitle' => ucfirst($role) . ' Registration - Verify Code',
            'role' => $role,
            'error' => Session::getFlash('error'),
            'csrf' => Session::csrfToken(),
        ]);
    }

    /**
     * AJAX Endpoint: Verify Organization Code
     */
    public function verifyCodeApi(): void
    {
        $code = trim($_POST['org_code'] ?? '');
        if ($code === '') {
            $this->json(['success' => false, 'message' => 'Please enter an organization code.'], 400);
        }

        $org = $this->orgModel->findByCode($code);
        if ($org === null) {
            $this->json(['success' => false, 'message' => 'Organization code not found. Please double-check the code with your President.'], 404);
        }

        Session::set('verified_org', $org);

        $this->json([
            'success' => true,
            'organization' => [
                'id' => $org['id'],
                'name' => $org['name'],
                'type' => $org['type'],
                'code' => $org['org_code'],
            ],
        ]);
    }

    /**
     * Render Officer Registration Form
     */
    public function showRegisterOfficer(): void
    {
        $org = Session::get('verified_org');
        if ($org === null) {
            Session::setFlash('error', 'Please verify your organization code first.');
            $this->redirect('/register/verify?role=officer');
        }

        $this->view('auth/register-officer', [
            'pageTitle' => 'Officer Registration',
            'org' => $org,
            'error' => Session::getFlash('error'),
            'old' => Session::getFlash('old') ?? [],
            'csrf' => Session::csrfToken(),
        ]);
    }

    /**
     * Process Officer Registration
     */
    public function registerOfficer(): void
    {
        if (!Session::validateCsrf($_POST['csrf_token'] ?? null)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirect('/register/officer');
        }

        $org = Session::get('verified_org');
        if ($org === null) {
            Session::setFlash('error', 'Session expired. Please verify your organization code again.');
            $this->redirect('/register/verify?role=officer');
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $department = trim($_POST['department_committee'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($fullName === '' || $course === '' || $position === '' || $email === '' || $password === '') {
            Session::setFlash('error', 'Please fill in all required fields.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/officer');
        }

        if ($password !== $confirmPassword) {
            Session::setFlash('error', 'Passwords do not match.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/officer');
        }

        if (strlen($password) < 6) {
            Session::setFlash('error', 'Password must be at least 6 characters long.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/officer');
        }

        if ($this->userModel->findByEmail($email) !== null) {
            Session::setFlash('error', 'An account with this email address already exists.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/officer');
        }

        $this->userModel->create([
            'organization_id' => $org['id'],
            'full_name' => $fullName,
            'email' => $email,
            'password' => $password,
            'course' => $course,
            'department_committee' => $department,
            'role' => 'Officer',
            'position' => $position,
            'status' => 'Active',
        ]);

        Session::set('registration_success', [
            'org_name' => $org['name'],
            'org_type' => $org['type'],
            'org_code' => $org['org_code'],
            'role' => 'Officer',
            'full_name' => $fullName,
        ]);

        Session::remove('verified_org');
        $this->redirect('/register/success');
    }

    /**
     * Render Member Registration Form
     */
    public function showRegisterMember(): void
    {
        $org = Session::get('verified_org');
        if ($org === null) {
            Session::setFlash('error', 'Please verify your organization code first.');
            $this->redirect('/register/verify?role=member');
        }

        $this->view('auth/register-member', [
            'pageTitle' => 'Member Registration',
            'org' => $org,
            'error' => Session::getFlash('error'),
            'old' => Session::getFlash('old') ?? [],
            'csrf' => Session::csrfToken(),
        ]);
    }

    /**
     * Process Member Registration
     */
    public function registerMember(): void
    {
        if (!Session::validateCsrf($_POST['csrf_token'] ?? null)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirect('/register/member');
        }

        $org = Session::get('verified_org');
        if ($org === null) {
            Session::setFlash('error', 'Session expired. Please verify your organization code again.');
            $this->redirect('/register/verify?role=member');
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $department = trim($_POST['department_committee'] ?? 'General Membership');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($fullName === '' || $course === '' || $email === '' || $password === '') {
            Session::setFlash('error', 'Please fill in all required fields.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/member');
        }

        if ($password !== $confirmPassword) {
            Session::setFlash('error', 'Passwords do not match.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/member');
        }

        if (strlen($password) < 6) {
            Session::setFlash('error', 'Password must be at least 6 characters long.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/member');
        }

        if ($this->userModel->findByEmail($email) !== null) {
            Session::setFlash('error', 'An account with this email address already exists.');
            Session::setFlash('old', $_POST);
            $this->redirect('/register/member');
        }

        $this->userModel->create([
            'organization_id' => $org['id'],
            'full_name' => $fullName,
            'email' => $email,
            'password' => $password,
            'course' => $course,
            'department_committee' => $department,
            'role' => 'Member',
            'position' => 'Member',
            'status' => 'Active',
        ]);

        Session::set('registration_success', [
            'org_name' => $org['name'],
            'org_type' => $org['type'],
            'org_code' => $org['org_code'],
            'role' => 'Member',
            'full_name' => $fullName,
        ]);

        Session::remove('verified_org');
        $this->redirect('/register/success');
    }

    /**
     * Render Registration Success Screen
     */
    public function showSuccess(): void
    {
        $info = Session::get('registration_success');
        if ($info === null) {
            $this->redirect('/login');
        }

        $this->view('auth/success', [
            'pageTitle' => 'Registration Successful',
            'info' => $info,
        ]);
    }

    /**
     * Log User Out
     */
    public function logout(): void
    {
        Session::destroy();
        Session::start();
        Session::setFlash('success', 'You have been successfully logged out.');
        $this->redirect('/login');
    }
}
