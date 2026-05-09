@extends('layouts.app')

@section('title', 'Dashboard Overview — HR App')
@section('page_title', 'Dashboard Overview')

@section('css')
    <style>
        /* ============================================================
        KHUSUS HALAMAN DASHBOARD
        ============================================================ */
        .summary-card {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            border-left: 4px solid var(--accent); /* Garis aksen di sebelah kiri */
        }
        
        /* Efek terangkat (hover) yang halus */
        .summary-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Varian warna untuk icon box */
        .bg-primary-soft { background-color: rgba(79, 110, 247, 0.15); color: var(--accent); }
        .bg-success-soft { background-color: rgba(16, 185, 129, 0.15); color: #10b981; }
        .bg-warning-soft { background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid px-0">
    
    {{-- ===================== SUMMARY CARDS ===================== --}}
    <div class="row g-4 mb-4">
        
        <!-- Card 1: Total Employees -->
        <div class="col-12 col-md-4">
            <div class="card card-enterprise summary-card h-100 p-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted-custom fw-semibold mb-1" style="font-size: 13px;">Total Employees</p>
                        <!-- Angka statis sementara -->
                        <h3 class="fw-bold mb-0 text-primary-custom">250</h3>
                    </div>
                    <div class="icon-box bg-primary-soft">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Total Departments -->
        <div class="col-12 col-md-4">
            <div class="card card-enterprise summary-card h-100 p-4 border-0" style="border-left-color: #f59e0b;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted-custom fw-semibold mb-1" style="font-size: 13px;">Total Departments</p>
                        <h3 class="fw-bold mb-0 text-primary-custom">5</h3>
                    </div>
                    <div class="icon-box bg-warning-soft">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Present Today -->
        <div class="col-12 col-md-4">
            <div class="card card-enterprise summary-card h-100 p-4 border-0" style="border-left-color: #10b981;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted-custom fw-semibold mb-1" style="font-size: 13px;">Present Today</p>
                        <h3 class="fw-bold mb-0 text-primary-custom">238</h3>
                    </div>
                    <div class="icon-box bg-success-soft">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== CHART AREA ===================== --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-enterprise p-4 border-0">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-primary-custom mb-1">Employee Distribution</h5>
                        <p class="text-muted-custom mb-0" style="font-size: 13px;">Number of employees in each department</p>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" style="font-family: var(--font-main);">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                </div>
                
                <div class="chart-container">
                    <!-- Canvas Placeholder for Chart.js -->
                    <canvas id="hrChart"></canvas>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
{{-- Loading the Chart.js library via a CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    
    const ctx = document.getElementById('hrChart').getContext('2d');
    
    // Use CSS color variables to make the chart adapt to Dark Mode/Light Mode
    const style = getComputedStyle(document.body);
    const textColor = style.getPropertyValue('--text-primary').trim() || '#1a2035';
    const gridColor = style.getPropertyValue('--border-color').trim() || '#e8eaf2';
    const accentColor = style.getPropertyValue('--accent').trim() || '#4f6ef7';

    // Bar Chart Configuration
    const hrChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // Preliminary static data
            labels: ['IT', 'Finance', 'HRD', 'Production', 'Marketing'],
            datasets: [{
                label: 'Total Karyawan',
                data: [45, 25, 10, 120, 50],
                backgroundColor: accentColor,
                borderRadius: 6,         
                barPercentage: 0.4       
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Hidden to keep the layout clean
                },
                tooltip: {
                    backgroundColor: '#1a2035',
                    titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                    bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor,
                        drawBorder: false,
                    },
                    ticks: {
                        color: textColor,
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 }
                    }
                },
                x: {
                    grid: {
                        display: false, // Removing vertical lines from the chart background
                        drawBorder: false,
                    },
                    ticks: {
                        color: textColor,
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 }
                    }
                }
            }
        }
    });

    /* 
       Refresh the text and line colors in Chart.js when the Dark Mode button is clicked
    */
    $('#themeToggle').on('click', function() {
        setTimeout(() => {
            const newStyle = getComputedStyle(document.body);
            hrChart.options.scales.x.ticks.color = newStyle.getPropertyValue('--text-primary').trim();
            hrChart.options.scales.y.ticks.color = newStyle.getPropertyValue('--text-primary').trim();
            hrChart.options.scales.y.grid.color = newStyle.getPropertyValue('--border-color').trim();
            hrChart.update();
        }, 300); // Wait 300 ms for the CSS transition to complete
    });

});
</script>
@endsection