<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg flex flex-col md:flex-row max-w-5xl w-full overflow-hidden">
            <!-- Left Panel - Government Branding -->
            <div class="bg-gradient-to-br from-blue-700 to-indigo-800 md:w-2/5 p-8 text-white relative hidden md:block">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
                        <path fill="currentColor" d="M50,5 L95,25 L95,75 L50,95 L5,75 L5,25 Z"></path>
                    </svg>
                </div>
                
                <div class="flex items-center space-x-4 mb-8 relative">
                    <div class="bg-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-bold">Badan Pusat Statistik</div>
                        <div class="text-sm opacity-75">Kota Magelang</div>
                    </div>
                </div>
                
                <div class="mb-8 relative">
                    <h1 class="text-3xl font-bold mb-4">Sistem Informasi Manajemen Pekerjaan (SiManja)</h1>
                    <p class="opacity-80">Portal resmi untuk meningkatkan pelayanan publik dan efisiensi kinerja aparatur negara dalam mendukung tata kelola pemerintahan yang baik.</p>
                </div>
                
                <div class="absolute bottom-8 left-8 right-8 text-sm opacity-70">
                    <p>© 2025 BPS Kota Magelang</p>
                </div>
            </div>
            
            <!-- Right Panel - Login Form -->
            <div class="p-8 md:p-12 md:w-3/5">
                <!-- Mobile Logo -->
                <div class="flex items-center space-x-3 mb-8 md:hidden">
                    <div class="bg-blue-700 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-gray-800">INSTANSI PEMERINTAH</div>
                </div>
                
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                    <p class="text-gray-600">Silakan masuk untuk mengakses sistem</p>
                </div>
                
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-text-input id="email" class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@bps.go.id" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="password" class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="bg-blue-700 hover:bg-blue-800 transition duration-150 ease-in-out text-white font-medium py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-center text-sm text-gray-600">
                            Mengalami kesulitan login? Hubungi <span class="text-blue-600">Admin SiManja</span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>