<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Informasi profil lengkap pegawai.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8">
        @csrf
        @method('patch')

        @php
            // Data mapping untuk menghindari repetisi kode
            $profileSections = [
                [
                    'title' => 'Informasi Dasar',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                    'fields' => [
                        ['id' => 'name', 'label' => 'Nama Lengkap', 'value' => $user->pegawai->nama ?? $user->name, 'type' => 'text'],
                        ['id' => 'gelar', 'label' => 'Gelar', 'value' => $user->pegawai->gelar ?? '-', 'type' => 'text'],
                        ['id' => 'alias', 'label' => 'Alias/Nama Panggilan', 'value' => $user->pegawai->alias ?? '-', 'type' => 'text'],
                        ['id' => 'sex', 'label' => 'Jenis Kelamin', 'value' => $user->pegawai->sex == 'L' ? 'Laki-laki' : ($user->pegawai->sex == 'P' ? 'Perempuan' : '-'), 'type' => 'text']
                    ]
                ],
                [
                    'title' => 'Informasi Kepegawaian',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                    'fields' => [
                        ['id' => 'nip_lama', 'label' => 'NIP Lama', 'value' => $user->pegawai->nip_lama ?? '-', 'type' => 'text'],
                        ['id' => 'nip_baru', 'label' => 'NIP Baru', 'value' => $user->pegawai->nip_baru ?? '-', 'type' => 'text'],
                        ['id' => 'nik', 'label' => 'NIK', 'value' => $user->pegawai->nik ?? '-', 'type' => 'text'],
                        ['id' => 'pangkat', 'label' => 'Pangkat/Golongan', 'value' => $user->pegawai->pangkat ?? '-', 'type' => 'text'],
                        ['id' => 'jabatan', 'label' => 'Jabatan', 'value' => $user->pegawai->jabatan ?? '-', 'type' => 'text'],
                    ]
                ],
                [
                    'title' => 'Informasi Kontak',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                    'fields' => [
                        ['id' => 'email', 'label' => 'Email', 'value' => $user->email, 'type' => 'email', 'special' => 'email'],
                        ['id' => 'nomor_hp', 'label' => 'Nomor HP', 'value' => $user->pegawai->nomor_hp ?? '-', 'type' => 'text']
                    ]
                ],
                [
                    'title' => 'Informasi Pendidikan',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>',
                    'fields' => [
                        ['id' => 'educ', 'label' => 'Tingkat Pendidikan', 'value' => $user->pegawai->educ ?? '-', 'type' => 'text'],
                        ['id' => 'pendidikan', 'label' => 'Jurusan/Program Studi', 'value' => $user->pegawai->pendidikan ?? '-', 'type' => 'text'],
                        ['id' => 'universitas', 'label' => 'Universitas/Instansi', 'value' => $user->pegawai->universitas ?? '-', 'type' => 'text']
                    ]
                ],
                [
                    'title' => 'Status & Informasi Sistem',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    'fields' => [
                        ['id' => 'is_active', 'label' => 'Status Aktif', 'value' => ($user->pegawai->is_active ?? true) ? 'Aktif' : 'Tidak Aktif', 'type' => 'text'],
                        ['id' => 'created_at', 'label' => 'Tanggal Dibuat', 'value' => $user->pegawai->created_at ? $user->pegawai->created_at->format('d/m/Y H:i') : '-', 'type' => 'text'],
                        ['id' => 'updated_at', 'label' => 'Terakhir Diupdate', 'value' => $user->pegawai->updated_at ? $user->pegawai->updated_at->format('d/m/Y H:i') : '-', 'type' => 'text']
                    ]
                ]
            ];
        @endphp

        {{-- Loop untuk setiap section --}}
        @foreach($profileSections as $index => $section)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                {{-- Section Header --}}
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-600">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 text-blue-600 dark:text-blue-400">
                            {!! $section['icon'] !!}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $section['title'] }}
                        </h3>
                    </div>
                </div>

                {{-- Section Content --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ count($section['fields']) <= 3 ? count($section['fields']) : '3' }} gap-6">
                        @foreach($section['fields'] as $field)
                            <div class="space-y-2">
                                <x-input-label for="{{ $field['id'] }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __($field['label']) }}
                                </x-input-label>
                                
                                <div class="relative">
                                    <x-text-input 
                                        id="{{ $field['id'] }}" 
                                        name="{{ $field['id'] }}" 
                                        type="{{ $field['type'] }}" 
                                        class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" 
                                        value="{{ old($field['id'], $field['value']) }}" 
                                        disabled 
                                        readonly/>
                                    
                                    {{-- Icon untuk field yang kosong --}}
                                    @if($field['value'] === '-' || empty($field['value']))
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Special handling untuk email verification --}}
                                @if(isset($field['special']) && $field['special'] === 'email')
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-amber-600 dark:text-amber-400 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                {{ __('Email belum terverifikasi.') }}
                                                <button form="send-verification" class="ml-2 underline text-amber-700 dark:text-amber-300 hover:text-amber-900 dark:hover:text-amber-100 font-medium">
                                                    {{ __('Kirim ulang email verifikasi') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-sm text-green-600 dark:text-green-400 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
                                        <p class="mt-1 text-sm text-green-600 dark:text-green-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('Email sudah terverifikasi') }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Info Box --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 shadow-sm">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                        Informasi Penting
                    </h4>
                    <div class="text-sm text-blue-800 dark:text-blue-200 space-y-2">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <strong>Data profil di atas bersifat read-only dan tidak dapat diubah melalui halaman ini.</strong>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Untuk melakukan perubahan data pegawai, silakan hubungi administrator sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>