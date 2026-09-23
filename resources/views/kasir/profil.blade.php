<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil - {{ $namaToko }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">

<style>
    /* =========================
       PROFIL
       ========================= */

    .profil-wrap {
        max-width: 900px;
        margin: 0 auto;
    }

    /*
     * Kartu informasi akun
     * Warna biru dan desain dasar tetap dipertahankan
     */
    .profil-header {
        background: linear-gradient(135deg, #1e3a5f, #2b527f);
        border-radius: 14px;
        padding: 34px 36px;
        display: flex;
        align-items: center;
        gap: 26px;
        color: #fff;
        margin-bottom: 22px;
        min-height: 180px;
    }

    /*
     * Lingkaran inisial tetap ada,
     * hanya diperbesar sedikit.
     */
    .profil-avatar {
        width: 76px;
        height: 76px;
        min-width: 76px;
        border-radius: 50%;
        background: rgba(255,255,255,.18);
        display: grid;
        place-items: center;
        font-size: 28px;
        font-weight: 700;
    }

    .profil-info {
        flex: 1;
        min-width: 0;
    }

    .profil-name {
        font-size: 23px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .profil-username {
        color: #d4e3ff;
        font-size: 15px;
        margin-top: 2px;
    }

    /*
     * Informasi bergabung dan email
     * diletakkan berdampingan.
     */
    .profil-meta {
        display: flex;
        align-items: center;
        gap: 28px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .profil-meta span {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 14px;
        color: #d4e3ff;
    }

    .profil-meta svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .badge {
        display: inline-block;
        background: rgba(46,125,50,.25);
        color: #eafff0;
        border: 1px solid rgba(255,255,255,.25);
        padding: 5px 13px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 12px;
    }

    /*
     * Panel password berada di bawah kartu informasi akun.
     */
    .panel {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,.08);
        padding: 24px 28px;
    }

    .panel h2 {
        font-size: 16px;
        margin: 0 0 4px;
        color: #1e3a5f;
    }

    .panel p.subtitle {
        color: #708099;
        font-size: 13px;
        margin: 0 0 20px;
    }

    .section-title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #94a3b8;
        margin: 22px 0 12px;
        padding-top: 18px;
        border-top: 1px solid #eef1f5;
    }

    .section-title:first-of-type {
        margin-top: 0;
        padding-top: 0;
        border-top: 0;
    }

    .form-field {
        margin-bottom: 15px;
    }

    .form-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .form-field input {
        width: 100%;
        border: 1px solid #d8e0eb;
        border-radius: 8px;
        padding: 10px 12px;
        font: inherit;
        box-sizing: border-box;
    }

    .form-field input:focus {
        outline: none;
        border-color: #1e3a5f;
    }

    .form-hint {
        font-size: 12px;
        color: #708099;
        margin-top: 5px;
    }

    .btn-primary {
        border: 0;
        border-radius: 8px;
        background: #1e3a5f;
        color: #fff;
        padding: 12px 16px;
        font: 600 14px inherit;
        cursor: pointer;
        width: 100%;
        margin-top: 6px;
    }

    .btn-primary:hover {
        background: #16304e;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .success {
        background: #e5f8ed;
        color: #14733b;
    }

    .error {
        background: #fff0f0;
        color: #a52828;
    }

    /*
     * Agar tetap bagus di layar kecil
     */
    @media (max-width: 700px) {
        .profil-header {
            padding: 26px 22px;
            gap: 18px;
        }

        .profil-avatar {
            width: 64px;
            height: 64px;
            min-width: 64px;
            font-size: 24px;
        }

        .profil-name {
            font-size: 20px;
        }

        .profil-meta {
            gap: 10px;
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
</head>

<body>

<div class="app">

@include('kasir.partials.sidebar', ['active' => 'profil'])


    <main class="main" style="grid-template-columns: 1fr;">

        <div class="profil-wrap">

            {{-- Pesan berhasil --}}
            @if(session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pesan error --}}
            @if($errors->any())
                <div class="alert error">
                    {{ $errors->first() }}
                </div>
            @endif


            {{-- =========================
                 INFORMASI AKUN
                 ========================= --}}
            <div class="profil-header">

                {{-- Inisial tetap berbentuk lingkaran --}}
                <div class="profil-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>


                <div class="profil-info">

                    {{-- Nama hanya ditampilkan --}}
                    <div class="profil-name">
                        {{ $user->name }}
                    </div>

                    {{-- Username hanya ditampilkan --}}
                    <div class="profil-username">
                        {{ '@'.$user->username }}
                    </div>


                    {{-- Informasi akun --}}
                    <div class="profil-meta">

                        {{-- Tanggal bergabung --}}
                        <span>
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="3" y="4"
                                      width="18"
                                      height="18"
                                      rx="2"/>
                                <path d="M16 2v4"/>
                                <path d="M8 2v4"/>
                                <path d="M3 10h18"/>
                            </svg>

                            Bergabung {{ $user->created_at->translatedFormat('d F Y') }}
                        </span>


                        {{-- Email --}}
                        <span>
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="M2 7l10 6 10-6"/>
                            </svg>

                            {{ $user->email ?: '-' }}
                        </span>

                    </div>


                    {{-- Status kasir --}}
                    <span class="badge">
                        Kasir Aktif
                    </span>

                </div>

            </div>


            {{-- =========================
                 GANTI PASSWORD
                 ========================= --}}
            <div class="panel">

                <h2>Ganti Password</h2>

                <p class="subtitle">
                    Ubah password akun kasir Anda.
                </p>


                <form method="POST"
                      action="{{ route('kasir.profil.update') }}">

                    @csrf
                    @method('PUT')


                    {{-- Password lama --}}
                    <div class="form-field">

                        <label for="password_lama">
                            Password Lama
                        </label>

                        <input
                            id="password_lama"
                            name="password_lama"
                            type="password"
                        >

                        <div class="form-hint">
                            Wajib diisi jika Anda ingin mengganti password.
                        </div>

                    </div>


                    {{-- Password baru --}}
                    <div class="form-field">

                        <label for="password">
                            Password Baru
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            minlength="6"
                        >

                    </div>


                    {{-- Konfirmasi password --}}
                    <div class="form-field">

                        <label for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            minlength="6"
                        >

                    </div>


                    <button class="btn-primary" type="submit">
                        Ubah Password
                    </button>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>