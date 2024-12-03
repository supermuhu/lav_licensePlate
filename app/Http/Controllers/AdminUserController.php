<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\City;
use App\Models\User;
use App\Traits\DeleteRowTrait;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{

    use StorageImageTrait, DeleteRowTrait;
    private $users;
    public function __construct(User $users)
    {
        $this->users = $users;
    }
    public function index()
    {
        $sidebar = 'users';
        $users = $this->users->latest()->paginate(5);
        $cities = City::all();
        return view('administrator.users.index', compact('sidebar', 'users', 'cities'));
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
        $query = $this->users->query();
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
        $sidebar = 'users';
        $users = $query->latest()->paginate(4);
        $dateQuery = !$from ? null : $from . ' - ' . $to;
        $cities = City::all();
        return view('administrator.users.index', compact('sidebar', 'users', 'cities', 'dateQuery', 'search'));
    }
    public function edit(Request $request)
    {
        try{
            DB::beginTransaction();
            $user = $this->users->find($request->id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->phone_verified_at = ($request->phone_verified_at == 0 ? Carbon::now() : null);
            $user->city_id = $request->city_id;
            $user->save();
            DB::commit();
            return response()->json([
                'data' => null,
                'message' => 'Người dùng đã được cập nhật thành công!',
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
        return $this->deleteRow($this->users, $id);
    }
    public function multiDelete(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id) {
                // $imagePath = $this->users->find($id)->image_path;
                // if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                //     Storage::disk('public')->delete($imagePath);
                // }
                $this->users->find($id)->delete();
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
        $sidebar = 'users';
        $cities = City::all();
        return view('administrator.users.create', compact('sidebar', 'cities'));
    }
    public function store(Request $request)
    {
        if(User::where('phone', $request->phone)->exists()){
            return response()->json([
                'data' => null,
                'message' => 'Người dùng đã tồn tại!',
                'status' => 400,
            ]);
        }
        try{
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->phone_verified_at = Carbon::now();
            $user->city_id = $request->city_id;
            $user->save();
            DB::commit();
            return response()->json([
                'data' => null,
                'message' => 'Người dùng đã được thêm mới thành công!',
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
        return Excel::download(new UserExport, 'users.xlsx');
    }
    // public function import(Request $request)
    // {
    //     try{
    //         Excel::import(new Type_carsImport, $request->file('import_excel'));
    //         return response()->json([
    //             'data' => null,
    //             'message' => 'Import dữ liệu thành công!',
    //             'status' => 200,
    //         ]);
    //     }catch(Exception $e){
    //         return response()->json([
    //             'data' => null,
    //             'message' => 'Có lỗi xảy ra!',
    //             'status' => 500,
    //         ]);
    //     }
    // }
}
