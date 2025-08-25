@extends('layout.app')

@section('content')
    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="w-full max-w-2xl bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-white/20 p-8 md:p-10">
            <div class="text-center mb-8">
                <h2
                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent mb-2">
                    Formulir Pendaftaran
                </h2>
                <p class="text-gray-600">Silakan lengkapi data Anda untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6">
                @csrf

                <!-- Personal Info Section -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Nama Lengkap
                                </span>
                            </label>
                            <input type="text"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50/50"
                                id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="flex-1">
                            <label for="nomor_telpon" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    Nomor Telepon
                                </span>
                            </label>
                            <input type="text"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50/50"
                                id="nomor_telpon" name="nomor_telpon" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                                Email
                            </span>
                        </label>
                        <input type="email"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50/50"
                            id="email" name="email" placeholder="nama@email.com" required>
                    </div>

                    <div>
                        <label for="institusi" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Institusi
                            </span>
                        </label>
                        <input type="text"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50/50"
                            id="institusi" name="institusi" placeholder="Nama universitas/sekolah/institusi" required>
                    </div>
                </div>

                <!-- Program Selection -->
                <div>
                    <label for="jenis_pendaftaran" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Jenis Pendaftaran
                        </span>
                    </label>
                    <select
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50/50 cursor-pointer"
                        id="jenis_pendaftaran" name="jenis_pendaftaran" required>
                        <option value="">-- Pilih Jenis Program --</option>
                        <option value="PKL">PKL (Praktik Kerja Lapangan)</option>
                        <option value="Magang Mandiri">Magang Mandiri</option>
                        <option value="Penelitian">Penelitian</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-l-4 border-blue-500 pl-3">Periode Kegiatan</h3>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Tanggal Mulai
                                </span>
                            </label>
                            <input type="date"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-200 bg-gray-50/50 cursor-pointer"
                                id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="flex-1">
                            <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Tanggal Selesai
                                </span>
                            </label>
                            <input type="date"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition-all duration-200 bg-gray-50/50 cursor-pointer"
                                id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-bold py-4 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl cursor-pointer">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Daftar Sekarang
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Enhanced form validation with SweetAlert2
        document.querySelector('form').addEventListener('submit', function(e) {
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');

            // Show loading state
            submitBtn.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                    Memproses...
                </span>
            `;
            submitBtn.disabled = true;

            // Simple client-side validation
            const requiredFields = form.querySelectorAll('input[required], select[required]');
            let hasError = false;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();

                Swal.fire({
                    title: 'Data Belum Lengkap',
                    html: `
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-2">Mohon lengkapi semua field yang diperlukan sebelum melanjutkan.</p>
                        </div>
                    `,
                    confirmButtonText: 'OK, Saya Mengerti',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white rounded-2xl shadow-xl border border-gray-100',
                        confirmButton: 'bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl'
                    }
                });

                // Reset button
                submitBtn.innerHTML = `
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Daftar Sekarang
                    </span>
                `;
                submitBtn.disabled = false;
            }
        });

        // Show validation errors if any
        @if ($errors->any())
            Swal.fire({
                title: 'Terdapat Kesalahan',
                html: `
                    <div class="text-left">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-red-400 to-red-600 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <ul class="text-sm text-gray-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 mt-0.5">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                `,
                confirmButtonText: 'Perbaiki Data',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white rounded-2xl shadow-xl border border-gray-100',
                    confirmButton: 'bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl'
                }
            });
        @endif

        // Show success message if session has success flash
        @if (session('success'))
            Swal.fire({
                title: '🎉 Pendaftaran Berhasil!',
                html: `
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-2 mt-3 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center animate-bounce">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Data Tersimpan Berhasil!</h3>
                        <p class="text-gray-600 mb-4">{{ session('success') }}</p>
                    </div>
                `,
                confirmButtonText: 'Tutup',
                allowOutsideClick: false,
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white rounded-2xl shadow-xl border border-gray-100 p-6',
                    title: 'text-2xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-4',
                    confirmButton: 'bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer'
                },
                backdrop: 'rgba(0,0,0,0.4)',
                timer: 10000,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then(() => {
                // Reset form after success
                document.querySelector('form').reset();
            });
        @endif
    </script>
@endsection
