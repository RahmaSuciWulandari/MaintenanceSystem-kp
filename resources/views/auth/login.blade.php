<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance System - FATHMA MEDIKA HOSPITAL</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#1e40af',
                        'light-blue': '#60a5fa',
                        'bg-blue': '#3b82f6'
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #1e40af 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        .tech-pattern {
            background-image: 
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="h-screen bg-gradient-custom flex items-center justify-center p-4">
    
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full floating-animation"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: -4s;"></div>
        <div class="absolute bottom-32 right-1/3 w-8 h-8 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-2xl card-shadow overflow-hidden max-w-4xl w-full flex flex-col md:flex-row">
        
        <!-- Left Side - Login Form -->
        <div class="flex-1 p-8 md:p-12">
            <div class="max-w-md mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Welcome to</h1>
                    <h2 class="text-xl md:text-3xl font-bold text-gray-800 mb-2">Maintenance System</h2>
                    <h2>FATHMA MEDIKA HOSPITAL</h2>
                    <p class="text-xs text-gray-500 mt-2">Please use your account to access our system</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Username Field -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="username" 
                            placeholder="Username" 
                            value="{{ old('username') }}"
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white @error('username') border-red-500 @enderror"
                        >
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Password" 
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white @error('password') border-red-500 @enderror"
                        >
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <!-- <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            class="h-4 w-4 text-primary-blue focus:ring-primary-blue border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div> -->

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-primary-blue hover:bg-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-blue-300 focus:outline-none mt-6"
                    >
                        Login
                    </button>
                </form>

                <!-- Additional Links -->
                <!-- <div class="text-center mt-6">
                    <a href="#" class="text-sm text-primary-blue hover:underline">Forgot password?</a>
                </div> -->
            </div>
        </div>

        <!-- Right Side - Welcome Panel -->
        <div class="flex-1 p-8 md:p-12 text-white relative overflow-hidden rounded-r-2xl"
             style="background-image: url('{{ asset('image.png') }}'); background-size: cover; background-position: center;">
            <!-- Tech Pattern Background -->
            <div class="absolute inset-0 tech-pattern opacity-30"></div>
            
            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col justify-center">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">Hello, Everyone!</h3>
                    <p class="text-blue-100 mb-8 text-sm md:text-base leading-relaxed">
                        Let's make another great day's<br>
                        and keep smile
                    </p>
                    
                    <!-- Floating particles -->
                    <div class="absolute -top-4 -right-2 w-2 h-2 bg-white rounded-full opacity-60 floating-animation" style="animation-delay: -1s;"></div>
                    <div class="absolute -bottom-2 -left-4 w-1 h-1 bg-white rounded-full opacity-40 floating-animation" style="animation-delay: -3s;"></div>
                </div>
            </div>
            
            <!-- Bottom decoration -->
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-white bg-opacity-5 rounded-full transform translate-x-16 translate-y-16"></div>
        </div>
    </div>
</body>
</html>