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
                    <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                        <div class="relative">
                            <button data-modal-target="createPegawaiModal" data-modal-show="createPegawaiModal" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                Tambah Pegawai
                            </button>
                            <button data-modal-target="importPegawaiModal" data-modal-show="importPegawaiModal" class="ml-2 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                Import Pegawai
                            </button>
                            <button data-modal-target="createTimModal" data-modal-show="createTimModal" class="ml-2 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                Buat Tim
                            </button>
                            <button data-modal-target="createRencanaKerjaModal" data-modal-show="createRencanaKerjaModal" class="ml-2 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                Buat RK Tim
                            </button>
                            <button data-modal-target="createProjectModal" data-modal-show="createProjectModal" class="ml-2 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                Buat Proyek
                            </button>
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="table-search-pegawai" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari pegawai...">
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
                                    <th scope="col" class="px-6 py-3">Aksi</th>
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

    <!-- Create Rencana Kerja Tim Modal -->
    <div id="createRencanaKerjaModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form id="createRencanaKerjaForm" action="{{ route('tims.store') }}" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" method="POST">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Buat Rencana Kerja Tim
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createRencanaKerjaModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Nama Tim -->
                        <div class="col-span-6">
                            <label for="nama_tim_rk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tim</label>
                            <select name="nama_tim_rk" id="nama_tim_rk" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">-- Pilih Tim --</option>
                                <option value="Tim Pengembangan Metodologi, Pengolahan Data, dan Dukungan Layanan Teknologi Informasi">Tim Pengembangan Metodologi, Pengolahan Data, dan Dukungan Layanan Teknologi Informasi</option>
                                <option value="Tim Pelayanan dan Pengembangan Diseminasi Informasi Statistik">Tim Pelayanan dan Pengembangan Diseminasi Informasi Statistik</option>
                            </select>
                        </div>
                        
                        <!-- Ketua Tim (awalnya tersembunyi) -->
                        <div id="ketuaTimContainer" class="col-span-6 hidden">
                            <label for="ketua_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ketua Tim</label>
                            <input type="text" name="ketua_tim" id="ketua_tim" value="Imam" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>

                        <!-- Rencana Kerja Tim (awalnya tersembunyi) -->
                        <div id="rencanaKerjaContainer" class="col-span-6 hidden">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Kerja Tim</label>
                            
                            <div class="space-y-3">
                                <!-- Default opsi rencana kerja -->
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="rencana_kerja_1" name="rencana_kerja[]" type="checkbox" value="Tersedianya Dukungan Metodologi sebagai Rujukan Kegiatan Statistik (Sensus atau Survei)" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="rencana_kerja_1" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Tersedianya Dukungan Metodologi sebagai Rujukan Kegiatan Statistik (Sensus atau Survei)</label>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="rencana_kerja_2" name="rencana_kerja[]" type="checkbox" value="Tersedianya Raw Data Hasil Pendataan Sensus/Survei yang Valid dan Lengkap" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="rencana_kerja_2" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Tersedianya Raw Data Hasil Pendataan Sensus/Survei yang Valid dan Lengkap</label>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="rencana_kerja_3" name="rencana_kerja[]" type="checkbox" value="Tersedianya Dukungan Pemanfaatan Sarana dan Prasarana Teknologi Informasi (TI) untuk Mewujudkan Sistem Pemerintahan Berbasis Elektornik (SPBE)" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="rencana_kerja_3" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Tersedianya Dukungan Pemanfaatan Sarana dan Prasarana Teknologi Informasi (TI) untuk Mewujudkan Sistem Pemerintahan Berbasis Elektornik (SPBE)</label>
                                </div>
                                
                                <!-- Container untuk rencana kerja tambahan -->
                                <div id="tambahan-rencana-kerja" class="space-y-3">
                                    <!-- Opsi tambahan akan ditambahkan di sini via JS -->
                                </div>
                                
                                <!-- Tombol untuk menambahkan rencana kerja -->
                                <div class="mt-4">
                                    <button type="button" id="tambahRencanaKerja" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Rencana Kerja
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createRencanaKerjaModal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div id="createProjectModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form id="createProjectForm" action="{{ route('tims.store') }}" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" method="POST">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Buat Proyek
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createProjectModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Nama Tim -->
                        <div class="col-span-6">
                            <label for="nama_tim_proyek" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tim</label>
                            <select name="nama_tim_proyek" id="nama_tim_proyek" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">-- Pilih Tim --</option>
                                <option value="Tim Pengembangan Metodologi, Pengolahan Data, dan Dukungan Layanan Teknologi Informasi">Tim Pengembangan Metodologi, Pengolahan Data, dan Dukungan Layanan Teknologi Informasi</option>
                                <option value="Tim Pelayanan dan Pengembangan Diseminasi Informasi Statistik">Tim Pelayanan dan Pengembangan Diseminasi Informasi Statistik</option>
                            </select>
                        </div>

                        <!-- Ketua Tim (awalnya tersembunyi) -->
                        <div id="ketuaTimContainer_proyek" class="col-span-6 hidden">
                            <label for="ketua_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ketua Tim</label>
                            <input type="text" name="ketua_tim" id="ketua_tim" value="Imam" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        
                        <!-- Rencana Kerja Tim -->
                        <div class="col-span-6">
                            <label for="rencana_kerja_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Kerja Tim</label>
                            <select name="rencana_kerja_tim" id="rencana_kerja_tim" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">-- Pilih Rencana Kerja Tim --</option>
                                <option value="Tersedianya Dukungan Metodologi sebagai Rujukan Kegiatan Statistik (Sensus atau Survei)">Tersedianya Dukungan Metodologi sebagai Rujukan Kegiatan Statistik (Sensus atau Survei)</option>
                                <option value="Tersedianya Raw Data Hasil Pendataan Sensus/Survei yang Valid dan Lengkap">Tersedianya Raw Data Hasil Pendataan Sensus/Survei yang Valid dan Lengkap</option>
                                <option value="Tersedianya Dukungan Pemanfaatan Sarana dan Prasarana Teknologi Informasi (TI) untuk Mewujudkan Sistem Pemerintahan Berbasis Elektornik (SPBE)">Tersedianya Dukungan Pemanfaatan Sarana dan Prasarana Teknologi Informasi (TI) untuk Mewujudkan Sistem Pemerintahan Berbasis Elektornik (SPBE)</option>
                            </select>
                            
                            <!-- Tombol tambah rencana kerja tim -->
                            <!-- <div class="mt-4">
                                <button type="button" id="tambahRencanaKerjaTim" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Rencana Kerja Tim
                                </button>
                            </div> -->
                        </div>
                        
                        <!-- Container untuk rencana kerja tim tambahan -->
                        <div id="tambahan-rencana-kerja-tim" class="col-span-6 space-y-3 hidden">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Kerja Tim Tambahan</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" name="rencana_kerja_tim_tambahan[]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan rencana kerja tim tambahan">
                                <button type="button" class="hapus-rencana-kerja-tim text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Proyek (muncul setelah rencana kerja tim dipilih) -->
                        <div id="proyek-container" class="col-span-6 hidden">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proyek</label>
                            
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="proyek_1" name="proyek[]" type="checkbox" value="Frame Register System (FRS)/Pemutakhiran Master File Desa (MFD) dan Master Blok Sensus (MBS) Semesteran Berbasis Web" class="proyek-checkbox w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="proyek_1" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Frame Register System (FRS)/Pemutakhiran Master File Desa (MFD) dan Master Blok Sensus (MBS) Semesteran Berbasis Web</label>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="proyek_2" name="proyek[]" type="checkbox" value="Pengelolaan Master File Desa (MFD), Master Blok Sensus (MBS), Master SLS (MSLS), Image Peta, dan Peta Digital" class="proyek-checkbox w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="proyek_2" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Pengelolaan Master File Desa (MFD), Master Blok Sensus (MBS), Master SLS (MSLS), Image Peta, dan Peta Digital</label>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="proyek_3" name="proyek[]" type="checkbox" value="Updating Direktori Perusahaan untuk System Business Register (SBR)" class="proyek-checkbox w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                    </div>
                                    <label for="proyek_3" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">Updating Direktori Perusahaan untuk System Business Register (SBR)</label>
                                </div>
                                
                                <!-- Container untuk proyek tambahan -->
                                <div id="tambahan-proyek" class="space-y-3">
                                    <!-- Proyek tambahan akan ditambahkan di sini via JS -->
                                </div>
                                
                                <!-- Tombol untuk menambahkan proyek -->
                                <div class="mt-4">
                                    <button type="button" id="tambahProyek" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Proyek
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Container untuk detail proyek (muncul ketika checkbox proyek diklik) -->
                        <div id="detail-proyek-container" class="col-span-6 space-y-6 hidden">
                            <!-- Detail akan ditambahkan di sini via JS -->
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createProjectModal">Batal</button>
                </div>
            </form>
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

    <!-- js create rk modal -->
