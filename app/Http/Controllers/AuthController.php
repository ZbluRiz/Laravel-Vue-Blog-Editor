<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;


class AuthController extends Controller
{
    public function index()
    {
        $userCount = User::count();

        return Inertia::render('Blogs/index', [
            'userCount' => $userCount,
        ]);
    }
}
