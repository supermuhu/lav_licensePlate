<?php

namespace App\Http\Controllers;

use App\Exports\Type_carsExport;
use App\Imports\Type_carsImport;
use App\Models\Type_car;
use App\Traits\DeleteRowTrait;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminTypeCarController extends Controller
{
    use StorageImageTrait, DeleteRowTrait;
    private $typecars;
    public function __construct(Type_car $typecars)
    {
        $this->typecars = $typecars;
    }
    public function index()
    {
        $sidebar = 'type-cars';
        $typecars = $this->typecars->latest()->paginate(4);
        return view('administrator.type-cars.index', compact('sidebar', 'typecars'));
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
        $query = $this->typecars->query();
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
        $sidebar = 'type-cars';
        $typecars = $query->latest()->paginate(4);
        $dateQuery = !$from ? null : $from . ' - ' . $to;
        return view('administrator.type-cars.index', compact('sidebar', 'typecars', 'dateQuery', 'search'));
    }
    public function edit(Request $request)
    {
        try{
            DB::beginTransaction();
            $typecar = $this->typecars->find($request->id);
            $typecar->name = $request->name;
            $dataImageTypeCar = $this->storeTraitUpload($request, 'image_path', 'type-cars');
            if (!empty($dataImageTypeCar)) {
                $typecar->image_path = $dataImageTypeCar['filePath'];
                $typecar->image_name = $dataImageTypeCar['fileName'];
            }
            $typecar->save();
            DB::commit();
            return response()->json([
                'data' => null,
                'message' => 'Loại xe đã được cập nhật thành công!',
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
        return $this->deleteRow($this->typecars, $id);
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
                $this->typecars->find($id)->delete();
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
        $sidebar = 'type-cars';
        return view('administrator.type-cars.create', compact('sidebar'));
    }
    public function store(Request $request)
    {
        if(Type_car::where('name', $request->name)->exists()){
            return response()->json([
                'data' => null,
                'message' => 'Loại xe đã tồn tại!',
                'status' => 400,
            ]);
        }
        try{
            DB::beginTransaction();
            $typecar = new Type_car();
            $typecar->name = $request->name;
            $dataImageTypeCar = $this->storeTraitUpload($request, 'image_path', 'type-cars');
            if(!empty($dataImageTypeCar)){
                $typecar->image_path = $dataImageTypeCar['filePath'];
                $typecar->image_name = $dataImageTypeCar['fileName'];
            }
            $typecar->save();
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
        return Excel::download(new Type_carsExport, 'type_cars.xlsx');
    }
    public function import(Request $request)
    {
        try{
            Excel::import(new Type_carsImport, $request->file('import_excel'));
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
