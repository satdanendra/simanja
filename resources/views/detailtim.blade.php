<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $tim->masterTim->tim_kode }} - {{ $tim->masterTim->tim_nama }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tahun {{ $tim->tahun }}
                    </p>
                </div>
            </div>
            <a href="{{ route('tim') }}" class="flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali ke Daftar Tim
            </a>
        </div>
    </x-slot>

    <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 hidden"></div>

    <!-- Anggota Card -->
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <!-- Team Overview Card -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex items-center text-white mb-4 md:mb-0">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Daftar Anggota Tim</h3>
                                <p class="text-blue-100 text-sm">{{ $tim->users->count() }} Anggota</p>
                            </div>
                        </div>
                        <button
                            data-modal-target="tambahAnggotaModal"
                            data-modal-toggle="tambahAnggotaModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Anggota
                        </button>
                    </div>
                </div>

                <!-- Team Members List -->
                <div class="p-6">
                    @if($tim->users->count() > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nama</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">NIP Lama</th>
                                    <th scope="col" class="px-6 py-4">NIP Baru</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tim->users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm">{{ $user->nip_lama ?: '-' }}</td>
                                    <td class="px-6 py-4 font-mono text-sm">{{ $user->nip_baru ?: '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('tim.anggota.destroy', ['tim' => $tim->id, 'user' => $user->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini dari tim?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada anggota</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">Tim ini belum memiliki anggota. Tambahkan anggota untuk mulai berkolaborasi dan mengelola pekerjaan bersama.</p>
                        <button data-modal-target="tambahAnggotaModal" data-modal-toggle="tambahAnggotaModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Anggota Tim
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- RK Tim Card -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <!-- RK Tim Overview Card -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex items-center text-white mb-4 md:mb-0">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Daftar RK Tim</h3>
                                <p class="text-blue-100 text-sm">{{ isset($rkTims) ? count($rkTims) : 0 }} RK Tim</p>
                            </div>
                        </div>
                        <button
                            data-modal-target="tambahRkTimModal"
                            data-modal-toggle="tambahRkTimModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah RK Tim
                        </button>
                    </div>
                </div>

                <!-- RK Tim List -->
                <div class="p-6">
                    @if(isset($rkTims) && count($rkTims) > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Kode RK Tim</th>
                                    <th scope="col" class="px-6 py-4">Uraian RK Tim</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rkTims as $rkTim)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <!-- Bagian dalam table di detailtim.blade.php, di kolom kode RK Tim dan Uraian RK Tim -->
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('detailrktim', $rkTim->id) }}" class="hover:text-blue-600 hover:underline">
                                            {{ $rkTim->masterRkTim->rk_tim_kode }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('detailrktim', $rkTim->id) }}" class="hover:text-blue-600 hover:underline">
                                            {{ $rkTim->masterRkTim->rk_tim_urai }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button
                                            data-modal-target="editRkTimModal"
                                            data-modal-toggle="editRkTimModal"
                                            data-rktim-id="{{ $rkTim->id }}"
                                            data-rktim-kode="{{ $rkTim->rk_tim_kode }}"
                                            data-rktim-urai="{{ $rkTim->rk_tim_urai }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2 edit-rktim-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('tim.rktim.destroy', ['tim' => $tim->id, 'rktim' => $rkTim->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus RK Tim ini?')" class="inline">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada RK Tim</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">Tim ini belum memiliki RK Tim. Tambahkan RK Tim untuk mulai mengelola pekerjaan.</p>
                        <button data-modal-target="tambahRkTimModal" data-modal-toggle="tambahRkTimModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah RK Tim
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <!-- Proyek Overview Card -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex items-center text-white mb-4 md:mb-0">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Daftar Proyek</h3>
                                <p class="text-blue-100 text-sm">{{ isset($proyeks) ? count($proyeks) : 0 }} Proyek</p>
                            </div>
                        </div>
                        <button
                            data-modal-target="tambahProyekModal"
                            data-modal-toggle="tambahProyekModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Proyek
                        </button>
                    </div>
                </div>

                <!-- Proyek List -->
                <div class="p-6">
                    @if(isset($proyeks) && count($proyeks) > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Kode RK Tim</th>
                                    <th scope="col" class="px-6 py-4">Kode Proyek</th>
                                    <th scope="col" class="px-6 py-4">Uraian Proyek</th>
                                    <th scope="col" class="px-6 py-4">IKU Terkait</th>
                                    <th scope="col" class="px-6 py-4">RK Anggota</th>
                                    <th scope="col" class="px-6 py-4">Lapangan</th>
                                    <th scope="col" class="px-6 py-4">PIC Proyek</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyeks as $proyek)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $proyek->masterProyek->rkTim->rk_tim_kode }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $proyek->masterProyek->proyek_kode }}</td>
                                    <td class="px-6 py-4">{{ $proyek->masterProyek->proyek_urai }}</td>
                                    <td class="px-6 py-4">
                                        @if($proyek->masterProyek->iku_kode)
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-blue-100 text-blue-800">
                                            {{ $proyek->masterProyek->iku_kode }}
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $proyek->masterProyek->iku_urai }}</div>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $proyek->masterProyek->rk_anggota ?: '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($proyek->masterProyek->proyek_lapangan)
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-green-100 text-green-800">Ya</span>
                                        @else
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-gray-100 text-gray-800">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($proyek->picUser)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                {{ strtoupper(substr($proyek->picUser->name, 0, 1)) }}
                                            </div>
                                            <span class="ml-2">{{ $proyek->picUser->name }}</span>
                                        </div>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <button
                                            data-modal-target="editProyekModal"
                                            data-modal-toggle="editProyekModal"
                                            data-rktim-id="{{ $proyek->rk_tim_id }}"
                                            data-proyek-id="{{ $proyek->id }}"
                                            data-proyek-kode="{{ $proyek->masterProyek->proyek_kode }}"
                                            data-proyek-urai="{{ $proyek->masterProyek->proyek_urai }}"
                                            data-iku-kode="{{ $proyek->masterProyek->iku_kode }}"
                                            data-iku-urai="{{ $proyek->masterProyek->iku_urai }}"
                                            data-rk-anggota="{{ $proyek->masterProyek->rk_anggota }}"
                                            data-proyek-lapangan="{{ $proyek->masterProyek->proyek_lapangan }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2 edit-proyek-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('tim.proyek.destroy', ['tim' => $tim->id, 'proyek' => $proyek->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')" class="inline">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada proyek</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">RK Tim ini belum memiliki proyek. Tambahkan proyek untuk mulai mengelola kegiatan.</p>
                        <button data-modal-target="tambahProyekModal" data-modal-toggle="tambahProyekModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Proyek
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div id="tambahAnggotaModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Tambah Anggota Tim
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahAnggotaModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    @if($availableUsers->count() > 0)
                    <form action="{{ route('tim.simpan_anggota', $tim->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="user_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari Pegawai
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="user_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari berdasarkan nama atau NIP...">
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Nama</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">NIP Lama</th>
                                        <th scope="col" class="px-6 py-3">NIP Baru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableUsers as $user)
                                    <tr class="user-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-name="{{ strtolower($user->name) }}" data-nip="{{ $user->nip_lama }} {{ $user->nip_baru }}">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-user-{{ $user->id }}" type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-user-{{ $user->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-3">{{ $user->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4 font-mono text-xs">{{ $user->nip_lama ?: '-' }}</td>
                                        <td class="px-6 py-4 font-mono text-xs">{{ $user->nip_baru ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span id="selected-count" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">0 pegawai dipilih</span>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" data-modal-hide="tambahAnggotaModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                    Batal
                                </button>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="bg-gray-50 dark:bg-gray-700 p-10 rounded-lg text-center">
                        <div class="mx-auto h-16 w-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada pegawai tersedia</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Semua pegawai sudah menjadi anggota tim ini.</p>
                        <button type="button" data-modal-hide="tambahAnggotaModal" class="text-blue-700 bg-blue-100 hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-800 transition-colors duration-150">
                            Tutup
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah RK Tim -->
    <div id="tambahRkTimModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah RK Tim
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahRkTimModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <!-- Tim Info Banner -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium">{{ $tim->masterTim->tim_kode }} - {{ $tim->masterTim->tim_nama }}</p>
                        </div>
                    </div>

                    <form action="{{ route('tim.simpan_rktim', $tim->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="rktim_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari RK Tim
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="rktim_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari berdasarkan kode atau uraian...">
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-rktim" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-rktim" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Kode RK Tim</th>
                                        <th scope="col" class="px-6 py-3">Uraian RK Tim</th>
                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($availableRkTims) && count($availableRkTims) > 0)
                                    @foreach($availableRkTims as $rkTim)
                                    <tr class="rktim-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-kode="{{ strtolower($rkTim->rk_tim_kode) }}" data-urai="{{ strtolower($rkTim->rk_tim_urai) }}">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-rktim-{{ $rkTim->id }}" type="checkbox" name="rktim_ids[]" value="{{ $rkTim->id }}" class="rktim-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-rktim-{{ $rkTim->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $rkTim->rk_tim_kode }}</td>
                                        <td class="px-6 py-4">{{ $rkTim->rk_tim_urai }}</td>
                                        <td class="px-6 py-4">
                                            <button type="button" data-modal-target="editRkTimModal" data-modal-toggle="editRkTimModal"
                                                data-rktim-id="{{ $rkTim->id }}"
                                                data-rktim-kode="{{ $rkTim->rk_tim_kode }}"
                                                data-rktim-urai="{{ $rkTim->rk_tim_urai }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-rktim-btn">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <!-- Row for adding new RK Tim -->
                                    <tr class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-new-rktim" type="checkbox" name="add_new_rktim" value="1" class="new-rktim-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-new-rktim" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4" colspan="3">
                                            <div class="font-medium text-blue-600 dark:text-blue-500">+ Tambah RK Tim baru</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Form for new RK Tim (initially hidden) -->
                        <div id="new-rktim-form" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6 hidden">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Detail RK Tim Baru</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="new_rk_tim_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode RK Tim</label>
                                    <input type="text" name="new_rk_tim_kode" id="new_rk_tim_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: RK631">
                                </div>
                                <div>
                                    <label for="new_rk_tim_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian RK Tim</label>
                                    <textarea name="new_rk_tim_urai" id="new_rk_tim_urai" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian RK Tim"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span id="selected-rktim-count" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">0 RK Tim dipilih</span>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" data-modal-hide="tambahRkTimModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                    Batal
                                </button>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit RK Tim -->
    <div id="editRkTimModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit RK Tim
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editRkTimModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="editRkTimForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit_rk_tim_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode RK Tim</label>
                            <input type="text" name="rk_tim_kode" id="edit_rk_tim_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_rk_tim_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian RK Tim</label>
                            <textarea name="rk_tim_urai" id="edit_rk_tim_urai" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" data-modal-hide="editRkTimModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                Batal
                            </button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Proyek -->
    <div id="tambahProyekModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Proyek
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahProyekModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('tim.simpan_proyek', $tim->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="proyek_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari Proyek
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="proyek_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari berdasarkan kode atau uraian...">
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-proyek" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-proyek" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Kode RK Tim</th>
                                        <th scope="col" class="px-6 py-3">Kode Proyek</th>
                                        <th scope="col" class="px-6 py-3">Uraian Proyek</th>
                                        <th scope="col" class="px-6 py-3">IKU Terkait</th>
                                        <th scope="col" class="px-6 py-3">PIC Proyek</th>
                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($availableProyeks) && count($availableProyeks) > 0)
                                    @foreach($availableProyeks as $proyek)
                                    <tr class="proyek-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-kode="{{ strtolower($proyek->proyek_kode) }}" data-urai="{{ strtolower($proyek->proyek_urai) }}">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-proyek-{{ $proyek->id }}" type="checkbox" name="proyek_ids[]" value="{{ $proyek->id }}" class="proyek-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-proyek-{{ $proyek->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $proyek->rkTim->rk_tim_kode }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $proyek->proyek_kode }}</td>
                                        <td class="px-6 py-4">{{ $proyek->proyek_urai }}</td>
                                        <td class="px-6 py-4">
                                            @if($proyek->iku_kode)
                                            <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-blue-100 text-blue-800">
                                                {{ $proyek->iku_kode }}
                                            </span>
                                            @else
                                            <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <select name="pic_ids[{{ $proyek->id }}]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                                <option value=""></option>
                                                @foreach($anggotaTim as $anggota)
                                                <option value="{{ $anggota->id }}">{{ $anggota->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" data-modal-target="editProyekModal" data-modal-toggle="editProyekModal"
                                                data-proyek-id="{{ $proyek->id }}"
                                                data-proyek-kode="{{ $proyek->proyek_kode }}"
                                                data-proyek-urai="{{ $proyek->proyek_urai }}"
                                                data-iku-kode="{{ $proyek->iku_kode }}"
                                                data-iku-urai="{{ $proyek->iku_urai }}"
                                                data-rk-anggota="{{ $proyek->rk_anggota }}"
                                                data-proyek-lapangan="{{ $proyek->proyek_lapangan }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-proyek-btn">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <!-- Row for adding new Proyek -->
                                    <tr class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-new-proyek" type="checkbox" name="add_new_proyek" value="1" class="new-proyek-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-new-proyek" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4" colspan="4">
                                            <div class="font-medium text-blue-600 dark:text-blue-500">+ Tambah Proyek baru</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Form for new Proyek (initially hidden) -->
                        <div id="new-proyek-form" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6 hidden">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Detail Proyek Baru</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label for="rk_tim_id" class="block mb-2 text-sm font-medium text-gray-900">RK Tim</label>
                                    <select name="rk_tim_id" id="rk_tim_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="">-- Pilih RK Tim --</option>
                                        @foreach($rkTims as $rkTimItem)
                                        <option value="{{ $rkTimItem->id }}">{{ $rkTimItem->masterRkTim->rk_tim_kode }} - {{ $rkTimItem->masterRkTim->rk_tim_urai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="new_proyek_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Proyek</label>
                                    <input type="text" name="new_proyek_kode" id="new_proyek_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: P1.1.1">
                                </div>
                                <div>
                                    <label for="new_proyek_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Proyek</label>
                                    <input type="text" name="new_proyek_urai" id="new_proyek_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian proyek">
                                </div>
                                <div class="col-span-2">
                                    <label for="new_iku_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IKU</label>
                                    <select name="new_iku_id" id="new_iku_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="">-- Pilih IKU --</option>
                                        @foreach($ikus as $iku)
                                        <option value="{{ $iku->id }}" data-kode="{{ $iku->iku_kode }}" data-urai="{{ $iku->iku_urai }}">
                                            {{ $iku->iku_kode }} - {{ $iku->iku_urai }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- Hidden fields to store the selected IKU kode and urai -->
                                    <input type="hidden" name="new_iku_kode" id="new_iku_kode">
                                    <input type="hidden" name="new_iku_urai" id="new_iku_urai">
                                </div>
                                <div>
                                    <label for="new_rk_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RK Anggota</label>
                                    <input type="text" name="new_rk_anggota" id="new_rk_anggota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Seluruh Anggota">
                                </div>
                                <div>
                                    <label for="new_proyek_lapangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proyek Lapangan</label>
                                    <select name="new_proyek_lapangan" id="new_proyek_lapangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="new_pic_proyek" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC Proyek</label>
                                    <select name="new_pic_proyek" id="new_pic_proyek" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="">-- Pilih PIC Proyek --</option>
                                        @foreach($anggotaTim as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span id="selected-proyek-count" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">0 Proyek dipilih</span>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" data-modal-hide="tambahProyekModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                    Batal
                                </button>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Proyek -->
    <div id="editProyekModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Proyek
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editProyekModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="editProyekForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="col-span-2">
                                <label for="edit_rk_tim_id" class="block mb-2 text-sm font-medium text-gray-900">RK Tim</label>
                                <select name="rk_tim_id" id="edit_rk_tim_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                    <option value="">-- Pilih RK Tim --</option>
                                    @foreach($rkTims as $rkTimItem)
                                    <option value="{{ $rkTimItem->id }}">{{ $rkTimItem->masterRkTim->rk_tim_kode }} - {{ $rkTimItem->masterRkTim->rk_tim_urai }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="edit_proyek_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Proyek</label>
                                <input type="text" name="proyek_kode" id="edit_proyek_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_proyek_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Proyek</label>
                                <input type="text" name="proyek_urai" id="edit_proyek_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div class="col-span-2">
                                <label for="edit_iku_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IKU</label>
                                <select name="edit_iku_id" id="edit_iku_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">-- Pilih IKU --</option>
                                    @foreach($ikus as $iku)
                                    <option value="{{ $iku->id }}" data-kode="{{ $iku->iku_kode }}" data-urai="{{ $iku->iku_urai }}">
                                        {{ $iku->iku_kode }} - {{ $iku->iku_urai }}
                                    </option>
                                    @endforeach
                                </select>
                                <!-- Hidden fields to store the selected IKU kode and urai -->
                                <input type="hidden" name="iku_kode" id="edit_iku_kode">
                                <input type="hidden" name="iku_urai" id="edit_iku_urai">
                            </div>
                            <div>
                                <label for="edit_rk_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RK Anggota</label>
                                <input type="text" name="rk_anggota" id="edit_rk_anggota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_proyek_lapangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proyek Lapangan</label>
                                <select name="proyek_lapangan" id="edit_proyek_lapangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="Tidak">Tidak</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label for="edit_pic_proyek" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC Proyek</label>
                                <select name="pic" id="edit_pic_proyek" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">-- Pilih PIC Proyek --</option>
                                    @foreach($anggotaTim as $anggota)
                                    <option value="{{ $anggota->id }}">{{ $anggota->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" data-modal-hide="editProyekModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
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

            // Variabel untuk menangani user/anggota tim
            const checkboxAll = document.getElementById('checkbox-all');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const selectedCount = document.getElementById('selected-count');
            const userSearch = document.getElementById('user_search');
            const userRows = document.querySelectorAll('.user-row');

            // Variabel untuk menangani RK Tim
            const checkboxAllRkTim = document.getElementById('checkbox-all-rktim');
            const rkTimCheckboxes = document.querySelectorAll('.rktim-checkbox');
            const selectedRkTimCount = document.getElementById('selected-rktim-count');
            const rkTimSearch = document.getElementById('rktim_search');
            const rkTimRows = document.querySelectorAll('.rktim-row');
            const newRkTimCheckbox = document.querySelector('.new-rktim-checkbox');
            const newRkTimForm = document.getElementById('new-rktim-form');

            // Variabel untuk menangani Proyek
            const checkboxAllProyek = document.getElementById('checkbox-all-proyek');
            const proyekCheckboxes = document.querySelectorAll('.proyek-checkbox');
            const selectedProyekCount = document.getElementById('selected-proyek-count');
            const proyekSearch = document.getElementById('proyek_search');
            const proyekRows = document.querySelectorAll('.proyek-row');
            const newProyekCheckbox = document.querySelector('.new-proyek-checkbox');
            const newProyekForm = document.getElementById('new-proyek-form');
            const newIkuSelect = document.getElementById('new_iku_id');
            const newIkuKodeInput = document.getElementById('new_iku_kode');
            const newIkuUraiInput = document.getElementById('new_iku_urai');

            // Fungsi untuk membuka modal
            function openModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.remove("hidden");
                    targetModal.classList.add("flex", "animate-fadeIn");
                    modalBackdrop.classList.remove("hidden");

                    // Reset search and selection when opening modal
                    if (targetModal.id === 'tambahAnggotaModal') {
                        resetAnggotaModal();
                    } else if (targetModal.id === 'tambahRkTimModal') {
                        resetRkTimModal();
                    } else if (targetModal.id === 'tambahProyekModal') {
                        resetProyekModal();
                    }
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

            // Reset modal functions
            function resetAnggotaModal() {
                if (userSearch) {
                    userSearch.value = '';
                }
                if (checkboxAll) {
                    checkboxAll.checked = false;
                }
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();

                // Show all rows
                userRows.forEach(row => {
                    row.style.display = '';
                });
            }

            function resetRkTimModal() {
                if (rkTimSearch) {
                    rkTimSearch.value = '';
                }
                if (checkboxAllRkTim) {
                    checkboxAllRkTim.checked = false;
                }
                rkTimCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                if (newRkTimCheckbox) {
                    newRkTimCheckbox.checked = false;
                }
                if (newRkTimForm) {
                    newRkTimForm.classList.add('hidden');
                }
                updateSelectedRkTimCount();

                // Show all rows
                rkTimRows.forEach(row => {
                    row.style.display = '';
                });
            }

            function resetProyekModal() {
                if (proyekSearch) {
                    proyekSearch.value = '';
                }
                if (checkboxAllProyek) {
                    checkboxAllProyek.checked = false;
                }
                proyekCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                if (newProyekCheckbox) {
                    newProyekCheckbox.checked = false;
                }
                if (newProyekForm) {
                    newProyekForm.classList.add('hidden');
                }
                updateSelectedProyekCount();

                // Show all rows
                proyekRows.forEach(row => {
                    row.style.display = '';
                });
            }

            // Fungsi untuk mengupdate counter anggota
            function updateSelectedCount() {
                const count = document.querySelectorAll('.user-checkbox:checked').length;
                if (selectedCount) {
                    selectedCount.textContent = count + ' pegawai dipilih';
                    if (count > 0) {
                        selectedCount.classList.add('bg-blue-100', 'text-blue-800');
                        selectedCount.classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        selectedCount.classList.remove('bg-blue-100', 'text-blue-800');
                        selectedCount.classList.add('bg-gray-100', 'text-gray-800');
                    }
                }
            }

            // Fungsi untuk mengupdate counter RK Tim
            function updateSelectedRkTimCount() {
                let count = document.querySelectorAll('.rktim-checkbox:checked').length;
                if (newRkTimCheckbox && newRkTimCheckbox.checked) {
                    count++;
                }

                if (selectedRkTimCount) {
                    selectedRkTimCount.textContent = count + ' RK Tim dipilih';
                    if (count > 0) {
                        selectedRkTimCount.classList.add('bg-blue-100', 'text-blue-800');
                        selectedRkTimCount.classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        selectedRkTimCount.classList.remove('bg-blue-100', 'text-blue-800');
                        selectedRkTimCount.classList.add('bg-gray-100', 'text-gray-800');
                    }
                }
            }

            // Fungsi untuk mengupdate counter proyek
            function updateSelectedProyekCount() {
                let count = document.querySelectorAll('.proyek-checkbox:checked').length;
                if (newProyekCheckbox && newProyekCheckbox.checked) {
                    count++;
                }

                if (selectedProyekCount) {
                    selectedProyekCount.textContent = count + ' Proyek dipilih';
                    if (count > 0) {
                        selectedProyekCount.classList.add('bg-blue-100', 'text-blue-800');
                        selectedProyekCount.classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        selectedProyekCount.classList.remove('bg-blue-100', 'text-blue-800');
                        selectedProyekCount.classList.add('bg-gray-100', 'text-gray-800');
                    }
                }
            }

            // Fungsi untuk menampilkan/menyembunyikan form RK Tim baru
            if (newRkTimCheckbox && newRkTimForm) {
                newRkTimCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        newRkTimForm.classList.remove('hidden');
                    } else {
                        newRkTimForm.classList.add('hidden');
                    }
                    updateSelectedRkTimCount();
                });
            }

            // Fungsi untuk menampilkan/menyembunyikan form Proyek baru
            if (newProyekCheckbox && newProyekForm) {
                newProyekCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        newProyekForm.classList.remove('hidden');
                    } else {
                        newProyekForm.classList.add('hidden');
                    }
                    updateSelectedProyekCount();
                });
            }

            const rkTimSelect = document.getElementById('rk_tim_id');
            if (newProyekCheckbox && rkTimSelect) {
                newProyekCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        rkTimSelect.required = true; // Wajib diisi kalau centang tambah proyek baru
                    } else {
                        rkTimSelect.required = false; // Tidak perlu kalau tidak centang
                    }
                });

                // Inisialisasi awal (kalau reload page atau modal buka ulang)
                if (!newProyekCheckbox.checked) {
                    rkTimSelect.required = false;
                }
            }

            // Event listener untuk checkbox utama anggota
            if (checkboxAll) {
                checkboxAll.addEventListener('change', function() {
                    userCheckboxes.forEach(checkbox => {
                        // Hanya memilih checkbox di baris yang terlihat
                        if (checkbox.closest('tr').style.display !== 'none') {
                            checkbox.checked = checkboxAll.checked;
                        }
                    });
                    updateSelectedCount();
                });
            }

            // Event listener untuk checkbox utama RK Tim
            if (checkboxAllRkTim) {
                checkboxAllRkTim.addEventListener('change', function() {
                    rkTimCheckboxes.forEach(checkbox => {
                        // Hanya memilih checkbox di baris yang terlihat
                        if (checkbox.closest('tr').style.display !== 'none') {
                            checkbox.checked = checkboxAllRkTim.checked;
                        }
                    });
                    updateSelectedRkTimCount();
                });
            }

            // Event listener untuk checkbox utama Proyek
            if (checkboxAllProyek) {
                checkboxAllProyek.addEventListener('change', function() {
                    proyekCheckboxes.forEach(checkbox => {
                        // Hanya memilih checkbox di baris yang terlihat
                        if (checkbox.closest('tr').style.display !== 'none') {
                            checkbox.checked = checkboxAllProyek.checked;
                        }
                    });
                    updateSelectedProyekCount();
                });
            }

            // Event listener untuk checkbox anggota individu
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Event listener untuk checkbox RK Tim individu
            rkTimCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedRkTimCount);
            });

            // Event listener untuk checkbox Proyek individu
            proyekCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedProyekCount);
            });

            // Pencarian user
            if (userSearch) {
                userSearch.addEventListener('input', function() {
                    const searchValue = userSearch.value.toLowerCase().trim();

                    userRows.forEach(row => {
                        const userName = row.getAttribute('data-name');
                        const userNip = row.getAttribute('data-nip');

                        if (userName.includes(searchValue) || (userNip && userNip.includes(searchValue))) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Reset checkbox utama ketika melakukan pencarian
                    if (checkboxAll) {
                        checkboxAll.checked = false;
                        updateSelectedCount();
                    }
                });
            }

            // Pencarian RK Tim
            if (rkTimSearch) {
                rkTimSearch.addEventListener('input', function() {
                    const searchValue = rkTimSearch.value.toLowerCase().trim();

                    rkTimRows.forEach(row => {
                        const rkTimKode = row.getAttribute('data-kode');
                        const rkTimUrai = row.getAttribute('data-urai');

                        if ((rkTimKode && rkTimKode.includes(searchValue)) ||
                            (rkTimUrai && rkTimUrai.includes(searchValue))) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Reset checkbox utama ketika melakukan pencarian
                    if (checkboxAllRkTim) {
                        checkboxAllRkTim.checked = false;
                        updateSelectedRkTimCount();
                    }
                });
            }

            // Pencarian Proyek
            if (proyekSearch) {
                proyekSearch.addEventListener('input', function() {
                    const searchValue = proyekSearch.value.toLowerCase().trim();

                    proyekRows.forEach(row => {
                        const proyekKode = row.getAttribute('data-kode');
                        const proyekUrai = row.getAttribute('data-urai');

                        if ((proyekKode && proyekKode.includes(searchValue)) ||
                            (proyekUrai && proyekUrai.includes(searchValue))) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Reset checkbox utama ketika melakukan pencarian
                    if (checkboxAllProyek) {
                        checkboxAllProyek.checked = false;
                        updateSelectedProyekCount();
                    }
                });
            }

            // IKU Select handling for new project
            if (newIkuSelect && newIkuKodeInput && newIkuUraiInput) {
                newIkuSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        newIkuKodeInput.value = selectedOption.getAttribute('data-kode');
                        newIkuUraiInput.value = selectedOption.getAttribute('data-urai');
                    } else {
                        newIkuKodeInput.value = '';
                        newIkuUraiInput.value = '';
                    }
                });
            }

            function checkFormValidity() {
                const submitButton = document.querySelector('#tambahProyekModal button[type="submit"]');
                const selectedCheckboxes = document.querySelectorAll('#tambahProyekModal .proyek-checkbox:checked').length;
                const newProyekSelected = document.querySelector('#tambahProyekModal .new-proyek-checkbox')?.checked || false;

                // Jika ada proyek yang dipilih atau opsi tambah proyek baru dicentang
                if (selectedCheckboxes > 0 || newProyekSelected) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // Tambahkan listener untuk semua checkbox
            document.querySelectorAll('#tambahProyekModal .proyek-checkbox, #tambahProyekModal .new-proyek-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', checkFormValidity);
            });

            // Panggil saat modal terbuka
            document.querySelectorAll('[data-modal-toggle="tambahProyekModal"]').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTimeout(checkFormValidity, 100);
                });
            });

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

            // Handle Edit RK Tim
            const editRkTimButtons = document.querySelectorAll('.edit-rktim-btn');
            const editRkTimForm = document.getElementById('editRkTimForm');

            if (editRkTimButtons.length > 0 && editRkTimForm) {
                editRkTimButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const rkTimId = this.getAttribute('data-rktim-id');
                        const rkTimKode = this.getAttribute('data-rktim-kode');
                        const rkTimUrai = this.getAttribute('data-rktim-urai');
                        const timId = document.querySelector('input[name="tim_id"]') ? document.querySelector('input[name="tim_id"]').value : '';

                        // Set form action
                        editRkTimForm.action = `/tim/${timId}/rktim/${rkTimId}`;

                        // Fill form fields
                        document.getElementById('edit_rk_tim_kode').value = rkTimKode;
                        document.getElementById('edit_rk_tim_urai').value = rkTimUrai;
                    });
                });
            }

            // Handle Edit Proyek
            const editProyekButtons = document.querySelectorAll('.edit-proyek-btn');
            const editProyekForm = document.getElementById('editProyekForm');
            const editIkuSelect = document.getElementById('edit_iku_id');
            const editIkuKodeInput = document.getElementById('edit_iku_kode');
            const editIkuUraiInput = document.getElementById('edit_iku_urai');

            if (editIkuSelect && editIkuKodeInput && editIkuUraiInput) {
                editIkuSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        editIkuKodeInput.value = selectedOption.getAttribute('data-kode');
                        editIkuUraiInput.value = selectedOption.getAttribute('data-urai');
                    } else {
                        editIkuKodeInput.value = '';
                        editIkuUraiInput.value = '';
                    }
                });
            }

            if (editProyekButtons.length > 0 && editProyekForm) {
                editProyekButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const proyekId = this.getAttribute('data-proyek-id');
                        const proyekKode = this.getAttribute('data-proyek-kode');
                        const proyekUrai = this.getAttribute('data-proyek-urai');
                        const ikuKode = this.getAttribute('data-iku-kode');
                        const ikuUrai = this.getAttribute('data-iku-urai');
                        const rkAnggota = this.getAttribute('data-rk-anggota');
                        const proyekLapangan = this.getAttribute('data-proyek-lapangan');
                        const picId = this.getAttribute('data-pic-id');
                        const timId = document.querySelector('input[name="tim_id"]') ? document.querySelector('input[name="tim_id"]').value : '';

                        // Set form action - Adapt to the appropriate route
                        editProyekForm.action = `/tim/${timId}/proyek/${proyekId}`;

                        // Fill form fields
                        document.getElementById('edit_proyek_kode').value = proyekKode || '';
                        document.getElementById('edit_proyek_urai').value = proyekUrai || '';
                        document.getElementById('edit_iku_kode').value = ikuKode || '';
                        document.getElementById('edit_iku_urai').value = ikuUrai || '';
                        document.getElementById('edit_rk_anggota').value = rkAnggota || '';
                        document.getElementById('edit_proyek_lapangan').value = proyekLapangan || 'Tidak';

                        // Set nilai dropdown PIC proyek
                        if (picId && document.getElementById('edit_pic_proyek')) {
                            document.getElementById('edit_pic_proyek').value = picId;
                        } else if (document.getElementById('edit_pic_proyek')) {
                            document.getElementById('edit_pic_proyek').selectedIndex = 0;
                        }

                        // Handle IKU dropdown
                        if (editIkuSelect) {
                            // Find matching option in dropdown
                            let optionFound = false;
                            for (let i = 0; i < editIkuSelect.options.length; i++) {
                                const option = editIkuSelect.options[i];
                                if (option.getAttribute('data-kode') === ikuKode) {
                                    editIkuSelect.selectedIndex = i;
                                    optionFound = true;
                                    break;
                                }
                            }

                            // If no matching option, clear the selection
                            if (!optionFound) {
                                editIkuSelect.selectedIndex = 0;
                            }
                        }
                        // Atur dropdown RK Tim
                        const rkTimId = this.getAttribute('data-rktim-id');
                        if (rkTimId && document.getElementById('edit_rk_tim_id')) {
                            document.getElementById('edit_rk_tim_id').value = rkTimId;
                        }
                    });
                });
            }

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

            // Make closeSuccessPopup function global
            window.closeSuccessPopup = closeSuccessPopup;

            // Auto close popup after 5 seconds
            const successPopup = document.getElementById('success-popup');
            if (successPopup) {
                setTimeout(() => {
                    closeSuccessPopup();
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