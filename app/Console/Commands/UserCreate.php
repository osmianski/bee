<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Enter new user details');

        User::create([
            'name' => $this->ask('Name'),
            'email' => $this->ask('Email'),
            'password' => Hash::make($this->secret('Password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $this->info('User created!');
    }
}
