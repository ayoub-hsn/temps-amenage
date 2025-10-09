@extends('admin-etab.layouts.master')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card shadow-lg rounded-lg border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                        <h4 class="mb-0">Actualité Details</h4>
                    </div>
                    <div class="card-body px-4 py-5">
                        <!-- Title -->
                        <h5 class="font-weight-bold text-primary mb-4" style="font-size: 1.75rem;color: #6777ef !important;">{{ $actualite->titre }}</h5>

                        <!-- Image -->
                        <div class="text-center mb-4">
                            <img src="{{ asset($actualite->image) }}" alt="Actualité Image" class="img-fluid rounded-lg shadow-lg" style="max-height: 500px; object-fit: cover;">
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <p class="text-muted" style="font-size: 1.1rem;">{!! $actualite->description !!}</p>
                        </div>

                        <!-- Date and Edit Button -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="text-muted" style="font-size: 1rem;">
                                    <i class="fas fa-calendar-alt"></i> Published on: <strong>{{ \Carbon\Carbon::parse($actualite->created_at)->format('d M Y') }}</strong>
                                </small>
                            </div>
                            @if($actualite->finished_at)
                                <div>
                                    <small class="text-muted" style="font-size: 1rem;">
                                        <i class="fas fa-calendar-check"></i> Finished on: <strong>{{ \Carbon\Carbon::parse($actualite->finished_at)->format('d M Y') }}</strong>
                                    </small>
                                </div>
                            @endif

                            <!-- Edit Button -->
                            <a href="{{ route('admin-etab.actualite.edit', $actualite->id) }}" class="btn btn-outline-success btn-sm px-4 py-2 rounded-pill" style="font-size: 1.1rem; transition: all 0.3s ease-in-out; border: 2px solid #28a745; font-weight: 600; padding-left: 20px; padding-right: 20px;">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
