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
                        <svg xmlns="http://www.w3.org/2