<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ms_module')->insert([
            [
                'id_module' => '0c0cd581-085c-4246-8951-6539c8350a1e',
                'induk_module' => '0',
                'code_module' => 'USM',
                'name_module' => 'User Management',
                'link_module' => '#header_usermanagement',
                'description_module' => '-',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 4,
                'created_at' => '2025-06-05 15:53:32',
                'updated_at' => '2025-06-05 16:15:19',
                'deleted_at' => null,
            ],
            [
                'id_module' => '10a6cd53-0557-4f83-a9b7-67b0712b149f',
                'induk_module' => '0',
                'code_module' => 'STT',
                'name_module' => 'Setting Website',
                'link_module' => 'setting-website',
                'description_module' => 'Fitur untuk setting tampilan website',
                'icon_module' => 'far fa-window-restore',
                'action_module' => 'create,read,update,delete',
                'order_module' => 5,
                'created_at' => '2025-06-12 07:10:59',
                'updated_at' => '2025-06-12 07:11:06',
                'deleted_at' => null,
            ],
            [
                'id_module' => '30870738-36b3-4d84-9bce-a2c7da30ea38',
                'induk_module' => '0',
                'code_module' => 'KTG',
                'name_module' => 'Kategori',
                'link_module' => 'category',
                'description_module' => 'Fitur untuk kategori',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 55,
                'created_at' => '2025-06-12 07:12:21',
                'updated_at' => '2025-06-12 07:12:21',
                'deleted_at' => null,
            ],
            [
                'id_module' => '37b9531e-dd3f-42e0-b8d9-e8ef46fda8de',
                'induk_module' => '0',
                'code_module' => 'DSH',
                'name_module' => 'Dashboard',
                'link_module' => 'home',
                'description_module' => 'Halaman dashboard admin',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 2,
                'created_at' => '2025-06-05 15:52:30',
                'updated_at' => '2025-06-05 15:52:30',
                'deleted_at' => null,
            ],
            [
                'id_module' => '493f1543-1685-4394-a3da-72f7e37b9831',
                'induk_module' => '0',
                'code_module' => 'DSHH',
                'name_module' => 'Dashboard',
                'link_module' => '#mainheader_dashboard',
                'description_module' => '-',
                'icon_module' => '-',
                'action_module' => 'create,read,update,delete',
                'order_module' => 1,
                'created_at' => '2025-06-05 15:45:48',
                'updated_at' => '2025-06-05 16:15:19',
                'deleted_at' => null,
            ],
            [
                'id_module' => '56a764f6-e032-4b50-a7b7-463ba6233580',
                'induk_module' => '0',
                'code_module' => 'MDL',
                'name_module' => 'Module',
                'link_module' => 'module',
                'description_module' => 'Fitur untuk manajemen module aplikasi',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 3,
                'created_at' => '2025-06-05 15:49:56',
                'updated_at' => '2025-06-05 16:15:19',
                'deleted_at' => null,
            ],
            [
                'id_module' => '67e969e0-2448-459c-a2b5-8ff145dcfa4c',
                'induk_module' => '0c0cd581-085c-4246-8951-6539c8350a1e',
                'code_module' => 'HAS',
                'name_module' => 'Hak Akses',
                'link_module' => 'permission',
                'description_module' => 'Fitur untuk manajemen hak akses tiap level',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 1,
                'created_at' => '2025-06-05 15:57:34',
                'updated_at' => '2025-06-05 15:57:34',
                'deleted_at' => null,
            ],
            [
                'id_module' => '891df66d-2a34-4336-9a7f-03c1f35aff82',
                'induk_module' => '0c0cd581-085c-4246-8951-6539c8350a1e',
                'code_module' => 'USR',
                'name_module' => 'Users',
                'link_module' => 'users',
                'description_module' => 'Fitur untuk manajemen user',
                'icon_module' => 'fas fa-fire',
                'action_module' => 'create,read,update,delete',
                'order_module' => 2,
                'created_at' => '2025-06-05 16:01:41',
                'updated_at' => '2025-06-05 16:15:23',
                'deleted_at' => null,
            ],
        ]);
    }
}
