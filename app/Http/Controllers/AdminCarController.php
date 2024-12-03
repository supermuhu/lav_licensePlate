<?php

namespace App\Http\Controllers;

use App\Exports\CarsExport;
use App\Imports\CarsImport;
use App\Models\Car;
use App\Models\Type_car;
use App\Traits\DeleteRowTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminCarController extends Controller
{
    use DeleteRowTrait, StorageImageTrait;
    private $cars;
    public function __construct(Car $cars)
    {
        $this->cars = $cars;
    }
    public function index()
    {
        $sidebar = 'cars';
        $cars = $this->cars->latest()->paginate(5);
        $typecars = Type_car::all();
        return view('administrator.cars.index', compact('sidebar', 'cars', 'typecars'));
    }
    public function indexQuery($query){
        $parts = explode('?', $query);
        $from = isset($parts[0]) ? str_replace("-", "/", $parts[0]) : null;
        $to = isset($parts[1]) ? str_replace("-", "/", $parts[1]) : null;
        $search = isset($parts[2]) ? $parts[2] : null;
        try {
            $fromDate = $from ? \Carbon\Carbon::createFromFormat('m/d/Y', $from)->startOfDay() : null;
        } catch (\Exception $e) {
            $fromDate = null;
        }

        try {
            $toDate = $to ? \Carbon\Carbon::createFromFormat('m/d/Y', $to)->endOfDay() : null;
        } catch (\Exception $e) {
            $toDate = null;
        }
        $query = $this->cars->query();
        if ($fromDate) {
            $query->where('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->where('created_at', '<=', $toDate);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
                //   ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        $sidebar = 'cars';
        $cars = $query->latest()->paginate(5);
        $typecars = Type_car::all();
        $dateQuery = !$from ? null : $from . ' - ' . $to;
        return view('administrator.cars.index', compact('sidebar', 'typecars', 'cars', 'dateQuery', 'search'));
    }
    public function edit(Request $request)
    {
        try{
            DB::beginTransaction();
            $car = $this->cars->find($request->id);
            $car->name = $request->name;
            $dataImageFrontCar = $this->storeTraitUpload($request, 'image_front_path', 'cars');
            $dataImageBackCar = $this->storeTraitUpload($request, 'image_back_path', 'cars');
            if (!empty($dataImageFrontCar)) {
                $car->image_front_path = $dataImageFrontCar['filePath'];
                $car->image_front_name = $dataImageFrontCar['fileName'];
            }
            if (!empty($dataImageBackCar)) {
                $car->image_back_path = $dataImageBackCar['filePath'];
                $car->image_back_name = $dataImageBackCar['fileName'];
            }
            $car->typeCar_id = $request->typeCar_id;
            $car->save();
            DB::commit();
            return response()->json([
                'data' => null,
                'message' => 'Xe đã được cập nhật thành công!',
                'status' => 200,
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Có lỗi xảy ra!',
                'status' => 500,
            ]);
        }
    }
    public function delete($id)
    {
        return $this->deleteRow($this->cars, $id);
    }
    public function multiDelete(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id) {
                // $imagePath = $this->typecars->find($id)->image_path;
                // if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                //     Storage::disk('public')->delete($imagePath);
                // }
                $this->cars->find($id)->delete();
            }
            DB::commit();
            return response()->json([
                'data' => null,
                'status' => 200,
                'message' => 'Xóa dữ liệu thành công'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Có lỗi xảy ra!',
                'status' => 500,
            ]);
        }
    }
    public function create()
    {
        $sidebar = 'cars';
        $typecars = Type_car::all();
        return view('administrator.cars.create', compact('sidebar', 'typecars'));
    }
    public function store(Request $request)
    {
        if(Car::where('name', $request->name)->exists()){
            return response()->json([
                'data' => null,
                'message' => 'Xe đã tồn tại!',
                'status' => 400,
            ]);
        }
        try{
            DB::beginTransaction();
            $car = new Car();
            $car->name = $request->name;
            $dataImageFrontCar = $this->storeTraitUpload($request, 'image_front_path', 'cars');
            $dataImageBackCar = $this->storeTraitUpload($request, 'image_back_path', 'cars');
            if (!empty($dataImageFrontCar)) {
                $car->image_front_path = $dataImageFrontCar['filePath'];
                $car->image_front_name = $dataImageFrontCar['fileName'];
            }
            if (!empty($dataImageBackCar)) {
                $car->image_back_path = $dataImageBackCar['filePath'];
                $car->image_back_name = $dataImageBackCar['fileName'];
            }
            $car->typeCar_id = $request->typeCar_id;
            $car->save();
            DB::commit();
            return response()->json([
                'data' => null,
                'message' => 'Loại xe đã được thêm mới thành công!',
                'status' => 200,
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Có lỗi xảy ra!',
                'status' => 500,
            ]);
        }
    }
    public function export()
    {
        return Excel::download(new CarsExport, 'cars.xlsx');
    }
    public function import(Request $request)
    {
        try{
            Excel::import(new CarsImport, $request->file('import_excel'));
            return response()->json([
                'data' => null,
                'message' => 'Import dữ liệu thành công!',
                'status' => 200,
            ]);
        }catch(Exception $e){
            return response()->json([
                'data' => null,
                'message' => 'Có lỗi xảy ra!',
                'status' => 500,
            ]);
        }
    }
}
