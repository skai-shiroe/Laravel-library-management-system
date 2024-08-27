<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\book_issue;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function date_wise()
    {
        return view('report.dateWise', ['books' => '']);
    }
    public function generate_date_wise_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
    
        // Utiliser whereDate pour filtrer par date seulement
        $books = book_issue::whereDate('issue_date', $request->date)->latest()->get();
    
        return view('report.dateWise', compact('books'));
    }
    

    public function month_wise()
    {
        return view('report.monthWise', ['books' => '']);
    }

    public function generate_month_wise_report(Request $request)
    {
        $request->validate(['month' => "required|date"]);
        return view('report.monthWise', [
            'books' => book_issue::where('issue_date', 'LIKE', '%' . $request->month . '%')->latest()->get(),
        ]);
    }

    public function not_returned()
    {
        // Récupère uniquement les livres qui n'ont pas été retournés
        $books = book_issue::whereNull('return_date')->latest()->get();
    
        return view('report.notReturned', compact('books'));
    }
    
}
