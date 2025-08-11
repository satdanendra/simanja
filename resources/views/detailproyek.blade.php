<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $proyek->rkTim->tim->masterTim->tim_kode }} - {{ $proyek->rkTim->tim->masterTim->tim_nama }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tahun {{ $proyek->rkTim->tim->tahun }}
                    </p>
                </div>
            </div>
            <a href="{{ route('detailtim', $proyek->rkTim->tim_id) }}" class="flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
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
            <!-- Proyek Detail Card -->
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
                                <h3 class="text-xl font-bold">Detail Proyek</h3>
                            </div>
                        </div>

                        @if(Auth::id() == $proyek->rkTim->tim->tim_ketua)
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
                            data-pic-id="{{ $proyek->pic }}"
                            data-rktim-id="{{ $proyek->rk_tim_id }}"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out edit-proyek-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Proyek
                        </button>
                        @endif
                    </div>
                </div>

                <div class="p-10">
                    <!-- Simple, stylish list instead of card grid -->
                    <!-- <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded mb-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">RK Tim: {{ $proyek->rkTim->masterRkTim->rk_tim_kode }} - {{ $proyek->rkTim->masterRkTim->rk_tim_urai }}</p>
                            </div>
                        </div>
                    </div> -->

                    <ul class="space-y-4">
                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">RK Tim</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $proyek->rkTim->masterRkTim->rk_tim_kode }} - {{ $proyek->rkTim->masterRkTim->rk_tim_urai }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Kode Proyek</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $proyek->masterProyek->proyek_kode }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Uraian Proyek</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $proyek->masterProyek->proyek_urai }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">IKU Terkait</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $proyek->masterProyek->iku_kode }} - {{ $proyek->masterProyek->iku_urai }}</div>
                        </li>

                        <!-- <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">IKU Terkait</div>
                            <div class="w-2/3">
                                @if($proyek->masterProyek->iku_kode)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $proyek->masterProyek->iku_kode }}
                                </span>
                                <p class="mt-1 text-gray-700 dark:text-gray-300 text-sm">{{ $proyek->masterProyek->iku_urai }}</p>
                                @else
                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </div>
                        </li> -->

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">RK Anggota</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $proyek->masterProyek->rk_anggota ?: '-' }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Proyek Lapangan</div>
                            <div class="w-2/3">
                                @if($proyek->masterProyek->proyek_lapangan == 'Ya')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-m font-medium bg-green-100 text-green-800">
                                    Ya
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak
                                </span>
                                @endif
                            </div>
                        </li>

                        <li class="flex">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">PIC Proyek</div>
                            <div class="w-2/3">
                                @if($proyek->picUser)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                        {{ strtoupper(substr($proyek->picUser->name, 0, 1)) }}
                                    </div>
                                    <span class="ml-3 text-gray-900 dark:text-white">{{ $proyek->picUser->name }}</span>
                                </div>
                                @else
                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Kegiatan Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 border-b border-blue-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex items-center text-white mb-4 md:mb-0">
                            <div class="flex h-12 w-12 rounded-full bg-white/20 items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Daftar Kegiatan</h3>
                                <p class="text-blue-100 text-sm">{{ isset($kegiatans) ? count($kegiatans) : 0 }} Kegiatan</p>
                            </div>
                        </div>
                        @if(Auth::id() == $proyek->pic)
                        <button
                            data-modal-target="tambahKegiatanModal"
                            data-modal-toggle="tambahKegiatanModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Kegiatan
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Kegiatan List -->
                <div class="p-6">
                    @if(isset($kegiatans) && count($kegiatans) > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Kode Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Uraian Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">IKI</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kegiatans as $kegiatan)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $kegiatan->masterKegiatan->kegiatan_kode }}</td>
                                    <td class="px-6 py-4">{{ $kegiatan->masterKegiatan->kegiatan_urai }}</td>
                                    <td class="px-6 py-4">{{ $kegiatan->masterKegiatan->iki ?: '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('detailkegiatan', $kegiatan->id) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        @if(Auth::id() == $proyek->pic)
                                        <button
                                            data-modal-target="editKegiatanModal"
                                            data-modal-toggle="editKegiatanModal"
                                            data-kegiatan-id="{{ $kegiatan->id }}"
                                            data-kegiatan-kode="{{ $kegiatan->masterKegiatan->kegiatan_kode }}"
                                            data-kegiatan-urai="{{ $kegiatan->masterKegiatan->kegiatan_urai }}"
                                            data-iki="{{ $kegiatan->masterKegiatan->iki }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2 edit-kegiatan-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('proyek.kegiatan.destroy', ['proyek' => $proyek->id, 'kegiatan' => $kegiatan->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
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
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada kegiatan</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">Proyek ini belum memiliki kegiatan. Tambahkan kegiatan untuk mulai mengelola rincian kegiatan.</p>
                        @if(Auth::id() == $proyek->pic)
                        <button data-modal-target="tambahKegiatanModal" data-modal-toggle="tambahKegiatanModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Kegiatan
                        </button>
                        @endif
                    </div>
                    @endif
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
                    <form id="editProyekForm" action="{{ route('proyek.update', $proyek->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="col-span-2">
                                <label for="edit_rk_tim_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RK Tim</label>
                                <select name="rk_tim_id" id="edit_rk_tim_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                    <option value="">-- Pilih RK Tim --</option>
                                    @foreach($proyek->rkTim->tim->rkTims as $rkTimItem)
                                    <option value="{{ $rkTimItem->id }}" {{ $proyek->rk_tim_id == $rkTimItem->id ? 'selected' : '' }}>
                                        {{ $rkTimItem->masterRkTim->rk_tim_kode }} - {{ $rkTimItem->masterRkTim->rk_tim_urai }}
                                    </option>
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

    <!-- Modal Tambah Kegiatan -->
    <div id="tambahKegiatanModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Kegiatan
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahKegiatanModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <!-- Proyek Info Banner -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">{{ $proyek->masterProyek->proyek_kode }} - {{ $proyek->masterProyek->proyek_urai }}</p>
                                <p class="text-sm">{{ $proyek->rkTim->masterRkTim->rk_tim_kode }} - {{ $proyek->rkTim->masterRkTim->rk_tim_urai }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('proyek.simpan_kegiatan', $proyek->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="kegiatan_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari Kegiatan
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="kegiatan_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari berdasarkan kode atau uraian...">
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-kegiatan" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-kegiatan" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Kode Kegiatan</th>
                                        <th scope="col" class="px-6 py-3">Uraian Kegiatan</th>
                                        <th scope="col" class="px-6 py-3">IKI</th>
                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($availableKegiatans) && count($availableKegiatans) > 0)
                                    @foreach($availableKegiatans as $kegiatan)
                                    <tr class="kegiatan-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-kode="{{ strtolower($kegiatan->kegiatan_kode) }}" data-urai="{{ strtolower($kegiatan->kegiatan_urai) }}">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-kegiatan-{{ $kegiatan->id }}" type="checkbox" name="kegiatan_ids[]" value="{{ $kegiatan->id }}" class="kegiatan-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-kegiatan-{{ $kegiatan->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $kegiatan->kegiatan_kode }}</td>
                                        <td class="px-6 py-4">{{ $kegiatan->kegiatan_urai }}</td>
                                        <td class="px-6 py-4">{{ $kegiatan->iki ?: '-' }}</td>
                                        <td class="px-6 py-4">
                                            <button type="button" data-modal-target="editKegiatanModal" data-modal-toggle="editKegiatanModal"
                                                data-kegiatan-id="{{ $kegiatan->id }}"
                                                data-kegiatan-kode="{{ $kegiatan->kegiatan_kode }}"
                                                data-kegiatan-urai="{{ $kegiatan->kegiatan_urai }}"
                                                data-iki="{{ $kegiatan->iki }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-kegiatan-btn">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <!-- Row for adding new Kegiatan -->
                                    <tr class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-new-kegiatan" type="checkbox" name="add_new_kegiatan" value="1" class="new-kegiatan-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-new-kegiatan" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4" colspan="4">
                                            <div class="font-medium text-blue-600 dark:text-blue-500">+ Tambah Kegiatan baru</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Form for new Kegiatan (initially hidden) -->
                        <div id="new-kegiatan-form" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6 hidden">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Detail Kegiatan Baru</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="new_kegiatan_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Kegiatan</label>
                                    <input type="text" name="new_kegiatan_kode" id="new_kegiatan_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: K1.1.1">
                                </div>
                                <div>
                                    <label for="new_kegiatan_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Kegiatan</label>
                                    <input type="text" name="new_kegiatan_urai" id="new_kegiatan_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian kegiatan">
                                </div>
                                <div class="col-span-2">
                                    <label for="new_iki" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IKI (Indikator Kinerja Individu)</label>
                                    <input type="text" name="new_iki" id="new_iki" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Ketepatan waktu pengumpulan">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span id="selected-kegiatan-count" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">0 Kegiatan dipilih</span>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" data-modal-hide="tambahKegiatanModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
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

    <!-- Modal Edit Kegiatan -->
    <div id="editKegiatanModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Kegiatan
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editKegiatanModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="editKegiatanForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div>
                                <label for="edit_kegiatan_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Kegiatan</label>
                                <input type="text" name="kegiatan_kode" id="edit_kegiatan_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_kegiatan_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Kegiatan</label>
                                <input type="text" name="kegiatan_urai" id="edit_kegiatan_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_iki" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IKI (Indikator Kinerja Individu)</label>
                                <input type="text" name="iki" id="edit_iki" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" data-modal-hide="editKegiatanModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
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

            // Variabel untuk menangani Kegiatan
            const checkboxAllKegiatan = document.getElementById('checkbox-all-kegiatan');
            const kegiatanCheckboxes = document.querySelectorAll('.kegiatan-checkbox');
            const selectedKegiatanCount = document.getElementById('selected-kegiatan-count');
            const kegiatanSearch = document.getElementById('kegiatan_search');
            const kegiatanRows = document.querySelectorAll('.kegiatan-row');
            const newKegiatanCheckbox = document.querySelector('.new-kegiatan-checkbox');
            const newKegiatanForm = document.getElementById('new-kegiatan-form');

            // Fungsi untuk membuka modal
            function openModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.remove("hidden");
                    targetModal.classList.add("flex", "animate-fadeIn");
                    modalBackdrop.classList.remove("hidden");

                    // Reset search and selection when opening modal
                    if (targetModal.id === 'tambahKegiatanModal') {
                        resetKegiatanModal();
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

            // Reset functions for modals
            function resetKegiatanModal() {
                if (document.getElementById('kegiatan_search')) {
                    document.getElementById('kegiatan_search').value = '';
                }

                if (document.getElementById('checkbox-all-kegiatan')) {
                    document.getElementById('checkbox-all-kegiatan').checked = false;
                }

                document.querySelectorAll('.kegiatan-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                if (document.querySelector('.new-kegiatan-checkbox')) {
                    document.querySelector('.new-kegiatan-checkbox').checked = false;
                }

                if (document.getElementById('new-kegiatan-form')) {
                    document.getElementById('new-kegiatan-form').classList.add('hidden');
                }

                updateSelectedKegiatanCount();

                // Show all rows
                document.querySelectorAll('.kegiatan-row').forEach(row => {
                    row.style.display = '';
                });
            }

            // Function to update selected kegiatan count
            function updateSelectedKegiatanCount() {
                let count = document.querySelectorAll('.kegiatan-checkbox:checked').length;
                if (document.querySelector('.new-kegiatan-checkbox') &&
                    document.querySelector('.new-kegiatan-checkbox').checked) {
                    count++;
                }

                if (document.getElementById('selected-kegiatan-count')) {
                    document.getElementById('selected-kegiatan-count').textContent = count + ' Kegiatan dipilih';
                    if (count > 0) {
                        document.getElementById('selected-kegiatan-count').classList.add('bg-blue-100', 'text-blue-800');
                        document.getElementById('selected-kegiatan-count').classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        document.getElementById('selected-kegiatan-count').classList.remove('bg-blue-100', 'text-blue-800');
                        document.getElementById('selected-kegiatan-count').classList.add('bg-gray-100', 'text-gray-800');
                    }
                }
            }

            // Handle "Tambah Kegiatan" modal
            const tambahKegiatanModal = document.getElementById('tambahKegiatanModal');

            // Setup search functionality
            if (kegiatanSearch) {
                kegiatanSearch.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase().trim();

                    kegiatanRows.forEach(row => {
                        const kodeText = row.getAttribute('data-kode');
                        const uraiText = row.getAttribute('data-urai');

                        if ((kodeText && kodeText.includes(searchValue)) ||
                            (uraiText && uraiText.includes(searchValue))) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Reset select all checkbox
                    if (checkboxAllKegiatan) {
                        checkboxAllKegiatan.checked = false;
                        updateSelectedKegiatanCount();
                    }
                });
            }

            // Setup "select all" functionality
            if (checkboxAllKegiatan) {
                checkboxAllKegiatan.addEventListener('change', function() {
                    kegiatanCheckboxes.forEach(checkbox => {
                        // Only check visible rows
                        if (checkbox.closest('tr').style.display !== 'none') {
                            checkbox.checked = checkboxAllKegiatan.checked;
                        }
                    });
                    updateSelectedKegiatanCount();
                });
            }

            // Setup individual checkboxes
            kegiatanCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedKegiatanCount);
            });

            // Setup new kegiatan form toggle
            if (newKegiatanCheckbox && newKegiatanForm) {
                newKegiatanCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        newKegiatanForm.classList.remove('hidden');
                    } else {
                        newKegiatanForm.classList.add('hidden');
                    }
                    updateSelectedKegiatanCount();
                });
            }

            // Open modal handler
            document.querySelectorAll('[data-modal-toggle="tambahKegiatanModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    if (tambahKegiatanModal) {
                        // Reset the modal state
                        resetKegiatanModal();

                        // Show the modal
                        tambahKegiatanModal.classList.remove('hidden');
                        tambahKegiatanModal.classList.add('flex');
                        document.getElementById('modalBackdrop').classList.remove('hidden');

                        console.log("Available Kegiatans:", document.querySelectorAll('.kegiatan-row').length);
                    }
                });
            });

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
                    });
                });
            }

            // Handle Edit Kegiatan
            const editKegiatanButtons = document.querySelectorAll('.edit-kegiatan-btn');
            const editKegiatanForm = document.getElementById('editKegiatanForm');

            if (editKegiatanButtons.length > 0 && editKegiatanForm) {
                editKegiatanButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const kegiatanId = this.getAttribute('data-kegiatan-id');
                        const kegiatanKode = this.getAttribute('data-kegiatan-kode');
                        const kegiatanUrai = this.getAttribute('data-kegiatan-urai');
                        const iki = this.getAttribute('data-iki');
                        const proyekId = '{{ $proyek->id }}'; // Ambil dari halaman

                        // Set form action
                        editKegiatanForm.action = `/proyek/${proyekId}/kegiatan/${kegiatanId}`;

                        // Fill form fields
                        document.getElementById('edit_kegiatan_kode').value = kegiatanKode || '';
                        document.getElementById('edit_kegiatan_urai').value = kegiatanUrai || '';
                        document.getElementById('edit_iki').value = iki || '';
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
</x-app-layout>