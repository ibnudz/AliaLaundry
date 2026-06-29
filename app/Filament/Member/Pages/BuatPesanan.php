<?php

namespace App\Filament\Member\Pages;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BuatPesanan extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected string $view = 'filament.member.pages.buat-pesanan';

    protected static ?string $title = 'Buat Pesanan';

    public $services = [];

    public $cart = [];

    public $estimasiTotal = 0;

    public function mount()
    {
        $this->services = Service::all();
    }

    public function addToCart($serviceId)
    {
        $service = Service::find($serviceId);

        if (! isset($this->cart[$serviceId])) {
            $this->cart[$serviceId] = [
                'id' => $service->id,
                'name' => $service->name,
                'service_type' => $service->service_type,
                'price' => $service->price,
                'unit_type' => $service->unit_type,
                'quantity' => 1, // Diubah menjadi quantity
            ];
        } else {
            $this->cart[$serviceId]['quantity']++;
        }

        $this->calculateTotal();
    }

    public function updated($name, $value)
    {
        if (str_starts_with($name, 'cart.')) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->estimasiTotal = 0;
        foreach ($this->cart as $item) {
            $quantity = (float) ($item['quantity'] ?: 0);
            $this->estimasiTotal += ($item['price'] * $quantity);
        }
    }

    public function hapusItem($serviceId)
    {
        unset($this->cart[$serviceId]);
        $this->calculateTotal();
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Keranjang kosong!')->danger()->send();

            return;
        }

        // Simpan ke tabel Orders dengan nama kolom baru
        $order = Order::create([
            'invoice_number' => 'INV-ALIA-'.strtoupper(Str::random(3)).now()->format('YmdHis'),
            'user_id' => Auth::id(),
            'order_date' => now(),
            'laundry_status' => 'Pending Confirmation',
            'payment_status' => 'Unpaid',
            'total_price' => 0,
        ]);

        // Simpan rincian ke tabel OrderDetails
        foreach ($this->cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'service_id' => $item['id'],
                'quantity' => $item['quantity'],
                // Di migration Anda, kolomnya bernama 'price', bukan 'subtotal'
                'price' => $item['price'],
            ]);
        }

        Notification::make()->title('Pesanan berhasil dibuat!')->success()->send();

        return redirect()->to('/member/orders');
    }
}
