<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Reply;
use App\Models\Like;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // * Trước khi tạo các records cho bảng questions, mình phải có data của users và categories
        factory(User::class, 10)->create();
        factory(Category::class, 5)->create();

        // * Trước khi tạo các records cho replies, mình phải có data của questions
        factory(Question::class, 10)->create();

        factory(Reply::class, 50)->create()->each(function ($reply) {
            // - Dùng mối quan hệ trong model để tạo các like (nhờ mqh nên các like tự có reply_id)
            // - Vì trong LikeFactory lấy random user, nên nếu 1 reply mà tạo giả NHIỀU like
            //   thì có rủi ro là 1 user like 1 reply >= 2 lần (bảng likes có 2 records trùng user_id và reply_id)
            // - Nên ở đây đang là mỗi reply đều có 1 like hết đó
            return $reply->likes()->save(factory(Like::class)->make());
            // * Chú ý:
            // - factory(Like::class)->make() trả về 1 instance của Like model
            // - factory(Like::class, 1)->make() trả về 1 MẢNG chứa 1 instance của Like model
        });
    }
}
