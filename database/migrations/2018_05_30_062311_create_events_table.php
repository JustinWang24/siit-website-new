<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Page;
use App\Models\Blog\Event;
use Carbon\Carbon;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedSmallInteger('type')->default(\App\Models\Blog\Event::PUBLIC_EVENT);
            $table->string('uri',255)->unique();   // 页面的URI

            $table->string('title',255); // 页面的title
            $table->string('title_cn',255)->nullable(); // 中文页面的title
            $table->text('content')->nullable();

            $table->string('feature_image')->nullable(); // 代表的图片
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('teasing')->nullable();

            $table->dateTime('start')->nullable();              // 开始时间
            $table->dateTime('end')->nullable();                // 结束时间
            $table->string('location')->nullable();             // 地点
            $table->unsignedInteger('attendees_limit')->default(0);   // 参加人数上限

            $table->unsignedInteger('clicks')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        foreach (range(1,6) as $idx){
            Page::Persistent([
                'layout'=>\App\Models\Utils\ContentTool::$LAYOUT_ONE_COLUMN,
                'type'=>Page::$TYPE_BLOG,
                'title'=>'Blog title '.$idx,
                'title_cn'=>'Blog title '.$idx,
                'uri'=>'/blog-title-'.$idx,
                'content'=>'<h1>Blog title</h1>',
                'seo_keyword'=>'Blog title',
                'seo_description'=>'Blog title',
                'feature_image'=>null,
                'teasing'=>'Blog teasing '.$idx,
            ]);

            Page::Persistent([
                'layout'=>\App\Models\Utils\ContentTool::$LAYOUT_ONE_COLUMN,
                'type'=>Page::$TYPE_NEWS,
                'title'=>'News title '.$idx,
                'title_cn'=>'News title '.$idx,
                'uri'=>'/news-title-'.$idx,
                'content'=>'<h1>News title</h1>',
                'seo_keyword'=>'News title',
                'seo_description'=>'News title',
                'feature_image'=>null,
                'teasing'=>'News teasing '.$idx,
            ]);

            Event::create([
                'type'=>Event::PUBLIC_EVENT,
                'title'=>'Event title '.$idx,
                'title_cn'=>'Event title '.$idx,
                'uri'=>'/event-title-'.$idx,
                'content'=>'<h1>Event title</h1>',
                'seo_keyword'=>'Event title',
                'seo_description'=>'Event title',
                'feature_image'=>null,
                'start'=>Carbon::now(),
                'end'=>Carbon::now()->addHours(3),
                'location'=>'Somewhere in Vic Australia',
                'teasing'=>'Event teasing '.$idx,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
