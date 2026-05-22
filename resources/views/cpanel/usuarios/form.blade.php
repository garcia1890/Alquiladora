@extends('cpanel.app')

@section('content')

<style>

    body{
        background: #eef2f7;
        overflow-x: hidden;
    }

    .main-container{
        width: 100%;
        max-width: 100%;
        padding: 30px;
    }

    .card-custom{
        border: none;
        border-radius: 30px;
        overflow: hidden;
        background: white;
    }

    .card-header-custom{
        background: linear-gradient(135deg,#111827,#1f2937);
        color: white;
        padding: 35px;
        position: relative;
    }

    .close-btn{
        position: absolute;
        right: 25px;
        top: 20px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        font-size: 24px;
        transition: 0.3s;
    }

    .close-btn:hover{
        background: red;
        color: white;
        transform: scale(1.1);
    }

    .section-card{
        background: #ffffff;
        border-radius: 25px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 10px 25px rgba(0,0,0,.06);
    }

    .section-title{
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .form-label{
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select{
        border-radius: 18px !important;
        padding: 15px;
        border: 1px solid #d1d5db;
        transition: .3s;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus{
        border-color: #2563eb;
        box-shadow: 0 0 12px rgba(37,99,235,.2) !important;
    }

    .btn-custom{
        border-radius: 18px;
        padding: 14px 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-custom:hover{
        transform: translateY(-3px);
    }

    .alert-custom{
        border-radius: 18px;
        padding: 18px;
        font-weight: bold;
        text-align: center;
    }

</style>

<div class="main-container">

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success alert-custom shadow mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg card-custom">

        {{-- HEADER --}}
        <div class="card-header-custom text-center">

            {{-- BOTÓN X --}}
            <a href="{{ route('login') }}"
               class="close-btn">
                ✕
            </a>

            <h1 class="fw-bold mb-0">
                👤 Registro de Usuarios
            </h1>

        </div>

        <div class="card-body p-5">

            <form action="{{ route('usuarios.registro') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- DATOS PERSONALES --}}
                    <div class="col-xl-6 col-lg-12">

                        <div class="section-card">

                            <h3 class="section-title text-primary">
                                👤 Datos Personales
                            </h3>

                            <div class="row">

                                <div class="col-md-4 mb-4">
                                    <label class="form-label">
                                        Nombre(s)
                                    </label>

                                    <input type="text"
                                           name="Nombre"
                                           class="form-control"
                                           value="{{ old('Nombre') }}"
                                           pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                           title="Solo letras"
                                           oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ ]/g,'')"
                                           required>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="form-label">
                                        Apellido Paterno
                                    </label>

                                    <input type="text"
                                           name="Ape_pat"
                                           class="form-control"
                                           value="{{ old('Ape_pat') }}"
                                           pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                           title="Solo letras"
                                           oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ ]/g,'')"
                                           required>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="form-label">
                                        Apellido Materno
                                    </label>

                                    <input type="text"
                                           name="Ape_mat"
                                           class="form-control"
                                           value="{{ old('Ape_mat') }}"
                                           pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                           title="Solo letras"
                                           oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ ]/g,'')"
                                           required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Fecha de Registro
                                    </label>

                                    <input type="date"
                                           name="Fecha_registro"
                                           class="form-control"
                                           value="{{ date('Y-m-d') }}"
                                           min="{{ date('Y-m-d') }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Usuario
                                    </label>

                                    <input type="text"
                                           name="Nom_usuario"
                                           class="form-control"
                                           value="{{ old('Nom_usuario') }}"
                                           required>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- CONTACTO --}}
                    <div class="col-xl-6 col-lg-12">

                        <div class="section-card">

                            <h3 class="section-title text-success">
                                📞 Acceso y Contacto
                            </h3>

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Teléfono
                                    </label>

                                    <input type="text"
                                           name="Telefono"
                                           class="form-control"
                                           maxlength="10"
                                           pattern="[0-9]{10}"
                                           title="Solo números"
                                           value="{{ old('Telefono') }}"
                                           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                           required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Correo Electrónico
                                    </label>

                                    <input type="email"
                                           name="Email"
                                           class="form-control"
                                           value="{{ old('Email') }}"
                                           placeholder="ejemplo@correo.com"
                                           required>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label">
                                        Contraseña
                                    </label>

                                    <input type="password"
                                           name="Contrasena"
                                           class="form-control"
                                           minlength="6"
                                           maxlength="10"
                                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,10}$"
                                           title="Debe contener mayúsculas, minúsculas y un carácter especial"
                                           required>

                                    <small class="text-muted">
                                        6-10 caracteres, usando mayúsculas,
                                        minúsculas y símbolos.
                                    </small>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- DIRECCIÓN --}}
                    <div class="col-12">

                        <div class="section-card">

                            <h3 class="section-title text-danger">
                                📍 Dirección
                            </h3>

                            <div class="row">

                                <div class="col-lg-3 col-md-6 mb-4">
                                    <label class="form-label">
                                        Calle
                                    </label>

                                    <input type="text"
                                           name="Calle"
                                           class="form-control"
                                           value="{{ old('Calle') }}"
                                           required>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-4">
                                    <label class="form-label">
                                        Número
                                    </label>

                                    <input type="text"
                                           name="Numero"
                                           class="form-control"
                                           value="{{ old('Numero') }}"
                                           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                           required>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-4">
                                    <label class="form-label">
                                        Código Postal
                                    </label>

                                    <select id="CP"
                                            name="CP"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Selecciona
                                        </option>

                                        <option value="72000">72000</option>
                                        <option value="72160">72160</option>
                                        <option value="72410">72410</option>
                                        <option value="72580">72580</option>
                                        <option value="72760">72760</option>

                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-4">
                                    <label class="form-label">
                                        Municipio
                                    </label>

                                    <input type="text"
                                           id="Municipio"
                                           name="Municipio"
                                           class="form-control bg-light"
                                           readonly
                                           required>
                                </div>

                                <div class="col-lg-3 col-md-6 mb-4">
                                    <label class="form-label">
                                        Estado
                                    </label>

                                    <input type="text"
                                           id="Estado"
                                           name="Estado"
                                           class="form-control bg-light"
                                           readonly
                                           required>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="text-center mt-5">

                    <button type="submit"
                            class="btn btn-success btn-custom shadow">

                        💾 Guardar Usuario

                    </button>

                    <a href="{{ route('login') }}"
                       class="btn btn-danger btn-custom shadow ms-2">

                        ✖ Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

const cpData = {

    "72000": {
        municipio: "Puebla",
        estado: "Puebla"
    },

    "72160": {
        municipio: "Puebla",
        estado: "Puebla"
    },

    "72410": {
        municipio: "Puebla",
        estado: "Puebla"
    },

    "72580": {
        municipio: "Puebla",
        estado: "Puebla"
    },

    "72760": {
        municipio: "Cholula",
        estado: "Puebla"
    }

};

document.getElementById("CP")
.addEventListener("change", function () {

    let cp = this.value;

    if(cpData[cp]) {

        document.getElementById("Municipio").value =
            cpData[cp].municipio;

        document.getElementById("Estado").value =
            cpData[cp].estado;

    } else {

        document.getElementById("Municipio").value = "";
        document.getElementById("Estado").value = "";

    }

});

</script>

@endsection