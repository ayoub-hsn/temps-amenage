@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
  <section class="section">
    <div class="row g-4">
      <!-- ===== Filières Master ===== -->
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card equal-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
          <div>
            <h6 class="text-muted mb-2">Filières Master</h6>
            <h2 class="fw-bold text-success mb-3">{{ $FilieresMasterCount }}</h2>
          </div>
          <img src="{{ asset('dashboard/img/banner/master.png') }}" alt="Master" class="mx-auto" style="width:80px; height:auto;">
        </div>
      </div>

      <!-- ===== Filières Licence (S5 + S1) ===== -->
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card equal-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
          <div>
            <h6 class="text-muted mb-2">Filières Licence (Accès S5 + S1)</h6>
            <div class="d-flex flex-column">
              <span class="fw-bold text-success">S5 : {{ $filieresPasserelleCount }}</span>
              <span class="fw-bold text-info">S1 : {{ $filieresBachelierCount }}</span>
            </div>
          </div>
          <img src="{{ asset('dashboard/img/banner/bachelor.png') }}" alt="Licence" class="mx-auto" style="width:80px; height:auto;">
        </div>
      </div>

      <!-- ===== Candidats Master ===== -->
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card equal-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
          <div>
            <h6 class="text-muted mb-2">Candidats Master</h6>
            <h2 class="fw-bold text-success mb-3">{{ $filieresMasterCandidatCount }}</h2>
          </div>
          <img src="{{ asset('dashboard/img/banner/1.png') }}" alt="Master Candidats" class="mx-auto" style="width:80px; height:auto;">
        </div>
      </div>

      <!-- ===== Candidats Licence (S5 + S1) ===== -->
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card equal-card shadow-sm border-0 rounded-4 text-center p-3 d-flex flex-column justify-content-between h-100">
          <div>
            <h6 class="text-muted mb-2">Candidats Licence (Accès S5 + S1)</h6>
            <div class="d-flex flex-column">
              <span class="fw-bold text-success">S5 : {{ $filieresPasserelleCandidatCount }}</span>
              <span class="fw-bold text-info">S1 : {{ $filieresBachelierCandidatCount }}</span>
            </div>
          </div>
          <img src="{{ asset('dashboard/img/banner/group-passerelle.png') }}" alt="Licence Candidats" class="mx-auto" style="width:80px; height:auto;">
        </div>
      </div>
    </div>

    <!-- ===== Chart Section ===== -->
    <div class="row mt-4">
    <div class="col-12">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Répartition des Candidats par Établissement</h5>
          <div class="d-flex">
            <form action="{{ route('sup-admin.data.telecharger.etablissement') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-light btn-sm me-2">
                <i class="fas fa-download"></i> Télécharger les données par établissement
              </button>
            </form>
            <form action="{{ route('sup-admin.data.telecharger.filiere') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-light btn-sm">
                <i class="fas fa-download"></i> Télécharger par Filière
              </button>
            </form>
          </div>
        </div>
        <div class="card-body bg-light rounded-bottom-4">
          <div style="height: 400px;">
            <canvas id="beautifulChart"></canvas>
          </div>
        </div>
      </div>
    </div>
</div>

  </section>


</div>

<!-- === Styles to unify card size and improve responsiveness === -->
<style>
  .equal-card {
    min-height: 220px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .equal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  @media (max-width: 767px) {
    .equal-card {
      min-height: 180px;
    }
  }
</style>

<!-- === Chart.js with datalabels === -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
  const ctx = document.getElementById('beautifulChart').getContext('2d');

  // === Dégradés ===
  const gradientMaster = ctx.createLinearGradient(0, 0, 0, 400);
  gradientMaster.addColorStop(0, 'rgba(54, 162, 235, 0.9)');
  gradientMaster.addColorStop(1, 'rgba(54, 162, 235, 0.2)');

  const gradientPasserelle = ctx.createLinearGradient(0, 0, 0, 400);
  gradientPasserelle.addColorStop(0, 'rgba(255, 159, 64, 0.9)');
  gradientPasserelle.addColorStop(1, 'rgba(255, 159, 64, 0.2)');

  const gradientBachelier = ctx.createLinearGradient(0, 0, 0, 400);
  gradientBachelier.addColorStop(0, 'rgba(75, 192, 192, 0.9)');
  gradientBachelier.addColorStop(1, 'rgba(75, 192, 192, 0.2)');

  // === Graphique ===
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($labels),
      datasets: [
        {
          label: 'Masters',
          data: @json($dataMaster),
          backgroundColor: gradientMaster,
          borderRadius: 10,
          barThickness: 30
        },
        {
          label: 'Licences (Accès S5)',
          data: @json($dataPasserelle),
          backgroundColor: gradientPasserelle,
          borderRadius: 10,
          barThickness: 30
        },
        {
          label: 'Licences (Accès S1)',
          data: @json($dataBachelier),
          backgroundColor: gradientBachelier,
          borderRadius: 10,
          barThickness: 30
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            color: '#333',
            font: { size: 14, weight: 'bold' }
          }
        },
        tooltip: {
          backgroundColor: '#fff',
          titleColor: '#000',
          bodyColor: '#000',
          borderColor: '#ddd',
          borderWidth: 1
        },
        datalabels: {
          anchor: 'end',
          align: 'top',
          color: '#000',
          font: { weight: 'bold', size: 12 },
          formatter: Math.round
        }
      },
      scales: {
        x: {
          ticks: { color: '#555', font: { size: 13 } },
          grid: { display: false }
        },
        y: {
          beginAtZero: true,
          ticks: { color: '#555', font: { size: 13 }, stepSize: 1 },
          grid: { borderDash: [5, 5], color: '#ccc' }
        }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>

@endsection
