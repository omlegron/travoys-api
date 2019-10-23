<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Redirect to homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return redirect('https://travoy.id');
    }
}
