<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DeleteRowTrait
{
    public function deleteRow($table, $id){
        try{
            // $imagePath = $table->find($id)->image_path;
            // if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            //     Storage::disk('public')->delete($imagePath);
            // }
            DB::beginTransaction();
            $table->find($id)->delete();
            DB::commit();
            return response()->json([
                'data' => null,
                'status' => 200,
                'message' => 'Xóa dữ liệu thành công'
            ], 200);
        } catch(Exception $exception){
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => 500,
                'message' => 'Xóa dữ liệu thất bại'
            ], 500);
        }
    }
}
