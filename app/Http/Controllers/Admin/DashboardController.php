<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'filmCount' => Film::count(),
            'genreCount' => Genre::count(),
            'userCount' => User::count(),
            'reviewCount' => Kritik::count(),
        ]);
    }
}
