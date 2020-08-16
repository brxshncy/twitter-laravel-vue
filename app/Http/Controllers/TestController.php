<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function tweetFeed(){
        $data=[];
        $tweets['tweet'] = DB::table('tweets as t')
                        ->select('t.id as TWEET_ID',DB::raw('CONCAT(u.fname," ",u.lname )as tweet_poster'),
                            't.tweet as TWEET','u.id as USER_ID','u.username as USERNAME',
                            't.created_at as tweet_date',)
                        ->leftJoin('twitter_users as u','t.user_id','=','u.id')
                        ->orderBy('t.created_at')->get();
                        
        $tweets['retweets']  = DB::table('retweets as rt')
                            ->select('t.tweet','rt.caption', 'rt.id as RETWEET_ID',
                                'u.username as tweeter_username','x.username as retweeter_username',
                                DB::raw('CONCAT(u.fname," ",u.lname) as tweeter_poster'),
                                DB::raw('CONCAT(x.fname," ",x.lname) as retweeter_name'),'rt.created_at as retweeted_date')
                            ->leftJoin('tweets as t','t.id','=','rt.tweet_id')
                            ->leftJoin('twitter_users as u','u.id','=','t.user_id')
                            ->leftJoin('twitter_users as x','x.id','=','rt.user_id')
                            ->orderBy('rt.created_at')
                            ->get();
            $likes='';
            $comments='';
            $num_retweets='';
            foreach($tweets['tweet'] as $tweet){
                $num_likes = DB::table('likes as l')
                            ->select(DB::raw('count(tweet_id) as num_likes'))->where('tweet_id',$tweet->TWEET_ID)->get();
                $comment = DB::table('comments as c')
                           ->select(DB::raw('count(comment) as num_comments, c.comment as comment'))->where('tweet_id',$tweet->TWEET_ID)->get();
                $retweet = DB::table('retweets as rt')
                            ->select(DB::raw('count(tweet_id) as num_retweets'))->where('tweet_id',$tweet->TWEET_ID)->get();

            if(count($num_likes) > 0){
                    $likes = $num_likes;
            }
            else{
                     $likes= 0;
            }
            if(count($comment) > 0){
                    $comments = $comment;
            }
            else{
                    $comments = 0;
            }
            if(count($retweet) > 0 ){
                $num_retweets = $retweet;
            }
            else{
                $num_retweets = 0;
            }
            $tweet->num_likes = $likes;
            $tweet->num_comments = $comments;
            $tweet->num_retweets = $num_retweets;
      }
        return response()->json($tweets);
    }
}
