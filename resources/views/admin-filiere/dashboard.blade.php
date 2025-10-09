@extends('admin-filiere.layouts.master')
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
                    @php
                        $colorMaster = 'col-red';

                        if ($percentageIncreaseMaster >= 10) {
                            $colorMaster = 'col-green';
                        } elseif ($percentageIncreaseMaster >= 1) {
                            $colorMaster = 'col-orange';
                        }
                    @endphp
                    <div class="card-content">
                      <h5 class="font-15">Master - Candidatures</h5>
                      <h2 class="mb-3 font-18">{{ $studentsMasterCount }}</h2>
                      <p class="mb-0"><span class="{{ $colorMaster }}">{{ $percentageIncreaseMaster }}%</span> Increase</p>
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
                  @php
                      $colorPasserelle = 'col-red';

                      if ($percentageIncreasePasserelle >= 10) {
                          $colorPasserelle = 'col-green';
                      } elseif ($percentageIncreasePasserelle >= 1) {
                          $colorPasserelle = 'col-orange';
                      }
                  @endphp
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Licence - Candidatures</h5>
                      <h2 class="mb-3 font-18">{{ $studentsPasserelleCount }}</h2>
                      <p class="mb-0"><span class="{{ $colorPasserelle }}">{{ $percentageIncreasePasserelle }}%</span> Increase</p>
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
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Filieres - Master</h5>
                      <h2 class="mb-3 font-18">{{ $filiereMasterCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">18%</span>
                        Increase</p>
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
                      <h5 class="font-15">Filieres - Licence</h5>
                      <h2 class="mb-3 font-18">{{ $filierePasserelleCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">42%</span> Increase</p>
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
      </div>
      <div class="row">
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
              <h4 class="mb-0">Licence</h4>
            </div>
            <div class="card-body">
              <canvas id="filiereChartPasserelle" height="450"></canvas>
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

        // Render Licence Chart
        createChart(
            'filiereChartPasserelle',
            @json($statsPasserelle->pluck('nom_complet')),
            @json($statsPasserelle->pluck('postulants_count')),
            "Candidatures Licences d'excellence",
            '#388e3c',
            '#66bb6a'
        );
    });
  </script>
@endsection
