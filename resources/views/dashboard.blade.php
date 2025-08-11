<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    @if($isKepalaBps || $isSuperadmin)
                    Dashboard Kepala BPS
                    @else
                    Dashboard
                    @endif
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if($isKepalaBps || $isSuperadmin)
                    Monitoring seluruh tim dan proyek
                    @else
                    Selamat datang, {{ Auth::user()->name }}
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($isKepalaBps || $isSuperadmin)
            {{-- Dashboard Kepala BPS --}}

            <!-- Statistik Cards untuk Kepala BPS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Tim -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-lg text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Tim</p>
                            <p class="text-3xl font-bold">{{ $totalTims }}</p>
                        </div>
                        <div class="bg-blue-400 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Proyek -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg shadow-lg text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Proyek</p>
                            <p class="text-3xl font-bold">{{ $totalProyeks }}</p>
                        </div>
                        <div class="bg-green-400 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg shadow-lg text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total Pegawai</p>
                            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-purple-400 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Nilai -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-lg shadow-lg text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Rata-rata Nilai</p>
                            <p class="text-3xl font-bold">{{ number_format($nilaiStatistics->rata_rata ?? 0, 1) }}</p>
                        </div>
                        <div class="bg-orange-400 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Performers & Need Attention -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Top Performers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Top Performers</h3>
                        <p class="text-green-100 text-sm">Proyek dengan progress tertinggi</p>
                    </div>
                    <div class="p-6">
                        @if($topPerformers->count() > 0)
                        <div class="space-y-4">
                            @foreach($topPerformers as $proyek)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $proyek['nama_proyek'] }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $proyek['tim_nama'] }}</p>
                                    <p class="text-xs text-gray-400">PIC: {{ $proyek['pic_nama'] }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600">{{ $proyek['progress'] }}%</div>
                                    <div class="text-xs text-gray-500">{{ $proyek['status'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">Belum ada data</p>
                        @endif
                    </div>
                </div>

                <!-- Need Attention -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Perlu Perhatian</h3>
                        <p class="text-red-100 text-sm">Proyek dengan progress rendah</p>
                    </div>
                    <div class="p-6">
                        @if($needAttention->count() > 0)
                        <div class="space-y-4">
                            @foreach($needAttention as $proyek)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $proyek['nama_proyek'] }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $proyek['tim_nama'] }}</p>
                                    <p class="text-xs text-gray-400">PIC: {{ $proyek['pic_nama'] }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-red-600">{{ $proyek['progress'] }}%</div>
                                    <div class="text-xs text-gray-500">{{ $proyek['status'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">Semua proyek berjalan baik</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistik Tim untuk Kepala BPS -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Statistik Tim</h3>
                    <p class="text-blue-100 text-sm">Overview semua tim</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Ketua Tim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Direktorat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Anggota</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($timStatistics as $tim)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $tim['tim_nama'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $tim['tim_kode'] }} ({{ $tim['tahun'] }})</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $tim['ketua_tim'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $tim['direktorat'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $tim['jumlah_anggota'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $tim['jumlah_proyek'] }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('detailtim', $tim['id']) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Semua Proyek untuk Kepala BPS -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Semua Proyek</h3>
                    <p class="text-purple-100 text-sm">Overview semua proyek dengan progress</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">PIC</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Progress</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($proyekWithProgress->sortByDesc('progress') as $proyek)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $proyek['nama_proyek'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $proyek['kode_proyek'] }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $proyek['tim_nama'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $proyek['tim_kode'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $proyek['pic_nama'] }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, $proyek['progress']) }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $proyek['progress'] }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                               @if($proyek['progress'] >= 90) bg-green-100 text-green-800
                                               @elseif($proyek['progress'] >= 70) bg-blue-100 text-blue-800
                                               @elseif($proyek['progress'] >= 30) bg-yellow-100 text-yellow-800
                                               @else bg-red-100 text-red-800
                                               @endif">
                                            {{ $proyek['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('detailproyek', $proyek['id']) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @else
            {{-- Dashboard User Biasa --}}

            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-blue-100 text-sm">Dashboard pribadi Anda</p>
                </div>
            </div>

            <!-- Tim yang Diikuti -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Tim yang Anda Ikuti</h3>
                    <p class="text-green-100 text-sm">{{ $userTims->count() }} Tim</p>
                </div>
                <div class="p-6">
                    @if($userTims->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($userTims as $tim)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900 dark:text-white">
                                    {{ $tim->masterTim->tim_nama }}
                                </h4>
                                @if($tim->tim_ketua == Auth::id())
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Ketua</span>
                                @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Anggota</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Kode:</strong> {{ $tim->masterTim->tim_kode }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Direktorat:</strong> {{ $tim->direktorat->nama }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Ketua Tim:</strong> {{ $tim->ketuaTim->name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Tahun:</strong> {{ $tim->tahun }}
                            </p>
                            <div class="mt-3">
                                <a href="{{ route('detailtim', $tim->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum bergabung dengan tim</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Hubungi admin untuk bergabung dengan tim.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Proyek Anda -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Proyek yang Anda Kerjakan</h3>
                    <p class="text-purple-100 text-sm">{{ $proyekWithProgress->count() }} Proyek</p>
                </div>
                <div class="p-6">
                    @if($proyekWithProgress->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Proyek</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">PIC</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Progress</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($proyekWithProgress as $proyek)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $proyek['nama_proyek'] }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $proyek['kode_proyek'] }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $proyek['jumlah_kegiatan'] }} kegiatan, {{ $proyek['jumlah_rincian_kegiatan'] }} rincian
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $proyek['pic_nama'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $proyek['progress'] }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $proyek['progress'] }}%</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Target: {{ $proyek['total_target'] }} | Realisasi: {{ $proyek['total_realisasi'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                       @if($proyek['progress'] >= 90) bg-green-100 text-green-800
                                                       @elseif($proyek['progress'] >= 70) bg-blue-100 text-blue-800
                                                       @elseif($proyek['progress'] >= 30) bg-yellow-100 text-yellow-800
                                                       @else bg-red-100 text-red-800
                                                       @endif">
                                            {{ $proyek['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('detailproyek', $proyek['id']) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada proyek</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum dialokasikan ke proyek manapun.</p>
                    </div>
                    @endif
                </div>
            </div>

            @endif

        </div>
    </div>
</x-app-layout>