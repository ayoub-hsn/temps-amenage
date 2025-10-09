<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\Actualite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$actualites = Actualite::where('finished_at', '<=', Carbon::now())->orderBy('published_at', 'desc')->get();
        $actualites = Actualite::where('user_id',Auth::id())->get();
        return view('admin-etab.actualite.index',compact('actualites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-etab.actualite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file'          => 'required',
            'titre'         => 'required',
            'description'   => 'required',
            'published_at'  => 'required',
            'finished_at'   => 'required'
        ]);

        $content = $request->description;
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            $explodedData = explode(';', $data);

            if (count($explodedData) >= 2) {
                $type = $explodedData[0];
                $data = $explodedData[1];

                list(, $data) = explode(',', $data);
                $imageData = base64_decode($data);
                $image_name = "/files/actualites/" . time() . $item . '.png';
                $path = public_path() . $image_name;
                file_put_contents($path, $imageData);

                $image->removeAttribute('src');
                $image->setAttribute('src', asset($image_name));
            } else {
                // Handle the case where the expected delimiter is not found
                // You can choose to skip the image processing or perform alternative actions
            }
        }

        $request['description'] = $dom->saveHTML();


        $fileName = $request->file;
        $filePath = storage_path('tmp/uploads/') . $fileName;

        $fileExists = File::exists($filePath);

        if ($fileExists) {
            File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/actualites/'. basename($request->file)));
            $request['image'] = 'files/actualites/'. basename($request->file);
        } else {
            $request['image'] = "No picture";
        }

        $request['user_id'] = Auth::id();
        $request['published_at'] = $request->published_at;
        $request['finished_at'] = $request->finished_at;

        $actualite = Actualite::create($request->all());


        return redirect()->route('admin-etab.actualite.index')->with('message','actualite est crée avec succées');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actualite $actualite)
    {
        if(Auth::id() != $actualite->user_id){
            abort(403);
        }
        return view('admin-etab.actualite.show',compact('actualite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actualite $actualite)
    {
        if(Auth::id() != $actualite->user_id){
            abort(403);
        }
        return view('admin-etab.actualite.edit',compact('actualite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actualite $actualite)
    {
        if(Auth::id() != $actualite->user_id){
            abort(403);
        }
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'published_at'  => 'required',
            'finished_at'   => 'required'
        ]);


        $content = $request->description;
        $dom = new \DomDocument();
        libxml_use_internal_errors(true); // Add this line to suppress errors
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors(); // Clear any errors that occurred during parsing
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            if (strpos($data, ';') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $imgeData = base64_decode($data);
                $image_name = "/files/actualites/" . time() . $item . '.png';
                $path = public_path() . $image_name;
                file_put_contents($path, $imgeData);

                $image->removeAttribute('src');
                $image->setAttribute('src', asset($image_name));
            } else {
                // Handle the case when semicolon is not found in $data
                // For example, you can skip this iteration or perform alternative logic
            }
        }

        $request['description'] = $dom->saveHTML();

        $fileName = $request->file;
    

        if ($fileName) {
            File::delete(public_path($actualite->logo));
            File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/actualites/'. basename($request->file)));
            $request['image'] = 'files/actualites/'. basename($request->file);
        } else {
            $request['image'] = $actualite->image;
        }

        $actualite->update($request->all());

        return redirect()->route('admin-etab.actualite.index')->with('message','actualite est modifié avec succées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeMedia(Request $request){
        // Validates file size
        if (request()->has('size')) {
            $this->validate(request(), [
                'file' => 'max:' . request()->input('size') * 1024,
            ]);
        }

        // If width or height is preset - we are validating it as an image
        if (request()->has('width') || request()->has('height')) {
            $this->validate(request(), [
                'file' => sprintf(
                    'image|dimensions:max_width=%s,max_height=%s',
                    request()->input('width', 1),
                    request()->input('height', 1)
                ),
            ]);
        }

        $path = storage_path('tmp'.DIRECTORY_SEPARATOR.'uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = time() .'.' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }
}
