@props(['status'])
@php
    $warna = match ($status) {
        'tersedia', 'disetujui' => 'bg-green-100 text-green-800',
        'menunggu'              => 'bg-yellow-100 text-yellow-800',
        'ditolak'               => 'bg-red-100 text-red-800',
        'teradopsi'             => 'bg-indigo-100 text-indigo-800',
        default                 => 'bg-gray-100 text-gray-700',
    };
@endphp
<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $warna }}">{{ ucfirst($status) }}</span>
