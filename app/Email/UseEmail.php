<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDiubahMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param User $user User yang datanya baru saja diubah (baik oleh
     *                    admin lewat Kelola User, maupun oleh dirinya
     *                    sendiri lewat halaman Profil).
     * @param array<int, string> $perubahan Daftar nama field yang berubah, untuk ditampilkan di isi email (mis. ['Nama', 'Role'] atau ['Password']).
     */
    public function __construct(
        public User $user,
        public array $perubahan,
    ) {}

    public function build()
    {
        return $this
            ->subject('Data Akun Anda Diperbarui — ' . config('app.name'))
            ->view('emails.user-diubah');
    }
}
