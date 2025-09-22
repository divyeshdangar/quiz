<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Menu::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                "id" => 1, 
                "icon" => "grid", 
                "title" => 'dashboard.dashboard', 
                "route" => "dashboard",
                "order" => 1,
                "title_only" => "0",
                "type" => "2"
            ],
            [
                "id" => 2, 
                "icon" => "", 
                "title" => 'dashboard.manage_work', 
                "route" => "",
                "order" => 2,
                "title_only" => "1",
                "type" => "2"
            ],
            [
                "id" => 5, 
                "icon" => "", 
                "title" => 'dashboard.public_features', 
                "route" => "",
                "order" => 5,
                "title_only" => "1",
                "type" => "2"
            ],
            [
                "id" => 6, 
                "icon" => "file-text", 
                "title" => 'dashboard.blog', 
                "route" => "dashboard.blog",
                "order" => 6,
                "title_only" => "0",
                "type" => "2"
            ],
            [
                "id" => 15, 
                "icon" => "file-text", 
                "title" => 'dashboard.blog_category', 
                "route" => "dashboard.blog.category",
                "order" => 6,
                "title_only" => "0",
                "type" => "2"
            ],
            [
                "id" => 9, 
                "icon" => "", 
                "title" => 'dashboard.setting_other', 
                "route" => "",
                "order" => 9,
                "title_only" => "1",
                "type" => "2"
            ],
            [
                "id" => 10, 
                "icon" => "bell", 
                "title" => 'dashboard.notification', 
                "route" => "dashboard.notification",
                "order" => 10,
                "title_only" => "0",
                "type" => "2"
            ],
            [
                "id" => 11, 
                "icon" => "mail", 
                "title" => 'dashboard.contact', 
                "route" => "dashboard.contact",
                "order" => 11,
                "title_only" => "0",
                "type" => "2"
            ],
            [
                "id" => 12, 
                "icon" => "user", 
                "title" => 'dashboard.profile', 
                "route" => "dashboard.profile",
                "order" => 1,
                "title_only" => "0",
                "type" => "3"
            ],
            [
                "id" => 13, 
                "icon" => "", 
                "title" => 'dashboard.user_manage', 
                "route" => "",
                "order" => 12,
                "title_only" => "1",
                "type" => "2"
            ],
            [
                "id" => 14, 
                "icon" => "user", 
                "title" => 'dashboard.user', 
                "route" => "dashboard.user",
                "order" => 13,
                "title_only" => "0",
                "type" => "2"
            ],
        ];

        foreach (array_chunk($data,1000) as $t){
            Menu::insert($t); 
        }
    }
}
