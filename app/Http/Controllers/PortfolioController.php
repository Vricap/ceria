<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        // Portfolio data - akan diisi dari database nantinya
        $portfolios = collect([]);

        return view('portfolio.index', compact('portfolios'));
    }

    public function show(string $slug): View
    {
        // Portfolio detail - akan diisi dari database nantinya
        return view('portfolio.show', compact('slug'));
    }
}
