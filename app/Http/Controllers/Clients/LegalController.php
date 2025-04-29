<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function legal(Request $request)
    {
        $legal = settings("legal");
        return view('clients.legal', compact('legal'));
    }
    public function terms(Request $request)
    {
        $terms = settings("terms");
        return view('clients.terms', compact('terms'));
    }
    public function privacy(Request $request)
    {
        $privacy = settings("privacy");
        return view('clients.privacy', compact('privacy'));
    }
}
