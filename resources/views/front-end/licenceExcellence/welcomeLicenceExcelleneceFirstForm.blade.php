@extends('front-end.layouts.master',['etablissement' => $etablissement])

@section('content')
<div class="application-container">
    <div class="application-header">
        <h1 class="application-title">Postuler au Licence</h1>
        <p class="application-subtitle">Merci de remplir le formulaire ci-dessous pour postuler au programme de Licence.</p>
    </div>
    @if (Session::has('error_student_exist'))
        <div class="alert alert-danger">{{ Session::get('error_student_exist') }}</div>
    @endif
    <form action="{{ route('welcomeLicenceExcelllence.apply',['etablissement' => $etablissement->id]) }}" method="POST" class="application-form">
        @csrf
        <div class="form-group">
            <label for="cne" class="form-label">CNE <span class="required">*</span></label>
            <input type="text" id="cne" name="cne" class="form-input {{ $errors->has('cne') ? 'is-invalid' : '' }}" placeholder="Entrez votre CNE">
            @if($errors->has('cne'))
                <div class="invalid-feedback">
                    {{ $errors->first('cne') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="cin" class="form-label">CIN <span class="required">*</span></label>
            <input type="text" id="cin" name="cin" class="form-input {{ $errors->has('cin') ? 'is-invalid' : '' }}" placeholder="Entrez votre CIN">
            @if($errors->has('cin'))
                <div class="invalid-feedback">
                    {{ $errors->first('cin') }}
                </div>
            @endif
        </div>
        <div class="form-actions">
            <button type="submit" class="submit-button">Soumettre</button>
        </div>
    </form>
</div>

<style>
    body {
        font-family: "Lato", sans-serif;
        background-color: #f4f7fb;
        margin: 0;
        line-height: 1.6;
    }

    /* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    margin: 0;
    padding: 0;
    color: #333;
}

/* Alert Styling */
.alert {
    padding: 1.5rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    text-align: center;
    font-size: 1rem;
    font-weight: 700;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.8s ease-out;
    transition: all 0.3s ease-in-out;
}

.alert-danger {
    background: rgba(255, 77, 79, 0.2);
    border: 1px solid rgba(255, 77, 79, 0.4);
    color: #ff4d4f;
    box-shadow: 0 8px 20px rgba(255, 77, 79, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.alert-danger i {
    font-size: 1.5rem;
    color: #ff4d4f;
    transition: transform 0.3s ease-in-out;
}

.alert-danger:hover i {
    transform: rotate(20deg);
}

/* Validation Feedback */
.invalid-feedback {
    color: #ff4d4f;
    font-size: 0.9rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    transition: color 0.3s ease-in-out;
}

.invalid-feedback i {
    font-size: 1.2rem;
    color: #ff4d4f;
}

/* Form Input with Error */
.form-input.is-invalid {
    border: 2px solid #ff4d4f;
    background: rgba(255, 77, 79, 0.1);
    box-shadow: 0 6px 20px rgba(255, 77, 79, 0.3);
    transition: all 0.3s ease-in-out;
}

.form-input.is-invalid:focus {
    border-color: #ff4d4f;
    box-shadow: 0 8px 25px rgba(255, 77, 79, 0.4);
}

/* Application Container */
.application-container {
    max-width: 900px;
    margin: 4rem auto;
    background: rgba(255, 255, 255, 0.7);
    padding: 3.5rem;
    border-radius: 25px;
    backdrop-filter: blur(20px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    animation: fadeIn 1s ease-out;
    transition: all 0.3s ease-in-out;
}

.application-container:hover {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

/* Button Styling */
.submit-button {
    padding: 1rem 2.5rem;
    font-size: 1.2rem;
    font-weight: bold;
    color: #ffffff;
    background: linear-gradient(135deg, #36d1dc, #5b86e5);
    border: none;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 10px 30px rgba(91, 134, 229, 0.4);
}

.submit-button:hover {
    background: linear-gradient(135deg, #5b86e5, #36d1dc);
    transform: translateY(-3px);
    box-shadow: 0 15px 50px rgba(91, 134, 229, 0.6);
}

.submit-button:active {
    transform: scale(0.98);
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .application-container {
        padding: 2rem;
    }

    .alert {
        font-size: 0.95rem;
        padding: 1.2rem 1.5rem;
    }

    .submit-button {
        font-size: 1rem;
        padding: 0.9rem 2rem;
    }
}


    .application-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .application-title {
        font-size: 2.4rem;
        font-weight: 700;
        color: #0073e6;
        margin-bottom: 0.8rem;
    }

    .application-subtitle {
        font-size: 1.1rem;
        color: #555;
        font-weight: 400;
    }

    .application-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .required {
        color: #ff4d4f;
    }

    .form-input {
        padding: 0.95rem 1.25rem;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        background-color: #f8f9fa;
        color: #333;
    }

    .form-input:focus {
        outline: none;
        border-color: #00c4b5;
        box-shadow: 0 4px 12px rgba(0, 196, 181, 0.2);
        background-color: #ffffff;
    }

    .form-actions {
        text-align: center;
    }

    .submit-button {
        width: 100%;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #00c4b5, #0073e6);
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.3s ease;
    }

    .submit-button:hover {
        background: linear-gradient(135deg, #0073e6, #00c4b5);
        transform: translateY(-4px);
    }

    .submit-button:active {
        transform: scale(0.98);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .application-container {
            padding: 2rem;
        }

        .application-title {
            font-size: 1.8rem;
        }

        .form-input {
            font-size: 0.95rem;
        }

        .submit-button {
            font-size: 1rem;
        }
    }
</style>
@endsection
