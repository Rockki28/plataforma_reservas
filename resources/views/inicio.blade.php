@extends('layouts.website')

@section('content')

<div class="container mt-4">

    <div class="row g-3">

        @foreach ($libros as $libro)
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{$libro->nombre}}</div>
                    <div class="card-body">
            
                        <img width="300" src="{{ asset('storage/imagenes/' . $libro->imagen) }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 200px;">
            
                    </div>
                <div class="card-footer text-muted">
                    <a class="btn btn-success" href="{{ asset('storage/archivos/' . $libro->archivo) }}"><i class="fa fa-book"></i>Ver Carta</a>
                </div>
            </div>
        </div>
        
        @endforeach

    </div>



</div>






@endsection