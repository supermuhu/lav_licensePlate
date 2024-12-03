<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait StorageImageTrait
{
    public function storeTraitUpload($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($folderName, $fileNameHash);
            $dataUploadTrait = [
                'fileName' => $fileNameOrigin,
                'filePath' => Storage::url($filePath)
            ];
            return $dataUploadTrait;
        }
        return null;
    }
    public function storeTraitUploadMultiple($file, $folderName)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($folderName . '/' . '1', $fileNameHash);
        $dataUploadTrait = [
            'fileName' => $fileNameOrigin,
            'filePath' => Storage::url($filePath)
        ];
        return $dataUploadTrait;
    }
}
