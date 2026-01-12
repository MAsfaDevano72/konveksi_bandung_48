<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class CheckOrderDeadline extends Command
{
    protected $signature = 'order:check-deadline';
    protected $description = 'Cek pesanan yang mendekati deadline dan kirim notifikasi';

    public function handle()
    {
        // 1. Ambil setting batas notifikasi (Default H-3 jika tidak diatur)
        $settings = \App\Models\Setting::first();
        if (!$settings || !$settings->notification_deadline) {
             return;
        }

        $alertDays = $settings->deadline_reminder_days ?? 3; 

        // 2. Ambil SEMUA pesanan yang statusnya BELUM SELESAI
        $orders = \App\Models\Order::where('status', '!=', 'Done')
                    ->whereNotNull('deadline') 
                    ->get();

        $notificationCount = 0;
        $recipients = \App\Models\User::role(['Admin', 'Owner', 'Cutting', 'Tailor', 'QC/Packing'])->get(); 

        foreach ($orders as $order) {
            $deadline = \Carbon\Carbon::parse($order->deadline)->endOfDay();
            $daysLeft = now()->diffInDays($deadline, false); 
            
            $daysLeft = (int) floor($daysLeft);

            if ($daysLeft <= $alertDays && $daysLeft >= 0) {
                
                if ($daysLeft === 0) {
                    $title = "⚠️ PERINGATAN: HARI INI DEADLINE!";
                    $body  = "Pesanan {$order->order_number} ({$order->product_name}) HARUS SELESAI HARI INI.";
                } elseif ($daysLeft === 1) {
                    $title = "⏰ BESOK DEADLINE (H-1)";
                    $body  = "Pesanan {$order->order_number} ({$order->product_name}) tinggal 1 hari lagi.";
                } else {
                    $title = "Deadline Mendekat (H-{$daysLeft})";
                    $body  = "Pesanan {$order->order_number} ({$order->product_name}) jatuh tempo dalam {$daysLeft} hari.";
                }

                // Kirim Notifikasi
                \Filament\Notifications\Notification::make()
                    ->title($title)
                    ->body($body)
                    ->warning() // Atau ->danger() biar merah
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('Lihat')
                            ->url("/admin/orders/{$order->id}/edit") 
                    ])
                    ->send()
                    ->sendToDatabase($recipients);
                
                $notificationCount++;
            }
        }

        $this->info("Pengecekan selesai. Dikirim {$notificationCount} notifikasi deadline.");
    }
}
