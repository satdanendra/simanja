<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('Manajemen Tim') }}
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
                <!-- Card Header with Search and Create Button -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h3 class="text-lg font-semibold text-white mb-3 md:mb-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Daftar Tim
                        </h3>
                        
                        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3 w-full md:w-auto">
                            <button 
                                data-modal-target="createTimModal" 
                                data-modal-show="createTimModal" 
                                class="flex items-center justify-center space-x-2 bg-white text-blue-700 hover:bg-blue-50 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Buat Tim Baru</span>
                            </button>
                            
                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="table-search-tims" class="bg-blue-700 bg-opacity-30 border border-blue-500 text-white placeholder-blue-200 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full pl-10 p-2.5" placeholder="Cari tim...">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Team Cards Grid -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($tims as $tim)
                    <div class="tim-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-name="{{ strtolower($tim->nama_tim) }}">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-white font-bold truncate">{{ $tim->nama_tim }}</h3>
                                <span class="text-blue-100 bg-blue-800 bg-opacity-50 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $tim->tahun }}</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <div class="flex -space-x-3">
                                    <!-- Placeholder avatars - in real app, these would be actual team members -->
                                    <div class="w-8 h-8 rounded-full bg-blue-200 border-2 border-white flex items-center justify-center text-blue-600 text-xs font-bold">AB</div>
                                    <div class="w-8 h-8 rounded-full bg-green-200 border-2 border-white flex items-center justify-center text-green-600 text-xs font-bold">CD</div>
                                    <div class="w-8 h-8 rounded-full bg-yellow-200 border-2 border-white flex items-center justify-center text-yellow-600 text-xs font-bold">EF</div>
                                    <div class="w-8 h-8 rounded-full bg-indigo-200 border-2 border-white flex items-center justify-center text-indigo-600 text-xs font-bold">+3</div>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">7 Anggota</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>5 Pekerjaan</span>
                                </div>
                                
                                <a href="{{ route('detailtim', $tim->id) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150">
                                    <span>Detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Empty State (displayed when no teams) -->
                @if(count($tims) == 0)
                <div class="p-12 flex flex-col items-center justify-center text-center">
                    <div class="rounded-full bg-blue-100 p-3 h-16 w-16 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tim</h3>
                    <p class="text-gray-500 mb-6 max-w-md">Mulai dengan membuat tim pertama Anda untuk mengatur pekerjaan dan anggota tim dengan lebih efisien.</p>
                    <!-- <button data-modal-target="createTimModal" data-modal-show="createTimModal" class="flex items-center justify-center space-x-2 bg-blue-600 text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Buat Tim Baru</span>
                    </button> -->
                </div>
                @endif
                
                <!-- Pagination if needed -->
                @if(count($tims) > 0)
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan <span class="font-medium">{{ count($tims) }}</span> tim
                        </div>
                        
                        <!-- Add pagination controls here if needed -->
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create tim modal -->
    <div id="createTimModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <form action="{{ route('tims.store') }}" method="POST" class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gradient-to-r from-blue-600 to-indigo-700">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Tim Baru
                    </h3>
                    <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="createTimModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="nama_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tim</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="nama_tim" id="nama_tim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama tim" required>
                            </div>
                        </div>
                        <div>
                            <label for="tahun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" name="tahun" id="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="ex: 2025" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" data-modal-hide="createTimModal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 transition-colors duration-150">
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
            const createTimButtons = document.querySelectorAll("[data-modal-show='createTimModal']");
            const createTimModal = document.getElementById("createTimModal");
            const closeModalButtons = document.querySelectorAll("[data-modal-hide='createTimModal']");
            const modalBackdrop = document.getElementById("modalBackdrop");

            // Function to open modal
            function openModal() {
                createTimModal.classList.remove("hidden");
                createTimModal.classList.add("flex");
                modalBackdrop.classList.remove("hidden");
                // Add animation class
                createTimModal.classList.add("animate-fadeIn");
            }

            // Function to close modal
            function closeModal() {
                // Add animation class first
                createTimModal.classList.add("animate-fadeOut");
                
                // Set timeout for animation to complete
                setTimeout(() => {
                    createTimModal.classList.remove("animate-fadeIn", "animate-fadeOut");
                    createTimModal.classList.add("hidden");
                    createTimModal.classList.remove("flex");
                    modalBackdrop.classList.add("hidden");
                }, 200);
            }

            createTimButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    openModal();
                });
            });

            // Close modal when clicking close buttons
            closeModalButtons.forEach(button => {
                button.addEventListener("click", closeModal);
            });

            // Close modal when clicking outside the modal content
            createTimModal.addEventListener("click", function(event) {
                if (event.target === createTimModal) {
                    closeModal();
                }
            });

            // Add keydown event for Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !createTimModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("table-search-tims");
            const timCards = document.querySelectorAll(".tim-card");

            searchInput.addEventListener("input", function() {
                const searchValue = this.value.toLowerCase().trim();

                timCards.forEach(card => {
                    const timName = card.getAttribute("data-name");
                    if (timName.includes(searchValue)) {
                        card.style.display = "";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });

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
        /* Animation classes */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out forwards;
        }
        
        .animate-fadeOut {
            animation: fadeOut 0.2s ease-in forwards;
        }
    </style>
</x-app-layout>