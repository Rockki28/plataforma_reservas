@extends('layouts.frontend') {{-- Asegúrate que este layout cargue Bootstrap 5 --}}

@section('title', 'Bienvenido a Sabor Élite - Una Experiencia Culinaria Única')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> {{-- Para iconos --}}
<style>
    /* --- Hero Section --- */
    .hero-section {
        position: relative;
        height: 90vh; /* Altura del viewport */
        min-height: 600px;
        background: url('/storage/imagenes/lolo.jpg') no-repeat center center; /* Placeholder - reemplaza con tu imagen */
        background-size: cover;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .hero-section::before { /* Overlay para mejorar contraste */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* Overlay oscuro semitransparente */
    }
    .hero-content {
        position: relative; /* Para que esté sobre el overlay */
        z-index: 1;
        animation: fadeInHero 1.5s ease-out;
    }
    .hero-content h1 {
        font-size: 3rem; /* Tamaño base */
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }
    .hero-content p {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    }
    .hero-content .btn-primary {
        font-size: 1.2rem;
        padding: 0.8rem 2rem;
        border-radius: 50px; /* Botón más redondeado */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hero-content .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    @keyframes fadeInHero {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- General Section Styling --- */
    .section-padding {
        padding: 80px 0;
    }
    .section-title {
        text-align: center;
        margin-bottom: 60px;
        font-size: 2.5rem;
        font-weight: 600;
        position: relative;
    }
    .section-title::after { /* Pequeño subrayado decorativo */
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background-color: var(--bs-primary); /* Color primario de Bootstrap */
        margin: 10px auto 0;
        border-radius: 2px;
    }

    /* --- Menú Destacado --- */
    .menu-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none; /* Quitar borde por defecto de Bootstrap */
        border-radius: 15px; /* Bordes más suaves */
        overflow: hidden; /* Para que la imagen no se salga con el borde redondeado */
    }
    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .menu-card img {
        height: 250px;
        object-fit: cover;
    }
    .menu-card .card-title {
        color: var(--bs-primary);
    }

    /* --- Galería --- */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 1.5rem; /* Espacio entre items en móviles */
    }
    .gallery-item img {
        transition: transform 0.5s ease;
        width: 100%;
        height: 280px; /* Altura fija para consistencia */
        object-fit: cover; /* Asegura que la imagen cubra el espacio sin distorsión */
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .gallery-item .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    .gallery-item:hover .overlay {
        opacity: 1;
    }

    /* --- Contacto --- */
    .contact-section {
        background-color: #f8f9fa; /* Un gris claro de fondo */
    }
    .contact-info-item {
        text-align: center;
        margin-bottom: 30px;
    }
    .contact-info-item i {
        font-size: 2.5rem;
        color: var(--bs-primary);
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }
    .contact-info-item:hover i {
        transform: scale(1.2);
    }
    .map-placeholder { /* Placeholder para el mapa */
        height: 400px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-style: italic;
        color: #6c757d;
    }

    /* --- Responsive Adjustments --- */
    @media (max-width: 768px) {
        .hero-section {
            height: 70vh;
            min-height: 500px;
        }
        .hero-content h1 {
            font-size: 2.2rem;
        }
        .hero-content p {
            font-size: 1.2rem;
        }
        .section-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')

<section class="hero-section">
    <div class="hero-content container">
        <h1 class="mb-4 display-3">Sabor Élite</h1>
        <p class="lead mb-5">Donde cada plato cuenta una historia de pasión y tradición.</p>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-lg">Reservar Mesa Ahora</a>
    </div>
</section>

<section id="about-us" class="section-padding">
    <div class="container">
        <h2 class="section-title">Nuestra Esencia</h2>
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="/imagenes/loco.png" alt="Interior del Restaurante Sabor Élite" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h3>Más que Comida, Creamos Recuerdos</h3>
                <p class="lead text-muted">En Sabor Élite, nos dedicamos a ofrecer una experiencia culinaria inolvidable. Desde ingredientes frescos de origen local hasta un servicio impecable, cada detalle está cuidadosamente seleccionado para tu disfrute.</p>
                <p class="text-muted">Nuestro chef, con años de experiencia internacional, fusiona técnicas clásicas con toques innovadores, resultando en platos que deleitan tanto al paladar como a la vista. Te invitamos a descubrir un oasis de sabor en el corazón de la ciudad.</p>
                <a href="#" class="btn btn-outline-primary mt-3">Conoce Nuestra Historia</a>
            </div>
        </div>
    </div>
</section>

<section id="menu-destacado" class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title">Delicias de Nuestro Menú</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card menu-card shadow-sm">
                    <img src="/images/dish1.jpg" class="card-img-top" alt="Plato Destacado 1"> {{-- Placeholder --}}
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Solomillo de la Pasión</h5>
                        <p class="card-text text-muted">Tierno solomillo cocinado a la perfección, acompañado de una reducción de vino tinto y hierbas aromáticas.</p>
                        <p class="fw-bold fs-5 text-primary">$28.50</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card menu-card shadow-sm">
                    <img src="/images/dish2.jpg" class="card-img-top" alt="Plato Destacado 2"> {{-- Placeholder --}}
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Risotto del Mar Encantado</h5>
                        <p class="card-text text-muted">Cremoso risotto con frutos del mar frescos, un toque de azafrán y parmesano Reggiano.</p>
                         <p class="fw-bold fs-5 text-primary">$24.00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card menu-card shadow-sm">
                    <img src="/images/dish3.jpg" class="card-img-top" alt="Plato Destacado 3"> {{-- Placeholder --}}
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Sinfonía de Chocolate</h5>
                        <p class="card-text text-muted">Un postre decadente con texturas de chocolate belga, mousse y coulis de frutos rojos.</p>
                         <p class="fw-bold fs-5 text-primary">$12.75</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary btn-lg">Ver Menú Completo</a>
        </div>
    </div>
</section>

<section id="gallery" class="section-padding">
    <div class="container">
        <h2 class="section-title">Un Vistazo a Sabor Élite</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery1.jpg" class="img-fluid" alt="Galería Restaurante 1"> {{-- Placeholder --}}
                    <div class="overlay"><span>Ambiente Acogedor</span></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery2.jpg" class="img-fluid" alt="Galería Restaurante 2"> {{-- Placeholder --}}
                    <div class="overlay"><span>Platos Exquisitos</span></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery3.jpg" class="img-fluid" alt="Galería Restaurante 3"> {{-- Placeholder --}}
                    <div class="overlay"><span>Detalles Únicos</span></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery4.jpg" class="img-fluid" alt="Galería Restaurante 4"> {{-- Placeholder --}}
                    <div class="overlay"><span>Noches Mágicas</span></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery5.jpg" class="img-fluid" alt="Galería Restaurante 5"> {{-- Placeholder --}}
                    <div class="overlay"><span>Ingredientes Frescos</span></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    <img src="/images/gallery6.jpg" class="img-fluid" alt="Galería Restaurante 6"> {{-- Placeholder --}}
                    <div class="overlay"><span>Sonrisas y Servicio</span></div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="contact-section" class="section-padding contact-section">
    <div class="container">
        <h2 class="section-title">Visítanos o Contáctanos</h2>
        <div class="row mt-5">
            <div class="col-lg-4 contact-info-item">
                <i class="fas fa-map-marked-alt"></i>
                <h4 class="text-uppercase">Dirección</h4>
                <p>Av. Siempreviva 742, Ciudad Gourmet<br>País Delicioso, CP 12345</p>
            </div>
            <div class="col-lg-4 contact-info-item">
                <i class="fas fa-phone-alt"></i>
                <h4 class="text-uppercase">Reservas Telefónicas</h4>
                <p><a href="tel:+1234567890" class="text-decoration-none text-dark">+1 (23) 456-7890</a><br>Lunes a Domingo, 12pm - 10pm</p>
            </div>
            <div class="col-lg-4 contact-info-item">
                <i class="fas fa-envelope"></i>
                <h4 class="text-uppercase">Correo Electrónico</h4>
                <p><a href="mailto:reservas@saborelite.com" class="text-decoration-none text-dark">reservas@saborelite.com</a><br>Consultas y eventos especiales</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-placeholder">
                    <p>Aquí iría un mapa integrado de Google Maps o similar.</p>
                    {{-- Ejemplo de cómo podrías embeder un iframe de Google Maps --}}
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5211620591224!2d-75.59139138573707!3d6.200967995509953!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e44298cf0a0a983%3A0x4254a6c0935f695f!2sRestaurante%20Ejemplo!5e0!3m2!1ses!2sco!4v1620000000000!5m2!1ses!2sco" width="100%" height="400" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe> --}}
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
             <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-lg">Haz tu Reserva Online</a>
        </div>
    </div>
</section>

@endsection

{{-- No necesitas @push('scripts') si todo el JS de Bootstrap ya está en el layout --}}