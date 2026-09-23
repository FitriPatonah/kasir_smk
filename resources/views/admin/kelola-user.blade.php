<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - {{ $namaToko }}</title>
    <style>
        :root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong,.brand small{display:block}.brand strong{font-size:15px}.brand small{margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a,.logout a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a.active,.nav a:hover,.logout a:hover{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.btn-primary{border:0;border-radius:8px;background:var(--blue);color:#fff;padding:11px 16px;font:600 14px inherit;cursor:pointer}.alert{padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:14px}.success{background:#e5f8ed;color:#14733b}.error{background:#fff0f0;color:#a52828}
        .user-card{background:#fff;border:1px solid var(--line);border-radius:13px;box-shadow:0 2px 5px rgba(23,36,58,.04);padding:18px 22px;display:flex;align-items:center;gap:16px;margin-bottom:14px}
        .user-avatar{width:46px;height:46px;border-radius:50%;background:#e7edf6;color:var(--blue);display:grid;place-items:center;flex:0 0 46px;font-size:20px}
        .user-avatar.kasir{background:#fdeee0;color:#c05a1a}
        .user-body{flex:1;min-width:0}
        .user-name-row{display:flex;align-items:center;gap:9px;flex-wrap:wrap}
        .user-name-row strong{font-size:16px}
        .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 11px;border-radius:99px;font-size:12px;font-weight:700}
        .badge svg{width:11px;height:11px;flex:0 0 auto}
        .badge-admin{background:#e4ecff;color:var(--blue)}
        .badge-kasir{background:#fdeee0;color:#c05a1a}
        .badge-aktif{background:#e5f8ed;color:#14733b}
        .badge-nonaktif{background:#f1f2f4;color:#6b7280}
        .user-meta{margin-top:5px;color:var(--muted);font-size:13.5px;display:flex;gap:14px;flex-wrap:wrap}
        .user-actions{display:flex;gap:6px;flex:0 0 auto}
        .icon-btn{border:1px solid var(--line);background:#fff;width:36px;height:36px;border-radius:8px;display:grid;place-items:center;cursor:pointer;color:var(--muted)}
        .icon-btn:hover{background:#f5f7fa}
        .icon-btn.danger{color:#c62828}
        .icon-btn.danger:hover{background:#fff0f0}
        .icon-btn svg{width:17px;height:17px}
        .empty{text-align:center;color:var(--muted);padding:50px 0;background:#fff;border-radius:13px;border:1px solid var(--line)}
        .modal{display:none;position:fixed;inset:0;z-index:10;background:rgba(20,30,45,.58);align-items:center;justify-content:center;padding:16px}.modal.open{display:flex}.modal-panel{width:min(520px,100%);background:#fff;border-radius:12px;padding:24px;box-shadow:0 18px 50px rgba(15,31,52,.28)}.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}.modal-head h2{margin:0;font-size:20px}.modal-close{border:0;background:none;font-size:26px;color:var(--muted);cursor:pointer}
        .form-field{margin-bottom:14px}.form-field label{display:block;font-size:13px;font-weight:700;margin-bottom:6px}.form-field input,.form-field select{width:100%;border:1px solid #d8e0eb;border-radius:7px;padding:10px;font:inherit}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-hint{font-size:12px;color:var(--muted);margin-top:4px}
        .modal-submit{width:100%}
        @media(max-width:760px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{gap:12px;flex-direction:column}.form-row{grid-template-columns:1fr}.user-card{flex-wrap:wrap}}
    </style>
</head>
<body>
<div class="layout">@include('admin.partials.sidebar', ['active' => 'kelola-user'])<main class="main">
<header class="heading"><div><h1>Kelola User</h1><p>{{ $user->count() }} user terdaftar</p></div><button class="btn-primary" type="button" onclick="bukaModal()">+ Tambah User</button></header>
@if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif @if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif

@forelse($user as $item)
<div class="user-card">
    <div class="user-avatar {{ $item->role === 'kasir' ? 'kasir' : '' }}">
        @if($item->role === 'admin')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        @else
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        @endif
    </div>
    <div class="user-body">
        <div class="user-name-row">
            <strong>{{ $item->name }}</strong>
            <span class="badge {{ $item->role === 'admin' ? 'badge-admin' : 'badge-kasir' }}">
                @if($item->role === 'admin')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20"/><path d="M4 20l-1.2-9 4.7 3L12 8l4.5 6 4.7-3-1.2 9"/></svg>
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                @endif
                {{ $item->role === 'admin' ? 'Admin' : 'Kasir' }}
            </span>
            <span class="badge {{ $item->aktif ? 'badge-aktif' : 'badge-nonaktif' }}">
                @if($item->aktif)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                @endif
                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div class="user-meta">
            <span>{{ '@'.$item->username }}</span>
            <span>{{ $item->email ?: '-' }}</span>
            <span>Bergabung: {{ $item->created_at->translatedFormat('d/m/Y') }}</span>
        </div>
    </div>
    <div class="user-actions">
        <form method="POST" action="{{ route('admin.kelola-user.status', $item->id) }}" onsubmit="return confirm('{{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }} user {{ $item->name }}?')">
            @csrf @method('PATCH')
            <button class="icon-btn" type="submit" title="{{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                @if($item->aktif)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M18 8l4 4m0-4l-4 4"/></svg>
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
                @endif
            </button>
        </form>
        <button class="icon-btn" type="button" title="Edit" onclick='bukaModal(@json($item->id), @json($item->name), @json($item->username), @json($item->email), @json($item->role))'>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
        </button>
        <form method="POST" action="{{ route('admin.kelola-user.destroy', $item->id) }}" onsubmit="return confirm('Hapus user {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.')">
            @csrf @method('DELETE')
            <button class="icon-btn danger" type="submit" title="Hapus">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            </button>
        </form>
    </div>
</div>
@empty
<div class="empty">Belum ada user.</div>
@endforelse

</main></div>

<div id="user-modal" class="modal"><div class="modal-panel">
    <div class="modal-head"><h2 id="modal-title">Tambah User</h2><button class="modal-close" type="button" onclick="tutupModal()">&times;</button></div>
    <form id="user-form" method="POST" action="{{ route('admin.kelola-user.store') }}">
        @csrf<input id="method-field" type="hidden" name="_method" value="POST">
        <div class="form-field"><label for="name">Nama Lengkap</label><input id="name" name="name" maxlength="120" required></div>
        <div class="form-row">
            <div class="form-field"><label for="username">Username</label><input id="username" name="username" maxlength="50" required></div>
            <div class="form-field"><label for="email">Email (Gmail)</label><input id="email" name="email" type="email" maxlength="255" placeholder="nama@gmail.com" required>
                <div class="form-hint">Dipakai untuk notifikasi kalau data akun ini diubah.</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-field"><label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="kasir">Kasir</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-field"><label for="password">Password</label><input id="password" name="password" type="password" minlength="6"><div class="form-hint" id="password-hint">Minimal 6 karakter.</div></div>
        </div>
        <button class="btn-primary modal-submit" type="submit">Simpan User</button>
    </form>
</div></div>

<script>
const modal = document.getElementById('user-modal');
const form = document.getElementById('user-form');
function bukaModal(id=null, name='', username='', email='', role='kasir'){
    document.getElementById('modal-title').textContent = id ? 'Edit User' : 'Tambah User';
    form.action = id ? '{{ url('/admin/kelola-user') }}/'+id : '{{ route('admin.kelola-user.store') }}';
    document.getElementById('method-field').value = id ? 'PUT' : 'POST';
    document.getElementById('name').value = name;
    document.getElementById('username').value = username;
    document.getElementById('email').value = email || '';
    document.getElementById('role').value = role || 'kasir';
    const password = document.getElementById('password');
    password.value = '';
    password.required = !id;
    document.getElementById('password-hint').textContent = id ? 'Kosongkan jika tidak ingin mengganti password.' : 'Minimal 6 karakter.';
    modal.classList.add('open');
    document.getElementById('name').focus();
}
function tutupModal(){ modal.classList.remove('open'); }
modal.addEventListener('click', e => { if (e.target === modal) tutupModal(); });
</script>
</body></html>