@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Maintenance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#3b82f6',
                        'sidebar-blue': '#1e40af'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #3b82f6 0%, #1e40af 100%);
        }
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient text-white flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-blue-400">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 object-contain" />
                    <div>
                        <h1 class="font-bold text-lg">Maintenance</h1>
                        <p class="text-sm text-blue-200">System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-1">
                    <!-- Dashboard (active item) -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-4 p-3 rounded-lg bg-white bg-opacity-20 text-white font-medium">
                            <span class="material-symbols-outlined">dashboard</span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Jadwal -->
                    <li>
                        <a href=""
                           class="flex items-center gap-4 p-3 rounded-lg transition-colors hover:bg-white hover:bg-opacity-10 text-white">
                            <span class="material-symbols-outlined">event_note</span>
                            <span>Jadwal</span>
                        </a>
                    </li>

                    <!-- Aset -->
                    <li>
                        <a href=""
                           class="flex items-center gap-4 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 text-white">
                            <span class="material-symbols-outlined">inventory_2</span>
                            <span>Aset</span>
                        </a>
                    </li>

                    <!-- Parameter -->
                    <li>
                        <a href=""
                           class="flex items-center gap-4 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 text-white">
                            <span class="material-symbols-outlined">tune</span>
                            <span>Parameter</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <div class="sidebar-gradient text-white shadow border-b p-4 flex items-center justify-end">
                <div class="flex items-center space-x-4">
                    <span class="text-sm">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="flex-1 p-8 overflow-auto">
                <div class="max-w-7xl mx-auto">
                    <!-- Dashboard Cards -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        
                        <!-- Jadwal Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal</h3>
                                <div class="flex items-center justify-center mb-4">
                                    <div class="relative w-24 h-24">
                                        <canvas id="jadwalChart"></canvas>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-blue-600">67%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span>Terlaksana</span>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xs text-gray-500">Bulan ini</span>
                                </div>
                            </div>
                        </div>

                        <!-- Aset Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="bg-blue-100 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aset</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-blue-600">165</div>
                                        <div class="text-sm text-gray-600">Komputer</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-blue-600">66</div>
                                        <div class="text-sm text-gray-600">Printer</div>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="" class="text-sm text-blue-600 hover:text-blue-800">
                                        Lihat Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>

                        
                    <!-- Notifications Section -->
                    <div class="bg-white rounded-lg shadow col-span-2">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Notifikasi</h3>
                            <div class="space-y-3">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">
                                        Jadwal maintenance untuk <strong>Printer EPSON L3120</strong> di <strong>Ruang ICU</strong> akan dilaksanakan pada tanggal <strong>24 Juli 2025</strong> pukul <strong>14:30 WIB</strong>
                                    </p>
                                    <span class="text-xs text-gray-500 mt-2 block">2 jam yang lalu</span>
                                </div>
                                
                                <!-- <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">
                                        Maintenance <strong>CT Scan</strong> di <strong>Radiologi</strong> telah selesai dilaksanakan
                                    </p>
                                    <span class="text-xs text-gray-500 mt-2 block">5 jam yang lalu</span>
                                </div> -->
                                
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">
                                        Semua aset di <strong>Farmasi</strong> telah melewati pemeriksaan rutin bulan ini
                                    </p>
                                    <span class="text-xs text-gray-500 mt-2 block">3 jam yang lalu</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create donut chart for Jadwal
        const ctx = document.getElementById('jadwalChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [67, 33],
                    backgroundColor: ['#3b82f6', '#e5e7eb'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

</body>
</html>
@endsection