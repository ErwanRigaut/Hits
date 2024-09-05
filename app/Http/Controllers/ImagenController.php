<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage; // Importa el facade Storage
class ImagenController extends Controller
{


    public function index(){
        $canciones = Imagen::where('active', 1)->paginate(2);

    
    return view('imagen.index', ['canciones' => $canciones ]);
    }

    public function show(){
        if (Auth::check()) {
            $userId = Auth::user()->id;
            // Puedes realizar más acciones aquí si es necesario
            $canciones = Imagen::where('user_id', $userId)->paginate(2);
            // Redirigir a otra ruta o a una vista con mensaje de éxito
            return view('imagen.show', ['canciones' => $canciones])
            ->with('success', 'Se ha identificado todas las imagenes');
        
        
        } else {
            // Redirigir a la ruta de inicio de sesión o una página diferente con mensaje de error
            return redirect()->route('login')->with('error', 'Usuario no identificado.');
        }
    }

    public function crear()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            // Puedes realizar más acciones aquí si es necesario

            // Redirigir a otra ruta o a una vista con mensaje de éxito
            return view('imagen.create', ['userId' => $userId])
            ->with('success', 'Se ha identificado al usuario Logeado');
        
        
        } else {
            // Redirigir a la ruta de inicio de sesión o una página diferente con mensaje de error
            return redirect()->route('login')->with('error', 'Usuario no identificado.');
        }
    }


    public function store(Request $request, $userId)
    {
 
        // Validar los datos
        $validatedData = $request->validate([
            'url' => 'required|url|max:255',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'duracion' => 'required|string|max:10',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Subir la imagen
        if ($request->hasFile('imagen')) {
            $imageName = time().'.'.$request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
            $validatedData['imagen'] = $imageName;
        }
    
        // Añadir el user_id al array de datos validados
        $validatedData['user_id'] = $userId;
    
        // Guardar los datos en la base de datos
        Imagen::create($validatedData);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('imagen.show')->with('success', 'Imagen subida y datos guardados correctamente.');
    }
    
    public function update(Request $request, $id)
{          // dd($request->all()); 
     $isActive = $request->has('active');
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'url' => 'required|url|max:255',
        'titulo' => 'required|string|max:255',
        'autor' => 'required|string|max:255',
        'duracion' => 'required|string|max:10',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Imagen es opcional
       // 'active' => 'nullable|boolean', // Validar que el campo es booleano o no está presente
    ]);

    // Buscar el registro por ID
    $imagen = Imagen::find($id);


    // Verificar si el registro existe
    if (!$imagen) {
        return redirect()->route('imagen.show')->with('error', 'Imagen no encontrada.');
    }

    // Actualizar los campos
    $imagen->url = $validatedData['url'];
    $imagen->titulo = $validatedData['titulo'];
    $imagen->autor = $validatedData['autor'];
    $imagen->duracion = $validatedData['duracion'];

    // Establecer el valor del campo 'active'
    $imagen->active = $request->has('active') ? true : false;


    // Subir la nueva imagen si se ha enviado una
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen anterior si es necesario
        if ($imagen->imagen) {
            $previousImagePath = public_path('images/' . $imagen->imagen);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        // Guardar la nueva imagen
        $imageName = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('images'), $imageName);
        $imagen->imagen = $imageName;
    }

    // Guardar los cambios
    $imagen->save();

    // Redirigir con un mensaje de éxito
    return redirect()->route('imagen.show', $id)->with('success', 'Imagen actualizada correctamente.');
}

    
    





            public function destroy($id)
            {
                // Encuentra el registro de la imagen
                $imagen = Imagen::findOrFail($id);
            
                // Borra el archivo de imagen del servidor
                if ($imagen->imagen) {
          
                    Storage::delete('public/images/' . $imagen->imagen); // Asumiendo que las imágenes están en 'public/images'
                }
            
                // Elimina el registro de la base de datos
                $imagen->delete();
            
                // Redirige con un mensaje de éxito
           
         
    return redirect()->route('imagen.show', $id)->with('success', 'Imagen Eliminada correctamente.');
        }
    
}
