<?php

use Illuminate\Support\Facades\Route;
use App\Tweet;
use App\Like;
use Carbon\Carbon;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/','RegisterController@login')->name('user-login');
Route::get('/register',function(){
    return view('register');
});
Route::post('/register','RegisterController@register')->name('register');
Route::group(['middleware' => ['twitterUser']],function(){
    route::get('{any}','TwitterController@home')->name('tweet-feed')->where('any','.*');
});
Route::get('test',function(){
    $data=[];
    /*DB::table('tweets as t')
    ->select('t.tweet as tweet',DB::raw("count(distinct l.tweet_id) as num_likes,count(c.tweet_id) as num_comments, CONCAT(u.fname,' ',u.lname) as user_fullname"))
    ->leftJoin('comments as c','c.tweet_id','=','t.id')
    ->leftJoin('likes as l','l.tweet_id','=','t.id')
    ->leftJoin('twitter_users as u','u.id','=','t.user_id')
    ->groupBy('t.tweet')
    ->where('t.id',75)->get();*/

   /* $tweet = DB::table('tweets as t')
            ->select('t.tweet as tweet',
            DB::raw("CONCAT(u.fname,' ',u.lname) as user_fullname"),
            DB::raw("(SELECT COUNT(*) FROM comments c where c.tweet_id = t.id) as num_comments"),
            DB::raw("(SELECT COUNT(*) FROM likes l WHERE l.tweet_id = t.id) as num_likes")
            )
        ->leftJoin('twitter_users as u','u.id','=','t.user_id')
        ->where('t.id','=',75)->get();
    
    /*$tweet['comment'] = DB::table('tweets as x')
                      ->select('y.comment as comment',DB::raw("concat(a.fname,' ',a.lname) as commenter_name"))
                      ->leftJoin('comments as y','y.tweet_id','=','x.id')
                      ->leftJoin('twitter_users as a','a.id','=','y.user_id')
                      ->where('x.id',75)->get();*/

    $tweet['tweets'] =  DB::table('tweets as t')
                        ->select('t.id as TWEET_ID',DB::raw('CONCAT(u.fname," ",u.lname )as tweet_poster'),
                            't.tweet as TWEET','u.id as USER_ID','u.username as USERNAME',
                            't.created_at as tweet_date',)
                        ->leftJoin('twitter_users as u','t.user_id','=','u.id')
                        ->orderBy('t.created_at')->get();
                        
    $tweet['retweets'] = DB::table('retweets as rt')
                      ->select('t.tweet','rt.caption',
                            'u.username as tweeter_username','x.username as retweeter_username',
                            DB::raw('CONCAT(u.fname," ",u.lname) as tweeter_poster'),
                            DB::raw('CONCAT(x.fname," ",x.lname) as retweeter_name'),'rt.created_at as retweeted_datet')
                      ->leftJoin('tweets as t','t.id','=','rt.tweet_id')
                      ->leftJoin('twitter_users as u','u.id','=','t.user_id')
                      ->leftJoin('twitter_users as x','x.id','=','rt.user_id')
                      ->get();
  foreach($tweet['tweets'] as $tweet){
      $tweet_date = Carbon::create($tweet->tweet_date)->diffForHumans();
      echo $tweet_date."<br>";
  }
});
