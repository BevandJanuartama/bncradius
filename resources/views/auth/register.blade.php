<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
    {{-- <script>
        // Backup jika Tailwind belum ter-compile
        if (!document.querySelector('link[href*="app.css"]')) {
            const link = document.createElement('script');
            link.src = 'https://cdn.tailwindcss.com';
            document.head.appendChild(link);
        }
    </script> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-blue { color: #4A90E2; }
        .bg-custom-blue { background-color: #4A90E2; }
        .border-custom-blue { border-color: #4A90E2; }
        .focus\:ring-custom-blue:focus { 
            --tw-ring-color: #4A90E2; 
            box-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        }
        .focus\:border-custom-blue:focus { border-color: #4A90E2; }
        .text-custom-blue { color: #4A90E2; }
        .hover\:from-blue-600:hover { background-image: linear-gradient(to right, #2563eb, var(--tw-gradient-to)); }
        .hover\:to-indigo-700:hover { --tw-gradient-to: #4338ca; }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-5xl flex min-h-[700px]">
        
        <!-- Left Illustration Panel -->
        <div class="hidden lg:flex w-1/2 bg-cover bg-center items-center justify-center p-12 relative"
            style="background-image: linear-gradient(to bottom right, rgba(219,234,254,0.8), rgba(199,210,254,0.8)), url('{{ asset('assets/img/bg-login.png') }}');">

            <!-- Decorative background elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 bg-blue-300 rounded-full"></div>
                <div class="absolute bottom-20 right-15 w-16 h-16 bg-purple-300 rounded-full"></div>
                <div class="absolute top-1/2 left-5 w-12 h-12 bg-indigo-300 rounded-full"></div>
            </div>
            
            <!-- Main illustration container -->
            <div class="relative z-10 flex flex-col items-center">
                
                <!-- Mobile device mockup -->
                <div class="bg-white rounded-2xl p-6 shadow-xl mb-6 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                    <div class="w-48 h-80 bg-gradient-to-b from-blue-50 to-white rounded-xl border-2 border-gray-100 flex flex-col items-center justify-center p-4">
                        
                        <!-- Profile creation icon -->
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                            </svg>
                        </div>
                        
                        <!-- Form fields mockup for registration -->
                        <div class="w-full space-y-2">
                            <div class="h-2 bg-gray-200 rounded w-2/3"></div>
                            <div class="h-6 bg-gray-100 rounded border"></div>
                            <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-6 bg-gray-100 rounded border"></div>
                            <div class="h-2 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-6 bg-gray-100 rounded border"></div>
                            <div class="h-2 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-6 bg-gray-100 rounded border"></div>
                            <div class="h-8 bg-blue-500 rounded text-white flex items-center justify-center mt-3">
                                <div class="w-16 h-2 bg-white rounded opacity-80"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Registration success illustration -->
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-custom-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="w-8 h-0.5 bg-blue-500"></div>
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Create Account!</h2>
                <p class="text-gray-500 text-lg">Sign up to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div class="space-y-2">
                    <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <x-text-input id="name" 
                                     type="text" 
                                     name="name" 
                                     :value="old('name')" 
                                     required 
                                     autofocus 
                                     autocomplete="name"
                                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                     placeholder="Masukkan nama lengkap" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Phone Number Field -->
                <div class="space-y-2">
                    <x-input-label for="telepon" :value="__('No Telepon')" class="block text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <x-text-input id="telepon" 
                                     type="text" 
                                     name="telepon" 
                                     :value="old('telepon')" 
                                     required 
                                     autocomplete="tel"
                                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                     placeholder="Masukkan nomor telepon" />
                    </div>
                    <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <x-text-input id="password" 
                                     type="password" 
                                     name="password" 
                                     required 
                                     autocomplete="new-password"
                                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                     placeholder="Masukkan password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <x-text-input id="password_confirmation" 
                                     type="password" 
                                     name="password_confirmation" 
                                     required 
                                     autocomplete="new-password"
                                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                     placeholder="Konfirmasi password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Captcha Field with Individual Inputs -->
                <div class="space-y-2">
                    <x-input-label for="captcha" :value="__('Captcha')" class="block text-sm font-medium text-gray-700" />
                    
                    <div class="flex items-center space-x-3">
                        <!-- Input per digit -->
                        <div class="flex space-x-2" id="captcha-inputs">
                            @if(session('captcha_register'))
                                @for ($i = 0; $i < strlen(session('captcha_register')); $i++)
                                    <input type="text"
                                           maxlength="1"
                                           class="w-10 h-12 text-center text-lg font-bold border border-gray-300 rounded-lg 
                                                  focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                           oninput="moveToNext(this, {{ $i }})">
                                @endfor
                            @endif
                        </div>

                        <!-- Tampilan kode asli dari Laravel -->
                        <div class="bg-gray-100 px-4 py-3 rounded-xl border font-mono text-lg font-bold text-gray-800 min-w-[100px] text-center">
                            {{ session('captcha_register') }}
                        </div>
                    </div>

                    <!-- Hidden input untuk gabungan semua digit -->
                    <x-text-input type="hidden" id="captcha" name="captcha" required autocomplete="off" />
                    
                    <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    {{ __('CREATE ACCOUNT') }}
                </button>

                <!-- Sign In Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-custom-blue hover:underline font-semibold ml-1">Sign in</a>
                </p>
            </form>
        </div>
    </div>

    <!-- JavaScript untuk Captcha Individual Inputs -->
    <script>
        function moveToNext(el, index) {
            // Bersihkan input, hanya alphanumeric
            el.value = el.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
            
            // Get all captcha inputs
            let inputs = document.querySelectorAll('#captcha-inputs input');
            
            // Move to next input if current has value
            if (el.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            
            // Gabungkan semua input ke hidden field
            let fullValue = '';
            inputs.forEach(input => fullValue += input.value);
            document.getElementById('captcha').value = fullValue;
        }

        // Handle backspace to move to previous input
        document.addEventListener('DOMContentLoaded', function() {
            let inputs = document.querySelectorAll('#captcha-inputs input');
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].select();
                    }
                });
            });
        });
    </script>

</body>
</html>