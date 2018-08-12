@component('mail::message')
Hello, {{ $user }}.<br>
Terima Kasih telah mendaftar di Kamusku.

Untuk mengaktifasi akun anda harap klik tombol di bawah ini.

@component('mail::button', ['url' => $url])
Aktivasi
@endcomponent

Salam Hormat,<br>
{{ config('app.name') }}
@endcomponent
