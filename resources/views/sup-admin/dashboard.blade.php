@extends('sup-admin.layouts.master')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="row ">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Filiere - Master</h5>
                      <h2 class="mb-3 font-18">{{ $FilieresMasterCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">10%</span> Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/master.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15"> Licence</h5>
                      <h2 class="mb-3 font-18">{{ $filieresPasserelleCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-orange">09%</span> Decrease</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/bachelor.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Master - Candidats</h5>
                      <h2 class="mb-3 font-18">{{ $filieresMasterCandidatCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">18%</span>
                        Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                       <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/1.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Licence - Candidats</h5>
                      <h2 class="mb-3 font-18">{{ $filieresPasserelleCandidatCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">42%</span> Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/group-passerelle.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
  <div class="col-12">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-gradient-primary text-white">
        <h4 class="mb-0">Répartition des Candidats par Établissement</h4>
      </div>
      <div class="card-body bg-light">
        <div style="height: 500px;">
          <canvas id="beautifulChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>



    </section>
    <div class="settingSidebar">
      <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
      </a>
      <div class="settingSidebar-body ps-container ps-theme-default">
        <div class=" fade show active">
          <div class="setting-panel-header">Setting Panel
          </div>
          <div class="p-15 border-bottom">
            <h6 class="font-medium m-b-10">Select Layout</h6>
            <div class="selectgroup layout-color w-50">
              <label class="selectgroup-item">
                <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                <span class="selectgroup-button">Light</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                <span class="selectgroup-button">Dark</span>
              </label>
            </div>
          </div>
          <div class="p-15 border-bottom">
            <h6 class="font-medium m-b-10">Sidebar Color</h6>
            <div class="selectgroup selectgroup-pills sidebar-color">
              <label class="selectgroup-item">
                <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                  data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                  data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
              </label>
            </div>
          </div>
          <div class="p-15 border-bottom">
            <h6 class="font-medium m-b-10">Color Theme</h6>
            <div class="theme-setting-options">
              <ul class="choose-theme list-unstyled mb-0">
                <li title="white" class="active">
                  <div class="white"></div>
                </li>
                <li title="cyan">
                  <div class="cyan"></div>
                </li>
                <li title="black">
                  <div class="black"></div>
                </li>
                <li title="purple">
                  <div class="purple"></div>
                </li>
                <li title="orange">
                  <div class="orange"></div>
                </li>
                <li title="green">
                  <div class="green"></div>
                </li>
                <li title="red">
                  <div class="red"></div>
                </li>
              </ul>
            </div>
          </div>
          <div class="p-15 border-bottom">
            <div class="theme-setting-options">
              <label class="m-b-0">
                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                  id="mini_sidebar_setting">
                <span class="custom-switch-indicator"></span>
                <span class="control-label p-l-10">Mini Sidebar</span>
              </label>
            </div>
          </div>
          <div class="p-15 border-bottom">
            <div class="theme-setting-options">
              <label class="m-b-0">
                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                  id="sticky_header_setting">
                <span class="custom-switch-indicator"></span>
                <span class="control-label p-l-10">Sticky Header</span>
              </label>
            </div>
          </div>
          <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
            <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
              <i class="fas fa-undo"></i> Restore Default
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('beautifulChart').getContext('2d');

    // Create gradient colors
    const gradientMaster = ctx.createLinearGradient(0, 0, 0, 400);
    gradientMaster.addColorStop(0, 'rgba(54, 162, 235, 0.9)');
    gradientMaster.addColorStop(1, 'rgba(54, 162, 235, 0.2)');

    const gradientPasserelle = ctx.createLinearGradient(0, 0, 0, 400);
    gradientPasserelle.addColorStop(0, 'rgba(255, 99, 132, 0.9)');
    gradientPasserelle.addColorStop(1, 'rgba(255, 99, 132, 0.2)');

    const chart = new Chart(ctx, {
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
                    label: 'Licences',
                    data: @json($dataPasserelle),
                    backgroundColor: gradientPasserelle,
                    borderRadius: 10,
                    barThickness: 30
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#000',
                    borderColor: '#ddd',
                    borderWidth: 1,
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#555',
                        font: {
                            size: 13
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#555',
                        font: {
                            size: 13
                        }
                    },
                    grid: {
                        borderDash: [5, 5],
                        color: '#ccc'
                    }
                }
            }
        }
    });
</script>
@endsection
