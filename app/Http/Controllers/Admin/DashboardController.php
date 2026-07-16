<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();
        
        // 6. Data Grafik Pertumbuhan (User & Event) per bulan tahun ini
        $usersPerMonthData = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()->keyBy('month')->toArray();

        $eventsPerMonthData = Event::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()->keyBy('month')->toArray();

        // Siapkan array dengan nilai 0 untuk 12 bulan
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $userCounts = [];
        $eventCounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $userCounts[] = isset($usersPerMonthData[$i]) ? $usersPerMonthData[$i]['count'] : 0;
            $eventCounts[] = isset($eventsPerMonthData[$i]) ? $eventsPerMonthData[$i]['count'] : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 
            'recentTransactions', 'months', 'userCounts', 'eventCounts'
        ));
    }
}
