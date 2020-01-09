<?php
namespace Robust\Core\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Robust\Core\Repositories\API\MediaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



/**
 * Class FileUploadController
 * @package Robust\Core\Controllers\API
 */
class FileUploadController extends Controller
{

    /**
     * @var AttributeRepository
     */
    protected $model;


    /**
     * SettingsController constructor.
     * @param MediaRepository $model
     */
    public function __construct(MediaRepository $model)
    {
        $this->model = $model;
    }


    /**
     * @param MediaRepository $model
     * @return string
     */
    public function store(Request $request, MediaRepository $model)
    {
        $files = $request->all();
        $return_status = [];
        $ids = [];
        $medias = collect();

        foreach($files as $i => $file){
            $fileName = $file->getClientOriginalName();
            $uploadedFile = $request->file($file);
            $newFileName = Carbon::now()->format('YmdHs') . "-" . $fileName;
            
            $newMedia = $this->model->store(
                [
                    'name' => $fileName,
                    'slug' => Str::slug($fileName),
                    'file' => $newFileName,
                    'type' => $file->extension(),
                    'extension' =>  $file->getClientOriginalExtension()
                ]
            );

            $filePath = storage_path("app/medias/" . $newMedia->id);
            $file->move($filePath, $newFileName);
            $ids[] = $newMedia->id;    
            $medias->push([
                'name' => $fileName,
                'url' => url("/medias/{$newMedia->id}/" . $newFileName)
            ]);           
        }

        return response()->json(['data' => [
                'status' => 'success',
                'message' => 'Successfully Uploaded',
                'media_ids' => implode(',', $ids),
                'medias' => json_encode($medias)
        ]]); 
    }
}
