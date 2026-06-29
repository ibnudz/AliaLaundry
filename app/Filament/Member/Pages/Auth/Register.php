<?php

namespace App\Filament\Member\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function getMaxWidth(): ?string
    {
        return '4xl';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Profil')
                        ->icon('heroicon-o-user')
                        ->description('Lengkapi data diri Anda.')
                        ->schema([
                            $this->getNameFormComponent(),

                            TextInput::make('phone')
                                ->label('Nomor HP')
                                ->tel()
                                ->required()
                                ->maxLength(20),

                            Textarea::make('address')
                                ->label('Alamat')
                                ->required()
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),

                    Step::make('Akun')
                        ->icon('heroicon-o-envelope')
                        ->description('Masukkan email Anda.')
                        ->schema([
                            $this->getEmailFormComponent(),
                        ]),

                    Step::make('Keamanan')
                        ->icon('heroicon-o-lock-closed')
                        ->description('Buat password yang aman.')
                        ->schema([
                            $this->getPasswordFormComponent(),

                            $this->getPasswordConfirmationFormComponent(),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => 'member',
        ]);
    }
}
