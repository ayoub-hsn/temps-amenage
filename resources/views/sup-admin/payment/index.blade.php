@extends('sup-admin.layouts.master')
@section('content')
<style>
   /* ===========================
   BACKGROUND
   =========================== */
   body{
   background: radial-gradient(circle at 10% 20%, #ffffff, #eef2f9);
   font-family: 'Segoe UI', sans-serif;
   color:#0f172a;
   }
   /* ===========================
   HEADER GLOBAL
   =========================== */
   .dashboard-header{
   text-align:center;
   padding:70px 40px;
   border-radius:50px;
   background: linear-gradient(135deg,#1e3a8a,#2563eb);
   color:white;
   font-size:38px;
   font-weight:900;
   box-shadow:0 40px 120px rgba(37,99,235,0.35);
   }
   /* ===========================
   CARTE ETABLISSEMENT PREMIUM
   =========================== */
   .etab-header{
   display:flex;
   align-items:center;
   justify-content:space-between;
   padding:40px;
   border-radius:35px;
   background:linear-gradient(135deg,#f8fafc,#ffffff);
   box-shadow:0 25px 70px rgba(0,0,0,0.06);
   position:relative;
   overflow:hidden;
   transition:0.4s;
   }
   .etab-header:hover{
   transform:translateY(-6px);
   }
   .etab-left{
   display:flex;
   align-items:center;
   gap:30px;
   }
   .etab-logo{
   width:130px;
   height:130px;
   object-fit:contain;
   padding:25px;
   border-radius:50%;
   background:white;
   box-shadow:0 20px 50px rgba(37,99,235,0.25);
   transition:0.4s;
   }
   .etab-info h2{
   font-size:28px;
   font-weight:900;
   margin-bottom:5px;
   }
   .etab-info p{
   font-size:15px;
   color:#64748b;
   }
   .etab-badge{
   background:linear-gradient(90deg,#16a34a,#22c55e);
   color:white;
   padding:10px 18px;
   border-radius:20px;
   font-size:13px;
   font-weight:600;
   box-shadow:0 10px 25px rgba(34,197,94,0.4);
   }
   .etab-line{
   height:4px;
   width:100%;
   margin-top:25px;
   border-radius:10px;
   background:linear-gradient(90deg,#1e3a8a,#2563eb,#10b981);
   }
   /* ===========================
   MAIN CARD
   =========================== */
   .main-card{
   background:white;
   border-radius:45px;
   padding:60px;
   box-shadow:0 50px 140px rgba(0,0,0,0.06);
   margin-top:40px;
   }
   /* ===========================
   KPI
   =========================== */
   .kpi-card{
   padding:45px;
   border-radius:35px;
   color:white;
   box-shadow:0 30px 80px rgba(0,0,0,0.15);
   transition:0.4s;
   }
   .kpi-card:hover{
   transform:scale(1.05);
   }
   .kpi-master{background:linear-gradient(135deg,#1e40af,#3b82f6);}
   .kpi-orange{background:linear-gradient(135deg,#ea580c,#fb923c);}
   .kpi-green{background:linear-gradient(135deg,#047857,#10b981);}
   .kpi-number{
   font-size:44px;
   font-weight:900;
   }
   .progress-modern{
   height:10px;
   background:rgba(255,255,255,0.3);
   border-radius:20px;
   overflow:hidden;
   margin-top:18px;
   }
   .progress-fill{
   height:100%;
   width:0%;
   background:white;
   border-radius:20px;
   transition:1.5s ease;
   }
   /* ===========================
   CHARTS
   =========================== */
   .chart-card{
   background:rgba(255,255,255,0.9);
   border-radius:40px;
   padding:45px;
   box-shadow:0 40px 120px rgba(0,0,0,0.07);
   height:480px;
   display:flex;
   flex-direction:column;
   }
   .chart-card h5{
   font-weight:700;
   margin-bottom:30px;
   color:#1e3a8a;
   }
   .chart-wrapper{
   flex:1;
   display:flex;
   align-items:center;
   justify-content:center;
   }
   .chart-wrapper canvas{
   max-height:350px !important;
   }
</style>
<div class="main-content">
   <section class="section">
      <div class="dashboard-header mb-5">
         🏛 Dashboard financier
      </div>
      @php
      $totalUniversityRevenue =
      $etablissements->sum('master_revenue') +
      $etablissements->sum('passerelle_revenue') +
      $etablissements->sum('bachelier_revenue');
      @endphp
      <div class="container mb-5" style="max-width:1600px">
         <div style="
            background:white;
            padding:55px 60px;
            border-radius:65px;
            box-shadow:0 40px 120px rgba(0,0,0,0.05);
            ">
            <div class="row align-items-center">
               <div class="col-md-7">
                  <div style="display:flex;align-items:center;gap:40px">
                     <div style="
                        background:#F9F9F9;
                        padding:22px;
                        border-radius:40px;
                        box-shadow:0 20px 60px rgba(37,99,235,0.15);
                        ">
                        <img src="{{ asset('form/images/uh1-vert-plus.PNG') }}"
                           style="width:110px;height:110px;object-fit:contain;">
                     </div>
                     <div style="padding-left:25px;border-left:5px solid #e2e8f0">
                        <h2 style="font-size:38px;font-weight:900;color:#1e3a8a;">
                           Revenue Total d'UH1
                        </h2>
                        <p style="color:#94a3b8;margin:0;font-size:15px;">
                           Université Hassan 1er — Dashboard financier
                        </p>
                     </div>
                  </div>
               </div>
               @php
               $totalMasterRevenue = $etablissements->sum('master_revenue');
               $totalPassRevenue   = $etablissements->sum('passerelle_revenue');
               $totalBacRevenue    = $etablissements->sum('bachelier_revenue');
               $totalMasterPaid = $etablissements->sum('master_paid');
               $totalPassPaid   = $etablissements->sum('passerelle_paid');
               $totalBacPaid    = $etablissements->sum('bachelier_paid');
               $totalMaster     = $etablissements->sum('master_total');
               $totalPass       = $etablissements->sum('passerelle_total');
               $totalBac        = $etablissements->sum('bachelier_total');
               $masterPercentGlobal = $totalMaster > 0 ? ($totalMasterPaid / $totalMaster) * 100 : 0;
               $passPercentGlobal   = $totalPass > 0 ? ($totalPassPaid / $totalPass) * 100 : 0;
               $bacPercentGlobal    = $totalBac > 0 ? ($totalBacPaid / $totalBac) * 100 : 0;
               @endphp
               <div class="col-md-5 text-end">
                  <div style="
                     font-size:70px;
                     font-weight:900;
                     background: linear-gradient(90deg,#2563eb,#22c55e,#38bdf8);
                     -webkit-background-clip:text;
                     -webkit-text-fill-color:transparent;
                     line-height:1;
                     ">
                     <span class="counter">
                     {{ $totalUniversityRevenue }}
                     </span>
                  </div>
               </div>
               {{-- =========================
                Global KPI & Charts for UH1
                ========================= --}}
                <div class="container mb-5" style="max-width:1600px; margin-top:50px;">
                    <div class="main-card">
                        {{-- KPI CARDS --}}
                        <div class="row g-4 text-center mb-5">
                            {{-- MASTER KPI --}}
                            <div class="col-md-4">
                                <div class="kpi-card kpi-master">
                                    <h5>🎓 Master (Global)</h5>
                                    <div class="kpi-number counter">{{ $totalMasterRevenue ?? 0 }}</div>
                                    <p>Total : {{ $totalMaster }}</p>
                                    <p>Payés : {{ $totalMasterPaid }}</p>
                                    <div class="progress-modern">
                                        <div class="progress-fill" data-value="{{ $masterPercentGlobal }}"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- LICENCE S5 KPI --}}
                            <div class="col-md-4">
                                <div class="kpi-card kpi-orange">
                                    <h5>⚡ Licence S5 (Global)</h5>
                                    <div class="kpi-number counter">{{ $totalPassRevenue ?? 0 }}</div>
                                    <p>Total : {{ $totalPass }}</p>
                                    <p>Payés : {{ $totalPassPaid }}</p>
                                    <div class="progress-modern">
                                        <div class="progress-fill" data-value="{{ $passPercentGlobal }}"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- LICENCE S1 KPI --}}
                            <div class="col-md-4">
                                <div class="kpi-card kpi-green">
                                    <h5>📚 Licence S1 (Global)</h5>
                                    <div class="kpi-number counter">{{ $totalBacRevenue ?? 0 }}</div>
                                    <p>Total : {{ $totalBac }}</p>
                                    <p>Payés : {{ $totalBacPaid }}</p>
                                    <div class="progress-modern">
                                        <div class="progress-fill" data-value="{{ $bacPercentGlobal }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CHARTS --}}
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="chart-card">
                                    <h5>Répartition des Revenus (Global)</h5>
                                    <div class="chart-wrapper">
                                        <canvas id="revChart_global"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-card">
                                    <h5>Répartition des Étudiants Payés (Global)</h5>
                                    <div class="chart-wrapper">
                                        <canvas id="stuChart_global"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
      <div class="container-fluid">
         @foreach($etablissements as $etablissement)
         <div style="margin-bottom:140px;padding-bottom:120px;
            border-bottom:2px dashed rgba(30,58,138,0.1);">
            <div class="etab-header">
               <div class="etab-left">
                  <img src="{{ asset($etablissement->logo) }}" class="etab-logo">
                  <div class="etab-info">
                     <h2>{{ $etablissement->nom_abrev }}</h2>
                     <p>{{ $etablissement->nom }}</p>
                  </div>
               </div>
               <!-- ================= RIGHT PANEL ================= -->
               <div style="display:flex;align-items:center;gap:30px">
                  <div class="etab-badge">
                     ✔ Établissement Actif
                  </div>
                  <!-- ===== FILIERES BUTTONS ===== -->
                  <div style="display:flex;flex-direction:column;gap:10px">
                     <a href="{{ route('sup-admin.payment.master.filiere.index', $etablissement->id) }}"
                        style="
                        text-decoration:none;
                        padding:10px 22px;
                        border-radius:30px;
                        font-weight:600;
                        font-size:14px;
                        background:linear-gradient(135deg,#1e40af,#3b82f6);
                        color:white;
                        box-shadow:0 10px 30px rgba(37,99,235,0.25);
                        transition:0.3s;
                        "
                        onmouseover="this.style.transform='scale(1.05)'"
                        onmouseout="this.style.transform='scale(1)'"
                        >
                     🎓 Master Filières
                     </a>
                     <a href="{{ route('sup-admin.payment.licence.filiere.index', $etablissement->id) }}"
                        style="
                        text-decoration:none;
                        padding:10px 22px;
                        border-radius:30px;
                        font-weight:600;
                        font-size:14px;
                        background:linear-gradient(135deg,#ea580c,#fb923c);
                        color:white;
                        box-shadow:0 10px 30px rgba(234,88,12,0.25);
                        transition:0.3s;
                        "
                        onmouseover="this.style.transform='scale(1.05)'"
                        onmouseout="this.style.transform='scale(1)'"
                        >
                     ⚡ Licence S5 Filières
                     </a>
                     <a href="{{ route('sup-admin.payment.bachelier.filiere.index', $etablissement->id) }}"
                        style="
                        text-decoration:none;
                        padding:10px 22px;
                        border-radius:30px;
                        font-weight:600;
                        font-size:14px;
                        background:linear-gradient(135deg,#047857,#10b981);
                        color:white;
                        box-shadow:0 10px 30px rgba(4,120,87,0.25);
                        transition:0.3s;
                        "
                        onmouseover="this.style.transform='scale(1.05)'"
                        onmouseout="this.style.transform='scale(1)'"
                        >
                     📚 Licence S1 Filières
                     </a>
                  </div>
               </div>
            </div>
            <div class="etab-line"></div>
            <div class="main-card">
               @php
               $masterPercent = $etablissement->master_total>0 ?
               ($etablissement->master_paid/$etablissement->master_total)*100 : 0;
               $passPercent = $etablissement->passerelle_total>0 ?
               ($etablissement->passerelle_paid/$etablissement->passerelle_total)*100 : 0;
               $bacPercent = $etablissement->bachelier_total>0 ?
               ($etablissement->bachelier_paid/$etablissement->bachelier_total)*100 : 0;
               @endphp
               <div class="row g-4 text-center">
                  <div class="col-md-4">
                     <div class="kpi-card kpi-master">
                        <h5>🎓 Master</h5>
                        <div class="kpi-number counter">{{ $etablissement->master_revenue ?? 0 }}</div>
                        <p>Total : {{ $etablissement->master_total }}</p>
                        <p>Payés : {{ $etablissement->master_paid }}</p>
                        <div class="progress-modern">
                           <div class="progress-fill" data-value="{{ $masterPercent }}"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="kpi-card kpi-orange">
                        <h5>⚡ Licence (Accès S5)</h5>
                        <div class="kpi-number counter">{{ $etablissement->passerelle_revenue ?? 0 }}</div>
                        <p>Total : {{ $etablissement->passerelle_total }}</p>
                        <p>Payés : {{ $etablissement->passerelle_paid }}</p>
                        <div class="progress-modern">
                           <div class="progress-fill" data-value="{{ $passPercent }}"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="kpi-card kpi-green">
                        <h5>📚 Licence (Accès S1)</h5>
                        <div class="kpi-number counter">{{ $etablissement->bachelier_revenue ?? 0 }}</div>
                        <p>Total : {{ $etablissement->bachelier_total }}</p>
                        <p>Payés : {{ $etablissement->bachelier_paid }}</p>
                        <div class="progress-modern">
                           <div class="progress-fill" data-value="{{ $bacPercent }}"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row mt-5">
                  <div class="col-md-6">
                     <div class="chart-card">
                        <h5>Répartition des Revenus</h5>
                        <div class="chart-wrapper">
                           <canvas id="revChart_{{ $etablissement->id }}"></canvas>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="chart-card">
                        <h5>Répartition des Étudiants Payés</h5>
                        <div class="chart-wrapper">
                           <canvas id="stuChart_{{ $etablissement->id }}"></canvas>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
               new Chart(document.getElementById('revChart_{{ $etablissement->id }}'),{
               type:'doughnut',
               data:{
               labels:['Master','Licence (Accès S5)','Licence (Accès S1)'],
               datasets:[{
               data:[
               {{ $etablissement->master_revenue ?? 0 }},
               {{ $etablissement->passerelle_revenue ?? 0 }},
               {{ $etablissement->bachelier_revenue ?? 0 }}
               ],
               backgroundColor:['#2563eb','#fb923c','#10b981']
               }]
               },
               options:{cutout:'65%'}
               });
               
               new Chart(document.getElementById('stuChart_{{ $etablissement->id }}'),{
               type:'pie',
               data:{
               labels:['Master Payés','Licence (Accès S5) Payés','Licence (Accès S1) Payés'],
               datasets:[{
               data:[
               {{ $etablissement->master_paid ?? 0 }},
               {{ $etablissement->passerelle_paid ?? 0 }},
               {{ $etablissement->bachelier_paid ?? 0 }}
               ],
               backgroundColor:['#1e40af','#ea580c','#047857']
               }]
               }
               });
            </script>
         </div>
         @endforeach
      </div>
   </section>
</div>
<script>
    // Revenue Chart Global
    new Chart(document.getElementById('revChart_global'), {
        type: 'doughnut',
        data: {
            labels: ['Master', 'Licence (Accès S5)', 'Licence (Accès S1)'],
            datasets: [{
                data: [
                    {{ $totalMasterRevenue ?? 0 }},
                    {{ $totalPassRevenue ?? 0 }},
                    {{ $totalBacRevenue ?? 0 }}
                ],
                backgroundColor: ['#2563eb', '#fb923c', '#10b981']
            }]
        },
        options: { cutout: '65%' }
    });

    // Paid Students Chart Global
    new Chart(document.getElementById('stuChart_global'), {
        type: 'pie',
        data: {
            labels: ['Master Payés', 'Licence (Accès S5) Payés', 'Licence (Accès S1) Payés'],
            datasets: [{
                data: [
                    {{ $totalMasterPaid ?? 0 }},
                    {{ $totalPassPaid ?? 0 }},
                    {{ $totalBacPaid ?? 0 }}
                ],
                backgroundColor: ['#1e40af', '#ea580c', '#047857']
            }]
        }
    });
</script>
<script>
   $('.counter').each(function(){
   let el=$(this);
   let value=parseInt(el.text().replace(/\s/g,''))||0;
   
   $({n:0}).animate({n:value},{
   duration:2200,
   easing:"swing",
   step:function(){
   el.text(Math.floor(this.n).toLocaleString("fr-FR"));
   },
   complete:function(){
   el.text(value.toLocaleString("fr-FR")+" DH");
   }
   });
   });
   
   $('.progress-fill').each(function(){
   $(this).css('width',$(this).data('value')+'%');
   });
</script>
@endsection