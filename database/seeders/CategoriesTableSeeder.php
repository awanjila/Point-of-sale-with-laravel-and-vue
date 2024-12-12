<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // Level 0 categories
            ['parent_id' => null, '_lft' => 1, '_rgt' => 2, 'depth' => 0, 'category_name' => 'Technology', 'meta_title' => 'Technology', 'slug' => 'technology', 'category_description' => 'Technology category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 3, '_rgt' => 4, 'depth' => 0, 'category_name' => 'Business', 'meta_title' => 'Business', 'slug' => 'business', 'category_description' => 'Business category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 5, '_rgt' => 6, 'depth' => 0, 'category_name' => 'Science', 'meta_title' => 'Science', 'slug' => 'science', 'category_description' => 'Science category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 7, '_rgt' => 8, 'depth' => 0, 'category_name' => 'Health', 'meta_title' => 'Health', 'slug' => 'health', 'category_description' => 'Health category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 9, '_rgt' => 10, 'depth' => 0, 'category_name' => 'Sports', 'meta_title' => 'Sports', 'slug' => 'sports', 'category_description' => 'Sports category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 11, '_rgt' => 12, 'depth' => 0, 'category_name' => 'Education', 'meta_title' => 'Education', 'slug' => 'education', 'category_description' => 'Education category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 13, '_rgt' => 14, 'depth' => 0, 'category_name' => 'Fashion', 'meta_title' => 'Fashion', 'slug' => 'fashion', 'category_description' => 'Fashion category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 15, '_rgt' => 16, 'depth' => 0, 'category_name' => 'Travel', 'meta_title' => 'Travel', 'slug' => 'travel', 'category_description' => 'Travel category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 17, '_rgt' => 18, 'depth' => 0, 'category_name' => 'Food', 'meta_title' => 'Food', 'slug' => 'food', 'category_description' => 'Food category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => null, '_lft' => 19, '_rgt' => 20, 'depth' => 0, 'category_name' => 'Entertainment', 'meta_title' => 'Entertainment', 'slug' => 'entertainment', 'category_description' => 'Entertainment category description', 'created_at' => now(), 'updated_at' => now()],

            // Level 1 categories
            ['parent_id' => 1, '_lft' => 21, '_rgt' => 22, 'depth' => 1, 'category_name' => 'Computers', 'meta_title' => 'Computers', 'slug' => 'computers', 'category_description' => 'Computers category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 1, '_lft' => 23, '_rgt' => 24, 'depth' => 1, 'category_name' => 'Mobile', 'meta_title' => 'Mobile', 'slug' => 'mobile', 'category_description' => 'Mobile category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 1, '_lft' => 25, '_rgt' => 26, 'depth' => 1, 'category_name' => 'Networking', 'meta_title' => 'Networking', 'slug' => 'networking', 'category_description' => 'Networking category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 1, '_lft' => 27, '_rgt' => 28, 'depth' => 1, 'category_name' => 'Programming', 'meta_title' => 'Programming', 'slug' => 'programming', 'category_description' => 'Programming category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 2, '_lft' => 29, '_rgt' => 30, 'depth' => 1, 'category_name' => 'Marketing', 'meta_title' => 'Marketing', 'slug' => 'marketing', 'category_description' => 'Marketing category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 2, '_lft' => 31, '_rgt' => 32, 'depth' => 1, 'category_name' => 'Finance', 'meta_title' => 'Finance', 'slug' => 'finance', 'category_description' => 'Finance category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 2, '_lft' => 33, '_rgt' => 34, 'depth' => 1, 'category_name' => 'Management', 'meta_title' => 'Management', 'slug' => 'management', 'category_description' => 'Management category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 3, '_lft' => 35, '_rgt' => 36, 'depth' => 1, 'category_name' => 'Physics', 'meta_title' => 'Physics', 'slug' => 'physics', 'category_description' => 'Physics category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 3, '_lft' => 37, '_rgt' => 38, 'depth' => 1, 'category_name' => 'Chemistry', 'meta_title' => 'Chemistry', 'slug' => 'chemistry', 'category_description' => 'Chemistry category description', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => 3, '_lft' => 39, '_rgt' => 40, 'depth' => 1, 'category_name' => 'Biology', 'meta_title' => 'Biology', 'slug' => 'biology', 'category_description' => 'Biology category description', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}