<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Kontrol tampilan modal
            const createRencanaKerjaButtons = document.querySelectorAll("[data-modal-show='createRencanaKerjaModal']");
            const createRencanaKerjaModal = document.getElementById("createRencanaKerjaModal");
            const closeModalButtons = document.querySelectorAll("[data-modal-hide='createRencanaKerjaModal']");
            const body = document.body;

            // Tampilkan modal saat tombol diklik
            createRencanaKerjaButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    createRencanaKerjaModal.classList.remove("hidden");
                    createRencanaKerjaModal.classList.add("flex");
                    body.classList.add("blur-background");
                });
            });

            // Tutup modal saat tombol close diklik
            closeModalButtons.forEach(button => {
                button.addEventListener("click", function() {
                    createRencanaKerjaModal.classList.add("hidden");
                    createRencanaKerjaModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                });
            });

            // Tutup modal saat klik di luar modal
            createRencanaKerjaModal.addEventListener("click", function(event) {
                if (event.target === createRencanaKerjaModal) {
                    createRencanaKerjaModal.classList.add("hidden");
                    createRencanaKerjaModal.classList.remove("flex");
                    body.classList.remove("blur-background");
                }
            });

            // Tampilkan rencana kerja saat tim dipilih
            const namaTimSelect = document.getElementById("nama_tim_rk");
            const ketuaTimContainer = document.getElementById("ketuaTimContainer"); // Container untuk ketua tim
            const rencanaKerjaContainer = document.getElementById("rencanaKerjaContainer");

            namaTimSelect.addEventListener("change", function() {
                if (this.value) {
                    // Tampilkan field ketua tim terlebih dahulu
                    if (ketuaTimContainer) {
                        ketuaTimContainer.classList.remove("hidden");
                    }
                    
                    // Kemudian tampilkan rencana kerja
                    rencanaKerjaContainer.classList.remove("hidden");
                } else {
                    // Sembunyikan field ketua tim
                    if (ketuaTimContainer) {
                        ketuaTimContainer.classList.add("hidden");
                    }
                    
                    // Sembunyikan rencana kerja
                    rencanaKerjaContainer.classList.add("hidden");
                }
            });

            // Tambah rencana kerja baru
            let counter = 4; // Mulai dari 4 karena sudah ada 3 item default
            const tambahRencanaKerjaBtn = document.getElementById("tambahRencanaKerja");
            const tambahanRencanaKerjaContainer = document.getElementById("tambahan-rencana-kerja");

            tambahRencanaKerjaBtn.addEventListener("click", function() {
                // Buat container untuk row baru
                const newRow = document.createElement("div");
                newRow.classList.add("flex", "items-start", "gap-2");
                
                // HTML untuk row baru dengan checkbox dan input
                newRow.innerHTML = `
                    <div class="flex items-center h-5 mt-1">
                        <input id="rencana_kerja_${counter}" name="rencana_kerja[]" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                    </div>
                    <div class="flex-1">
                        <input type="text" id="rencana_kerja_text_${counter}" name="rencana_kerja_text[]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan rencana kerja baru">
                    </div>
                    <button type="button" class="hapus-row text-red-500 hover:text-red-700 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                
                // Tambahkan ke container
                tambahanRencanaKerjaContainer.appendChild(newRow);
                
                // Setup event untuk menghapus row
                const hapusBtn = newRow.querySelector(".hapus-row");
                hapusBtn.addEventListener("click", function() {
                    newRow.remove();
                });
                
                // Setup event untuk sinkronisasi nilai checkbox dengan input text
                const checkbox = newRow.querySelector(`#rencana_kerja_${counter}`);
                const textInput = newRow.querySelector(`#rencana_kerja_text_${counter}`);
                
                textInput.addEventListener("input", function() {
                    checkbox.value = this.value;
                });
                
                counter++;
            });

            // Validasi form sebelum submit
            const createRencanaKerjaForm = document.getElementById("createRencanaKerjaForm");
            createRencanaKerjaForm.addEventListener("submit", function(event) {
                // Cek apakah nama tim sudah dipilih
                if (!namaTimSelect.value) {
                    event.preventDefault();
                    namaTimSelect.classList.add("border-red-500");
                    
                    // Tambahkan pesan error jika belum ada
                    if (!namaTimSelect.nextElementSibling || !namaTimSelect.nextElementSibling.classList.contains("text-red-500")) {
                        const errorMsg = document.createElement("p");
                        errorMsg.classList.add("text-red-500", "text-xs", "mt-1");
                        errorMsg.textContent = "Silakan pilih tim terlebih dahulu";
                        namaTimSelect.parentNode.insertBefore(errorMsg, namaTimSelect.nextSibling);
                    }
                    return;
                }
                
                // Cek apakah minimal satu rencana kerja dipilih
                const checkedRencanaKerja = document.querySelectorAll('input[name="rencana_kerja[]"]:checked');
                if (checkedRencanaKerja.length === 0) {
                    event.preventDefault();
                    
                    // Tambahkan pesan error jika belum ada
                    const container = document.querySelector('#rencanaKerjaContainer label');
                    if (!container.nextElementSibling || !container.nextElementSibling.classList.contains("text-red-500")) {
                        const errorMsg = document.createElement("p");
                        errorMsg.classList.add("text-red-500", "text-xs", "mt-1");
                        errorMsg.textContent = "Silakan pilih minimal satu rencana kerja";
                        container.parentNode.insertBefore(errorMsg, container.nextSibling);
                    }
                    return;
                }
                
                // Validasi custom rencana kerja
                const customInputs = document.querySelectorAll('input[name="rencana_kerja_text[]"]');
                let isValid = true;
                
                customInputs.forEach(input => {
                    const checkbox = document.getElementById(input.id.replace('text_', ''));
                    
                    // Jika checkbox dicentang tapi input kosong
                    if (checkbox.checked && !input.value.trim()) {
                        isValid = false;
                        input.classList.add("border-red-500");
                        
                        // Tambahkan pesan error jika belum ada
                        if (!input.nextElementSibling || !input.nextElementSibling.classList.contains("text-red-500")) {
                            const errorMsg = document.createElement("p");
                            errorMsg.classList.add("text-red-500", "text-xs", "mt-1");
                            errorMsg.textContent = "Mohon isi rencana kerja";
                            input.parentNode.insertBefore(errorMsg, input.nextSibling);
                        }
                    } else {
                        input.classList.remove("border-red-500");
                        // Hapus pesan error jika ada
                        if (input.nextElementSibling && input.nextElementSibling.classList.contains("text-red-500")) {
                            input.nextElementSibling.remove();
                        }
                    }
                });
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>

    <!-- js create proyek modal -->
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Variabel untuk tombol dan modal
    const createProjectButtons = document.querySelectorAll("[data-modal-show='createProjectModal']");
    const createProjectModal = document.getElementById("createProjectModal");
    const closeModalButton = createProjectModal?.querySelector("[data-modal-hide='createProjectModal']");
    const body = document.body;
    
    // Jika modal tidak ada di halaman, hentikan eksekusi
    if (!createProjectModal) return;
    
    // Dropdown dan container
    const namaTimDropdown = document.getElementById("nama_tim_proyek");
    const ketuaTimContainer = document.getElementById("ketuaTimContainer_proyek");
    const rencanaKerjaTimDropdown = document.getElementById("rencana_kerja_tim");
    const proyekContainer = document.getElementById("proyek-container");
    const detailProyekContainer = document.getElementById("detail-proyek-container");
    
    // Tombol tambah
    const tambahProyekBtn = document.getElementById("tambahProyek");
    
    // Fungsi untuk membuka modal
    createProjectButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            createProjectModal.classList.remove("hidden");
            createProjectModal.classList.add("flex");
            body.classList.add("blur-background");
        });
    });
    
    // Fungsi untuk menutup modal
    closeModalButton.addEventListener("click", function() {
        createProjectModal.classList.add("hidden");
        createProjectModal.classList.remove("flex");
        body.classList.remove("blur-background");
    });
    
    // Tutup modal ketika klik di luar modal
    createProjectModal.addEventListener("click", function(event) {
        if (event.target === createProjectModal) {
            createProjectModal.classList.add("hidden");
            createProjectModal.classList.remove("flex");
            body.classList.remove("blur-background");
        }
    });
    
    // Event ketika nama tim dipilih
    namaTimDropdown.addEventListener("change", function() {
        if (this.value) {
            // Tampilkan field ketua tim
            ketuaTimContainer.classList.remove("hidden");
            
            // Aktifkan dropdown rencana kerja tim
            rencanaKerjaTimDropdown.disabled = false;
        } else {
            // Sembunyikan field ketua tim
            ketuaTimContainer.classList.add("hidden");
            
            // Reset dan nonaktifkan dropdown rencana kerja tim
            rencanaKerjaTimDropdown.value = "";
            rencanaKerjaTimDropdown.disabled = true;
            
            // Sembunyikan container proyek
            proyekContainer.classList.add("hidden");
            
            // Reset detail proyek
            detailProyekContainer.classList.add("hidden");
            detailProyekContainer.innerHTML = '';
            
            // Hapus semua checkbox yang sudah dicentang
            document.querySelectorAll('.proyek-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    });

    // Event ketika rencana kerja tim dipilih
    rencanaKerjaTimDropdown.addEventListener("change", function() {
        if (this.value) {
            proyekContainer.classList.remove("hidden");
        } else {
            proyekContainer.classList.add("hidden");
            detailProyekContainer.classList.add("hidden");
            detailProyekContainer.innerHTML = '';
            
            // Hapus semua checkbox yang sudah dicentang
            document.querySelectorAll('.proyek-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    });
    
    // Event untuk checkbox proyek
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("proyek-checkbox") && event.target.checked) {
            // Dapatkan nilai proyek
            const proyekValue = event.target.value;
            const proyekId = event.target.id;
            
            // Buat ID unik untuk container detail
            const detailId = `detail-${proyekId}`;
            
            // Periksa apakah detail sudah ada
            if (!document.getElementById(detailId)) {
                // Buat container untuk detail proyek
                const detailDiv = document.createElement("div");
                detailDiv.id = detailId;
                detailDiv.dataset.proyekId = proyekId; // Tambahkan data attribute untuk tracking
                detailDiv.className = "p-4 border border-gray-200 rounded-lg dark:border-gray-600 mb-4";
                
                // Tentukan apakah ini proyek bawaan atau proyek tambahan
                // Proyek baru adalah yang ID-nya dimulai dengan 'proyek_' dan diikuti angka yang lebih besar dari 3
                // karena proyek_1, proyek_2, proyek_3 adalah proyek bawaan
                const isNewProject = proyekId.startsWith('proyek_') && parseInt(proyekId.split('_')[1]) > 3;
                
                // Jika proyek baru/tambahan, ambil nilai dari input text
                let displayName = proyekValue;
                if (isNewProject) {
                    const relatedInput = document.querySelector(`input[name="nama_proyek_tambahan[]"][data-proyek-id="${proyekId}"]`);
                    if (relatedInput) {
                        displayName = relatedInput.value || 'Proyek Baru';
                    }
                }
                
                // Template untuk detail proyek
                let detailTemplate = `
                    <div class="mb-4">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">${displayName}</h4>
                        <div class="grid grid-cols-1 gap-4">
                `;
                
                // Tambahkan field rencana kerja anggota
                if (isNewProject) {
                    // Untuk proyek baru, buat input text yang bisa diedit
                    detailTemplate += `
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Kerja Anggota</label>
                                <input type="text" name="rencana_kerja_anggota[${proyekId}]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan rencana kerja anggota">
                            </div>
                    `;
                } else {
                    // Untuk proyek bawaan, gunakan teks tetap yang disabled
                    detailTemplate += `
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Kerja Anggota</label>
                                <input type="text" name="rencana_kerja_anggota[${proyekId}]" value="Tersedianya Data Hasil Frame Register System (FRS)/Pemutakhiran Master File Desa (MFD) dan Master Blok Sensus (MBS) Semesteran yang Berkualitas" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                            </div>
                    `;
                }
                
                // Tambahkan dropdown PIC
                detailTemplate += `
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IKU</label>
                                <select name="pic[${proyekId}]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">-- Pilih IKU --</option>
                                    <option value="Mugi">Persentase Publikasi/Laporan Statistik Kependudukan dan Ketenagakerjaan yang Berkualitas</option>
                                    <option value="Hesti">Persentase Publikasi/Laporan Statistik Kesejahteraan Rakyat yang Berkualitas</option>
                                    <option value="Imam">Persentase Publikasi/Laporan Statistik Ketahanan Sosial yang Berkualitas</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC</label>
                                <select name="pic[${proyekId}]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">-- Pilih PIC --</option>
                                    <option value="Mugi">Mugi</option>
                                    <option value="Hesti">Hesti</option>
                                    <option value="Imam">Imam</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apakah merupakan kegiatan lapangan?</label>
                                <select name="pic[${proyekId}]" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Mugi">Ya</option>
                                    <option value="Hesti">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                
                detailDiv.innerHTML = detailTemplate;
                
                detailProyekContainer.appendChild(detailDiv);
                detailProyekContainer.classList.remove("hidden");
            }
        } else if (event.target.classList.contains("proyek-checkbox") && !event.target.checked) {
            // Hapus detail jika checkbox tidak dicentang
            const proyekId = event.target.id;
            const detailId = `detail-${proyekId}`;
            const detailElement = document.getElementById(detailId);
            
            if (detailElement) {
                detailElement.remove();
                
                // Sembunyikan container jika tidak ada detail lagi
                if (detailProyekContainer.children.length === 0) {
                    detailProyekContainer.classList.add("hidden");
                }
            }
        }
    });
    
    // Event untuk menambahkan proyek tambahan
    tambahProyekBtn.addEventListener("click", function() {
        const tambahanProyekContainer = document.getElementById("tambahan-proyek");
        const proyekCount = document.querySelectorAll(".proyek-checkbox").length;
        const newProyekId = `proyek_${proyekCount + 1}`;
        
        const newProyek = document.createElement("div");
        newProyek.className = "flex items-start mt-3";
        newProyek.dataset.proyekId = newProyekId; // Tambahkan data attribute untuk tracking
        
        newProyek.innerHTML = `
            <div class="flex items-center h-5">
                <input id="${newProyekId}" name="proyek_tambahan[]" type="checkbox" class="proyek-checkbox w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
            </div>
            <div class="ms-2 w-full">
                <input type="text" name="nama_proyek_tambahan[]" data-proyek-id="${newProyekId}" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan nama proyek baru">
                <button type="button" class="hapus-proyek mt-2 text-red-500 hover:text-red-700 text-sm">
                    Hapus
                </button>
            </div>
        `;
        
        tambahanProyekContainer.appendChild(newProyek);
        
        // Mendapatkan referensi ke input dan checkbox
        const projectNameInput = newProyek.querySelector(`input[data-proyek-id="${newProyekId}"]`);
        const projectCheckbox = newProyek.querySelector(`#${newProyekId}`);
        
        // Mengubah nilai checkbox berdasarkan input nama proyek
        projectNameInput.addEventListener('input', function() {
            projectCheckbox.value = this.value;
            
            // Update judul di detail jika detail sudah ada
            const detailId = `detail-${newProyekId}`;
            const detailElement = document.getElementById(detailId);
            if (detailElement) {
                const headerElement = detailElement.querySelector("h4");
                headerElement.textContent = this.value || 'Proyek Baru';
            }
        });
        
        // Event untuk tombol hapus
        newProyek.querySelector(".hapus-proyek").addEventListener("click", function() {
            // Hapus detail proyek jika ada
            const detailId = `detail-${newProyekId}`;
            const detailElement = document.getElementById(detailId);
            if (detailElement) {
                detailElement.remove();
                
                // Cek apakah masih ada detail proyek
                if (detailProyekContainer.children.length === 0) {
                    detailProyekContainer.classList.add("hidden");
                }
            }
            
            // Hapus proyek dari daftar
            newProyek.remove();
        });
    });
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