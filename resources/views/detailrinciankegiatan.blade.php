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
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded">
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
                    </div>

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
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
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
                            {{ $remainingVolume <= 0 ? 'class=flex items-center px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed' : '' }}
                        >
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
                                            $color =