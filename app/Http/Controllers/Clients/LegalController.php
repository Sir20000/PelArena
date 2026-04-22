<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function legal(Request $request)
    {
        $legal = settings("legal");
        return view('client.legal', compact('legal'));
    }
    public function terms(Request $request)
    {
        $terms = settings("tos");
        return view('client.terms', compact('terms'));
    }
    public function privacy(Request $request)
    {
        $privacy = settings("privacypolitique");
        return view('client.privacy', compact('privacy'));
    }
}
