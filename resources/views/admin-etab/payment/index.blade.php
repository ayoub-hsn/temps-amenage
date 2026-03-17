@extends('admin-etab.layouts.master')

@section('content')
<style>
/* ===========================
   BODY
=========================== */
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(160deg, #e0e7ff, #fef9f0);
    color: #0f172a;
    overflow-x: hidden;
}

/* ===========================
   HERO SECTION
=========================== */
.dashboard-hero {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    border-radius: 40px;
    padding: 50px 40px;
    margin-bottom: 50px;
    color: white;
    box-shadow: 0 25px 80px rgba(0,0,0,0.25);
    position: relative;
    overflow: hidden;
}

/* Animated glowing circles */
.dashboard-hero::before, .dashboard-hero::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.2), transparent);
    z-index: 0;
    animation: float 7s ease-in-out infinite alternate;
}
.dashboard-hero::before { width: 500px; height: 500px; top: -150px; right: -150px; }
.dashboard-hero::after { width: 400px; height: 400px; bottom: -120px; left: -120px; }

@keyframes float { 0%{transform: translateY(0) translateX(0);} 50%{transform: translateY(20px) translateX(20px);} 100%{transform: translateY(0) translateX(0);} }

/* Logo */
.dashboard-hero img {
    width: 160px;
    height: 160px;
    object-fit: contain; /* ensures logo fits without stretching */
    border-radius: 50%;
    background: linear-gradient(135deg,#ffffff,#dbeafe);
    padding: 15px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.35), 0 0 40px rgba(255,255,255,0.3) inset;
    transition: transform 0.5s, box-shadow 0.5s;
    z-index: 1;
}
.dashboard-hero img:hover {
    transform: rotateY(15deg) rotateX(5deg) scale(1.05);
    box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 50px rgba(255,255,255,0.4) inset;
}

/* Hero Text */
.hero-info {
    position: relative;
    z-index: 1;
    max-width: 650px;
}
.hero-info h1 {
    font-size: 46px;
    font-weight: 900;
    margin-bottom: 10px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.4);
}
.hero-info p {
    font-size: 18px;
    color: rgba(255,255,255,0.9);
    margin-bottom: 10px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.25);
}
.hero-info .total-revenue {
    font-size: 32px;
    font-weight: 700;
    margin-top: 20px;
    color: #fffb;
    text-shadow: 0 4px 25px rgba(0,0,0,0.6);
}

/* ===========================
   KPI CARDS (Glassmorphism)
=========================== */
.kpi-container {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    margin-bottom: 50px;
}
.kpi-card {
    flex: 1;
    min-width: 280px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 30px;
    text-align: center;
    color: white;
    box-shadow: 0 25px 70px rgba(0,0,0,0.2);
    transform: translateY(50px);
    opacity: 0;
    animation: fadeUp 0.7s forwards;
}
.kpi-card:nth-child(1) { animation-delay: 0.2s; }
.kpi-card:nth-child(2) { animation-delay: 0.4s; }
.kpi-card:nth-child(3) { animation-delay: 0.6s; }

@keyframes fadeUp { to { transform: translateY(0); opacity: 1; } }

.kpi-card h5 { font-weight: 700; font-size: 22px; margin-bottom: 15px; }
.kpi-number { font-size: 38px; font-weight: 900; margin-bottom: 10px; }
.progress-modern { height: 14px; background: rgba(255,255,255,0.25); border-radius: 25px; overflow: hidden; margin-top: 15px; }
.progress-fill { height: 100%; width: 0%; background: white; border-radius: 25px; transition: 1.5s ease; }

