<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('username', 'admin')->first();
var_dump($user ? $user->toArray() : null);
if ($user) {
    var_dump(Hash::check('admin123', $user->password));
    var_dump(Auth::guard('admin')->attempt(['username' => 'admin', 'password' => 'admin123']));
}

$user2 = App\Models\User::where('username', 'kasir')->first();
var_dump($user2 ? $user2->toArray() : null);
if ($user2) {
    var_dump(Hash::check('kasir123', $user2->password));
    var_dump(Auth::guard('kasir')->attempt(['username' => 'kasir', 'password' => 'kasir123']));
}
