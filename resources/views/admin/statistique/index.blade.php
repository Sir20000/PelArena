<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analyze') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Statistiques Générales</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach([
                        ['Utilisateurs', $totalUsers, 'ri-user-line', 'text-blue-500'],
                        ['Serveurs', $totalOrders, 'ri-server-line', 'text-green-500'],
                        ['Transactions', $totalTransactions, 'ri-exchange-line', 'text-yellow-500'],
                        ['Crédits', $totalCredits, 'ri-money-dollar-box-line', 'text-purple-500'],
                        ['Coupons Utilisés', $totalCouponUsage, 'ri-price-tag-3-line', 'text-red-500'],
                        ['Tickets (Ouverts/Fermés)', "$openTickets / $closedTickets", 'ri-customer-service-2-line', 'text-orange-500'],
                        ['Revenue du mois', "$currentMonthRevenue €", 'ri-money-euro-circle-line', 'text-green-500'],
                        ['Revenue du mois dernier', "$lastMonthRevenue €", 'ri-money-euro-circle-line', 'text-purple-500'],
                        ["Revenue de l'anné", "$thisYearRevenue €", 'ri-money-euro-circle-line', 'text-blue-500'],
                        ["Revenue de l'anné dernier", "$lastYearRevenue €", 'ri-money-euro-circle-line', 'text-red-500'],
                        ["Nombre de requete total",format_number($totalrequete),"ri-arrow-up-down-fill","text-cyan-500"],

                    ] as $stat)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg shadow-md flex items-center ">
                            <i class="{{ $stat[2] }} text-3xl {{ $stat[3] }}"></i>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $stat[0] }}</h3>
                                <p class="text-gray-300 text-lg font-semibold">{{ $stat[1] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Graphiques -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Répartition Tickets </h2>
                        <canvas id="statsChart"></canvas>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Évolution des Statistiques (30 derniers jours)</h2>
                        <canvas id="evolutionChart"></canvas>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Évolution des Statistiques (Depuis 1 ans)</h2>
                        <canvas id="evolutionChartyear"></canvas>
                    </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Évolution des Statistiques (Depuis toujours)</h2>
                        <canvas id="evolutionChartever"></canvas>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Prix Selon la categorie </h2>
                        <canvas id="prixChart"></canvas>
                        </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Graphique Répartition Tickets et Coupons
            new Chart(document.getElementById('statsChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Tickets Ouverts', 'Tickets Fermés', ],
                    datasets: [{
                        data: [{{ $openTickets }}, {{ $closedTickets }}],
                        backgroundColor: ['#ff4d4d', '#4CAF50'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } }
                }
                
            });
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: 'Utilisateurs',
                        data: {!! json_encode($userStats) !!},
                        borderColor: '#4A90E2',
                        backgroundColor: 'rgba(74, 144, 226, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Commandes',
                        data: {!! json_encode($orderStats) !!},
                        borderColor: '#50C878',
                        backgroundColor: 'rgba(80, 200, 120, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Transactions',
                        data: {!! json_encode($transactionStats) !!},
                        borderColor: '#FF7F50',
                        backgroundColor: 'rgba(255, 127, 80, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Tickets',
                        data: {!! json_encode($ticketStats) !!},
                        borderColor: '#FF4D4D',
                        backgroundColor: 'rgba(255, 77, 77, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
        const ctxEver = document.getElementById('evolutionChartever').getContext('2d');
        new Chart(ctxEver, {
            type: 'line',
            data: {
                labels: {!! json_encode($datesEver) !!},
                datasets: [
                    {
                        label: 'Utilisateurs',
                        data: {!! json_encode($userStatsEver) !!},
                        borderColor: '#4A90E2',
                        backgroundColor: 'rgba(74, 144, 226, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Commandes',
                        data: {!! json_encode($orderStatsEver) !!},
                        borderColor: '#50C878',
                        backgroundColor: 'rgba(80, 200, 120, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Transactions',
                        data: {!! json_encode($transactionStatsEver) !!},
                        borderColor: '#FF7F50',
                        backgroundColor: 'rgba(255, 127, 80, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Tickets',
                        data: {!! json_encode($ticketStatsEver) !!},
                        borderColor: '#FF4D4D',
                        backgroundColor: 'rgba(255, 77, 77, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
        const ctxYear = document.getElementById('evolutionChartyear').getContext('2d');
        new Chart(ctxYear, {
            type: 'line',
            data: {
                labels: {!! json_encode($datesYear) !!},
                datasets: [
                    {
                        label: 'Utilisateurs',
                        data: {!! json_encode($userStatsYear) !!},
                        borderColor: '#4A90E2',
                        backgroundColor: 'rgba(74, 144, 226, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Commandes',
                        data: {!! json_encode($orderStatsYear) !!},
                        borderColor: '#50C878',
                        backgroundColor: 'rgba(80, 200, 120, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Transactions',
                        data: {!! json_encode($transactionStatsYear) !!},
                        borderColor: '#FF7F50',
                        backgroundColor: 'rgba(255, 127, 80, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Tickets',
                        data: {!! json_encode($ticketStatsYear) !!},
                        borderColor: '#FF4D4D',
                        backgroundColor: 'rgba(255, 77, 77, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });    
    </script>
    <script>
        var prixData = @json($prixData); // Conversion des données PHP en JavaScript

        // Extraire les labels (catégories) et les données pour chaque caractéristique
        var categories = prixData.map(function(item) {
            return item.categorie.name; // Ou item.categories.name si tu veux les noms
        });

        var ramData = prixData.map(function(item) {
            return item.ram;
        });

        var cpuData = prixData.map(function(item) {
            return item.cpu;
        });

        var storageData = prixData.map(function(item) {
            return item.storage;
        });

        var dbData = prixData.map(function(item) {
            return item.db;
        });

        var backupsData = prixData.map(function(item) {
            return item.backups;
        });

        var allocationsData = prixData.map(function(item) {
            return item.allocations;
        });

        // Créer le graphique
        var ctx = document.getElementById('prixChart').getContext('2d');
        var prixChart = new Chart(ctx, {
            type: 'bar', // Type du graphique
            data: {
                labels: categories, // Labels pour chaque barre
                datasets: [{
                    label: 'RAM',
                    data: ramData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'CPU',
                    data: cpuData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Storage',
                    data: storageData,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }, {
                    label: 'Database',
                    data: dbData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Backups',
                    data: backupsData,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }, {
                    label: 'Allocations',
                    data: allocationsData,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
