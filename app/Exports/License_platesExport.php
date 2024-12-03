<?php

namespace App\Exports;

use App\Models\LicensePlate;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class License_platesExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithEvents, WithDrawings
{
    use Exportable;

    private $rowNumber = 2;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return LicensePlate::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ký tự',
            'Hình ảnh',
            'Định giá',
            'Tên người sở hữu',
            'Created at',
            'Updated at',
        ];
    }

    public function map($licensePlate): array
    {
        return [
            $licensePlate->id,
            $licensePlate->license_number,
            '',
            $licensePlate->price,
            optional($licensePlate->user)->name .' - '. optional($licensePlate->user)->phone,
            // $licensePlate->user_id,
            $licensePlate->created_at,
            $licensePlate->updated_at,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $licensePlates = LicensePlate::all();

        foreach ($licensePlates as $index => $licensePlate) {
            $drawing = new Drawing();
            $drawing->setName('Image');
            $drawing->setDescription('Image');
            $drawing->setPath(public_path($licensePlate->image_path));
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
        $sheet->getColumnDimension('C')->setWidth(110);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
