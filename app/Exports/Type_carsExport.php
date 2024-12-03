<?php

namespace App\Exports;

use App\Models\Type_car;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Type_carsExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithEvents, WithDrawings
{
    use Exportable;

    private $rowNumber = 2;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Type_car::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Hình ảnh',
            'Created at',
            'Updated at',
        ];
    }

    public function map($type_car): array
    {
        return [
            $type_car->id,
            $type_car->name,
            '',
            $type_car->created_at,
            $type_car->updated_at,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $type_cars = Type_car::all();

        foreach ($type_cars as $index => $type_car) {
            $drawing = new Drawing();
            $drawing->setName('Image');
            $drawing->setDescription('Image');
            $drawing->setPath(public_path($type_car->image_path));
            $drawing->setHeight(75);
            $drawing->setCoordinates('C' . ($index + $this->rowNumber));
            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $highestRow = $sheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(55);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
