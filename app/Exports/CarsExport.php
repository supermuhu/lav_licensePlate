<?php

namespace App\Exports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CarsExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithEvents, WithDrawings
{
    use Exportable;

    private $rowNumber = 2;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Car::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Mặt trước',
            'Mặt sau',
            'Created at',
            'Updated at',
        ];
    }

    public function map($car): array
    {
        return [
            $car->id,
            $car->name,
            '',
            '',
            $car->created_at,
            $car->updated_at,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $cars = Car::all();

        foreach ($cars as $index => $car) {
            $drawing1 = new Drawing();
            $drawing1->setName('Image Front');
            $drawing1->setDescription('Image Front');
            $drawing1->setPath(public_path($car->image_front_path));
            $drawing1->setHeight(75);
            $drawing1->setCoordinates('C' . ($index + 2));
            $drawings[] = $drawing1;

            $drawing2 = new Drawing();
            $drawing2->setName('Image Back');
            $drawing2->setDescription('Image Back');
            $drawing2->setPath(public_path($car->image_back_path));
            $drawing2->setHeight(75);
            $drawing2->setCoordinates('D' . ($index + 2));
            $drawings[] = $drawing2;
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
        $sheet->getColumnDimension('C')->setWidth(55);
        $sheet->getColumnDimension('D')->setWidth(55);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
