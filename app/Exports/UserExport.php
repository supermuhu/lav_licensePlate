<?php

namespace App\Exports;

use App\Models\LicensePlate;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    private $rowNumber = 2;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return User::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Số điện thoại',
            'Xác thực',
            'Thành phố',
            'Số lượng biển số',
            'Created at',
            'Updated at',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->phone,
            $user->phone_verified_at,
            optional($user->city)->name,
            $user->licensePlate->count(),
            $user->created_at,
            $user->updated_at,
        ];
    }
}
