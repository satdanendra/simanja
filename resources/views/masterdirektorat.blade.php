<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            {{ __('Manajemen Direktorat') }}
        </h2>
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
                <!-- Card Header with Search and Create Button -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h3 class="text-lg font-semibold text-white mb-3 md:mb-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Daftar Direktorat
                        </h3>

                        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3 w-full md:w-auto">
                            <button
                                data-modal-target="createDirektoratModal"
                                data-modal-show="createDirektoratModal"
                                class="flex items-center justify-center space-x-2 bg-white text-blue-700 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Tambah Direktorat</span>
                            </button>

                            <button
                                data-modal-target="importDirektoratModal"
                                data-modal-show="importDirektoratModal"
                                class="flex items-center justify-center space-x-2 bg-green-600 text-white hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Import Direktorat</span>
                            </button>

                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="table-search-direktorat" class="bg-blue-700 bg-opacity-30 border border-blue-500 text-white placeholder-blue-200 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full pl-10 p-2.5" placeholder="Cari direktorat...">
                            </div>

                            
                                <button id="delete-selected" class="hidden items-center justify-center space-x-2 bg-red-600 text-white hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Hapus Data Terpilih</span>
                                </button>
                            
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4">Kode</th>
                                <th scope="col" class="px-6 py-4">Nama</th>
                                <th scope="col" class="px-6 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($direktorats as $direktorat)
                            <tr class="direktorat-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150" data-name="{{ strtolower($direktorat->nama) }}" data-kode="{{ strtolower($direktorat->kode) }}">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-{{ $direktorat->id }}" type="checkbox" class="direktorat-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" data-id="{{ $direktorat->id }}">
                                        <label for="checkbox-{{ $direktorat->id }}" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $direktorat->kode }}</td>
                                <td class="px-6 py-4">{{ $direktorat->nama }}</td>
                                <td class="px-6 py-4">
                                    <button type="button" data-modal-target="editDirektoratModal" data-modal-show="editDirektoratModal" data-direktorat-id="{{ $direktorat->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-direktorat-btn">Edit</button>
                                    <a href="#" data-direktorat-id="{{ $direktorat->id }}" class="delete-direktorat font-medium text-red-600 hover:underline">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination if needed -->
                @if(count($direktorats) > 0)
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan <span class="font-medium">{{ count($direktorats) }}</span> direktorat
                        </div>
                    </div>
                </div>
                @else
                <div class="p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada data direktorat</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Direktorat Modal -->
    <div id="createDirektoratModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <form action="{{ route('master-direktorat.store') }}" method="POST" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Direktorat Baru
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createDirektoratModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode</label>
                            <input type="text" name="kode" id="kode" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan kode direktorat" required>
                        </div>
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama" id="nama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan nama direktorat" required>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createDirektoratModal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Direktorat Modal -->
    <div id="editDirektoratModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <form id="editDirektoratForm" method="POST" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                @csrf
                @method('PUT')
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Direktorat
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editDirektoratModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="edit_kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode</label>
                            <input type="text" name="kode" id="edit_kode" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan kode direktorat" required>
                        </div>
                        <div>
                            <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan nama direktorat" required>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="editDirektoratModal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Import Direktorat Modal -->
    <div id="importDirektoratModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Header modal -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Import Data Direktorat
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="importDirektoratModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <!-- Form di dalam modal -->
                <form id="importForm" action="{{ route('master-direktorat.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_import">Upload file Excel/CSV</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_import" name="file" type="file" accept=".csv, .xlsx, .xls">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Format file: CSV, XLS, atau XLSX</p>
                        </div>
                        <div>
                            <a href="{{ route('master-direktorat.template.download') }}" class="text-blue-600 hover:underline dark:text-blue-500">Download template</a>
                        </div>
                    </div>
                    <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Import</button>
                        <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="importDirektoratModal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hasil Import -->
    <div id="importResultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Hasil Import Data Direktorat
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="importResultModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-green-600 dark:text-green-400 font-semibold">Berhasil: <span id="successCount">0</span> data</span>
                        </div>
                        <div>
                            <span class="text-red-600 dark:text-red-400 font-semibold">Gagal: <span id="errorCount">0</span> data</span>
                        </div>
                    </div>

                    <!-- Errors List -->
                    <div id="errorsContainer" class="mb-4 hidden">
                        <h4 class="text-md font-medium mb-2 text-red-600">Pesan Error:</h4>
                        <ul id="errorsList" class="list-disc pl-5 text-red-600 dark:text-red-400 text-sm">
                            <!-- Error items will be added here dynamically -->
                        </ul>
                    </div>

                    <!-- Results Table -->
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Baris</th>
                                    <th scope="col" class="py-3 px-6">Kode</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Pesan</th>
                                </tr>
                            </thead>
                            <tbody id="importResultsTable">
                                <!-- Result rows will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-hide="importResultModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi untuk membuka modal
            function openModal(modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
                document.getElementById("modalBackdrop").classList.remove("hidden");
            }

            // Fungsi untuk menutup modal
            function closeModal(modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                document.getElementById("modalBackdrop").classList.add("hidden");
            }

            // Pencarian direktorat
            const searchInput = document.getElementById("table-search-direktorat");
            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    const searchValue = this.value.toLowerCase().trim();

                    document.querySelectorAll(".direktorat-row").forEach(row => {
                        const direktoratName = row.getAttribute("data-name");
                        const direktoratKode = row.getAttribute("data-kode");

                        if (direktoratName.includes(searchValue) || direktoratKode.includes(searchValue)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                });
            }

            // Tambah Direktorat Modal
            const createDirektoratModal = document.getElementById("createDirektoratModal");
            if (createDirektoratModal) {
                // Tombol untuk membuka modal
                document.querySelectorAll("[data-modal-show='createDirektoratModal']").forEach(btn => {
                    btn.addEventListener("click", () => {
                        openModal(createDirektoratModal);
                    });
                });

                // Tombol untuk menutup modal
                document.querySelectorAll("[data-modal-hide='createDirektoratModal']").forEach(btn => {
                    btn.addEventListener("click", () => {
                        closeModal(createDirektoratModal);
                    });
                });

                // Menutup modal saat klik di luar modal
                createDirektoratModal.addEventListener("click", function(e) {
                    if (e.target === this) {
                        closeModal(createDirektoratModal);
                    }
                });
            }

            // Edit Direktorat Modal
            const editDirektoratModal = document.getElementById("editDirektoratModal");
            const editDirektoratForm = document.getElementById("editDirektoratForm");

            if (editDirektoratModal && editDirektoratForm) {
                // Tombol untuk membuka modal edit
                document.querySelectorAll(".edit-direktorat-btn").forEach(btn => {
                    btn.addEventListener("click", function() {
                        const direktoratId = this.getAttribute("data-direktorat-id");
                        editDirektoratForm.action = `/master-direktorat/${direktoratId}`;

                        // Mendapatkan data direktorat untuk diisi ke form
                        fetch(`/master-direktorat/${direktoratId}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById("edit_kode").value = data.kode;
                                document.getElementById("edit_nama").value = data.nama;
                                openModal(editDirektoratModal);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat memuat data direktorat');
                            });
                    });
                });

                // Tombol untuk menutup modal
                document.querySelectorAll("[data-modal-hide='editDirektoratModal']").forEach(btn => {
                    btn.addEventListener("click", () => {
                        closeModal(editDirektoratModal);
                    });
                });

                // Menutup modal saat klik di luar modal
                editDirektoratModal.addEventListener("click", function(e) {
                    if (e.target === this) {
                        closeModal(editDirektoratModal);
                    }
                });
            }

            // Import Direktorat Modal
            const importDirektoratModal = document.getElementById("importDirektoratModal");
            if (importDirektoratModal) {
                // Tombol untuk membuka modal import
                document.querySelectorAll("[data-modal-show='importDirektoratModal']").forEach(btn => {
                    btn.addEventListener("click", () => {
                        openModal(importDirektoratModal);
                    });
                });

                // Tombol untuk menutup modal
                document.querySelectorAll("[data-modal-hide='importDirektoratModal']").forEach(btn => {
                    btn.addEventListener("click", () => {
                        closeModal(importDirektoratModal);
                    });
                });

                // Menutup modal saat klik di luar modal
                importDirektoratModal.addEventListener("click", function(e) {
                    if (e.target === this) {
                        closeModal(importDirektoratModal);
                    }
                });
            }

            // Import Form Handler
            const importForm = document.getElementById('importForm');
            const importResultModal = document.getElementById('importResultModal');

            if (importForm) {
                importForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(this);

                    // Show loading indicator
                    const submitBtn = importForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Importing...';
                    submitBtn.disabled = true;

                    fetch(importForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Reset submit button
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;

                            // Close import modal
                            closeModal(importDirektoratModal);

                            // Display results
                            displayImportResults(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                            alert('Terjadi kesalahan saat mengimpor data. Silakan coba lagi.');
                        });
                });
            }

            // Function to display import results
            function displayImportResults(data) {
                // Update counts
                document.getElementById('successCount').textContent = data.successCount;
                document.getElementById('errorCount').textContent = data.errorCount;

                // Clear previous results
                const errorsList = document.getElementById('errorsList');
                const resultsTable = document.getElementById('importResultsTable');
                errorsList.innerHTML = '';
                resultsTable.innerHTML = '';

                // Show/hide errors container
                const errorsContainer = document.getElementById('errorsContainer');
                if (data.errors && data.errors.length > 0) {
                    errorsContainer.classList.remove('hidden');

                    // Add error messages
                    data.errors.forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorsList.appendChild(li);
                    });
                } else {
                    errorsContainer.classList.add('hidden');
                }

                // Add result rows
                if (data.results && data.results.length > 0) {
                    data.results.forEach(result => {
                        const tr = document.createElement('tr');
                        tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700';

                        // Row number
                        const tdRow = document.createElement('td');
                        tdRow.className = 'py-3 px-6';
                        tdRow.textContent = result.row;
                        tr.appendChild(tdRow);

                        // Kode
                        const tdKode = document.createElement('td');
                        tdKode.className = 'py-3 px-6';
                        tdKode.textContent = result.data.kode || '-';
                        tr.appendChild(tdKode);

                        // Nama
                        const tdNama = document.createElement('td');
                        tdNama.className = 'py-3 px-6';
                        tdNama.textContent = result.data.nama || '-';
                        tr.appendChild(tdNama);

                        // Status
                        const tdStatus = document.createElement('td');
                        tdStatus.className = 'py-3 px-6';

                        const statusSpan = document.createElement('span');
                        if (result.status === 'created') {
                            statusSpan.className = 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300';
                            statusSpan.textContent = 'Ditambahkan';
                        } else if (result.status === 'updated') {
                            statusSpan.className = 'bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300';
                            statusSpan.textContent = 'Diperbarui';
                        } else {
                            statusSpan.className = 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300';
                            statusSpan.textContent = 'Error';
                        }
                        tdStatus.appendChild(statusSpan);
                        tr.appendChild(tdStatus);

                        // Message
                        const tdMessage = document.createElement('td');
                        tdMessage.className = 'py-3 px-6';
                        tdMessage.textContent = result.message;
                        tr.appendChild(tdMessage);

                        resultsTable.appendChild(tr);
                    });
                }

                // Show result modal
                openModal(importResultModal);

                // Set up modal close handlers
                document.querySelectorAll("[data-modal-hide='importResultModal']").forEach(btn => {
                    btn.addEventListener("click", function() {
                        closeModal(importResultModal);
                        window.location.reload();
                    });
                });
            }

            // Handle delete direktorat
            document.querySelectorAll(".delete-direktorat").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const direktoratId = this.getAttribute("data-direktorat-id");

                    if (confirm("Apakah Anda yakin ingin menghapus direktorat ini? Tindakan ini tidak dapat dibatalkan.")) {
                        // Ambil CSRF token dari meta tag
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Tampilkan indikator loading
                        const originalText = this.textContent;
                        this.textContent = "Memproses...";
                        this.disabled = true;

                        // Kirim request ke server
                        fetch(`/master-direktorat/${direktoratId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                credentials: 'same-origin'
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Gagal menghapus direktorat');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Reload halaman untuk memperbarui tampilan
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert("Terjadi kesalahan saat menghapus direktorat");

                                // Kembalikan tombol ke keadaan semula
                                this.textContent = originalText;
                                this.disabled = false;
                            });
                    }
                });
            });

            // Fungsi untuk menangani checkbox
            const checkboxAll = document.getElementById('checkbox-all');
            const checkboxes = document.querySelectorAll('.direktorat-checkbox');
            const deleteSelectedBtn = document.getElementById('delete-selected');

            // Handle checkbox semua
            if (checkboxAll) {
                checkboxAll.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = checkboxAll.checked;
                    });
                    updateDeleteButtonVisibility();
                });
            }

            // Handle checkbox individual
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateDeleteButtonVisibility();

                    // Update "select all" checkbox
                    checkboxAll.checked = [...checkboxes].every(c => c.checked);
                    checkboxAll.indeterminate = !checkboxAll.checked && [...checkboxes].some(c => c.checked);
                });
            });

            // Update visibilitas tombol hapus berdasarkan checkbox yang dipilih
            function updateDeleteButtonVisibility() {
                const checkedCount = document.querySelectorAll('.direktorat-checkbox:checked').length;
                if (checkedCount > 0) {
                    deleteSelectedBtn.classList.remove('hidden');
                    deleteSelectedBtn.classList.add('flex');
                } else {
                    deleteSelectedBtn.classList.add('hidden');
                    deleteSelectedBtn.classList.remove('flex');
                }
            }

            // Handle hapus data terpilih
            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function() {
                    const selectedIds = [...document.querySelectorAll('.direktorat-checkbox:checked')].map(cb => cb.getAttribute('data-id'));

                    if (selectedIds.length === 0) return;

                    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} data direktorat yang dipilih? Tindakan ini tidak dapat dibatalkan.`)) {
                        // Ambil CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Tampilkan indikator loading
                        deleteSelectedBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menghapus...';
                        deleteSelectedBtn.disabled = true;

                        // Kirim request
                        fetch('/master-direktorat/batch-delete', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    ids: selectedIds
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Gagal menghapus data');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Reload halaman setelah berhasil menghapus
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat menghapus data');

                                // Reset tombol
                                deleteSelectedBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Hapus Data Terpilih';
                                deleteSelectedBtn.disabled = false;
                            });
                    }
                });
            }

            // Handle success popup
            window.closeSuccessPopup = function() {
                const popup = document.getElementById('success-popup');
                if (popup) {
                    popup.classList.add('transform', 'translate-x-full', 'opacity-0');
                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 300);
                }
            }

            // Auto close success popup after 5 seconds
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