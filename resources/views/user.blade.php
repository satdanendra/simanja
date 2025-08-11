<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ __('Manajemen User') }}
            </h2>
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
                <!-- Card Header with Search -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h3 class="text-lg font-semibold text-white mb-3 md:mb-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Daftar User
                        </h3>

                        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3 w-full md:w-auto">
                            @if(Auth::user()->isSuperadmin())
                            <button
                                data-modal-target="createUserModal"
                                data-modal-show="createUserModal"
                                class="flex items-center justify-center space-x-2 bg-white text-blue-700 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Buat User Baru</span>
                            </button>
                            @endif
                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="table-search-users" class="bg-blue-700 bg-opacity-30 border border-blue-500 text-white placeholder-blue-200 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full md:w-64 pl-10 p-2.5" placeholder="Cari user...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nama & Email</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                @if(Auth::user()->isSuperadmin())
                                <th scope="col" class="px-6 py-4">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($users as $user)
                            <tr class="user-row hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150" data-name="{{ strtolower($user->name) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="font-normal text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                    @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Nonaktif</span>
                                    @endif
                                </td>
                                @if(Auth::user()->isSuperadmin())
                                <td class="px-6 py-4">
                                    <button type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" data-user-id="{{ $user->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-3 edit-user-btn">Edit</button>
                                    @if($user->is_active)
                                    <a href="#" data-user-id="{{ $user->id }}" class="deactivate-user font-medium text-red-600 hover:underline">Nonaktifkan</a>
                                    @else
                                    <a href="#" data-user-id="{{ $user->id }}" class="activate-user font-medium text-green-600 hover:underline">Aktifkan</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination if needed -->
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan <span class="font-medium">{{ count($users) }}</span> user
                        </div>

                        <!-- Add pagination controls here if needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form id="createUserForm" action="{{ route('users.store') }}" class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" method="POST">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Buat User Baru
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createUserModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="pegawai_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Pegawai</label>
                            <select name="pegawai_id" id="pegawai_id" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" data-email="{{ $pegawai->email }}">{{ $pegawai->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="email@example.com" readonly required>
                            <p class="mt-1 text-sm text-gray-500">Email akan terisi otomatis sesuai dengan pegawai yang dipilih</p>
                        </div>
                        <div class="col-span-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required minlength="8">
                        </div>
                        <div class="col-span-6">
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required minlength="8">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createUserModal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit user modal -->
    <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form id="editUserForm" class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700" method="POST">
                @csrf
                @method('PUT')
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Password
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="editUserModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Nama Lengkap" disabled>
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email-edit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="nama@bps.go.id" disabled>
                            </div>
                        </div>

                        <div class="col-span-6">
                            <label for="new-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="new-password" id="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" minlength="8">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" data-modal-hide="editUserModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
                        Batal
                    </button>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Common functions
            function openModal(modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
                document.getElementById("modalBackdrop").classList.remove("hidden");
            }

            function closeModal(modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                document.getElementById("modalBackdrop").classList.add("hidden");
            }

            // Search functionality
            const searchInput = document.getElementById("table-search-users");
            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    const searchValue = this.value.toLowerCase().trim();
                    document.querySelectorAll(".user-row").forEach(row => {
                        row.style.display = row.getAttribute("data-name").includes(searchValue) ? "" : "none";
                    });
                });
            }

            // Create user modal
            const createUserModal = document.getElementById("createUserModal");
            if (createUserModal) {
                // Open modal
                document.querySelectorAll("[data-modal-show='createUserModal']").forEach(btn => {
                    btn.addEventListener("click", (e) => {
                        e.preventDefault();
                        openModal(createUserModal);
                    });
                });

                // Close modal
                document.querySelectorAll("[data-modal-hide='createUserModal']").forEach(btn => {
                    btn.addEventListener("click", () => closeModal(createUserModal));
                });

                // Close when clicking outside
                createUserModal.addEventListener("click", (e) => {
                    if (e.target === createUserModal) closeModal(createUserModal);
                });

                // Autofill email on dropdown change
                const pegawaiDropdown = document.getElementById("pegawai_id");
                const emailField = document.getElementById("email");
                if (pegawaiDropdown && emailField) {
                    pegawaiDropdown.addEventListener("change", function() {
                        const selectedOption = this.options[this.selectedIndex];
                        emailField.value = selectedOption.value ? (selectedOption.getAttribute("data-email") || "") : "";
                    });
                }
            }

            // Edit user modal
            const editUserModal = document.getElementById("editUserModal");
            if (editUserModal) {
                const editUserForm = document.getElementById("editUserForm");
                const nameInput = document.getElementById("name");
                const emailInput = document.getElementById("email-edit");

                // Open modal with user data
                document.querySelectorAll(".edit-user-btn").forEach(btn => {
                    btn.addEventListener("click", (e) => {
                        e.preventDefault();
                        const userId = btn.getAttribute("data-user-id");
                        editUserForm.action = `/users/${userId}`;

                        fetch(`/users/${userId}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                nameInput.value = data.name;
                                emailInput.value = data.email;
                                openModal(editUserModal);
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // Close modal
                document.querySelectorAll("[data-modal-hide='editUserModal']").forEach(btn => {
                    btn.addEventListener("click", () => closeModal(editUserModal));
                });

                // Close when clicking outside
                editUserModal.addEventListener("click", (e) => {
                    if (e.target === editUserModal) closeModal(editUserModal);
                });

                // Close on Escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !editUserModal.classList.contains('hidden')) {
                        closeModal(editUserModal);
                    }
                });
            }

            // Success popup handling
            const successPopup = document.getElementById('success-popup');
            if (successPopup) {
                // Auto close after 5 seconds
                setTimeout(() => closeSuccessPopup(), 5000);

                // Manual close function
                window.closeSuccessPopup = function() {
                    successPopup.classList.add('transform', 'translate-x-full', 'opacity-0');
                    setTimeout(() => successPopup.style.display = 'none', 300);
                };
            }
        });

        // Handle deactivate button
        const deactivateButtons = document.querySelectorAll(".deactivate-user");
        deactivateButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const userId = this.getAttribute("data-user-id");
                if (confirm("Apakah Anda yakin ingin menonaktifkan user ini?")) {
                    // Tampilkan indikator loading
                    const originalText = this.textContent;
                    this.textContent = "Memproses...";
                    this.disabled = true;

                    // Ambil CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Kirim request
                    fetch(`/users/${userId}/deactivate`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Tampilkan pesan sukses
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("Terjadi kesalahan saat menonaktifkan user");
                            // Kembalikan tombol ke keadaan semula
                            this.textContent = originalText;
                            this.disabled = false;
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
        const activateButtons = document.querySelectorAll(".activate-user");
        activateButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const userId = this.getAttribute("data-user-id");
                if (confirm("Apakah Anda yakin ingin mengaktifkan kembali user ini?")) {
                    // Buat form data dengan CSRF token
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    // Tampilkan indikator loading pada tombol
                    const clickedButton = this;
                    const originalText = clickedButton.textContent;
                    clickedButton.textContent = "Memproses...";
                    clickedButton.disabled = true;

                    // Kirim request dengan FormData
                    fetch(`/users/${userId}/activate`, {
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
                                localStorage.setItem('successMessage', 'User berhasil diaktifkan');
                                // Reload halaman
                                window.location.reload();
                            } else {
                                alert("Gagal mengaktifkan user");
                            }
                        })
                        .catch(function(error) {
                            // Kembalikan tombol ke keadaan semula
                            clickedButton.textContent = originalText;
                            clickedButton.disabled = false;

                            console.error('Error:', error);
                            alert("Terjadi kesalahan saat mengaktifkan user");
                        });
                }
            });
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