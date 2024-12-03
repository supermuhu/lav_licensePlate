<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['name' => 'Cao Bằng', 'code' => '[11]'],
            ['name' => 'Lạng Sơn', 'code' => '[12]'],
            ['name' => 'Quảng Ninh', 'code' => '[14]'],
            ['name' => 'Hải Phòng', 'code' => '[15, 16]'],
            ['name' => 'Thái Bình', 'code' => '[17]'],
            ['name' => 'Nam Định', 'code' => '[18]'],
            ['name' => 'Phú Thọ', 'code' => '[19]'],
            ['name' => 'Thái Nguyên', 'code' => '[20]'],
            ['name' => 'Yên Bái', 'code' => '[21]'],
            ['name' => 'Tuyên Quang', 'code' => '[22]'],
            ['name' => 'Hà Giang', 'code' => '[23]'],
            ['name' => 'Lào Cai', 'code' => '[24]'],
            ['name' => 'Lai Châu', 'code' => '[25]'],
            ['name' => 'Sơn La', 'code' => '[26]'],
            ['name' => 'Điện Biên', 'code' => '[27]'],
            ['name' => 'Hòa Bình', 'code' => '[28]'],
            ['name' => 'Hà Nội', 'code' => '[29, 30, 31, 32, 33, 40]'],
            ['name' => 'Hải Dương', 'code' => '[34]'],
            ['name' => 'Ninh Bình', 'code' => '[35]'],
            ['name' => 'Thanh Hóa', 'code' => '[36]'],
            ['name' => 'Nghệ An', 'code' => '[37]'],
            ['name' => 'Hà Tĩnh', 'code' => '[38]'],
            ['name' => 'Đà Nẵng', 'code' => '[43]'],
            ['name' => 'Đắk Lắk', 'code' => '[47]'],
            ['name' => 'Đắk Nông', 'code' => '[48]'],
            ['name' => 'Lâm Đồng', 'code' => '[49]'],
            ['name' => 'TP. Hồ Chí Minh', 'code' => '[41, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59]'],
            ['name' => 'Đồng Nai', 'code' => '[39, 60]'],
            ['name' => 'Bình Dương', 'code' => '[61]'],
            ['name' => 'Long An', 'code' => '[62]'],
            ['name' => 'Tiền Giang', 'code' => '[63]'],
            ['name' => 'Vĩnh Long', 'code' => '[64]'],
            ['name' => 'Cần Thơ', 'code' => '[65]'],
            ['name' => 'Đồng Tháp', 'code' => '[66]'],
            ['name' => 'An Giang', 'code' => '[67]'],
            ['name' => 'Kiên Giang', 'code' => '[68]'],
            ['name' => 'Cà Mau', 'code' => '[69]'],
            ['name' => 'Tây Ninh', 'code' => '[70]'],
            ['name' => 'Bến Tre', 'code' => '[71]'],
            ['name' => 'Bà Rịa - Vũng Tàu', 'code' => '[72]'],
            ['name' => 'Quảng Bình', 'code' => '[73]'],
            ['name' => 'Quảng Trị', 'code' => '[74]'],
            ['name' => 'Thừa Thiên Huế', 'code' => '[75]'],
            ['name' => 'Quảng Ngãi', 'code' => '[76]'],
            ['name' => 'Bình Định', 'code' => '[77]'],
            ['name' => 'Phú Yên', 'code' => '[78]'],
            ['name' => 'Khánh Hòa', 'code' => '[79]'],
            ['name' => 'Gia Lai', 'code' => '[81]'],
            ['name' => 'Kon Tum', 'code' => '[82]'],
            ['name' => 'Sóc Trăng', 'code' => '[83]'],
            ['name' => 'Trà Vinh', 'code' => '[84]'],
            ['name' => 'Ninh Thuận', 'code' => '[85]'],
            ['name' => 'Bình Thuận', 'code' => '[86]'],
            ['name' => 'Vĩnh Phúc', 'code' => '[88]'],
            ['name' => 'Hưng Yên', 'code' => '[89]'],
            ['name' => 'Hà Nam', 'code' => '[90]'],
            ['name' => 'Quảng Nam', 'code' => '[92]'],
            ['name' => 'Bình Phước', 'code' => '[93]'],
            ['name' => 'Bạc Liêu', 'code' => '[94]'],
            ['name' => 'Hậu Giang', 'code' => '[95]'],
            ['name' => 'Bắc Kạn', 'code' => '[97]'],
            ['name' => 'Bắc Giang', 'code' => '[98]'],
            ['name' => 'Bắc Ninh', 'code' => '[99]'],
        ]);
    }
}
