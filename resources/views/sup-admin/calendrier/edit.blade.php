@extends('sup-admin.layouts.master')
@section('content')

<style>
    /* === Layout & Card Styling === */
    body {
        background: linear-gradient(135deg, #eef3f8 0%, #f7fbff 100%);
    }

    .calendar-wrapper {
        margin: 0 auto;
    }

    .calendar-card {
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.4s ease;
    }
    .calendar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .calendar-header {
        background: linear-gradient(90deg, #007bff, #00c6ff);
        color: #fff;
        padding: 25px 30px;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .calendar-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 20px;
    }
    .calendar-header a {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 10px;
        padding: 8px 18px;
        transition: all 0.3s ease;
    }
    .calendar-header a:hover {
        background: rgba(255, 255, 255, 0.35);
    }

    /* === Form Structure === */
    .calendar-section {
        background: #f9fbff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    .calendar-section:hover {
        background: #f1f7ff;
    }

    .calendar-section-title {
        font-weight: 700;
        font-size: 18px;
        color: #007bff;
        margin-bottom: 15px;
        border-left: 5px solid #007bff;
        padding-left: 10px;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #dcdcdc;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
    }

    /* === Buttons === */
    .calendar-btn {
        width: 100%;
        background: linear-gradient(90deg, #007bff, #00b3ff);
        border: none;
        border-radius: 12px;
        padding: 14px 0;
        font-weight: 600;
        font-size: 17px;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 6px 18px rgba(0, 123, 255, 0.3);
    }
    .calendar-btn:hover {
        background: linear-gradient(90deg, #0066e6, #0099ff);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.45);
    }

    .calendar-section .row {
        margin-top: 15px;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="calendar-wrapper">
            <div class="card calendar-card">
                
                {{-- HEADER --}}
                <div class="calendar-header">
                    <h4><i class="fas fa-calendar-alt"></i> Modifier un calendrier</h4>
                    <a href="{{ route('sup-admin.calendrier.index') }}">
                        <i class="fas fa-list"></i> Liste des calendriers
                    </a>
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <form action="{{ route('sup-admin.calendrier.update',['calendrier' => $calendrier->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        {{-- Établissement --}}
                        <div class="calendar-section">
                            <div class="calendar-section-title">Informations générales</div>
                            <div class="form-group">
                                <label for="etablissement_id">Établissement</label>
                                <select name="etablissement_id"
                                        class="form-control select2 {{ $errors->has('etablissement_id') ? 'is-invalid' : '' }}"
                                        id="etablissement_id">
                                    <option value="">Choisir un établissement</option>
                                    @foreach ($etablissements as $etablissement)
                                        <option value="{{ $etablissement->id }}"
                                            {{ (old('etablissement_id', $calendrier->etablissement_id) == $etablissement->id) ? 'selected' : '' }}>
                                            {{ $etablissement->nom }} ({{ $etablissement->nom_abrev }})
                                        </option>
                                    @endforeach
                                </select>

                                @if($errors->has('etablissement_id'))
                                    <div class="invalid-feedback">{{ $errors->first('etablissement_id') }}</div>
                                @endif
                            </div>
                        </div>

                        {{-- DATES: MASTER & LICENCE S5 --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="calendar-section">
                                    <div class="calendar-section-title">Master</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date d’ouverture</label>
                                                <input type="datetime-local" name="date_debut_master" value="{{ old('date_debut_master',$calendrier->date_debut_master) }}" class="form-control {{ $errors->has('date_debut_master') ? 'is-invalid' : '' }}">
                                                @if($errors->has('date_debut_master'))
                                                    <div class="invalid-feedback">{{ $errors->first('date_debut_master') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date de fermeture</label>
                                                <input type="datetime-local" name="date_fin_master" value="{{ old('date_fin_master',$calendrier->date_fin_master) }}" class="form-control {{ $errors->has('date_fin_master') ? 'is-invalid' : '' }}">
                                                @if($errors->has('date_fin_master'))
                                                    <div class="invalid-feedback">{{ $errors->first('date_fin_master') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="calendar-section">
                                    <div class="calendar-section-title">Licence (Accès S5)</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date d’ouverture</label>
                                                <input type="datetime-local" name="date_debut_passerelle" value="{{ old('date_debut_passerelle',$calendrier->date_debut_passerelle) }}" class="form-control {{ $errors->has('date_debut_passerelle') ? 'is-invalid' : '' }}">
                                                @if($errors->has('date_debut_passerelle'))
                                                    <div class="invalid-feedback">{{ $errors->first('date_debut_passerelle') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date de fermeture</label>
                                                <input type="datetime-local" name="date_fin_passerelle" value="{{ old('date_fin_passerelle',$calendrier->date_fin_passerelle) }}" class="form-control {{ $errors->has('date_fin_passerelle') ? 'is-invalid' : '' }}">
                                                @if($errors->has('date_fin_passerelle'))
                                                    <div class="invalid-feedback">{{ $errors->first('date_fin_passerelle') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LICENCE S1 --}}
                        <div class="calendar-section">
                            <div class="calendar-section-title">Licence (Accès S1)</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date d’ouverture</label>
                                        <input type="datetime-local" name="date_debut_bachelier" value="{{ old('date_debut_bachelier',$calendrier->date_debut_bachelier) }}" class="form-control {{ $errors->has('date_debut_bachelier') ? 'is-invalid' : '' }}">
                                        @if($errors->has('date_debut_bachelier'))
                                            <div class="invalid-feedback">{{ $errors->first('date_debut_bachelier') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date de fermeture</label>
                                        <input type="datetime-local" name="date_fin_bachelier" value="{{ old('date_fin_bachelier',$calendrier->date_fin_bachelier) }}" class="form-control {{ $errors->has('date_fin_bachelier') ? 'is-invalid' : '' }}">
                                        @if($errors->has('date_fin_bachelier'))
                                            <div class="invalid-feedback">{{ $errors->first('date_fin_bachelier') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="mt-5 mb-3">
                            <button class="btn calendar-btn w-100 py-3">Modifier le calendrier</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
