<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('club:admin {email} {--revoke}', function () {
    $user = User::where('email', $this->argument('email'))->first();
    if (! $user) {
        $this->error('Aucun compte ne correspond Ã  cette adresse. CrÃ©ez dâ€™abord le compte sur le site.');

        return 1;
    }
    $user->forceFill(['is_admin' => ! $this->option('revoke')])->save();
    $this->info($this->option('revoke') ? 'AccÃ¨s administrateur retirÃ©.' : 'AccÃ¨s administrateur accordÃ©.');

    return 0;
})->purpose('Accorder ou retirer la gestion du club Ã  un compte existant');

Artisan::command('club:create-admin {email} {--name=Administrateur FC Hymont}', function () {
    $email = $this->argument('email');
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('Adresse e-mail invalide.');

        return 1;
    }
    if (User::where('email', $email)->exists()) {
        $this->error('Ce compte existe déjà : aucun changement effectué.');

        return 1;
    }
    $password = Str::password(24);
    $user = new User(['email' => $email, 'name' => $this->option('name'), 'password' => $password]);
    $user->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();
    $this->info('Compte administrateur créé.');
    $this->line('Identifiant : '.$email);
    $this->line('Mot de passe : '.$password);

    return 0;
})->purpose('Créer un administrateur avec un mot de passe aléatoire affiché une seule fois');
