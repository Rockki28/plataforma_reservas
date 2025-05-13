<?php

namespace App\Http\Controllers;
use App\Models\Libro; // Asegúrate de importar el modelo Libro
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Asegúrate de importar la clase Storage

class LibroController extends Controller
{
    //
    public function index()
    {
        $libros = Libro::paginate(2); // Obtener todos los libros de la base de datos
        return view('libro.index', compact('libros')); // Entramos a la vista de libros
    }

    public function catalogo(){
        $libros=Libro::all(); // Obtener todos los libros de la base de datos
        return view('inicio', compact('libros')); // Entramos a la vista de catalogo
    }

    public function create()
    {
        return view('libro.create'); // Entramos a la vista de crear libros
    }

    public function store(Request $request)
    {

        $campos=[
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ];
        $mensaje=[
            'required' => 'El :attribute es requerido',
            'imagen.required' => 'La imagen es requerida',
            'archivo.required' => 'El archivo es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'imagen.image' => 'El archivo debe ser una imagen',
            'archivo.file' => 'El archivo debe ser un documento',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif',
            'archivo.mimes' => 'El archivo debe ser de tipo pdf, doc o docx',
            'imagen.max' => 'La imagen no puede exceder los 2MB',
            'archivo.max' => 'El archivo no puede exceder los 2MB',
        ];
        $this->validate($request, $campos, $mensaje); // Validando los campos del formulario
        $datos = request()->all(); //recolectando toda la informacion que nos estan enviando del metodo post

        $nombre = $request->nombre;

        $imagenRuta= $request->file('imagen')->store('imagenes', 'public'); // Guardando la imagen en el disco público
        $archivoRuta= $request->file('archivo')->store('archivos', 'public'); // Guardando el archivo en el disco público
        
        
        /*$_imagen = $imagen->getClientOriginalName(); // Obteniendo el nombre original de la imagen
        $_archivo = $archivo->getClientOriginalName(); // Obteniendo el nombre original del archivo*/

        $libro = new Libro();
        $libro->nombre = $nombre; // Asignando el nombre del libro
        $libro->imagen = basename($imagenRuta); // Asignando el nombre de la imagen
        $libro->archivo = basename($archivoRuta); // Asignando el nombre del archivo
        $libro->save(); // Guardando el libro en la base de datos
         // Devuelve los datos recibidos como respuesta JSON
        // Aquí puedes manejar la lógica para almacenar el libro en la base de datos
        // Por ejemplo, usando un modelo Libro:
        // $libro = new Libro();
        // $libro->titulo = $request->input('titulo');
        // $libro->autor = $request->input('autor');
        // $libro->save();

        return redirect()->route('libros.index'); // Redirige a la lista de libros después de guardar
    }
    public function show(Libro $libro)
    {
        // Aquí puedes manejar la lógica para mostrar un libro específico
        return view('libro.show', compact('libro')); // Muestra la vista del libro
    }
    public function edit(Libro $libro)
    
    {
        // Aquí puedes manejar la lógica para editar un libro específico
        return view('libro.edit', compact('libro')); // Muestra la vista de edición del libro
    }
    public function update(Request $request, Libro $libro)
    {
        $libro->nombre = $request->nombre; // Actualiza el nombre del libro
        
        if ($request->hasFile('imagen')) {
            // Si se subió una nueva imagen, elimina la anterior
            if (Storage::disk('public')->exists('imagenes/'.$libro->imagen)) {
                Storage::disk('public')->delete('imagenes/'.$libro->imagen);
            }

            $imagenRuta = $request->file('imagen')->store('imagenes', 'public'); // Guardando la nueva imagen en el disco público
            $libro->imagen = basename($imagenRuta); // Asignando el nuevo nombre de la imagen
        }

        if ($request->hasFile('archivo')) {
            // Si se subió un nuevo archivo, elimina el anterior
            if (Storage::disk('public')->exists('archivos/'.$libro->archivo)) {
                Storage::disk('public')->delete('archivos/'.$libro->archivo);
            }

            $archivoRuta = $request->file('archivo')->store('archivos', 'public'); // Guardando el nuevo archivo en el disco público
            $libro->archivo = basename($archivoRuta); // Asignando el nuevo nombre del archivo
        }


        $libro->save();
        // Aquí puedes manejar la lógica para actualizar un libro específico
        return redirect()->route('libros.index'); // Redirige a la lista de libros después de actualizar
    }
    public function destroy(Libro $libro)
    {

        if(Storage::disk('public')->exists('imagenes/'.$libro->imagen)){
            Storage::disk('public')->delete('imagenes/'.$libro->imagen); // Elimina la imagen del disco público
        }
        if(Storage::disk('public')->exists('archivos/'.$libro->archivo)){
            Storage::disk('public')->delete('archivos/'.$libro->archivo); // Elimina el archivo del disco público
        }
        $libro->delete(); // Elimina el libro de la base de datos
        // Aquí puedes manejar la lógica para eliminar un libro específico
        return redirect()->route('libros.index'); // Redirige a la lista de libros después de eliminar
    }   
    
}
