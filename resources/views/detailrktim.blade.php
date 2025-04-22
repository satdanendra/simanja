<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $rkTim->masterRkTim->rk_tim_kode }} - {{ $rkTim->masterRkTim->rk_tim_urai }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tim: {{ $rkTim->tim->masterTim->tim_kode }} - {{ $rkTim->tim->masterTim->tim_nama }} ({{ $rkTim->tim->tahun }})
                    </p>
                </div>
            </div>
            <a href="{{ route('detailtim', $rkTim->tim_id) }}" class="flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali ke Detail Tim
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
                                    <th scope="col" class="px-6 py-4">Kode Proyek</th>
                                    <th scope="col" class="px-6 py-4">Uraian Proyek</th>
                                    <th scope="col" class="px-6 py-4">IKU Terkait</th>
                                    <th scope="col" class="px-6 py-4">RK Anggota</th>
                                    <th scope="col" class="px-6 py-4">Lapangan</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyeks as $proyek)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
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
                                    <td class="px-6 py-4 text-center">
                                        <button
                                            data-modal-target="editProyekModal"
                                            data-modal-toggle="editProyekModal"
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
                                        <form action="{{ route('rktim.proyek.destroy', ['rktim' => $rkTim->id, 'proyek' => $proyek->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')" class="inline">
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
                    <!-- Tim and RK Tim Info Banner -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">{{ $rkTim->tim->masterTim->tim_kode }} - {{ $rkTim->tim->masterTim->tim_nama }}</p>
                                <p class="text-sm">{{ $rkTim->masterRkTim->rk_tim_kode }} - {{ $rkTim->masterRkTim->rk_tim_urai }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('rktim.simpan_proyek', $rkTim->id) }}" method="POST">
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
                                        <th scope="col" class="px-6 py-3">Kode Proyek</th>
                                        <th scope="col" class="px-6 py-3">Uraian Proyek</th>
                                        <th scope="col" class="px-6 py-3">IKU Terkait</th>
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
                                <div>
                                    <label for="new_proyek_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Proyek</label>
                                    <input type="text" name="new_proyek_kode" id="new_proyek_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: P1.1.1">
                                </div>
                                <div>
                                    <label for="new_proyek_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Proyek</label>
                                    <input type="text" name="new_proyek_urai" id="new_proyek_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian proyek">
                                </div>
                                <div>
                                    <label for="new_iku_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode IKU</label>
                                    <input type="text" name="new_iku_kode" id="new_iku_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: IKU-1.1">
                                </div>
                                <div>
                                    <label for="new_iku_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian IKU</label>
                                    <input type="text" name="new_iku_urai" id="new_iku_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian IKU">
                                </div>
                                <div>
                                    <label for="new_rk_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RK Anggota</label>
                                    <input type="text" name="new_rk_anggota" id="new_rk_anggota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Seluruh Anggota">
                                </div>
                                <div>
                                    <label for="new_proyek_lapangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proyek Lapangan</label>
                                    <select name="new_proyek_lapangan" id="new_proyek_lapangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
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
                            <div>
                                <label for="edit_proyek_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Proyek</label>
                                <input type="text" name="proyek_kode" id="edit_proyek_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_proyek_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Proyek</label>
                                <input type="text" name="proyek_urai" id="edit_proyek_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_iku_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode IKU</label>
                                <input type="text" name="iku_kode" id="edit_iku_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_iku_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian IKU</label>
                                <input type="text" name="iku_urai" id="edit_iku_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_rk_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RK Anggota</label>
                                <input type="text" name="rk_anggota" id="edit_rk_anggota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_proyek_lapangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proyek Lapangan</label>
                                <select name="proyek_lapangan" id="edit_proyek_lapangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
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
            const checkboxAllProyek = document.getElementById('checkbox-all-proyek');
            const proyekCheckboxes = document.querySelectorAll('.proyek-checkbox');
            const selectedProyekCount = document.getElementById('selected-proyek-count');
            const proyekSearch = document.getElementById('proyek_search');
            const proyekRows = document.querySelectorAll('.proyek-row');
            const newProyekCheckbox = document.querySelector('.new-proyek-checkbox');
            const newProyekForm = document.getElementById('new-proyek-form');

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

            // Event listener untuk checkbox utama proyek
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

            // Event listener untuk checkbox proyek individu
            proyekCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedProyekCount);
            });

            // Pencarian proyek
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

            // Modal functions
            const modalButtons = document.querySelectorAll('[data-modal-toggle]');
            const modalCloseButtons = document.querySelectorAll('[data-modal-hide]');

            // Function to open modal
            function openModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.remove('hidden');
                    targetModal.classList.add('flex', 'animate-fadeIn');
                    modalBackdrop.classList.remove('hidden');

                    // Reset search and selection when opening modal
                    if (targetModal.id === 'tambahProyekModal') {
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
                }
            }

            // Function to close modal
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

            // Handle Edit Proyek
            const editProyekButtons = document.querySelectorAll('.edit-proyek-btn');
            const editProyekForm = document.getElementById('editProyekForm');

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

                        // Set form action
                        editProyekForm.action = `/rktim/{{ $rkTim->id }}/proyek/${proyekId}`;

                        // Fill form fields
                        document.getElementById('edit_proyek_kode').value = proyekKode || '';
                        document.getElementById('edit_proyek_urai').value = proyekUrai || '';
                        document.getElementById('edit_iku_kode').value = ikuKode || '';
                        document.getElementById('edit_iku_urai').value = ikuUrai || '';
                        document.getElementById('edit_rk_anggota').value = rkAnggota || '';
                        document.getElementById('edit_proyek_lapangan').value = proyekLapangan === '1' ? '1' : '0';
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