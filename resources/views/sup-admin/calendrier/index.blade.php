@extends('sup-admin.layouts.master')

@section('content')

@php
use Carbon\Carbon;
@endphp

<style>
    body {
        background: linear-gradient(135deg, #e0f7ff, #ffffff);
        font-family: 'Poppins', sans-serif;
    }

    .etablissement-card {
        border-radius: 25px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        overflow: hidden;
        transition: all 0.5s ease;
    }

    .etablissement-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .etablissement-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 25px;
        background: linear-gradient(145deg, #ffffff, #d4e9ff);
        border-bottom: 1px solid #d0d0d0;
    }

    .etablissement-left {
        display: flex;
        align-items: center;
    }

    .etablissement-logo-wrapper {
        position: relative;
        margin-right: 18px;
    }

    .etablissement-logo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #00b3ff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .etablissement-logo-wrapper::after {
        content: '';
        position: absolute;
        top: -10px;
        left: -10px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: linear-gradient(45deg, #00c6ff, #007bff);
        filter: blur(18px);
        opacity: 0.25;
        z-index: -1;
        animation: pulse 4s infinite alternate;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity:0.25; }
        100% { transform: scale(1.05); opacity:0.4; }
    }

    .etablissement-logo:hover {
        transform: scale(1.08) rotate(-3deg);
    }

    .etablissement-info h5 {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #007bff;
    }

    .etablissement-info span {
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-top: 4px;
    }

    /* Modifier Button */
    .btn-edit {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 25px;
        padding: 7px 18px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }

    .program-card {
        background: linear-gradient(135deg, #f7fbff, #ffffff);
        border-radius: 15px;
        padding: 14px 18px;
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        flex-wrap: wrap;
    }

    .program-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .program-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .program-left i {
        font-size: 24px;
        color: #00b3ff;
    }

    .program-left span {
        font-size: 15px;
        font-weight: 600;
        color: #333;
    }

    .program-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        width: 100%;
        margin-top: 10px;
    }

    .progress {
        width: 100%;
        height: 10px;
        border-radius: 6px;
        background: #e0e0e0;
        overflow: hidden;
        margin-top: 5px;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        border-radius: 6px;
        background: linear-gradient(90deg, #00b3ff, #0066cc);
        transition: width 0.8s ease;
    }

    .progress-label {
        font-size: 12px;
        color: #333;
        font-weight: 500;
        margin-top: 3px;
    }

    .alert-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        display: inline-block;
        margin-top: 5px;
        text-transform: uppercase;
    }

    .alert-soon { background: #f39c12; color: white; animation: pulseBadge 1.3s infinite alternate; }
    .alert-passed { background: #e74c3c; color: white; }
    .alert-ok { background: #2ecc71; color: white; }

    @keyframes pulseBadge {
        0% { transform: scale(1); }
        100% { transform: scale(1.08); }
    }

    .empty-message {
        text-align: center;
        padding: 40px 0;
        font-size: 15px;
        color: #555;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card shadow-lg">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-calendar-alt"></i> Liste des calendriers</h4>
                        <a href="{{ route('sup-admin.calendrier.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Ajouter un calendrier
                        </a>
                    </div>

                    <div class="card-body">
                        @if($calendriers->isEmpty())
                            <div class="empty-message">
                                <i class="fas fa-info-circle fa-2x mb-3 text-primary"></i><br>
                                Aucun calendrier n’a encore été ajouté.
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($calendriers as $calendrier)
                                    @php
                                        $today = Carbon::now();
                                        $programs = [
                                            'Master' => ['start' => $calendrier->date_debut_master, 'end' => $calendrier->date_fin_master, 'icon' => 'fas fa-user-graduate'],
                                            'Passerelle' => ['start' => $calendrier->date_debut_passerelle, 'end' => $calendrier->date_fin_passerelle, 'icon' => 'fas fa-exchange-alt'],
                                            'Bachelier' => ['start' => $calendrier->date_debut_bachelier, 'end' => $calendrier->date_fin_bachelier, 'icon' => 'fas fa-school'],
                                        ];
                                    @endphp

                                    <div class="col-md-6">
                                        <div class="etablissement-card">
                                            <div class="etablissement-header">
                                                <div class="etablissement-left">
                                                    <div class="etablissement-logo-wrapper">
                                                        <img src="{{ asset($calendrier->etablissement->logo) }}" class="etablissement-logo" alt="{{ $calendrier->etablissement->nom_abrev }}">
                                                    </div>
                                                    <div class="etablissement-info">
                                                        <h5>{{ $calendrier->etablissement->nom }}</h5>
                                                        <span>({{ $calendrier->etablissement->nom_abrev }})</span>
                                                    </div>
                                                </div>

                                                <a href="{{ route('sup-admin.calendrier.edit', $calendrier->id) }}" class="btn btn-edit">
                                                    <i class="fas fa-edit me-1"></i> Modifier
                                                </a>
                                            </div>

                                            <div class="calendrier-section p-3">
                                                @foreach($programs as $name => $data)
                                                    @php
                                                        $startDate = Carbon::parse($data['start']);
                                                        $endDate = Carbon::parse($data['end']);
                                                        $diffTotal = $startDate->diffInSeconds($endDate);
                                                        $diffRemaining = max(0, $today->diffInSeconds($endDate, false));
                                                        $progressPercent = $diffTotal > 0 ? (($diffTotal - $diffRemaining) / $diffTotal) * 100 : 100;
                                                        $diff = $today->diff($endDate);
                                                        $alertClass = '';
                                                        $alertText = '';

                                                        if($today->greaterThan($endDate)) {
                                                            $alertClass = 'alert-passed';
                                                            $alertText = "Fermeture passée";
                                                        } elseif($diff->d < 1) {
                                                            $alertClass = 'alert-soon countdown';
                                                            $alertText = "Fermeture dans <span data-endtime='".$endDate->timestamp."'></span>";
                                                        } elseif($diff->d <= 3) {
                                                            $alertClass = 'alert-soon';
                                                            $alertText = "Fermeture dans {$diff->d} jours";
                                                        } else {
                                                            $alertClass = 'alert-ok';
                                                            $alertText = "{$diff->d} jours restants";
                                                        }
                                                    @endphp

                                                    <div class="program-card">
                                                        <div class="program-left">
                                                            <i class="{{ $data['icon'] }}"></i>
                                                            <span>{{ $name }}</span>
                                                        </div>
                                                        <div class="program-right">
                                                            <div>
                                                                <small><b>Début:</b> {{ $startDate->format('d/m/Y H:i') }}</small><br>
                                                                <small><b>Fin:</b> {{ $endDate->format('d/m/Y H:i') }}</small>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div class="progress-bar" style="width: {{ $progressPercent }}%"></div>
                                                            </div>
                                                            <span class="progress-label">{{ number_format($progressPercent, 1) }}%</span>
                                                            <span class="alert-badge {{ $alertClass }}">{!! $alertText !!}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCountdown() {
        $('.countdown span').each(function() {
            var endTimestamp = $(this).data('endtime') * 1000;
            var now = new Date().getTime();
            var distance = endTimestamp - now;

            if(distance <= 0){
                $(this).parent().text('Fermeture passée');
                $(this).parent().removeClass('alert-soon').addClass('alert-passed');
            } else {
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000*60*60));
                var minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
                var seconds = Math.floor((distance % (1000*60)) / 1000);
                $(this).text(hours + 'h ' + minutes + 'm ' + seconds + 's');
            }
        });
    }

    $(document).ready(function(){
        updateCountdown(); 
        setInterval(updateCountdown, 1000);
    });
</script>

@endsection
