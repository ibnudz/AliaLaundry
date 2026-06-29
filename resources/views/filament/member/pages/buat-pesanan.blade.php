<x-filament-panels::page>
    <div class="flex flex-col lg:grid lg:grid-cols-12 gap-4 lg:gap-6 items-start">

        <div class="w-full lg:col-span-8 bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 lg:p-6 order-1">

            <div class="border-b border-gray-200 dark:border-gray-800 pb-3 lg:pb-4 mb-4">
                <h2 class="text-base lg:text-lg font-bold text-gray-950 dark:text-white">Daftar Layanan</h2>
                <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400">Klik layanan untuk menambahkan ke keranjang.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 lg:gap-4">
                @foreach ($services as $service)
                    <div wire:click="addToCart({{ $service->id }})" class="cursor-pointer flex flex-col justify-between p-3 lg:p-4 rounded-lg bg-gray-50 border border-gray-200 hover:border-primary-500 hover:ring-1 hover:ring-primary-500 transition-all dark:bg-gray-800 dark:border-gray-700 active:scale-95">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm lg:text-base leading-tight">
                                {{ $service->name }}
                            </h3>
                            <span class="inline-flex items-center rounded-md bg-primary-50 px-1.5 py-0.5 lg:px-2 lg:py-1 text-[10px] lg:text-xs font-medium text-primary-700 ring-1 ring-inset ring-primary-700/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30 mt-1.5 lg:mt-2">
                                {{ $service->service_type }}
                            </span>
                        </div>
                        <div class="mt-3 lg:mt-4 pt-2 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-primary-600 dark:text-primary-400 font-bold text-xs lg:text-sm">
                                Rp {{ number_format($service->price, 0, ',', '.') }} <span class="text-gray-500 dark:text-gray-400 text-[10px] lg:text-xs font-normal">/ {{ strtoupper($service->unit_type) }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="w-full lg:col-span-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 lg:p-6 lg:sticky lg:top-6 order-2 mb-8 lg:mb-0">

            <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3 lg:pb-4 mb-4">
                <x-heroicon-o-shopping-bag class="w-5 h-5 lg:w-6 lg:h-6 text-primary-600 dark:text-primary-400" />
                <h2 class="text-base lg:text-lg font-bold text-gray-950 dark:text-white">Keranjang</h2>
            </div>

            @if (empty($cart))
                <div class="flex flex-col items-center justify-center py-6 lg:py-8 text-center">
                    <x-heroicon-o-archive-box-x-mark class="w-10 h-10 lg:w-12 lg:h-12 text-gray-300 dark:text-gray-600 mb-2" />
                    <p class="text-xs lg:text-sm text-gray-500 dark:text-gray-400">Keranjang masih kosong.</p>
                </div>
            @else
                <div class="space-y-3 lg:space-y-4 mb-4 lg:mb-6 max-h-[350px] lg:max-h-[400px] overflow-y-auto pr-1 lg:pr-2">
                    @foreach ($cart as $id => $item)
                        <div class="flex flex-col gap-2 p-2.5 lg:p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-xs lg:text-sm text-gray-900 dark:text-white">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] lg:text-xs text-gray-500 dark:text-gray-400">Rp {{ number_format($item['price'], 0, ',', '.') }} / {{ strtoupper($item['unit_type']) }}</p>
                                </div>
                                <button wire:click="hapusItem({{ $id }})" class="text-red-500 hover:text-red-700 p-1">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5 lg:w-4 lg:h-4" />
                                </button>
                            </div>

                            <div class="flex items-center gap-2 mt-1">
                                <label class="text-[10px] lg:text-xs text-gray-600 dark:text-gray-300 w-12 lg:w-16">Estimasi:</label>
                                <div class="flex-1 relative">
                                    <input type="number" step="0.1" min="0.1" wire:model.live="cart.{{ $id }}.quantity" class="block w-full rounded-md border-0 py-1 pl-2 pr-8 lg:py-1.5 lg:pl-3 lg:pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 text-xs lg:text-sm lg:leading-6 dark:bg-gray-800 dark:text-white dark:ring-gray-700">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 lg:pr-3">
                                        <span class="text-gray-500 text-[10px] lg:text-sm">{{ strtoupper($item['unit_type']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right text-xs lg:text-sm font-medium text-gray-900 dark:text-white mt-1">
                                Subtotal: Rp {{ number_format($item['price'] * (float) ($item['quantity'] ?: 0), 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 dark:border-gray-800 pt-3 lg:pt-4">
                    <div class="flex justify-between items-center mb-3 lg:mb-4">
                        <span class="text-xs lg:text-sm font-medium text-gray-600 dark:text-gray-300">Estimasi Total</span>
                        <span class="font-bold text-lg lg:text-xl text-primary-600 dark:text-primary-400">
                            Rp {{ number_format($estimasiTotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <button wire:click="checkout" class="w-full flex justify-center items-center gap-2 bg-primary-600 hover:bg-primary-500 text-white font-semibold py-2 lg:py-2.5 px-4 rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 text-sm lg:text-base">
                        <x-heroicon-o-check-circle class="w-4 h-4 lg:w-5 lg:h-5" />
                        Pesan Sekarang
                    </button>

                    <div class="mt-2 lg:mt-3 flex items-start gap-2">
                        <x-heroicon-o-information-circle class="w-3 h-3 lg:w-4 lg:h-4 text-gray-400 flex-shrink-0 mt-0.5" />
                        <p class="text-[9px] lg:text-[11px] text-gray-500 dark:text-gray-400 leading-tight">
                            Total harga ini bersifat estimasi. Harga final akan diperbarui setelah pakaian ditimbang secara aktual oleh petugas laundry.
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-filament-panels::page>
