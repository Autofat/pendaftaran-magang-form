@extends('layout.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent mb-2">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-600">Kelola data pendaftar magang Kementerian Kesehatan</p>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
                </div>
                <div class="flex gap-3">
                    <!-- Add Admin Button -->
                    <a href="{{ route('admin.register') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Status Keaktifan Chart -->
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-white/20 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status Keaktifan Peserta
                </h2>

                <!-- Simple Bar Chart -->
                @if ($totalCount > 0)
                    <div class="space-y-4">
                        @php
                            $maxStatus = max($activeCount, $inactiveCount);
                            $statusData = [
                                'Sedang Aktif' => $activeCount,
                                'Sudah Selesai' => $inactiveCount,
                            ];
                            $statusColors = [
                                'Sedang Aktif' => 'bg-green-500',
                                'Sudah Selesai' => 'bg-red-500',
                            ];
                        @endphp

                        @foreach ($statusData as $status => $count)
                            <div class="flex items-center gap-4">
                                <div class="w-24 text-sm font-medium text-gray-700">{{ $status }}</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-8 relative overflow-hidden">
                                    @if ($count > 0)
                                        <div class="{{ $statusColors[$status] }} h-full rounded-full transition-all duration-1000 flex items-center justify-end pr-3"
                                            style="width: {{ $maxStatus > 0 ? ($count / $maxStatus) * 100 : 0 }}%">
                                            <span class="text-white text-sm font-bold">{{ $count }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State for Chart -->
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data</h3>
                        <p class="text-gray-500 text-center">Chart akan muncul setelah ada peserta yang mendaftar.</p>
                    </div>
                @endif

                <!-- Total -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Total Status:</span>
                        <span class="text-2xl font-bold text-green-600">{{ $totalCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Program Distribution Chart -->
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-white/20 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Distribusi Program Magang
                </h2>

                <!-- Simple Donut Chart Alternative -->
                @if ($totalCount > 0)
                    <div class="flex justify-center mb-6">
                        <div class="relative w-48 h-48" id="chart-container">
                            <!-- Background Circle -->
                            <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="#e5e7eb" stroke-width="10"
                                    fill="none"></circle>

                                @php
                                    $circumference = 2 * M_PI * 40;
                                    $pklPercentage = ($stats['PKL'] / $totalCount) * 100;
                                    $magangPercentage = ($stats['Magang Mandiri'] / $totalCount) * 100;
                                    $penelitianPercentage = ($stats['Penelitian'] / $totalCount) * 100;

                                    $pklStrokeDasharray = ($pklPercentage / 100) * $circumference;
                                    $magangStrokeDasharray = ($magangPercentage / 100) * $circumference;
                                    $penelitianStrokeDasharray = ($penelitianPercentage / 100) * $circumference;

                                    $pklOffset = 0;
                                    $magangOffset = -$pklStrokeDasharray;
                                    $penelitianOffset = -($pklStrokeDasharray + $magangStrokeDasharray);
                                @endphp

                                <!-- PKL Arc -->
                                @if ($stats['PKL'] > 0)
                                    <circle cx="50" cy="50" r="40" stroke="#3b82f6" stroke-width="10"
                                        fill="none" stroke-dasharray="{{ $pklStrokeDasharray }} {{ $circumference }}"
                                        stroke-dashoffset="{{ $pklOffset }}"
                                        class="transition-all duration-1000 hover:stroke-blue-600"></circle>
                                @endif

                                <!-- Magang Mandiri Arc -->
                                @if ($stats['Magang Mandiri'] > 0)
                                    <circle cx="50" cy="50" r="40" stroke="#10b981" stroke-width="10"
                                        fill="none"
                                        stroke-dasharray="{{ $magangStrokeDasharray }} {{ $circumference }}"
                                        stroke-dashoffset="{{ $magangOffset }}"
                                        class="transition-all duration-1000 hover:stroke-green-600"></circle>
                                @endif

                                <!-- Penelitian Arc -->
                                @if ($stats['Penelitian'] > 0)
                                    <circle cx="50" cy="50" r="40" stroke="#8b5cf6" stroke-width="10"
                                        fill="none"
                                        stroke-dasharray="{{ $penelitianStrokeDasharray }} {{ $circumference }}"
                                        stroke-dashoffset="{{ $penelitianOffset }}"
                                        class="transition-all duration-1000 hover:stroke-purple-600"></circle>
                                @endif
                            </svg>

                            <!-- Center Text -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $totalCount }}</div>
                                    <div class="text-sm text-gray-500">Total</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legend untuk Chart Lingkaran -->
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">Keterangan Program Magang</h4>
                        <div class="flex justify-center gap-6">
                            <!-- PKL -->
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ $stats['PKL'] }}
                                </div>
                                <span class="text-sm text-gray-700">PKL</span>
                            </div>

                            <!-- Magang Mandiri -->
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ $stats['Magang Mandiri'] }}
                                </div>
                                <span class="text-sm text-gray-700">Magang Mandiri</span>
                            </div>

                            <!-- Penelitian -->
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ $stats['Penelitian'] }}
                                </div>
                                <span class="text-sm text-gray-700">Penelitian</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State for Donut Chart -->
                    <div class="flex justify-center mb-6">
                        <div class="relative w-48 h-48 flex items-center justify-center">
                            <!-- Empty Circle -->
                            <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="#e5e7eb" stroke-width="10"
                                    fill="none"></circle>
                            </svg>

                            <!-- Center Text -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-sm text-gray-500">Belum Ada<br>Data</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legend untuk Chart Lingkaran -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="flex items-center justify-center p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-600">PKL</div>
                                    <div class="text-sm font-bold text-blue-600">{{ $stats['PKL'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-600">Magang</div>
                                    <div class="text-sm font-bold text-green-600">{{ $stats['Magang Mandiri'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-3 bg-purple-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-600">Penelitian</div>
                                    <div class="text-sm font-bold text-purple-600">{{ $stats['Penelitian'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pricing Info -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 border border-blue-200/50 rounded-2xl p-6 shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                    </path>
                </svg>
                Informasi Biaya
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-white/70 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="font-semibold text-gray-700">PKL & Penelitian:</span>
                        <span class="font-bold text-blue-600 text-lg">Rp110.000</span>
                        <span class="text-sm text-gray-500">/ 31 hari</span>
                    </div>
                </div>
                <div class="bg-white/70 rounded-xl p-4 border border-green-100">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="font-semibold text-gray-700">Magang Mandiri:</span>
                        <span class="font-bold text-green-600 text-lg">Rp1.100.000</span>
                        <span class="text-sm text-gray-500">/ 31 hari</span>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-600 mt-3 bg-white/50 rounded-lg p-2">
                💡 Pembayaran dihitung berdasarkan periode tanggal mulai hingga tanggal selesai, dengan minimal 31 hari.
            </p>
        </div>

        <!-- Data Table -->
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        class="w-6 h-6">
                        <g fill="none" stroke="#2563eb" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </g>
                    </svg>
                    Data Pendaftar
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">No</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Nama Lengkap</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Telepon</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Institusi</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Program</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Periode</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold whitespace-nowrap">Biaya</th>
                            <th class="py-3 px-6 text-center text-sm font-semibold whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pesertas as $peserta)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200">

                                <td class="py-3 px-6 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $peserta->nama_lengkap }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-gray-700">
                                    {{ $peserta->nomor_telpon }}
                                </td>
                                <td class="py-3 px-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $peserta->institusi }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    @php
                                        $badgeColor = match ($peserta->jenis_pendaftaran) {
                                            'PKL' => 'bg-blue-100 text-blue-800',
                                            'Magang Mandiri' => 'bg-green-100 text-green-800',
                                            'Penelitian' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                        {{ $peserta->jenis_pendaftaran }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="text-sm">
                                        <div class="text-gray-900 font-medium">
                                            {{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d M Y') }}</div>
                                        <div class="text-gray-500">s/d
                                            {{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d M Y') }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                        Rp{{ number_format($peserta->biaya, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <button
                                        onclick="confirmDelete('{{ $peserta->id }}', '{{ $peserta->nama_lengkap }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full transition-colors duration-200 group cursor-pointer">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Hidden form for deletion -->
                                    <form id="delete-form-{{ $peserta->id }}"
                                        action="{{ route('peserta.destroy', $peserta->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-4">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada pendaftar</h3>
                                            <p class="text-gray-500">Data pendaftar akan muncul di sini setelah ada yang
                                                mendaftar.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // SweetAlert2 Custom Theme Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            color: 'white',
            iconColor: 'white',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Function to confirm deletion with custom SweetAlert2
        function confirmDelete(pesertaId, pesertaNama) {
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                html: `
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-red-400 to-red-600 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-2">Apakah Anda yakin ingin menghapus data peserta:</p>
                    <p class="font-bold text-lg text-gray-800">${pesertaNama}?</p>
                    <p class="text-sm text-red-500 mt-2">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white rounded-2xl shadow-xl border border-gray-100',
                    title: 'text-2xl font-bold text-gray-800 mb-4',
                    confirmButton: 'bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer',
                    cancelButton: 'bg-gradient-to-r from-gray-400 to-gray-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-gray-500 hover:to-gray-600 transition-all duration-200 shadow-lg hover:shadow-xl ml-4 cursor-pointer',
                    actions: 'mt-6 gap-10 flex justify-center'
                },
                backdrop: 'rgba(0,0,0,0.4)',
                allowOutsideClick: false,
                allowEscapeKey: false,
                focusConfirm: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Menghapus Data...',
                        html: `
                        <div class="text-center">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-gradient-to-r from-blue-500 to-green-500"></div>
                            <p class="mt-4 text-gray-600">Sedang memproses penghapusan data</p>
                        </div>
                    `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'bg-white rounded-2xl shadow-xl border border-gray-100'
                        }
                    });

                    // Submit the form
                    document.getElementById('delete-form-' + pesertaId).submit();
                }
            });
        }

        // Success message if session has success flash
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                background: 'linear-gradient(135deg, #10b981 0%, #065f46 100%)',
            });
        @endif

        // Error message if session has error flash
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                background: 'linear-gradient(135deg, #ef4444 0%, #7f1d1d 100%)',
            });
        @endif
    </script>

@endsection
