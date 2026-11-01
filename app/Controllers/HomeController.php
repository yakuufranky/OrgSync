<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

/**
 * Home and Dashboard Controller
 */
class HomeController extends Controller
{
    /**
     * Render Application Dashboard
     */
    public function index(): void
    {
        $user = Session::get('user');
        if ($user === null) {
            $this->redirect('/login');
        }

        $this->view('home/index', [
            'pageTitle' => 'OrgSync Dashboard',
            'user' => $user,
        ], 'main');
    }
}
