<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-5xl flex min-h-[600px]">
        
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
                <div class="bg-white rounded-2xl p-6 shadow-xl mb-6 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                    <div class="w-48 h-80 bg-gradient-to-b from-blue-50 to-white rounded-xl border-2 border-gray-100 flex flex-col items-center justify-center p-4">
                        
                        <!-- Profile icon -->
                        <div class="w-16 h-16 bg-custom-blue rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        
                        <!-- Form fields mockup -->
                        <div class="w-full space-y-3">
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-8 bg-gray-100 rounded border"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-8 bg-gray-100 rounded border"></div>
                            <div class="h-10 bg-custom-blue rounded text-white flex items-center justify-center mt-4">
                                <div class="w-12 h-2 bg-white rounded opacity-80"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Security illustration -->
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="w-8 h-0.5 bg-custom-blue"></div>
                    <div class="w-12 h-12 bg-custom-blue rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Welcome!</h2>
                <p class="text-gray-500 text-lg">Sign in to your Account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Phone Number Field -->
                <div class="space-y-2">
                    <x-input-label for="telepon" :value="__('Nomor Telepon')" class="block text-sm font-medium text-gray-700" />
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
                                     autofocus 
                                     autocomplete="username"
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
                                     autocomplete="current-password"
                                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition duration-200"
                                     placeholder="Masukkan password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Captcha Field with Individual Inputs -->
                <div class="space-y-2">
                    <x-input-label for="captcha" :value="__('Captcha')" class="block text-sm font-medium text-gray-700" />
                    
                    <div class="flex items-center space-x-3">
                        <!-- Input per digit -->
                        <div class="flex space-x-2" id="captcha-inputs">
                            @if(session('captcha_login'))
                                @for ($i = 0; $i < strlen(session('captcha_login')); $i++)
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
                            {{ session('captcha_login') }}
                        </div>
                    </div>


                    <!-- Hidden input untuk gabungan semua digit -->
                    <x-text-input type="hidden" id="captcha" name="captcha" required autocomplete="off" />
                    
                    <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember"
                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-custom-blue focus:ring-2">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-custom-blue hover:underline font-medium">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    {{ __('SIGN IN') }}
                </button>

                <!-- Optional Google Login (uncomment if needed) -->
                {{-- 
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">OR CONTINUE WITH</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('google.login') }}"
                       class="w-full flex items-center justify-center bg-red-500 text-white p-3 rounded-xl hover:bg-red-600 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.7 1.22 9.19 3.6l6.85-6.85C35.34 2.38 29.99 0 24 0 14.64 0 6.4 5.64 2.56 13.77l7.94 6.18C12.22 13.35 17.61 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.08 24.55c0-1.52-.14-2.99-.4-4.41H24v8.36h12.44c-.54 2.91-2.14 5.37-4.56 7.01l7.14 5.53C43.34 37.3 46.08 31.4 46.08 24.55z"/>
                            <path fill="#FBBC05" d="M10.5 28.82c-1.09-3.17-1.09-6.56 0-9.73l-7.94-6.18C.88 17.93 0 20.9 0 24s.88 6.07 2.56 8.09l7.94-6.18z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.92-2.14 15.89-5.82l-7.14-5.53C30.59 38.82 27.44 39.5 24 39.5c-6.39 0-11.78-3.85-13.5-9.45l-7.94 6.18C6.4 42.36 14.64 48 24 48z"/>
                        </svg>
                        Login dengan Google
                    </a>
                </div> 
                --}}

                <!-- Sign Up Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-custom-blue hover:underline font-semibold ml-1">Sign up</a>
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