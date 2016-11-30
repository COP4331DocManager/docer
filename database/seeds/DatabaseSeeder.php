<?php

use App\Document;
use App\Group;
use App\MetaTag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed(123);

        // $this->call(UsersTableSeeder::class);
        Model::unguard();

        // Users
        DB::table('users')->delete();

        $users = [];

        $users [] = ['name' => 'Maximus 64', 'email' => 'maximus64@khoahoang.com', 'password' => Hash::make('password'), 'isAdmin' => 1];
        $users [] = ['name' => 'Tyler', 'email' => 'tyler@gmail.com', 'password' => Hash::make('password'), 'isAdmin' => 0];

        for($i = 0; $i < 100; $i++)
        {
            $users [] = [
                'name' => $faker->name, 'email' => $faker->email, 'password' => Hash::make($faker->password)
            ];
        }

        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }
        dump('Seeded users');



        // Groups
        DB::table('groups')->delete();

        $groups = array(
            ['name' => 'Group 1', 'created_by' => 1],
            ['name' => 'Group 2', 'created_by' => 1],
            ['name' => 'Group 3', 'created_by' => 1],
            ['name' => 'Group 4', 'created_by' => 2],
            ['name' => 'Group 5', 'created_by' => 2],
            ['name' => 'Group 6', 'created_by' => 2],

        );

        // Loop through each user above and create the record for them in the database
        foreach ($groups as $group)
        {
            Group::create($group);
        }
        dump('Seeded groups');



        // Documents
        DB::table('documents')->delete();

        $documents = array(
            ['path' => '/1/9ce95aa5dbd5f16f4126ac3fc848c9f5.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/1/e1610b00cf12a6533654289208b21ac8.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/1/e1610b00cf12a6533654289208b21ac8.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/1/e872e6d34e490ee3a88534717603d23d.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/1/8c3c5597c456075a76bc93988ff2eebb.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/1/e67c20c94d59295fc929b10b6a4ab246.jpg', 'user_id' => 1, 'group_id' => 1, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/1b32dd53d34df288ea4bd162e99188c4.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/e67c20c94d59295fc929b10b6a4ab246.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/dfaef229f973f458510d589a90cb086b.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/8c3c5597c456075a76bc93988ff2eebb.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/907789e8895d263160655d82442198ba.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],
            ['path' => '/4/2d55d99856abd616d19c6403c7a5959d.jpg', 'user_id' => 2, 'group_id' => 4, 'mime_type' => 'image/jpeg'],

        );

        // Loop through each user above and create the record for them in the database
        foreach ($documents as $document)
        {
            Document::create($document);
        }
        dump('Seeded documents');



        // MetaTag
        DB::table('meta_tags')->delete();

        $metaTags = array(
            ['name' => 'first_name'],
            ['name' => 'last_name'],
            ['name' => 'title'],
            ['name' => 'header'],
            ['name' => 'date'],
            ['name' => 'content'],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($metaTags as $metaTag)
        {
            MetaTag::create($metaTag);
        }
        dump('Seeded meta_tags');



        // Users groups pivot table.
        DB::table('users_groups')->insert([
            ['user_id' => 1, 'group_id' => 1],
            ['user_id' => 1, 'group_id' => 2],
            ['user_id' => 1, 'group_id' => 3],
            ['user_id' => 2, 'group_id' => 4],
            ['user_id' => 2, 'group_id' => 5],
            ['user_id' => 2, 'group_id' => 6],
        ]);
        dump('Seeded users_groups');



        // Documents groups pivot table.
        DB::table('documents_groups')->insert([
            ['document_id' => 1, 'group_id' => 1],
            ['document_id' => 2, 'group_id' => 1],
            ['document_id' => 3, 'group_id' => 2],
            ['document_id' => 4, 'group_id' => 2],
            ['document_id' => 5, 'group_id' => 3],
            ['document_id' => 6, 'group_id' => 3],
            ['document_id' => 7, 'group_id' => 4],
            ['document_id' => 8, 'group_id' => 4],
            ['document_id' => 9, 'group_id' => 5],
            ['document_id' => 10, 'group_id' => 5],
            ['document_id' => 11, 'group_id' => 6],
            ['document_id' => 12, 'group_id' => 6],
        ]);
        dump('Seeded documents_groups');



        // Documents groups pivot table.
        DB::table('document_meta_tags')->insert([
            ['document_id' => 1, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 1, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 1, 'meta_tag_id' => 5, 'value' => $faker->date('Y-m-d')],
            ['document_id' => 2, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 2, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 3, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 3, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 4, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 4, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 5, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 5, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 5, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
            ['document_id' => 6, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 7, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 7, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 7, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
            ['document_id' => 8, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
            ['document_id' => 8, 'meta_tag_id' => 5, 'value' => $faker->date('Y-m-d')],
            ['document_id' => 9, 'meta_tag_id' => 5, 'value' => $faker->date('Y-m-d')],
            ['document_id' => 9, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 10, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 10, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 10, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
            ['document_id' => 11, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 11, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 11, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
            ['document_id' => 12, 'meta_tag_id' => 2, 'value' => $faker->lastName],
            ['document_id' => 12, 'meta_tag_id' => 1, 'value' => $faker->firstName],
            ['document_id' => 12, 'meta_tag_id' => 6, 'value' => $faker->paragraph],
        ]);
        dump('Seeded document_meta_tags');

        Model::reguard();

        dump('Successfully Seeded Database');
    }
}
