<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account - BNC CLOUD MANAGER</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .sidebar-gradient {
            background: linear-gradient(to top, #549BE7, #3B82F6);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .menu-item {
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .profile-gradient {
            background: linear-gradient(to top, #549BE7, #3B82F6);
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="md:pl-72 pt-20 w-full p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-users w-8 h-8 mr-5 text-blue-500"></i>
                Account Settings
            </h2>
            <p class="text-gray-600 mt-1 sm:block ml-14">Manage your account information and security settings</p>
        </div>

        <!-- Profile Hero Card -->
        <div class="profile-gradient rounded-2xl p-8 text-white mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-10">
                <i class="fas fa-user-circle text-9xl animate-float"></i>
            </div>
            <div class="relative z-10">
                <div class="flex items-center space-x-6">
                    <div
                        class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
                        <i class="fas fa-user text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold mb-2">{{ Auth::user()->name }}</h3>
                        <p class="text-white/90 mb-1">{{ Auth::user()->telepon }}</p>
                        <p class="text-white/70 text-sm">
                            Member since {{ \Carbon\Carbon::parse(Auth::user()->created_at)->translatedFormat('F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 items-stretch">
            <!-- Account Information -->
            <div class="bg-white shadow-xl rounded-2xl p-8 card-hover flex flex-col justify-between h-full">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#549BE7]/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-user-edit text-[#3B82F6] text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Account Information</h3>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6 flex-1">
                        @csrf
                        @method('PATCH')

                        <!-- Full Name -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                class="form-input w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#3B82F6]">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Telepon</label>
                            <input type="telepon" name="telepon" value="{{ Auth::user()->telepon }}"
                                class="form-input w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#3B82F6]">
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="bg-[linear-gradient(to_top,#549BE7,#3B82F6)] hover:opacity-90 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Update Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white shadow-xl rounded-2xl p-8 card-hover flex flex-col justify-between h-full">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-key text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Change Password</h3>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6 flex-1">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Current Password</label>
                            <input type="password" name="current_password"
                                class="form-input w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">New Password</label>
                            <input type="password" name="password" id="newPassword"
                                class="form-input w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500"
                                oninput="checkPasswordStrength()" required>
                            <div class="mt-2">
                                <div class="password-strength bg-gray-200" id="passwordStrength"></div>
                                <p class="text-sm text-gray-600 mt-1" id="strengthText">Password strength</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-input w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500"
                                required>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                                <i class="fas fa-lock mr-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
    </main>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');

            let strength = 0;
            let feedback = '';

            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;

            if (strength < 25) {
                strengthBar.style.width = '25%';
                strengthBar.style.backgroundColor = '#ef4444';
                feedback = 'Weak password';
            } else if (strength < 50) {
                strengthBar.style.width = '50%';
                strengthBar.style.backgroundColor = '#f59e0b';
                feedback = 'Fair password';
            } else if (strength < 75) {
                strengthBar.style.width = '75%';
                strengthBar.style.backgroundColor = '#eab308';
                feedback = 'Good password';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.style.backgroundColor = '#22c55e';
                feedback = 'Strong password';
            }

            strengthText.textContent = feedback;
        }
    </script>

</body>

</html>
