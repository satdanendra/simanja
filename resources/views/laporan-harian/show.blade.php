<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Laporan Harian') }}
            </h2>
            <div class="flex space-x-2">
                @if($laporan->isPdfReady())
                    <a href="{{ route('laporan-harian.download', $laporan->id) }}" 
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </a>
                @endif
                <a href="{{ route('laporanharian') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header Info -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Informasi Laporan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p><strong>Proyek:</strong> {{ $laporan->proyek->masterProyek->proyek_urai }}</p>
                                <p><strong>Rincian Kegiatan:</strong> {{ $laporan->rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai }}</p>
                                <p><strong>Pembuat:</strong> {{ $laporan->user->name }}</p>
                            </div>
                            <div>
                                <p><strong>Tanggal:</strong> {{ $laporan->formatted_tanggal }}</p>
                                <p><strong>Waktu:</strong> {{ $laporan->formatted_waktu }}</p>
                                <p><strong>Dibuat:</strong> {{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Identitas Pegawai -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Identitas Pegawai</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Nama Pegawai:</p>
                                    <p class="font-medium">{{ strtoupper($laporan->user->name) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">NIP:</p>
                                    <p class="font-medium">
                                        Lama: {{ $laporan->user->nip_lama ?? '-' }} | 
                                        Baru: {{ $laporan->user->nip_baru ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan & Capaian -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Kegiatan & Capaian</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Kegiatan:</p>
                                    <p class="font-medium">{{ $laporan->kegiatan_deskripsi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Capaian:</p>
                                    <p class="font-medium">{{ $laporan->capaian }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dasar Pelaksanaan -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Dasar Pelaksanaan Kegiatan</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            @if(!empty($laporan->dasar_pelaksanaan))
                                <ol class="list-decimal list-inside space-y-2">
                                    @foreach($laporan->dasar_pelaksanaan as $dasar)
                                        <li class="text-sm">
                                            {{ $dasar['deskripsi'] }}
                                            @if($dasar['is_terlampir'])
                                                <span class="text-blue-600 font-medium">(terlampir)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-gray-500 italic">Tidak ada dasar pelaksanaan</p>
                            @endif
                        </div>
                    </div>

                    <!-- Bukti Dukung -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Bukti Pelaksanaan Pekerjaan</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            @php $buktiDukungs = $laporan->getBuktiDukungs(); @endphp
                            
                            @if($buktiDukungs->count() > 0)
                                <div class="space-y-3">
                                    @foreach($buktiDukungs as $bukti)
                                        <div class="flex items-center space-x-3 p-3 bg-white dark:bg-gray-600 rounded border">
                                            @if($bukti->isImage())
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            @endif
                                            <div class="flex-1">
                                                <p class="font-medium text-sm">
                                                    {{ $bukti->urutan_laporan }}. {{ $bukti->nama_file }}
                                                    <span class="text-blue-600">(Lampiran {{ $bukti->urutan_laporan }})</span>
                                                </p>
                                                @if($bukti->keterangan)
                                                    <p class="text-xs text-gray-500">{{ $bukti->keterangan }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">Tidak ada bukti dukung</p>
                            @endif
                        </div>
                    </div>

                    <!-- Kendala & Solusi -->
                    @if($laporan->kendala || $laporan->solusi)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Kendala & Solusi</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Kendala/Permasalahan:</p>
                                    <p class="font-medium">{{ $laporan->kendala ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Solusi:</p>
                                    <p class="font-medium">{{ $laporan->solusi ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan -->
                    @if($laporan->catatan)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3 text-green-600">Catatan</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="font-medium">{{ $laporan->catatan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- PDF Status -->
                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Status PDF:</p>
                                @if($laporan->isPdfReady())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Siap untuk diunduh
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Sedang diproses...
                                    </span>
                                @endif
                            </div>
                            
                            @if($laporan->isPdfReady())
                                <div class="flex space-x-2">
                                    <a href="{{ route('laporan-harian.create', $laporan->rincianKegiatan->id) }}" 
                                       class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Generate Ulang
                                    </a>
                                    <a href="{{ route('laporan-harian.download', $laporan->id) }}" 
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Download PDF
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>