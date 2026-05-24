<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function transactions(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Transaction::with('event');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'LIKE', '%' . $search . '%')
                  ->orWhere('customer_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('customer_email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($status && $status != 'Semua Status') {
            $query->where('status', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return view('admin.transactions', compact('transactions'));
    }
}
