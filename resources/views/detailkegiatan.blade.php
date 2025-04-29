<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $kegiatan->proyek->rkTim->tim->masterTim->tim_kode }} - {{ $kegiatan->proyek->rkTim->tim->masterTim->tim_nama }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tahun {{ $kegiatan->proyek->rkTim->tim->tahun }}
                    </p>
                </div>
            </div>
            <a href="{{ route('detailproyek', $kegiatan->proyek_id) }}" class="flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali ke Detail Proyek
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
            <!-- Kegiatan and Proyek Detail Card -->
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
                                <h3 class="text-xl font-bold">Detail Kegiatan</h3>
                            </div>
                        </div>

                        <button
                            data-modal-target="editKegiatanModal"
                            data-modal-toggle="editKegiatanModal"
                            data-kegiatan-id="{{ $kegiatan->id }}"
                            data-kegiatan-kode="{{ $kegiatan->masterKegiatan->kegiatan_kode }}"
                            data-kegiatan-urai="{{ $kegiatan->masterKegiatan->kegiatan_urai }}"
                            data-iki="{{ $kegiatan->masterKegiatan->iki }}"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out edit-kegiatan-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Kegiatan
                        </button>
                    </div>
                </div>

                <div class="p-10">
                    <!-- Detail information -->
                    <ul class="space-y-4">
                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Proyek</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $kegiatan->proyek->masterProyek->proyek_kode }} - {{ $kegiatan->proyek->masterProyek->proyek_urai }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">RK Tim</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $kegiatan->proyek->rkTim->masterRkTim->rk_tim_kode }} - {{ $kegiatan->proyek->rkTim->masterRkTim->rk_tim_urai }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Kode Kegiatan</div>
                            <div class="w-2/3 font-semibold text-gray-900 dark:text-white">{{ $kegiatan->masterKegiatan->kegiatan_kode }}</div>
                        </li>

                        <li class="flex border-b border-gray-100 pb-4">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">Uraian Kegiatan</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $kegiatan->masterKegiatan->kegiatan_urai }}</div>
                        </li>

                        <li class="flex">
                            <div class="w-1/3 font-medium text-gray-600 dark:text-gray-400">IKI (Indikator Kinerja Individu)</div>
                            <div class="w-2/3 text-gray-900 dark:text-white">{{ $kegiatan->masterKegiatan->iki ?: '-' }}</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Rincian Kegiatan Card -->
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
                                <h3 class="text-xl font-bold">Daftar Rincian Kegiatan</h3>
                                <p class="text-blue-100 text-sm">{{ isset($rincianKegiatans) ? count($rincianKegiatans) : 0 }} Rincian Kegiatan</p>
                            </div>
                        </div>
                        <button
                            data-modal-target="tambahRincianKegiatanModal"
                            data-modal-toggle="tambahRincianKegiatanModal"
                            class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Rincian Kegiatan
                        </button>
                    </div>
                </div>

                <!-- Rincian Kegiatan List -->
                <div class="p-6">
                    @if(isset($rincianKegiatans) && count($rincianKegiatans) > 0)
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Kode Rincian Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Uraian Rincian Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Catatan</th>
                                    <th scope="col" class="px-6 py-4">Satuan</th>
                                    <th scope="col" class="px-6 py-4">Volume</th>
                                    <th scope="col" class="px-6 py-4">Waktu</th>
                                    <th scope="col" class="px-6 py-4">Deadline</th>
                                    <th scope="col" class="px-6 py-4">Variabel Kontrol</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rincianKegiatans as $rincian)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $rincian->masterRincianKegiatan->rincian_kegiatan_kode }}</td>
                                    <td class="px-6 py-4">{{ $rincian->masterRincianKegiatan->rincian_kegiatan_urai }}</td>
                                    <td class="px-6 py-4">{{ $rincian->masterRincianKegiatan->catatan ?: '-' }}</td>
                                    <td class="px-6 py-4">{{ $rincian->masterRincianKegiatan->rincian_kegiatan_satuan ?: '-' }}</td>
                                    <td class="px-6 py-4">{{ $rincian->volume ?: '-' }}</td>
                                    <td class="px-6 py-4">{{ $rincian->waktu ?: '-' }}</td>
                                    <td class="px-6 py-4">{{ $rincian->deadline ? date('d/m/Y', strtotime($rincian->deadline)) : '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($rincian->is_variabel_kontrol)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('detailrinciankegiatan', $rincian->id) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <button
                                            data-modal-target="editRincianKegiatanModal"
                                            data-modal-toggle="editRincianKegiatanModal"
                                            data-rincian-id="{{ $rincian->id }}"
                                            data-rincian-kode="{{ $rincian->masterRincianKegiatan->rincian_kegiatan_kode }}"
                                            data-rincian-urai="{{ $rincian->masterRincianKegiatan->rincian_kegiatan_urai }}"
                                            data-catatan="{{ $rincian->masterRincianKegiatan->catatan }}"
                                            data-satuan="{{ $rincian->masterRincianKegiatan->rincian_kegiatan_satuan }}"
                                            data-volume="{{ $rincian->volume }}"
                                            data-waktu="{{ $rincian->waktu }}"
                                            data-deadline="{{ $rincian->deadline }}"
                                            data-variabel-kontrol="{{ $rincian->is_variabel_kontrol }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 inline-flex items-center transition-colors duration-150 mr-2 edit-rincian-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('kegiatan.rincian.destroy', ['kegiatan' => $kegiatan->id, 'rincian' => $rincian->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rincian kegiatan ini?')" class="inline">
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
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada rincian kegiatan</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6 max-w-md">Kegiatan ini belum memiliki rincian kegiatan. Tambahkan rincian kegiatan untuk mulai mendokumentasikan detail pekerjaan.</p>
                        <button data-modal-target="tambahRincianKegiatanModal" data-modal-toggle="tambahRincianKegiatanModal" class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Rincian Kegiatan
                        </button>
                    </div>
                    @endif
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
                        Edit Rincian Kegiatan
                    </h3>000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    <form id="editKegiatanForm" action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
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

    <!-- Modal Edit Rincian Kegiatan -->
    <div id="editRincianKegiatanModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Rincian Kegiatan
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editRincianKegiatanModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="editRincianKegiatanForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_rincian_id" name="rincian_id" value="">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="edit_rincian_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Rincian Kegiatan</label>
                                <input type="text" name="rincian_kegiatan_kode" id="edit_rincian_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_rincian_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Rincian Kegiatan</label>
                                <input type="text" name="rincian_kegiatan_urai" id="edit_rincian_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="edit_catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                <textarea name="catatan" id="edit_catatan" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                            </div>
                            <div>
                                <label for="edit_satuan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan</label>
                                <input type="text" name="satuan" id="edit_satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_volume" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Volume</label>
                                <input type="number" name="volume" id="edit_volume" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_waktu" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu (jam)</label>
                                <input type="number" name="waktu" id="edit_waktu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deadline</label>
                                <input type="date" name="deadline" id="edit_deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                            <div>
                                <label for="edit_variabel_kontrol" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variabel Kontrol</label>
                                <select name="is_variabel_kontrol" id="edit_variabel_kontrol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" data-modal-hide="editRincianKegiatanModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                                Batal
                            </button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Rincian Kegiatan -->
    <div id="tambahRincianKegiatanModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 animate-fadeIn">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Rincian Kegiatan
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tambahRincianKegiatanModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <!-- Kegiatan Info Banner -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">{{ $kegiatan->masterKegiatan->kegiatan_kode }} - {{ $kegiatan->masterKegiatan->kegiatan_urai }}</p>
                                <p class="text-sm">{{ $kegiatan->proyek->masterProyek->proyek_kode }} - {{ $kegiatan->proyek->masterProyek->proyek_urai }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('kegiatan.simpan_rincian', $kegiatan->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="rincian_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari Rincian Kegiatan
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="rincian_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari berdasarkan kode atau uraian...">
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-rincian" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-rincian" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Kode</th>
                                        <th scope="col" class="px-6 py-3">Uraian</th>
                                        <th scope="col" class="px-6 py-3">Catatan</th>
                                        <th scope="col" class="px-6 py-3">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($availableRincianKegiatans) && count($availableRincianKegiatans) > 0)
                                    @foreach($availableRincianKegiatans as $rincian)
                                    <tr class="rincian-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-kode="{{ strtolower($rincian->rincian_kegiatan_kode) }}" data-urai="{{ strtolower($rincian->rincian_kegiatan_urai) }}">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-rincian-{{ $rincian->id }}" type="checkbox" name="rincian_ids[]" value="{{ $rincian->id }}" class="rincian-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-rincian-{{ $rincian->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $rincian->rincian_kegiatan_kode }}</td>
                                        <td class="px-6 py-4">{{ $rincian->rincian_kegiatan_urai }}</td>
                                        <td class="px-6 py-4">{{ $rincian->catatan ?: '-' }}</td>
                                        <td class="px-6 py-4">{{ $rincian->rincian_kegiatan_satuan ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <!-- Row for adding new Rincian Kegiatan -->
                                    <tr class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-new-rincian" type="checkbox" name="add_new_rincian" value="1" class="new-rincian-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-new-rincian" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4" colspan="4">
                                            <div class="font-medium text-blue-600 dark:text-blue-500">+ Tambah Rincian Kegiatan baru</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Form for new Rincian Kegiatan (initially hidden) -->
                        <div id="new-rincian-form" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6 hidden">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Detail Rincian Kegiatan Baru</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="new_rincian_kegiatan_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Rincian Kegiatan</label>
                                    <input type="text" name="new_rincian_kegiatan_kode" id="new_rincian_kegiatan_kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: RK1.1.1.1">
                                </div>
                                <div>
                                    <label for="new_rincian_kegiatan_urai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uraian Rincian Kegiatan</label>
                                    <input type="text" name="new_rincian_kegiatan_urai" id="new_rincian_kegiatan_urai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan uraian rincian kegiatan">
                                </div>
                                <div>
                                    <label for="new_catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                    <textarea name="new_catatan" id="new_catatan" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan catatan (opsional)"></textarea>
                                </div>
                                <div>
                                    <label for="new_satuan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan</label>
                                    <input type="text" name="new_satuan" id="new_satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Dokumen, Orang, Jam">
                                </div>
                                <div>
                                    <label for="new_volume" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Volume</label>
                                    <input type="number" name="new_volume" id="new_volume" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: 10">
                                </div>
                                <div>
                                    <label for="new_waktu" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu (jam)</label>
                                    <input type="number" name="new_waktu" id="new_waktu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: 8">
                                </div>
                                <div>
                                    <label for="new_deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deadline</label>
                                    <input type="date" name="new_deadline" id="new_deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                </div>
                                <div>
                                    <label for="new_variabel_kontrol" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variabel Kontrol</label>
                                    <select name="new_is_variabel_kontrol" id="new_variabel_kontrol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span id="selected-rincian-count" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">0 Rincian Kegiatan dipilih</span>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" data-modal-hide="tambahRincianKegiatanModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBackdrop = document.getElementById('modalBackdrop');

            // Variabel untuk menangani rincian kegiatan
            const checkboxAllRincian = document.getElementById('checkbox-all-rincian');
            const rincianCheckboxes = document.querySelectorAll('.rincian-checkbox');
            const selectedRincianCount = document.getElementById('selected-rincian-count');
            const rincianSearch = document.getElementById('rincian_search');
            const rincianRows = document.querySelectorAll('.rincian-row');
            const newRincianCheckbox = document.querySelector('.new-rincian-checkbox');
            const newRincianForm = document.getElementById('new-rincian-form');
            const editButtons = document.querySelectorAll('.edit-rincian-btn');

            // Fungsi untuk membuka modal
            function openModal(targetModal) {
                if (targetModal && modalBackdrop) {
                    targetModal.classList.remove("hidden");
                    targetModal.classList.add("flex", "animate-fadeIn");
                    modalBackdrop.classList.remove("hidden");

                    // Reset search and selection when opening modal
                    if (targetModal.id === 'tambahRincianKegiatanModal') {
                        resetRincianModal();
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
            function resetRincianModal() {
                if (rincianSearch) {
                    rincianSearch.value = '';
                }
                if (checkboxAllRincian) {
                    checkboxAllRincian.checked = false;
                }
                rincianCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                if (newRincianCheckbox) {
                    newRincianCheckbox.checked = false;
                }
                if (newRincianForm) {
                    newRincianForm.classList.add('hidden');
                }
                updateSelectedRincianCount();

                // Show all rows
                rincianRows.forEach(row => {
                    row.style.display = '';
                });
            }

            // Function to update selected rincian count
            function updateSelectedRincianCount() {
                let count = document.querySelectorAll('.rincian-checkbox:checked').length;
                if (newRincianCheckbox && newRincianCheckbox.checked) {
                    count++;
                }

                if (selectedRincianCount) {
                    selectedRincianCount.textContent = count + ' Rincian Kegiatan dipilih';
                    if (count > 0) {
                        selectedRincianCount.classList.add('bg-blue-100', 'text-blue-800');
                        selectedRincianCount.classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        selectedRincianCount.classList.remove('bg-blue-100', 'text-blue-800');
                        selectedRincianCount.classList.add('bg-gray-100', 'text-gray-800');
                    }
                }
            }

            // Set up show/hide for new rincian form
            if (newRincianCheckbox && newRincianForm) {
                newRincianCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        newRincianForm.classList.remove('hidden');
                    } else {
                        newRincianForm.classList.add('hidden');
                    }
                    updateSelectedRincianCount();
                });
            }

            // Event listener for checkbox utama
            if (checkboxAllRincian) {
                checkboxAllRincian.addEventListener('change', function() {
                    rincianCheckboxes.forEach(checkbox => {
                        // Hanya memilih checkbox di baris yang terlihat
                        if (checkbox.closest('tr').style.display !== 'none') {
                            checkbox.checked = checkboxAllRincian.checked;
                        }
                    });
                    updateSelectedRincianCount();
                });
            }

            // Event listener untuk checkbox individu
            rincianCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedRincianCount);
            });

            // Pencarian rincian kegiatan
            if (rincianSearch) {
                rincianSearch.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase().trim();

                    rincianRows.forEach(row => {
                        const kodeText = row.getAttribute('data-kode');
                        const uraiText = row.getAttribute('data-urai');

                        if ((kodeText && kodeText.includes(searchValue)) ||
                            (uraiText && uraiText.includes(searchValue))) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Reset checkbox utama ketika melakukan pencarian
                    if (checkboxAllRincian) {
                        checkboxAllRincian.checked = false;
                        updateSelectedRincianCount();
                    }
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

                        // Fill form fields
                        document.getElementById('edit_kegiatan_kode').value = kegiatanKode || '';
                        document.getElementById('edit_kegiatan_urai').value = kegiatanUrai || '';
                        document.getElementById('edit_iki').value = iki || '';
                    });
                });
            }

            // Handle Edit Rincian Kegiatan
            const editRincianButtons = document.querySelectorAll('.edit-rincian-btn');
            const editRincianForm = document.getElementById('editRincianKegiatanForm');

            if (editRincianButtons.length > 0 && editRincianForm) {
                editRincianButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const rincianId = this.getAttribute('data-rincian-id');
                        const rincianKode = this.getAttribute('data-rincian-kode');
                        const rincianUrai = this.getAttribute('data-rincian-urai');
                        const catatan = this.getAttribute('data-catatan');
                        const satuan = this.getAttribute('data-satuan');
                        const volume = this.getAttribute('data-volume');
                        const waktu = this.getAttribute('data-waktu');
                        const deadline = this.getAttribute('data-deadline');
                        const variabelKontrol = this.getAttribute('data-variabel-kontrol');
                        const kegiatanId = '{{ $kegiatan->id }}'; // Ambil dari halaman

                        // Update form action
                        const editForm = document.getElementById('editRincianKegiatanForm');
                        editForm.action = `/kegiatan/${kegiatanId}/rincian/${rincianId}`;

                        // Set hidden input value
                        document.getElementById('edit_rincian_id').value = rincianId;

                        // Fill form fields
                        document.getElementById('edit_rincian_kode').value = rincianKode || '';
                        document.getElementById('edit_rincian_urai').value = rincianUrai || '';
                        document.getElementById('edit_catatan').value = catatan || '';
                        document.getElementById('edit_satuan').value = satuan || '';
                        document.getElementById('edit_volume').value = volume || '';
                        document.getElementById('edit_waktu').value = waktu || '';

                        if (deadline) {
                            // Format tanggal untuk input date
                            const dateObj = new Date(deadline);
                            const formattedDate = dateObj.toISOString().split('T')[0];
                            document.getElementById('edit_deadline').value = formattedDate;
                        } else {
                            document.getElementById('edit_deadline').value = '';
                        }

                        document.getElementById('edit_variabel_kontrol').value = variabelKontrol === '1' ? '1' : '0';
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