@extends('admin-etab.layouts.master')


@section('content')
  <style>
    .dashboard-card {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      min-height: 220px;
      transition: all 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .dashboard-card h2 {
      font-size: 2rem;
    }

    .dashboard-card .card-img {
      width: 80px;
      height: auto;
      opacity: 0.9;
    }

    @media (max-width: 767px) {
      .dashboard-card {
        min-height: 180px;
        padding: 1rem;
      }
      .dashboard-card h2 {
        font-size: 1.6rem;
      }
      .dashboard-card .card-img {
        width: 65px;
      }
    }
  </style>

  <div class="main-content">
    <section class="section">
      <div class="row g-4">

        <!-- === Étudiants en Total === -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
          <div class="card dashboard-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
            @php
                $totalPercentageIncrease = $percentageIncreaseMaster + $percentageIncreasepasserelle;
                $colorTotal = 'text-danger';
                if ($totalPercentageIncrease >= 10) $colorTotal = 'text-success';
                elseif ($totalPercentageIncrease >= 1) $colorTotal = 'text-warning';
            @endphp
            <div>
              <h6 class="text-muted mb-2">Étudiants - Total</h6>
              <h2 class="fw-bold text-gray">{{ $studentMasterCount + $studentPasserelleCount }}</h2>
              <p class="mb-0"><span class="{{ $colorTotal }}">{{ $totalPercentageIncrease }}%</span> d’augmentation</p>
            </div>
            <img src="{{ asset('dashboard/img/banner/students-total.png') }}" alt="Total" class="card-img mx-auto">
          </div>
        </div>

        <!-- === Étudiants Master === -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
          <div class="card dashboard-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
            @php
                $colorMaster = 'text-danger';
                if ($percentageIncreaseMaster >= 10) $colorMaster = 'text-success';
                elseif ($percentageIncreaseMaster >= 1) $colorMaster = 'text-warning';
            @endphp
            <div>
              <h6 class="text-muted mb-2">Étudiants - Master</h6>
              <h2 class="fw-bold {{ $colorMaster }}">{{ $studentMasterCount }}</h2>
              <p class="mb-0"><span class="{{ $colorMaster }}">{{ $percentageIncreaseMaster }}%</span> d’augmentation</p>
            </div>
            <img src="{{ asset('dashboard/img/banner/master.png') }}" alt="Master" class="card-img mx-auto">
          </div>
        </div>

        <!-- === Étudiants Licence (S5 + S1) === -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
          <div class="card dashboard-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
            @php
                $colorPasserelle = 'text-danger';
                if ($percentageIncreasepasserelle >= 10) $colorPasserelle = 'text-success';
                elseif ($percentageIncreasepasserelle >= 1) $colorPasserelle = 'text-warning';

                $colorBachelier = 'text-danger';
                if ($percentageIncreaseBachelier >= 10) $colorBachelier = 'text-success';
                elseif ($percentageIncreaseBachelier >= 1) $colorBachelier = 'text-warning';
            @endphp

            <div>
              <h6 class="text-muted mb-2">Étudiants - Licences (Accès S5 + S1)</h6>
              <div class="d-flex flex-column gap-1">
                <span class="fw-bold {{ $colorPasserelle }}">S5 : {{ $studentPasserelleCount }} 
                  <small>({{ $percentageIncreasepasserelle }}%)</small>
                </span>
                <span class="fw-bold {{ $colorBachelier }}">S1 : {{ $studentBachelierCount }} 
                  <small>({{ $percentageIncreaseBachelier }}%)</small>
                </span>
              </div>
            </div>

            <img src="{{ asset('dashboard/img/banner/bachelor.png') }}" alt="Licence" class="card-img mx-auto">
          </div>
        </div>

        <!-- === Filières === -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
          <div class="card dashboard-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
            <div>
              <h6 class="text-muted mb-2">Filières</h6>
              <h2 class="fw-bold text-gray">{{ $filieresCount }}</h2>
              <p class="mb-0 text-transparent">.</p>
            </div>
            <img src="{{ asset('dashboard/img/banner/courses.png') }}" alt="Filières" class="card-img mx-auto">
          </div>
        </div>

      </div>


      <!-- === statistiques bars === -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0">Master</h4>
            </div>
            <div class="card-body">
              <canvas id="filiereChartMaster" height="450"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0">Licences (Accès S5)</h4>
            </div>
            <div class="card-body">
              <canvas id="filiereChartPasserelle" height="450"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0">Licences (Accès S1)</h4>
            </div>
            <div class="card-body">
              <canvas id="filiereChartBachelier" height="450"></canvas>
            </div>
          </div>
        </div>
      </div>



    </section>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {
    // Common style for both charts
    function createGradient(ctx, color1, color2) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    }

    function createChart(canvasId, labels, data, title, color1, color2) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        const gradient = createGradient(ctx, color1, color2);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre des Postulants',
                    data: data,
                    backgroundColor: gradient,
                    borderRadius: 10,
                    hoverBackgroundColor: '#00000022',
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 20
                },
                plugins: {
                    title: {
                        display: true,
                        text: title,
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Helvetica'
                        },
                        color: '#333'
                    },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 6
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#444',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: '#eaeaea'
                        },
                        title: {
                            display: true,
                            text: 'Nombre des postulants',
                            color: '#888',
                            font: {
                                size: 14,
                                style: 'italic'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#444',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'transparent'
                        },
                        title: {
                            display: true,
                            text: 'Filières',
                            color: '#888',
                            font: {
                                size: 14,
                                style: 'italic'
                            }
                        }
                    }
                }
            }
        });
    }

    // Render Master Chart
    createChart(
        'filiereChartMaster',
        @json($statsMaster->pluck('nom_complet')),
        @json($statsMaster->pluck('postulants_count')),
        "Candidatures Master",
        '#3f51b5',
        '#5c6bc0'
    );

    // Render Licences (Accès S5) Chart
    createChart(
        'filiereChartPasserelle',
        @json($statsPasserelle->pluck('nom_complet')),
        @json($statsPasserelle->pluck('postulants_count')),
        "Candidatures Licences (Accès S5)",
        '#388e3c',
        '#66bb6a'
    );

    // Render Licences (Accès S1) Chart
    createChart(
        'filiereChartBachelier',
        @json($statsBachelier->pluck('nom_complet')),
        @json($statsBachelier->pluck('postulants_count')),
        "Candidatures Licences (Accès S1)",
        '#360e3c',
        '#33ab6a'
    );
});
</script>



@endsection
