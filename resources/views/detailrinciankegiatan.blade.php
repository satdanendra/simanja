<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Detail Rincian Kegiatan
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $rincianKegiatan->kegiatan->proyek->rkTim->tim->masterTim->tim_kode }} - {{ $rincianKegiatan->kegiatan->proyek->rkTim->tim->masterTim->tim_nama }} ({{ $rincianKegiatan->kegiatan->proyek->rkTim->tim->tahun }})
                    </p>
                </div>
            </div>
            <a href="{{ route('detailkegiatan', $rincianKegiatan->kegiatan_id) }}" class="flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali ke Detail Kegiatan
            </a>
        </div>
    </x-slot>

    <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 hidden"></div>

    <div class="py-6">
        @if(session('success'))
        <div id="success-popup" class="fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-3 rounded-md shadow-lg flex items-center transition-all duration-300 transform translate-x-0">
            <div class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span class="font-medium">Berhasil!</span>
                <span class="block sm:inline ml-1">{{ session('success') }}</span>
            </div>
            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="closeSuccessPopup()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div id="error-popup" class="fixed top-4 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-3 rounded-md shadow-lg flex items-center transition-all duration-300 transform translate-x-0">
            <div class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span class="font-medium">Error!</span>
                <span class="block sm:inline ml-1">{{ session('error') }}</span>
            </div>
            <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="closeErrorPopup()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Rincian Kegiatan Detail Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center text-white">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Detail Rincian Kegiatan</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Path information -->
                    <!-- <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Path Kegiatan</p>
                                <p class="text-sm mt-1">
                                    <span class="font-semibold">RK Tim:</span> {{ $rincianKegiatan->kegiatan->proyek->rkTim->masterRkTim->rk_tim_kode }} - {{ $rincianKegiatan->kegiatan->proyek->rkTim->masterRkTim->rk_tim_urai }}<br>
                                    <span class="font-semibold">Proyek:</span> {{ $rincianKegiatan->kegiatan->proyek->masterProyek->proyek_kode }} - {{ $rincianKegiatan->kegiatan->proyek->masterProyek->proyek_urai }}<br>
                                    <span class="font-semibold">Kegiatan:</span> {{ $rincianKegiatan->kegiatan->masterKegiatan->kegiatan_kode }} - {{ $rincianKegiatan->kegiatan->masterKegiatan->kegiatan_urai }}
                                </p>
                            </div>
                        </div>
                    </div> -->

                    <!-- Detail information -->
                    <ul class="space-y-4">
                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Kode Rincian Kegiatan</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_kode }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Uraian Rincian Kegiatan</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Volume Total</div>
                            <div class="w-2/3">
                                <span class="text-gray-900 dark:text-white font-semibold">{{ $rincianKegiatan->volume ?? '0' }}</span>
                                <span class="text-gray-500 ml-1">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                            </div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Total Teralokasi</div>
                            <div class="w-2/3">
                                <span class="text-gray-900 dark:text-white font-semibold">{{ $totalAllocated }}</span>
                                <span class="text-gray-500 ml-1">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                            </div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Sisa Volume</div>
                            <div class="w-2/3">
                                <span class="text-gray-900 dark:text-white font-semibold">{{ $remainingVolume }}</span>
                                <span class="text-gray-500 ml-1">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                            </div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Waktu Standar</div>
                            <div class="w-2/3">
                                <span class="text-gray-900 dark:text-white font-semibold">{{ $rincianKegiatan->waktu ?? '0' }}</span>
                                <span class="text-gray-500 ml-1">jam</span>
                            </div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Deadline</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">
                                @if($rincianKegiatan->deadline)
                                {{ $rincianKegiatan->deadline->format('d F Y') }}
                                @else
                                <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Catatan</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">
                                {{ $rincianKegiatan->masterRincianKegiatan->catatan ?: 'Tidak ada catatan' }}
                            </div>
                        </li>

                        <li class="flex">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Variabel Kontrol</div>
                            <div class="w-2/3">
                                @if($rincianKegiatan->is_variabel_kontrol)
                                <span class="px-2 inline-flex text-m leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                @else
                                <span class="px-2 inline-flex text-m leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Allocation Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex items-center text-white mb-4 md:mb-0">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Alokasi Rincian Kegiatan</h3>
                                <p class="text-blue-100 text-sm">{{ count($existingAllocations) }} Alokasi</p>
                            </div>
                        </div>
                        <button
                            data-modal-target="tambahAlokasiModal"
                            data-modal-toggle="tambahAlokasiModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out"
                            {{ $remainingVolume <= 0 ? 'disabled' : '' }}
                            {{ $remainingVolume <= 0 ? 'title=Volume sudah teralokasi sepenuhnya' : '' }}
                            {{ $remainingVolume <= 0 ? 'class=flex items-center px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Alokasi
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    @if(count($existingAllocations) > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Pelaksana</th>
                                    <th scope="col" class="px-6 py-3">Target</th>
                                    <th scope="col" class="px-6 py-3">Realisasi</th>
                                    <th scope="col" class="px-6 py-3">Progress</th>
                                    <th scope="col" class="px-6 py-3">Bukti Dukung</th>
                                    <th scope="col" class="px-6 py-3">Laporan Harian</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($existingAllocations as $alokasi)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                {{ strtoupper(substr($alokasi->pelaksana->name, 0, 1)) }}
                                            </div>
                                            <span class="ml-3">{{ $alokasi->pelaksana->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium">{{ $alokasi->target }}</span>
                                        <span class="text-gray-500">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium">{{ $alokasi->realisasi ?? 0 }}</span>
                                        <span class="text-gray-500">{{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                        $percent = ($alokasi->target > 0) ? min(100, ($alokasi->realisasi / $alokasi->target) * 100) : 0;
                                        @endphp
                                        <span class="font-medium">{{ number_format($percent, 1) }}%</span>
                                    </td>
                                    <!-- Bukti Dukung column -->
                                    <td class="px-6 py-4">
                                        <a href="{{ route('detailbuktidukung', $rincianKegiatan->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat ({{ $rincianKegiatan->buktiDukungs->count() }})
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                        $laporanHarianCount = $rincianKegiatan->laporanHarians()
                                        ->where('user_id', $alokasi->pelaksana_id)
                                        ->count();
                                        $userHasAlokasi = $alokasi->pelaksana_id == Auth::id();
                                        @endphp

                                        @if($laporanHarianCount > 0)
                                        <a href="{{ route('laporanharian') }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat
                                        </a>
                                        @if($userHasAlokasi)
                                        <a href="{{ route('laporan-harian.create', $rincianKegiatan->id) }}"
                                            class="inline-flex items-center text-green-600 hover:text-green-800 dark:text-green-400 ml-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Buat
                                        </a>
                                        @endif
                                        @else
                                        @if($userHasAlokasi)
                                        <a href="{{ route('laporan-harian.create', $rincianKegiatan->id) }}"
                                            class="inline-flex items-center text-green-600 hover:text-green-800 dark:text-green-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Buat
                                        </a>
                                        @else
                                        <span class="text-gray-500">Belum ada</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button
                                            data-modal-target="editAlokasiModal"
                                            data-modal-toggle="editAlokasiModal"
                                            data-alokasi-id="{{ $alokasi->id }}"
                                            data-pelaksana-id="{{ $alokasi->pelaksana_id }}"
                                            data-pelaksana-name="{{ $alokasi->pelaksana->name }}"
                                            data-target="{{ $alokasi->target }}"
                                            data-realisasi="{{ $alokasi->realisasi }}"
                                            data-bukti-dukung-file-id="{{ $alokasi->bukti_dukung_file_id }}"
                                            data-bukti-dukung-file-name="{{ $alokasi->bukti_dukung_file_name }}"
                                            data-bukti-dukung-link="{{ $alokasi->bukti_dukung_link }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2 edit-alokasi-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('alokasi.destroy', $alokasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alokasi ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 p-12">
                        <div class="h-16 w-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada alokasi</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">Rincian kegiatan ini belum memiliki alokasi. Tambahkan alokasi untuk menetapkan volume tugas kepada anggota tim.</p>
                        <button data-modal-target="tambahAlokasiModal" data-modal-toggle="tambahAlokasiModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out" {{ $remainingVolume <= 0 ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Alokasi
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Alokasi -->
    <div id="tambahAlokasiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Alokasi
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahAlokasiModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <!-- Ringkasan Volume -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Informasi Volume</p>
                                <p class="text-sm">
                                    Volume Total: <span class="font-semibold">{{ $rincianKegiatan->volume ?? '0' }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span><br>
                                    Volume Teralokasi: <span class="font-semibold">{{ $totalAllocated }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span><br>
                                    Sisa Volume: <span class="font-semibold">{{ $remainingVolume }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('alokasi.store', $rincianKegiatan->id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="pelaksana_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Pelaksana</label>
                                <select name="pelaksana_id" id="pelaksana_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                    <option value="">-- Pilih Pelaksana --</option>
                                    @foreach($timMembers as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="target" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Target Volume</label>
                                <div class="flex">
                                    <input type="number" step="0.01" min="0.01" max="{{ $remainingVolume }}" name="target" id="target" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan target volume" required>
                                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                        {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Maksimal target: {{ $remainingVolume }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" data-modal-hide="tambahAlokasiModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                Batal
                            </button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Alokasi -->
    <div id="editAlokasiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Alokasi
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editAlokasiModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <!-- Ringkasan Volume -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Informasi Volume</p>
                                <p class="text-sm">
                                    Volume Total: <span class="font-semibold">{{ $rincianKegiatan->volume ?? '0' }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span><br>
                                    Volume Teralokasi: <span class="font-semibold">{{ $totalAllocated }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span><br>
                                    Sisa Volume: <span class="font-semibold">{{ $remainingVolume }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="editAlokasiForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_pelaksana" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pelaksana</label>
                                <input type="text" id="edit_pelaksana" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" disabled>
                            </div>

                            <div>
                                <label for="edit_target" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Target Volume</label>
                                <div class="flex">
                                    <input type="number" step="0.01" min="0.01" name="target" id="edit_target" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                        {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}
                                    </span>
                                </div>
                                <p id="edit_max_target" class="mt-1 text-sm text-gray-500"></p>
                            </div>

                            <div>
                                <label for="edit_realisasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Realisasi Volume</label>
                                <div class="flex">
                                    <input type="number" step="0.01" min="0" name="realisasi" id="edit_realisasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                        {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}
                                    </span>
                                </div>
                                <p class="mt-1 mb-4 text-sm text-gray-500">Masukkan nilai yang sudah terealisasi</p>
                            </div>

                            <!-- <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">Upload Bukti Dukung</label>
                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file" name="file" type="file">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Format file berupa gambar/dokumen</p>

                                Display current file if exists
                                <div id="current_file_container" class="mt-3 hidden">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">File Bukti Dukung Saat Ini:</p>
                                    <div class="flex items-center mt-1 p-2 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <a id="current_file_link" href="#" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 hover:underline truncate max-w-xs"></a>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Upload file baru akan menggantikan file yang ada</p>
                                </div>
                            </div> -->
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" data-modal-hide="editAlokasiModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                Batal
                            </button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBackdrop = document.getElementById('modalBackdrop');

            // Fungsi untuk membuka modal
            function openModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.remove("hidden");
                    targetModal.classList.add("flex", "animate-fadeIn");
                    modalBackdrop.classList.remove("hidden");
                }
            }

            // Fungsi untuk menutup modal
            function closeModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.add('animate-fadeOut');

                    setTimeout(() => {
                        targetModal.classList.remove('animate-fadeIn', 'animate-fadeOut');
                        targetModal.classList.add('hidden');
                        targetModal.classList.remove('flex');
                        modalBackdrop.classList.add('hidden');
                    }, 200);
                }
            }

            // Handle Edit Alokasi
            const editAlokasiButtons = document.querySelectorAll('.edit-alokasi-btn');
            const editAlokasiForm = document.getElementById('editAlokasiForm');

            if (editAlokasiButtons.length > 0 && editAlokasiForm) {
                editAlokasiButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const alokasiId = this.getAttribute('data-alokasi-id');
                        const pelaksanaName = this.getAttribute('data-pelaksana-name');
                        const target = this.getAttribute('data-target');
                        const realisasi = this.getAttribute('data-realisasi');
                        const currentRemainingVolume = parseFloat('{{ $remainingVolume }}');
                        const maxTarget = parseFloat(target) + currentRemainingVolume;

                        // Update form action
                        editAlokasiForm.action = `/alokasi/${alokasiId}`;

                        // Fill form fields
                        document.getElementById('edit_pelaksana').value = pelaksanaName;
                        document.getElementById('edit_target').value = target;
                        document.getElementById('edit_target').max = maxTarget;
                        document.getElementById('edit_realisasi').value = realisasi;
                        document.getElementById('edit_realisasi').max = target;

                        // Update max target text
                        //document.getElementById('edit_max_target').textContent = `Nilai maksimal: ${maxTarget} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}`;

                        // Check if file exists
                        fetch(`/api/alokasi/${alokasiId}/file-info`)
                            .then(response => response.json())
                            .then(data => {
                                const fileContainer = document.getElementById('current_file_container');
                                const fileLink = document.getElementById('current_file_link');

                                if (data.has_file) {
                                    fileContainer.classList.remove('hidden');
                                    fileLink.href = data.file_link;
                                    fileLink.textContent = data.file_name;
                                } else {
                                    fileContainer.classList.add('hidden');
                                }
                            })
                            .catch(error => console.error('Error fetching file info:', error));

                        // Check and display file information
                        const buktiDukungFileId = this.getAttribute('data-bukti-dukung-file-id');
                        const buktiDukungFileName = this.getAttribute('data-bukti-dukung-file-name');
                        const buktiDukungLink = this.getAttribute('data-bukti-dukung-link');

                        const fileContainer = document.getElementById('current_file_container');
                        const fileLink = document.getElementById('current_file_link');

                        if (buktiDukungFileId) {
                            fileContainer.classList.remove('hidden');
                            fileLink.href = buktiDukungLink;
                            fileLink.textContent = buktiDukungFileName;
                        } else {
                            fileContainer.classList.add('hidden');
                        }
                    });
                });
            }

            // Modal functions for opens and closes
            const modalButtons = document.querySelectorAll('[data-modal-toggle]');
            const modalCloseButtons = document.querySelectorAll('[data-modal-hide]');

            modalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetModalId = button.getAttribute('data-modal-target');
                    const targetModal = document.getElementById(targetModalId);
                    openModal(targetModal);
                });
            });

            modalCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetModal = button.closest('.fixed.top-0.left-0.right-0.z-50');
                    closeModal(targetModal);
                });
            });

            // Close modal when clicking outside the modal content
            const modals = document.querySelectorAll('.z-50.fixed');
            modals.forEach(modal => {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            // Add keydown event for Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    modals.forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            closeModal(modal);
                        }
                    });
                }
            });

            // Handle success popup
            function closeSuccessPopup() {
                const popup = document.getElementById('success-popup');
                if (popup) {
                    // Add slide-out animation
                    popup.classList.add('transform', 'translate-x-full');
                    popup.classList.add('opacity-0');

                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 300);
                }
            }

            // Handle error popup
            function closeErrorPopup() {
                const popup = document.getElementById('error-popup');
                if (popup) {
                    // Add slide-out animation
                    popup.classList.add('transform', 'translate-x-full');
                    popup.classList.add('opacity-0');

                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 300);
                }
            }

            // Make closeSuccessPopup and closeErrorPopup functions global
            window.closeSuccessPopup = closeSuccessPopup;
            window.closeErrorPopup = closeErrorPopup;

            // Auto close popups after 5 seconds
            const successPopup = document.getElementById('success-popup');
            if (successPopup) {
                setTimeout(() => {
                    closeSuccessPopup();
                }, 5000);
            }

            const errorPopup = document.getElementById('error-popup');
            if (errorPopup) {
                setTimeout(() => {
                    closeErrorPopup();
                }, 5000);
            }
        });
    </script>

    <style>
        /* Animation classes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out forwards;
        }

        .animate-fadeOut {
            animation: fadeOut 0.2s ease-in forwards;
        }
    </style>
</x-app-layout>