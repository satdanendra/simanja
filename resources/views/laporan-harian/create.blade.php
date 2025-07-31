<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buat Laporan Harian') }}
            </h2>
            <a href="{{ route('detailrinciankegiatan', $rincianKegiatan->id) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Informasi Konteks -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Informasi Rincian Kegiatan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p><strong>Tim:</strong> {{ $rincianKegiatan->kegiatan->proyek->rkTim->tim->masterTim->tim_urai }}</p>
                                <p><strong>Proyek:</strong> {{ $rincianKegiatan->kegiatan->proyek->masterProyek->proyek_urai }}</p>
                                <p><strong>Kegiatan:</strong> {{ $rincianKegiatan->kegiatan->masterKegiatan->kegiatan_urai }}</p>
                            </div>
                            <div>
                                <p><strong>Rincian Kegiatan:</strong> {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai }}</p>
                                <p><strong>Volume:</strong> {{ $rincianKegiatan->volume ?? 0 }} {{ $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('laporan-harian.store', $rincianKegiatan->id) }}" id="laporanForm">
                        @csrf

                        <!-- Tipe Waktu -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe Waktu
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="tipe_waktu" value="single_date" 
                                           class="mr-2" {{ old('tipe_waktu', 'single_date') === 'single_date' ? 'checked' : '' }}
                                           onchange="toggleWaktuFields()">
                                    Satu Hari
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tipe_waktu" value="rentang_tanggal" 
                                           class="mr-2" {{ old('tipe_waktu') === 'rentang_tanggal' ? 'checked' : '' }}
                                           onchange="toggleWaktuFields()">
                                    Rentang Tanggal
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_mulai" 
                                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            
                            <div id="tanggalSelesaiDiv" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="tanggal_selesai" 
                                       value="{{ old('tanggal_selesai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Jam (untuk single date) -->
                        <div id="jamDiv" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_mulai" 
                                       value="{{ old('jam_mulai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_selesai" 
                                       value="{{ old('jam_selesai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Dasar Pelaksanaan -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Dasar Pelaksanaan Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <button type="button" onclick="addDasarPelaksanaan()" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                                    Tambah
                                </button>
                            </div>
                            
                            <div id="dasarPelaksanaanContainer">
                                <div class="dasar-pelaksanaan-item flex items-center mb-2">
                                    <span class="w-8 text-center">1.</span>
                                    <input type="text" name="dasar_pelaksanaan[0][deskripsi]" 
                                           value="{{ old('dasar_pelaksanaan.0.deskripsi') }}"
                                           placeholder="Masukkan dasar pelaksanaan..."
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 mr-2"
                                           required>
                                    <label class="flex items-center mr-2">
                                        <input type="checkbox" name="dasar_pelaksanaan[0][is_terlampir]" 
                                               value="1" class="mr-1">
                                        Terlampir
                                    </label>
                                    <button type="button" onclick="removeDasarPelaksanaan(this)" 
                                            class="bg-red-500 hover:bg-red-700 text-white text-sm px-2 py-1 rounded">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bukti Dukung -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Bukti Dukung
                            </label>
                            
                            @if($rincianKegiatan->buktiDukungs->count() > 0)
                                <div class="space-y-2" id="buktiDukungContainer">
                                    @foreach($rincianKegiatan->buktiDukungs as $bukti)
                                        <div class="flex items-center p-3 border border-gray-300 rounded-md">
                                            <input type="checkbox" name="bukti_dukung_ids[]" 
                                                   value="{{ $bukti->id }}" 
                                                   class="mr-3 bukti-checkbox"
                                                   onchange="updateBuktiOrder()">
                                            <div class="flex-1">
                                                <p class="font-medium">{{ $bukti->nama_file }}</p>
                                                @if($bukti->keterangan)
                                                    <p class="text-sm text-gray-600">{{ $bukti->keterangan }}</p>
                                                @endif
                                            </div>
                                            <div class="urutan-display ml-2 text-sm text-gray-500" style="display: none;">
                                                Urutan: <span class="urutan-number">-</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">Belum ada bukti dukung yang tersedia.</p>
                            @endif
                        </div>

                        <!-- Kendala -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kendala/Permasalahan
                            </label>
                            <textarea name="kendala" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Masukkan kendala yang dihadapi (opsional)">{{ old('kendala') }}</textarea>
                        </div>

                        <!-- Solusi -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Solusi
                            </label>
                            <textarea name="solusi" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Masukkan solusi yang diterapkan (opsional)">{{ old('solusi') }}</textarea>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan
                            </label>
                            <textarea name="catatan" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('detailrinciankegiatan', $rincianKegiatan->id) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Generate PDF Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dasarPelaksanaanCount = 1;

        function toggleWaktuFields() {
            const tipeWaktu = document.querySelector('input[name="tipe_waktu"]:checked').value;
            const jamDiv = document.getElementById('jamDiv');
            const tanggalSelesaiDiv = document.getElementById('tanggalSelesaiDiv');
            
            if (tipeWaktu === 'single_date') {
                jamDiv.style.display = 'grid';
                tanggalSelesaiDiv.style.display = 'none';
            } else {
                jamDiv.style.display = 'none';
                tanggalSelesaiDiv.style.display = 'block';
            }
        }

        function addDasarPelaksanaan() {
            const container = document.getElementById('dasarPelaksanaanContainer');
            const newItem = document.createElement('div');
            newItem.className = 'dasar-pelaksanaan-item flex items-center mb-2';
            newItem.innerHTML = `
                <span class="w-8 text-center">${dasarPelaksanaanCount + 1}.</span>
                <input type="text" name="dasar_pelaksanaan[${dasarPelaksanaanCount}][deskripsi]" 
                       placeholder="Masukkan dasar pelaksanaan..."
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 mr-2"
                       required>
                <label class="flex items-center mr-2">
                    <input type="checkbox" name="dasar_pelaksanaan[${dasarPelaksanaanCount}][is_terlampir]" 
                           value="1" class="mr-1">
                    Terlampir
                </label>
                <button type="button" onclick="removeDasarPelaksanaan(this)" 
                        class="bg-red-500 hover:bg-red-700 text-white text-sm px-2 py-1 rounded">
                    Hapus
                </button>
            `;
            container.appendChild(newItem);
            dasarPelaksanaanCount++;
            updateDasarPelaksanaanNumbers();
        }

        function removeDasarPelaksanaan(button) {
            button.parentElement.remove();
            updateDasarPelaksanaanNumbers();
        }

        function updateDasarPelaksanaanNumbers() {
            const items = document.querySelectorAll('.dasar-pelaksanaan-item');
            items.forEach((item, index) => {
                const numberSpan = item.querySelector('span');
                numberSpan.textContent = (index + 1) + '.';
                
                const input = item.querySelector('input[type="text"]');
                const checkbox = item.querySelector('input[type="checkbox"]');
                
                input.name = `dasar_pelaksanaan[${index}][deskripsi]`;
                checkbox.name = `dasar_pelaksanaan[${index}][is_terlampir]`;
            });
            dasarPelaksanaanCount = items.length;
        }

        function updateBuktiOrder() {
            const checkboxes = document.querySelectorAll('.bukti-checkbox:checked');
            checkboxes.forEach((checkbox, index) => {
                const container = checkbox.closest('.flex');
                const urutanDisplay = container.querySelector('.urutan-display');
                const urutanNumber = container.querySelector('.urutan-number');
                
                urutanDisplay.style.display = 'block';
                urutanNumber.textContent = index + 1;
            });
            
            // Hide urutan untuk yang tidak tercentang
            const uncheckedBoxes = document.querySelectorAll('.bukti-checkbox:not(:checked)');
            uncheckedBoxes.forEach(checkbox => {
                const container = checkbox.closest('.flex');
                const urutanDisplay = container.querySelector('.urutan-display');
                urutanDisplay.style.display = 'none';
            });
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            toggleWaktuFields();
        });
    </script>
</x-app-layout>