/* ===========================
   CHARTS
=========================== */
.chart-container { display: flex; flex-wrap: wrap; gap: 30px; }
.chart-card {
    flex: 1;
    min-width: 350px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(25px);
    border-radius: 30px;
    padding: 30px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.15);
    transition: transform 0.3s, box-shadow 0.3s;
}
.chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 35px 90px rgba(0,0,0,0.25);
}
.chart-card h5 { font-weight: 700; margin-bottom: 20px; color: #1e3a8a; }
.chart-wrapper { display: flex; justify-content: center; align-items: center; }

/* ===========================
   FILIERE BUTTONS
=========================== */
.filiere-buttons {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 25px;
}
.filiere-buttons a {
    padding: 14px 30px;
    border-radius: 30px;
    font-weight: 600;
    color: white;
    text-decoration: none;
    transition: 0.4s;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.filiere-buttons a.active {
    transform: scale(1.1);
    box-shadow: 0 12px 35px rgba(0,0,0,0.35);
}

/* COLORS */
.kpi-master, .btn-master { background: linear-gradient(135deg,#1e40af,#3b82f6); }
.kpi-orange, .btn-licence { background: linear-gradient(135deg,#ea580c,#fb923c); }
.kpi-green, .btn-bac { background: linear-gradient(135deg,#047857,#10b981); }
</style>

<div class="main-content">
    <section class="section">

        {{-- ================= HERO ================= --}}
        <div class="dashboard-hero">
            <img src="{{ asset($etablissement->logo) }}" alt="Logo">
            <div class="hero-info">
                <h1>{{ $etablissement->nom_abrev }} - Dashboard Financier</h1>
                <p>{{ $etablissement->nom }}</p>
                <p class="total-revenue">
                    Revenue Total: <span class="counter">{{ $etablissement->master_revenue + $etablissement->passerelle_revenue + $etablissement->bachelier_revenue }}</span>
                </p>
            </div>
        </div>

        {{-- ================= KPI CARDS ================= --}}
        @php
            $masterPercent = $etablissement->master_total > 0 ? ($etablissement->master_paid / $etablissement->master_total) * 100 : 0;
            $passPercent   = $etablissement->passerelle_total > 0 ? ($etablissement->passerelle_paid / $etablissement->passerelle_total) * 100 : 0;
            $bacPercent    = $etablissement->bachelier_total > 0 ? ($etablissement->bachelier_paid / $etablissement->bachelier_total) * 100 : 0;
        @endphp
        <div class="kpi-container">
            <div class="kpi-card kpi-master">
                <h5>🎓 Master</h5>
                <div class="kpi-number counter">{{ $etablissement->master_revenue ?? 0 }}</div>
                <p>Total: {{ $etablissement->master_total }}</p>
                <p>Payés: {{ $etablissement->master_paid }}</p>
                <div class="progress-modern"><div class="progress-fill" data-value="{{ $masterPercent }}"></div></div>
            </div>
            <div class="kpi-card kpi-orange">
                <h5>⚡ Licence S5</h5>
                <div class="kpi-number counter">{{ $etablissement->passerelle_revenue ?? 0 }}</div>
                <p>Total: {{ $etablissement->passerelle_total }}</p>
                <p>Payés: {{ $etablissement->passerelle_paid }}</p>
                <div class="progress-modern"><div class="progress-fill" data-value="{{ $passPercent }}"></div></div>
            </div>
            <div class="kpi-card kpi-green">
                <h5>📚 Licence S1</h5>
                <div class="kpi-number counter">{{ $etablissement->bachelier_revenue ?? 0 }}</div>
                <p>Total: {{ $etablissement->bachelier_total }}</p>
                <p>Payés: {{ $etablissement->bachelier_paid }}</p>
                <div class="progress-modern"><div class="progress-fill" data-value="{{ $bacPercent }}"></div></div>
            </div>
        </div>

        {{-- ================= FILIERE BUTTONS ================= --}}
        <div class="filiere-buttons">
            <a href="javascript:void(0)" class="btn-master active" data-type="master">🎓 Master Filières</a>
            <a href="javascript:void(0)" class="btn-licence" data-type="passerelle">⚡ Licence S5 Filières</a>
            <a href="javascript:void(0)" class="btn-bac" data-type="bachelier">📚 Licence S1 Filières</a>
        </div>

        {{-- ================= CHARTS ================= --}}
        <div class="chart-container mt-5">
            <div class="chart-card">
                <h5>Répartition des Revenus</h5>
                <div class="chart-wrapper">
                    <canvas id="revChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h5>Répartition des Étudiants Payés</h5>
                <div class="chart-wrapper">
                    <canvas id="stuChart"></canvas>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue & Paid Data
const revenueData = { master: {{ $etablissement->master_revenue ?? 0 }}, passerelle: {{ $etablissement->passerelle_revenue ?? 0 }}, bachelier: {{ $etablissement->bachelier_revenue ?? 0 }} };
const paidData = { master: {{ $etablissement->master_paid ?? 0 }}, passerelle: {{ $etablissement->passerelle_paid ?? 0 }}, bachelier: {{ $etablissement->bachelier_paid ?? 0 }} };

// Charts
let revChart = new Chart(document.getElementById('revChart'), { type: 'doughnut', data: { labels: ['Master','Licence S5','Licence S1'], datasets: [{ data: [revenueData.master, revenueData.passerelle, revenueData.bachelier], backgroundColor: ['#2563eb','#fb923c','#10b981'] }] }, options: { cutout:'65%' } });
let stuChart = new Chart(document.getElementById('stuChart'), { type: 'pie', data: { labels: ['Master Payés','Licence S5 Payés','Licence S1 Payés'], datasets: [{ data: [paidData.master, paidData.passerelle, paidData.bachelier], backgroundColor: ['#1e40af','#ea580c','#047857'] }] } });

// Filieres button click
$('.filiere-buttons a').click(function(){
    $('.filiere-buttons a').removeClass('active');
    $(this).addClass('active');
    let type = $(this).data('type');
    revChart.data.datasets[0].data = [ type==='master'?revenueData.master:0, type==='passerelle'?revenueData.passerelle:0, type==='bachelier'?revenueData.bachelier:0 ];
    revChart.update();
    stuChart.data.datasets[0].data = [ type==='master'?paidData.master:0, type==='passerelle'?paidData.passerelle:0, type==='bachelier'?paidData.bachelier:0 ];
    stuChart.update();
});

// Counter Animation
$('.counter').each(function(){
    let el=$(this); let value=parseInt(el.text().replace(/\s/g,''))||0;
    $({n:0}).animate({n:value},{ duration:2200, easing:"swing", step:function(){ el.text(Math.floor(this.n).toLocaleString("fr-FR")); }, complete:function(){ el.text(value.toLocaleString("fr-FR")+" DH"); } });
});

// Progress Fill
$('.progress-fill').each(function(){ $(this).css('width', $(this).data('value')+'%'); });
</script>
@endsection