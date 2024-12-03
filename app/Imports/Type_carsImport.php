<?php

namespace App\Imports;

use App\Models\Type_car;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Type_carsImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        if(Type_car::where('name', $row[0])->exists()){
            return null;
        }
        $name = $row[0];
        $image_path = $row[1];
        if (file_exists($image_path) && $this->isValidImage($image_path)) {
            $imageContents = file_get_contents($image_path);
            $extension = pathinfo($image_path, PATHINFO_EXTENSION);
            $imageName = Str::random(20) . '.' . $extension;
            Storage::disk('public')->put('type-cars/' . $imageName, $imageContents);
            return new Type_car([
                'name' => $name,
                'image_path' => '/storage/type-cars/' . $imageName,
                'image_name' => $imageName,
            ]);
        } else {
            return null;
        }
    }
    private function isValidImage($path)
    {
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'svg', 'webp'];
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($extension, $validExtensions);
    }

    public function startRow(): int
    {
        return 2;
    }
}
