<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
        <div id="success-popup" class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded shadow-md flex items-center">
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span>{{ session('success') }}</span>
            <button type="button" class="ml-4 text-green-700 hover:text-green-900" onclick="closeSuccessPopup()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Tabel -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-8">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-lg shadow-md mb-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Daftar Pegawai
                            </h3>

                            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3 w-full md:w-auto">
                                @if(Auth::user()->isSuperadmin())
                                <button
                                    data-modal-target="createPegawaiModal"
                                    data-modal-show="createPegawaiModal"
                                    class="flex items-center justify-center space-x-2 bg-white text-blue-700 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>Tambah Pegawai</span>
                                </button>
                                
                                <button
                                    data-modal-target="importPegawaiModal"
                                    data-modal-show="importPegawaiModal"
                                    class="flex items-center justify-center space-x-2 bg-green-600 text-white hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>Import Pegawai</span>
                                </button>
                                @endif

                                <div class="relative w-full md:w-64">
                                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="table-search-pegawai" class="block pt-2 ps-10 text-sm text-blue-900 border border-blue-300 rounded-lg w-full bg-blue-50 focus:ring-blue-500 focus:border-blue-500 placeholder-blue-400" placeholder="Cari pegawai...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama & Email</th>
                                    <th scope="col" class="px-6 py-3">NIP Lama</th>
                                    <th scope="col" class="px-6 py-3">NIP Baru</th>
                                    <th scope="col" class="px-6 py-3">NIK</th>
                                    <th scope="col" class="px-6 py-3">Sex</th>
                                    <th scope="col" class="px-6 py-3">No. HP</th>
                                    <th scope="col" class="px-6 py-3">Jabatan</th>
                                    <th scope="col" class="px-6 py-3">Pangkat</th>
                                    <th scope="col" class="px-6 py-3">Pendidikan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    @if(Auth::user()->isSuperadmin())
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pegawais as $pegawai)
                                <tr class="pegawai-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600" data-name="{{ strtolower($pegawai->nama) }}" data-nip="{{ $pegawai->nip_baru }}">
                                    <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div>
                                            <div class="text-base font-semibold">{{ $pegawai->nama }}{{ $pegawai->gelar }}</div>
                                            <div class="font-normal text-gray-500">{{ $pegawai->email }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">{{ $pegawai->nip_lama }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->nip_baru }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->nik }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->sex }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->nomor_hp }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->jabatan }}</td>
                                    <td class="px-6 py-4">{{ $pegawai->pangkat }}</td>
                                    <td class="px-6 py-4">
                                        <div>{{ $pegawai->educ }} - {{ $pegawai->pendidikan }}</div>
                                        <div class="text-gray-500">{{ $pegawai->universitas }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($pegawai->is_active)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                        @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Nonaktif</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->isSuperadmin())
                                    <td class="px-6 py-4">
                                        <button type="button" data-modal-target="editPegawaiModal" data-modal-show="editPegawaiModal" data-pegawai-id="{{ $pegawai->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-pegawai-btn">Edit</button>
                                        <!-- <form class="inline" action="{{ route('master-pegawai.destroy', $pegawai->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                        </form> -->
                                        @if($pegawai->is_active)
                                        <a href="#" data-pegawai-id="{{ $pegawai->id }}" class="deactivate-pegawai font-medium text-red-600 hover:underline">Nonaktifkan</a>
                                        @else
                                        <a href="#" data-pegawai-id="{{ $pegawai->id }}" class="activate-pegawai font-medium text-green-600 hover:underline">Aktifkan</a>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Pegawai -->
    <div id="createPegawaiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form action="{{ route('master-pegawai.store') }}" method="POST" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Pegawai Baru
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createPegawaiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama" id="nama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="sex" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                            <select id="sex" name="sex" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Gelar -->
                        <div>
                            <label for="gelar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gelar</label>
                            <input type="text" name="gelar" id="gelar" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contoh: , S.ST., MM.">
                        </div>

                        <!-- Alias -->
                        <div>
                            <label for="alias" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alias/Nama Panggilan</label>
                            <input type="text" name="alias" id="alias" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIP Lama -->
                        <div>
                            <label for="nip_lama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP Lama</label>
                            <input type="text" name="nip_lama" id="nip_lama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIP Baru -->
                        <div>
                            <label for="nip_baru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP Baru</label>
                            <input type="text" name="nip_baru" id="nip_baru" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                            <input type="text" name="nik" id="nik" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="nomor_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor HP</label>
                            <input type="text" name="nomor_hp" id="nomor_hp" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Pangkat -->
                        <div>
                            <label for="pangkat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pangkat</label>
                            <input type="text" name="pangkat" id="pangkat" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Tingkat Pendidikan -->
                        <div>
                            <label for="educ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tingkat Pendidikan</label>
                            <select id="educ" name="educ" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">-- Pilih Tingkat Pendidikan --</option>
                                <option value="SMA">SMA/Sederajat</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <label for="pendidikan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan/Program Studi</label>
                            <input type="text" name="pendidikan" id="pendidikan" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Universitas -->
                        <div>
                            <label for="universitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Universitas/Instansi Pendidikan</label>
                            <input type="text" name="universitas" id="universitas" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createPegawaiModal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pegawai -->
    <div id="editPegawaiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form id="editPegawaiForm" method="POST" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                @csrf
                @method('PUT')
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Pegawai
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editPegawaiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="edit_sex" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                            <select id="edit_sex" name="sex" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Gelar -->
                        <div>
                            <label for="edit_gelar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gelar</label>
                            <input type="text" name="gelar" id="edit_gelar" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contoh: , S.ST., MM.">
                        </div>

                        <!-- Alias -->
                        <div>
                            <label for="edit_alias" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alias/Nama Panggilan</label>
                            <input type="text" name="alias" id="edit_alias" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIP Lama -->
                        <div>
                            <label for="edit_nip_lama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP Lama</label>
                            <input type="text" name="nip_lama" id="edit_nip_lama" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIP Baru -->
                        <div>
                            <label for="edit_nip_baru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP Baru</label>
                            <input type="text" name="nip_baru" id="edit_nip_baru" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="edit_nik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                            <input type="text" name="nik" id="edit_nik" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="edit_email" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="edit_nomor_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor HP</label>
                            <input type="text" name="nomor_hp" id="edit_nomor_hp" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Pangkat -->
                        <div>
                            <label for="edit_pangkat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pangkat</label>
                            <input type="text" name="pangkat" id="edit_pangkat" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label for="edit_jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <input type="text" name="jabatan" id="edit_jabatan" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Tingkat Pendidikan -->
                        <div>
                            <label for="edit_educ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tingkat Pendidikan</label>
                            <select id="edit_educ" name="educ" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">-- Pilih Tingkat Pendidikan --</option>
                                <option value="SMA">SMA/Sederajat</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <label for="edit_pendidikan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan/Program Studi</label>
                            <input type="text" name="pendidikan" id="edit_pendidikan" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <!-- Universitas -->
                        <div>
                            <label for="edit_universitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Universitas/Instansi Pendidikan</label>
                            <input type="text" name="universitas" id="edit_universitas" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="editPegawaiModal">Batal</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Import Pegawai -->
    <div id="importPegawaiModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Header modal -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Import Data Pegawai
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="importPegawaiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <!-- Form di dalam modal -->
                <form id="importForm" enctype="multipart/form-data">
                    <!-- Import Modal -->
                    <form id="importForm" enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_import">Upload file Excel/CSV</label>
                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_import" name="file" type="file" accept=".csv, .xlsx, .xls">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Format file: CSV, XLS, atau XLSX</p>
                            </div>
                            <div>
                                <a href="{{ route('master-pegawai.template.download') }}" class="text-blue-600 hover:underline dark:text-blue-500">Download template</a>
                            </div>
                        </div>
                        <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Import</button>
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="importPegawaiModal">Batal</button>
                        </div>
                    </form>
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
                        Hasil Import Data Pegawai
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
            const searchInput = document.getElementById("table-search-pegawai");
            const pegawaiRows = document.querySelectorAll(".pegawai-row");
            const body = document.body;

            // Pencarian Pegawai
            searchInput.addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();

                pegawaiRows.forEach(row => {
                    const pegawaiName = row.getAttribute("data-name");
                    const pegawaiNip = row.getAttribute("data-nip");

                    if (pegawaiName.includes(searchValue) || (pegawaiNip && pegawaiNip.includes(searchValue))) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

            // Modal Create Pegawai
            const createPegawaiButtons = document.querySelectorAll("[data-modal-show='createPegawaiModal']");
            const createPegawaiModal = document.getElementById("createPegawaiModal");
            const closeCreateModalButtons = createPegawaiModal.querySelectorAll("[data-modal-hide='createPegawaiModal']");

            createPegawaiButtons.forEach(button => {
                button.addEventListener("click", function() {
                    createPegawaiModal.classList.remove("hidden");
                    createPegawaiModal.classList.add("flex");
                    body.classList.add("blur-background");
                });
            });

            closeCreateModalButtons.forEach(button => {
                button.addEventListener("click", function() {
                    createPegawaiModal.classList.add("hidden");
                    createPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                });
            });

            // Modal Edit Pegawai
            const editPegawaiButtons = document.querySelectorAll(".edit-pegawai-btn");
            const editPegawaiModal = document.getElementById("editPegawaiModal");
            const editPegawaiForm = document.getElementById("editPegawaiForm");
            const closeEditModalButtons = editPegawaiModal.querySelectorAll("[data-modal-hide='editPegawaiModal']");

            editPegawaiButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const pegawaiId = this.getAttribute("data-pegawai-id");
                    editPegawaiForm.action = `/master-pegawai/${pegawaiId}`;

                    // Mengambil data pegawai dari server
                    fetch(`/master-pegawai/${pegawaiId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            // Mengisi form dengan data yang diterima
                            document.getElementById('edit_nama').value = data.nama;
                            document.getElementById('edit_sex').value = data.sex;
                            document.getElementById('edit_gelar').value = data.gelar || '';
                            document.getElementById('edit_alias').value = data.alias || '';
                            document.getElementById('edit_nip_lama').value = data.nip_lama || '';
                            document.getElementById('edit_nip_baru').value = data.nip_baru || '';
                            document.getElementById('edit_nik').value = data.nik || '';
                            document.getElementById('edit_email').value = data.email || '';
                            document.getElementById('edit_nomor_hp').value = data.nomor_hp || '';
                            document.getElementById('edit_pangkat').value = data.pangkat || '';
                            document.getElementById('edit_jabatan').value = data.jabatan || '';
                            document.getElementById('edit_educ').value = data.educ || '';
                            document.getElementById('edit_pendidikan').value = data.pendidikan || '';
                            document.getElementById('edit_universitas').value = data.universitas || '';

                            // Menampilkan modal
                            editPegawaiModal.classList.remove("hidden");
                            editPegawaiModal.classList.add("flex");
                            body.classList.add("blur-background");
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                        });
                });
            });

            closeEditModalButtons.forEach(button => {
                button.addEventListener("click", function() {
                    editPegawaiModal.classList.add("hidden");
                    editPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                });
            });

            const importPegawaiButtons = document.querySelectorAll("[data-modal-show='importPegawaiModal']");
            const importPegawaiModal = document.getElementById("importPegawaiModal");
            const closeImportModalButtons = importPegawaiModal.querySelectorAll("[data-modal-hide='importPegawaiModal']");

            importPegawaiButtons.forEach(button => {
                button.addEventListener("click", function() {
                    importPegawaiModal.classList.remove("hidden");
                    importPegawaiModal.classList.add("flex");
                    body.classList.add("blur-background");
                });
            });

            closeImportModalButtons.forEach(button => {
                button.addEventListener("click", function() {
                    importPegawaiModal.classList.add("hidden");
                    importPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                });
            });

            importPegawaiModal.addEventListener("click", function(event) {
                if (event.target === importPegawaiModal) {
                    importPegawaiModal.classList.add("hidden");
                    importPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                }
            });

            // Close modal when clicking outside the modal content
            editPegawaiModal.addEventListener("click", function(event) {
                if (event.target === editPegawaiModal) {
                    editPegawaiModal.classList.add("hidden");
                    editPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                }
            });

            createPegawaiModal.addEventListener("click", function(event) {
                if (event.target === createPegawaiModal) {
                    createPegawaiModal.classList.add("hidden");
                    createPegawaiModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Handle deactivate button
            const deactivateButtons = document.querySelectorAll(".deactivate-pegawai");
            deactivateButtons.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const pegawaiId = this.getAttribute("data-pegawai-id");
                    if (confirm("Apakah Anda yakin ingin menonaktifkan pegawai ini?")) {
                        // Buat form data dengan CSRF token
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        // Kirim request
                        fetch(`/master-pegawai/${pegawaiId}/deactivate`, {
                                method: 'POST',
                                body: formData,
                                credentials: 'same-origin'
                            })
                            .then(function(response) {
                                if (response.ok) {
                                    // Simpan flag sukses di localStorage
                                    localStorage.setItem('successMessage', 'Pegawai berhasil dinonaktifkan');
                                    // Reload halaman tanpa mencoba parse JSON
                                    window.location.reload();
                                } else {
                                    throw new Error('Network response was not ok');
                                }
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                alert("Terjadi kesalahan saat menonaktifkan pegawai");
                            });
                    }
                });
            });

            // Cek apakah ada pesan sukses setelah halaman di-reload
            document.addEventListener('DOMContentLoaded', function() {
                const successMessage = localStorage.getItem('successMessage');
                if (successMessage) {
                    showSuccessMessage(successMessage);
                    localStorage.removeItem('successMessage');
                }
            });

            // Handle activate button
            const activateButtons = document.querySelectorAll(".activate-pegawai");
            activateButtons.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const pegawaiId = this.getAttribute("data-pegawai-id");
                    if (confirm("Apakah Anda yakin ingin mengaktifkan kembali pegawai ini?")) {
                        // Buat form data dengan CSRF token
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        // Tampilkan indikator loading pada tombol
                        const clickedButton = this;
                        const originalText = clickedButton.textContent;
                        clickedButton.textContent = "Memproses...";
                        clickedButton.disabled = true;

                        // Kirim request dengan FormData
                        fetch(`/master-pegawai/${pegawaiId}/activate`, {
                                method: 'POST',
                                body: formData,
                                credentials: 'same-origin'
                            })
                            .then(function(response) {
                                // Kembalikan tombol ke keadaan semula
                                clickedButton.textContent = originalText;
                                clickedButton.disabled = false;

                                if (response.ok) {
                                    // Simpan pesan sukses di localStorage
                                    localStorage.setItem('successMessage', 'Pegawai berhasil diaktifkan');
                                    // Reload halaman
                                    window.location.reload();
                                } else {
                                    alert("Gagal mengaktifkan pegawai");
                                }
                            })
                            .catch(function(error) {
                                // Kembalikan tombol ke keadaan semula
                                clickedButton.textContent = originalText;
                                clickedButton.disabled = false;

                                console.error('Error:', error);
                                alert("Terjadi kesalahan saat mengaktifkan pegawai");
                            });
                    }
                });
            });
        });

        // Handle Import Form
        const importForm = document.getElementById('importForm');
        const importPegawaiModal = document.getElementById('importPegawaiModal');
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

                fetch('{{ route("master-pegawai.import") }}', {
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
                        importPegawaiModal.classList.add('hidden');
                        importPegawaiModal.classList.remove('flex');

                        // Display results
                        displayImportResults(data);

                        // Refresh the table (optional)
                        // window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        alert('Terjadi kesalahan saat mengimpor data. Silakan coba lagi.');
                    });
            });
        }

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

                    // Name
                    const tdName = document.createElement('td');
                    tdName.className = 'py-3 px-6';
                    tdName.textContent = result.data.nama || '-';
                    tr.appendChild(tdName);

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
            importResultModal.classList.remove('hidden');
            importResultModal.classList.add('flex');
            document.body.classList.add('blur-background');

            // Set up modal close handlers
            const closeButtons = importResultModal.querySelectorAll('[data-modal-hide="importResultModal"]');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    importResultModal.classList.add('hidden');
                    importResultModal.classList.remove('flex');
                    document.body.classList.remove('blur-background');
                    window.location.reload();
                });
            });

            importResultModal.addEventListener('click', function(event) {
                if (event.target === importResultModal) {
                    importResultModal.classList.add('hidden');
                    importResultModal.classList.remove('flex');
                    document.body.classList.remove('blur-background');
                }
            });
        }

        function closeSuccessPopup() {
            const popup = document.getElementById('success-popup');
            if (popup) {
                popup.classList.add('opacity-0');
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 300);
            }
        }

        // Auto close popup setelah 5 detik
        document.addEventListener("DOMContentLoaded", function() {
            const successPopup = document.getElementById('success-popup');
            if (successPopup) {
                setTimeout(() => {
                    closeSuccessPopup();
                }, 5000);
            }
        });
    </script>

    <style>
        .blur-background::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 40;
        }

        .hidden {
            display: none;
        }
    </style>
</x-app-layout>