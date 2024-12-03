<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(config('permissions.table_module') as $index => $module_item){
            $permision = Permission::firstOrCreate([
                'name' => $module_item,
                'description' => config('permissions.table_module_name')[$index],
                'parent_id' => 0,
            ]);

            Permission::firstOrCreate([
                'name' => 'list',
                'description' => 'list',
                'parent_id' => $permision->id,
                'key' => $module_item . '_' . 'list',
            ]);

            Permission::firstOrCreate([
                'name' => 'add',
                'description' => 'add',
                'parent_id' => $permision->id,
                'key' => $module_item . '_' . 'add',
            ]);

            Permission::firstOrCreate([
                'name' => 'edit',
                'description' => 'edit',
                'parent_id' => $permision->id,
                'key' => $module_item . '_' . 'edit',
            ]);

            Permission::firstOrCreate([
                'name' => 'delete',
                'description' => 'delete',
                'parent_id' => $permision->id,
                'key' => $module_item . '_' . 'delete',
            ]);
        }
    }
}
