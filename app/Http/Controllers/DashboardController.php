<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Receipt;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();

        $totalQuotations = Quotation::count();

        $totalInvoices = Invoice::count();

        $totalReceipts = Receipt::count();

        $totalRevenue = Receipt::sum('amount_received');

        $pendingPayments = Invoice::where('status', 'Pending')
            ->sum('total');

        $recentQuotations = Quotation::with('client')
            ->latest()
            ->take(5)
            ->get();

        $recentInvoices = Invoice::with('quotation.client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalClients',
            'totalQuotations',
            'totalInvoices',
            'totalReceipts',
            'totalRevenue',
            'pendingPayments',
            'recentQuotations',
            'recentInvoices'
        ));
    }
}