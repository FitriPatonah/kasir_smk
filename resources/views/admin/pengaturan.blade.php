<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan - {{{ $namaToko }}}</title>
<style>
:root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}
*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}
.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong{display:block;font-size:15px}.brand small{display:block;margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a:hover,.nav a.active{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.nav-arrow{margin-left:auto;font-size:11px;color:#9db3d1;transition:transform .15s ease}.nav-arrow.down{transform:rotate(90deg)}.nav-submenu{margin:2px 0 6px 33px;display:flex;flex-direction:column;gap:2px}.nav-submenu a{padding:8px 10px;font-size:13px;border-radius:7px;color:#c7d7ee;text-decoration:none;display:block}.nav-submenu a:hover{background:rgba(255,255,255,.12);color:#fff}.nav-submenu a.active{background:rgba(255,255,255,.2);color:#fff;font-weight:700}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff;text-decoration:none;display:flex;align-items:center;gap:13px;padding:12px 16px;border-radius:9px;font-size:14px}.logout a:hover{background:rgba(255,255,255,.15)}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.panel{background:#fff;border:1px solid var(--line);border-radius:13px;box-shadow:0 2px 5px rgba(23,36,58,.04);padding:25px;margin-bottom:22px}
.alert{padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:13px}.success{background:#e8f8ee;color:#168747}.error{background:#ffeded;color:#c33d3d}
.field label{display:block;font-size:11px;color:#758196;margin-bottom:5px;font-weight:600}.field input,.field textarea{width:100%;padding:9px 10px;border:1px solid #d7dfeb;border-radius:6px;font-family:inherit;font-size:14px}.field textarea{resize:vertical}.field{margin-bottom:16px}
.panel-title{display:flex;align-items:center;gap:10px;font-size:16px;font-weight:700;margin-bottom:22px}.panel-title .icon{width:34px;height:34px;border-radius:9px;background:#e8f0ff;color:#1670f5;display:grid;place-items:center;font-size:17px}
.field-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.toggle-label{font-size:11px;color:#758196;margin-bottom:8px;font-weight:600;display:block}
.toggle-row{display:flex;justify-content:space-between;align-items:center;background:#f5f7fa;border-radius:10px;padding:14px 16px;margin-bottom:10px}
.toggle-row span{font-size:14px;color:var(--ink);font-weight:500}
.switch{position:relative;display:inline-block;width:44px;height:24px;flex-shrink:0}
.switch input{opacity:0;width:0;height:0}
.slider{position:absolute;cursor:pointer;inset:0;background:#ccd3dd;border-radius:24px;transition:.2s}
.slider:before{content:"";position:absolute;height:18px;width:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:.2s}
.switch input:checked + .slider{background:#2865e9}
.switch input:checked + .slider:before{transform:translateX(20px)}
.btn-save{background:var(--blue);color:#fff;border:0;border-radius:9px;padding:13px 24px;font-size:14px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
.btn-save:hover{background:#16293f}
@media(max-width:680px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.field-grid-2{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar', ['active' => 'pengaturan'])
    <main class="main">
        <header class="heading">
            <div><h1>Pengaturan</h1><p>Konfigurasi toko dan sistem</p></div>
        </header>

        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="alert error"><strong>Data belum disimpan:</strong> {{ $errors->first() }}</div> @endif

        <form method="POST" action="{{ route('admin.pengaturan.update') }}">
            @csrf
            @method('PUT')

            <div class="panel">
                <div class="panel-title"><span class="icon">🏪</span> Informasi Toko</div>

                <div class="field-grid-2">
                    <div class="field">
                        <label for="nama_toko">Nama Toko</label>
                        <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $pengaturan->nama_toko) }}">
                    </div>
                    <div class="field">
                        <label for="telepon">Telepon</label>
                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}">
                    </div>
                </div>

                <div class="field" style="margin-bottom:0;">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $pengaturan->alamat) }}">
                </div>
            </div>

            <div class="panel">
                <div class="panel-title"><span class="icon">💳</span> Pembayaran</div>

                <label class="toggle-label">Metode Pembayaran Aktif</label>

                <div class="toggle-row">
                    <span>Cash</span>
                    <label class="switch">
                        <input type="checkbox" name="metode_cash" value="1" {{ old('metode_cash', $pengaturan->metode_cash) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <span>QRIS</span>
                    <label class="switch">
                        <input type="checkbox" name="metode_qris" value="1" {{ old('metode_qris', $pengaturan->metode_qris) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row" style="margin-bottom:16px;">
                    <span>Transfer Bank</span>
                    <label class="switch">
                        <input type="checkbox" name="metode_transfer" value="1" {{ old('metode_transfer', $pengaturan->metode_transfer) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="field" style="margin-bottom:0;">
                    <label for="info_rekening">Info Rekening Bank</label>
                    <input type="text" id="info_rekening" name="info_rekening" placeholder="Contoh: BCA 1234567890 a.n. Nama Toko" value="{{ old('info_rekening', $pengaturan->info_rekening) }}">
                </div>
            </div>

            <div class="panel">
                <div class="panel-title"><span class="icon">💲</span> Pengaturan Struk</div>

                <div class="field">
                    <label for="header_struk">Header Struk</label>
                    <textarea id="header_struk" name="header_struk" rows="2">{{ old('header_struk', $pengaturan->header_struk) }}</textarea>
                </div>

                <div class="field" style="margin-bottom:0;">
                    <label for="footer_struk">Footer Struk</label>
                    <textarea id="footer_struk" name="footer_struk" rows="2">{{ old('footer_struk', $pengaturan->footer_struk) }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn-save">💾 Simpan Pengaturan</button>
        </form>
    </main>
</div>
</body>
</html>