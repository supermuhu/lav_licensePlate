<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\Type_car;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarsImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        if(Car::where('name', $row[0])->exists()){
            return null;
        }
        $name = $row[0];
        $image_front_path = $row[1];
        $image_front_name = null;
        $image_back_path = $row[2];
        $image_back_name = null;
        $typeCar_id = $row[3];
        if (file_exists($image_front_path) && $this->isValidImage($image_front_path)) {
            $imageContents = file_get_contents($image_front_path);
            $extension = pathinfo($image_front_path, PATHINFO_EXTENSION);
            $image_front_name = Str::random(20) . '.' . $extension;
            Storage::disk('public')->put('cars/' . $image_front_name, $imageContents);
        } else {
            return null;
        }
        if (file_exists($image_back_path) && $this->isValidImage($image_back_path)) {
            $imageContents = file_get_contents($image_back_path);
            $extension = pathinfo($image_back_path, PATHINFO_EXTENSION);
            $image_back_name = Str::random(20) . '.' . $extension;
            Storage::disk('public')->put('cars/' . $image_back_name, $imageContents);
        } else {
            return null;
        }
        if(!Type_car::where('name', $typeCar_id)->exists()){
            return null;
        }else{
            $typeCar = Type_car::where('name', $typeCar_id)->first();
            $typeCar_id = $typeCar->id;
        }
        return new Car([
            'name' => $name,
            'image_front_path' => '/storage/cars/' . $image_front_name,
            'image_front_name' => $image_front_name,
            'image_back_path' => '/storage/cars/' . $image_back_name,
            'image_back_name' => $image_back_name,
            'typeCar_id' => $typeCar_id,
        ]);
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
