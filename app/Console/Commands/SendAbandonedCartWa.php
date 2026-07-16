<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\FonnteService;
use Carbon\Carbon;

class SendAbandonedCartWa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:recover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi WhatsApp untuk transaksi tertunda (Abandoned Cart)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        // Cari transaksi yang dibuat antara 15 menit hingga 24 jam yang lalu
        // Status masih Pending, dan belum pernah dikirimi WA recovery
        $transactions = Transaction::with('event')
            ->where('status', 'pending')
            ->where('wa_recovery_sent', false)
            ->where('created_at', '<=', $now->copy()->subMinutes(15))
            ->where('created_at', '>=', $now->copy()->subHours(24))
            ->get();

        if ($transactions->isEmpty()) {
            $this->info('Tidak ada transaksi tertunda yang perlu di-follow-up.');
            return;
        }

        $count = 0;
        foreach ($transactions as $trx) {
            $paymentUrl = route('checkout.payment', $trx->order_id);
            $eventTitle = $trx->event ? $trx->event->title : 'Event Pilihan Anda';

            $message = "Halo {$trx->customer_name},\n\n";
            $message .= "Kami melihat Anda memiliki transaksi tiket untuk *{$eventTitle}* yang belum dibayar.\n\n";
            $message .= "Order ID: {$trx->order_id}\n";
            $message .= "Total Tagihan: Rp " . number_format($trx->total_price, 0, ',', '.') . "\n\n";
            $message .= "Silakan klik link di bawah ini untuk menyelesaikan pembayaran menggunakan Midtrans sebelum tiket Anda hangus:\n";
            $message .= $paymentUrl . "\n\n";
            $message .= "Abaikan pesan ini jika Anda sudah tidak berminat. Terima kasih!";

            $sent = FonnteService::sendMessage($trx->customer_phone, $message);

            if ($sent) {
                // Tandai sudah dikirim agar tidak dispam terus-menerus
                $trx->update(['wa_recovery_sent' => true]);
                $count++;
            }
        }

        $this->info("Berhasil mengirim notifikasi recovery ke {$count} pelanggan.");
    }
}
