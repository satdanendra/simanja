<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif

                    @if ($laporanHarians->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum Ada Laporan Harian</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Anda belum membuat laporan harian. Buat laporan harian dari halaman detail rincian kegiatan.</p>
                        <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v1H8V5z"></path>
                            </svg>
                            Ke Dashboard
                        </a>
                    </div>
                    @else
                    <div class="space-y-6">
                        @foreach ($laporanHarians as $laporan)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                            <!-- Header -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                                <div class="mb-2 md:mb-0">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $laporan->proyek->masterProyek->proyek_urai }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $laporan->rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    @if($laporan->isPdfReady())
                                        <a href="{{ route('laporan-harian.download', $laporan->id) }}" 
                                           class="bg-green-500 hover:bg-green-700 text-white text-sm px-3 py-1 rounded inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download PDF
                                        </a>
                                        <a href="{{ route('laporan-harian.show', $laporan->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="bg-yellow-500 text-white text-sm px-3 py-1 rounded">
                                            PDF sedang diproses...
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('laporan-harian.create', $laporan->rincianKegiatan->id) }}" 
                                       class="bg-orange-500 hover:bg-orange-700 text-white text-sm px-3 py-1 rounded inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Generate Ulang
                                    </a>
                                    
                                    <!-- <button onclick="deleteLaporan({{ $laporan->id }})" 
                                            class="bg-red-500 hover:bg-red-700 text-white text-sm px-3 py-1 rounded inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button> -->
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Tanggal:</p>
                                    <p class="font-medium">{{ $laporan->formatted_tanggal }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Waktu:</p>
                                    <p class="font-medium">{{ $laporan->formatted_waktu }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Dibuat:</p>
                                    <p class="font-medium">{{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Kegiatan & Capaian -->
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Kegiatan:</p>
                                    <p class="font-medium">{{ Str::limit($laporan->kegiatan_deskripsi, 100) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Capaian:</p>
                                    <p class="font-medium">{{ Str::limit($laporan->capaian, 100) }}</p>
                                </div>
                            </div>

                            <!-- Bukti Dukung Count -->
                            @if($laporan->bukti_dukung_ids && count($laporan->bukti_dukung_ids) > 0)
                            <div class="mt-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ count($laporan->bukti_dukung_ids) }} Bukti Dukung
                                </span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $laporanHarians->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2">Hapus Laporan Harian</h3>
                <p class="text-sm text-gray-500 mt-2">
                    Apakah Anda yakin ingin menghapus laporan harian ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Hapus
                    </button>
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function deleteLaporan(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteId) {
                fetch(`/laporan-harian/${deleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan saat menghapus laporan harian.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus laporan harian.');
                });
            }
            closeDeleteModal();
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>