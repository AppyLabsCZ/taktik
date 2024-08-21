<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateApiUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-api-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vytvoří uživatele se secret klíčem pro použití API.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::create([
            'name' => 'Jan Novak',
            'email' => 'novak@example.com',
            'password' => Hash::make('password'),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        $this->info('Uživatel byl vytvořen.');
        $this->info('Osobní API token: ' . $token);

        return 0;
    }
}
