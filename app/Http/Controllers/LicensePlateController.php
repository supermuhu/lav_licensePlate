<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\LicensePlate;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class LicensePlateController extends Controller
{
    use StorageImageTrait;
    public function quotesLicensePlate($licensePlate)
    {
        $licensePlateNumber = explode('-', $licensePlate);
        $bienSo = $licensePlateNumber[1];
        $bienSo = str_replace(' ', '', $bienSo);
        $bienSo = str_replace('.', '', $bienSo);
        if (strlen($bienSo) != 5 || !ctype_digit($bienSo)) {
            return response()->json([
                'data' => null,
                'message' => 'Biển số không hợp lệ, phải là 5 chữ số.',
                'status' => 400,
            ]);
        }
        $giaTri = 1; // Đơn vị triệu VNĐ (tùy chỉnh)

        $heSoYNghia = [
            '0' => 1.0,
            '1' => 1.0,
            '2' => 1.0,
            '3' => 1.0,
            '4' => 0.7,  // Chết (giảm giá trị)
            '5' => 1.0,
            '6' => 1.1,  // Tài lộc
            '7' => 0.7,  // Thất bại
            '8' => 1.2,  // May mắn, thành công
            '9' => 1.3,  // Bền vững
        ];
        $capSoDacBiet = [
            '11' => 1.025,  // Phát phát
            '13' => 0.8,  // Xui rủi
            '17' => 0.8,  // Không may
            '25' => 0.8,  // Không may
            '29' => 1.025,  // Mãi mãi phát lộc
            '32' => 1.025,  // Tài mãi
            '38' => 1.025,  // Ông địa nhỏ
            '39' => 1.025,  // Thần tài nhỏ
            '44' => 0.7, // Tử tử (xấu)
            '47' => 0.7,  // Thất tử
            '49' => 0.7,  // Xấu
            '53' => 0.7,  // Xấu
            '56' => 1.025,  // Phát lộc
            '68' => 1.2,  // Lộc phát
            '78' => 1.2,  // Ông địa lớn
            '79' => 1.3,  // Thần tài lớn
            '86' => 1.2,  // Phát lộc
        ];
        $boBaDacBiet = [
            '111' => 1.025,  // Tam phất
            '444' => 1.1,   // Tam trường tứ
            '666' => 1.2,  // Tam lộc
            '777' => 0.6,  // Tam thất (xấu)
            '888' => 1.2,  // Tam phát
            '999' => 1.3,  // Tam trường cửu
        ];
        $boBonDacBiet = [
            '1102' => 1.025, // Độc nhất vô nhị
            '1111' => 1.1,  // Tứ nhất (ý nghĩa độc đáo)
            '1368' => 1.025, // Cả đời phát lộc
            '2626' => 1.025, // Tài lộc cân bằng
            '2628' => 1.025, // Hái ra lộc
            '3399' => 1.025, // Lâu dài vĩnh cửu
            '4444' => 0.7,  // Tứ tử (xấu)
            '4747' => 0.7,  // Tứ thất (xấu)
            '4949' => 0.7,  // Tứ xấu
            '4953' => 0.6,  // 49 chưa qua 53 đã tới
            '5353' => 0.7,  // Tứ xấu
            '5656' => 1.025, // Tài lộc sinh tài lộc
            '6666' => 1.2,  // Tứ lộc
            '6868' => 1.2,  // Lộc phát tài
            '7939' => 1.1,  // Thần tài lớn, thần tài nhỏ
            '8386' => 1.2,  // Phát tài phát lộc
            '8686' => 1.3,  // Phát lộc phát lộc
            '8888' => 1.3,  // Tứ phát
            '9999' => 1.4,  // Tứ trường cửu
        ];
        foreach (str_split($bienSo) as $so) {
            $giaTri += $heSoYNghia[$so] * 10;
        }
        foreach ($capSoDacBiet as $cap => $heSo) {
            if (strpos($bienSo, $cap) !== false) {
                $giaTri *= $heSo;
            }
        }
        foreach ($boBaDacBiet as $boBa => $heSo) {
            if (strpos($bienSo, $boBa) !== false) {
                $giaTri *= $heSo;
            }
        }
        foreach ($boBonDacBiet as $boBon => $heSo) {
            if (strpos($bienSo, $boBon) !== false) {
                $giaTri *= $heSo;
            }
        }
        if (count(array_unique(str_split($bienSo))) == 1) {
            $giaTri *= 6;
        } elseif ($bienSo == implode('', range(min(str_split($bienSo)), max(str_split($bienSo))))) {
            $giaTri *= 4;
        } elseif ($bienSo == implode('', range(max(str_split($bienSo)), min(str_split($bienSo))))) {
            $giaTri *= 3;
        }

        $tongCacSo = array_sum(array_map('intval', str_split($bienSo)));
        if (in_array($tongCacSo, [6, 8, 9])) {
            $giaTri *= 1.2;
        }
        $bienSoTanSuat = array_count_values(str_split($bienSo));
        if (max($bienSoTanSuat) >= 2) {
            $giaTri *= 1.1;
        }
        return response()->json([
            'data' => $giaTri,
            'message' => 'Giá trị của biển số này là: ',
            'status' => 500,
        ]);
    }
    public function create(Request $request)
    {
        $user = Auth::user();
        if(LicensePlate::where('user_id', $user->id)->exists()){
            return response()->json([
                'data' => null,
                'message' => 'Chỉ được tạo 1 biển số!',
                'status' => 400,
            ]);
        }
        $city = City::where('id', $user->city_id)->first();
        $cityCode = $city->code[array_rand($city->code)];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z'];
        $symbol = $letters[array_rand($letters)];
        do {
            $formattedNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $number = substr($formattedNumber, 0, 3) . '.' . substr($formattedNumber, 3, 2);
        } while (LicensePlate::where('license_number', $cityCode . $symbol . '-' . $number)->exists());
        $price = $this->quotesLicensePlate($cityCode . $symbol . '-' . $number);
        $price = $price->getData()->data;
        return response()->json([
            'data' => $cityCode . $symbol . '-' . $number,
            'price' => number_format($price, 2),
            'message' => 'Biển số đã được tạo.',
            'status' => 500,
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        if(LicensePlate::where('user_id', $user->id)->exists()){
            return response()->json([
                'data' => null,
                'message' => 'Chỉ được tạo 1 biển số!',
                'status' => 400,
            ]);
        }
        $licensePlate = new LicensePlate();
        $licensePlate->license_number = $request->license_number;
        $dataImageLicensePlate = $this->storeTraitUpload($request, 'image_path', 'licensePlate');
        if (!empty($dataImageLicensePlate)) {
            $licensePlate->image_path = $dataImageLicensePlate['filePath'];
            $licensePlate->image_name = $dataImageLicensePlate['fileName'];
        }
        $licensePlate->price = $request->price;
        $licensePlate->user_id = $user->id;
        $licensePlate->save();
        return response()->json([
            'data' => null,
            'message' => 'Biển số đã được lưu thành công!',
            'status' => 500,
        ]);
    }
    public function check()
    {
        $exists = LicensePlate::where('user_id', Auth::id())->exists();
        if($exists){
            return response()->json([
                'data' => null,
                'message' => 'Chỉ được tạo 1 biển số!',
                'status' => 400,
            ]);
        }else{
            return response()->json([
                'data' => null,
                'message' => 'Chưa có biển số!',
                'status' => 500,
            ]);
        }
    }
}
