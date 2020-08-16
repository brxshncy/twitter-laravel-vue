<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Tweet;
use App\Like;
use App\Comment;
use App\Retweet;
use App\TwitterUser;
use Auth;
use DB;
use Carbon\Carbon;
class TwitterController extends Controller
{
    public function home(){
        return view('tweet-home');
    }
    public function addTweet(Request $request){
        Tweet::create($request->all());
        return(['message' => 'saved']);
    }
    public function tweetFeed(){
        $data=[];
        $tweets =   DB::table('tweets as t')
                    ->select('t.id as TWEET_ID','u.fname as FNAME','u.lname as LNAME',
                        't.tweet as TWEET','u.id as USER_ID','u.username as USERNAME','rt.caption as caption',
                        't.created_at as tweet_date','rt.created_at as retweet_date','rt.tweet_id as RT_TWEET_ID',
                        DB::raw("(SELECT CONCAT(x.fname,' ',x.lname) FROM twitter_users x where id = rt.user_id) as retweeter_fullname"),
                        DB::raw("(SELECT y.username  FROM twitter_users y where id = rt.user_id) as retweeter_username"))
                    ->leftJoin('twitter_users as u','t.user_id','=','u.id')
                    ->leftJoin('retweets as rt','rt.tweet_id','=','t.id')
                    ->orderByRaw(
                        "CASE WHEN rt.created_at < t.created_at THEN rt.created_at ELSE t.created_at END DESC"
                    )->get();
            $likes='';
            $comments='';
            $num_retweets='';
            $retweets='';
            foreach($tweets as $tweet){
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
        $data[]=
            [
                'fname' => $tweet->FNAME, 
                'lname' => $tweet->LNAME,
                'tweet' => $tweet->TWEET, 
                'comment'=> $comments,
                'likes' => $likes,
                'num_retweets' =>  $num_retweets,
                'tweet_id' => $tweet->TWEET_ID,
                'user_id' => $tweet->USER_ID, 
                'username' => $tweet->USERNAME, 
                'tweet_date' => Carbon::create($tweet->tweet_date)->diffForHumans(),
                'retweets' => 
                [ 
                    "caption" => $tweet->caption, 
                    "retweeter_fullname" => $tweet->retweeter_fullname,
                    "retweeter_username" =>$tweet->retweeter_username, 
                    "tweet" => $tweet->TWEET,
                    'RT_TWEET_ID' => $tweet->RT_TWEET_ID,
                    'retweet_date' => Carbon::create($tweet->retweet_date)->diffForHumans()
                ],
            ];
      }
        return response()->json($data);
    }
    public function mountFeeds(){
        $tweets = DB::table('tweets as t')
                ->select('t.id as TWEET_ID','u.fname as FNAME','u.lname as LNAME','t.tweet as TWEET','u.id as USER_ID','u.username as USERNAME')
                ->leftJoin('twitter_users as u','t.user_id','=','u.id')->get();
        return $tweets;
    }
    public function likeTweet(Request $request){
         $check_like = Like::where('user_id',$request->user_id)
                            ->where('tweet_id',$request->tweet_id)->count();
         if($check_like >=1){
            Like::where('user_id',$request->user_id)
                ->where('tweet_id',$request->tweet_id)->delete();
                return "dislike";
         }
         else{
            $like = Like::create($request->all());
            $num_likes = Like::groupBy('tweet_id');
            return $num_likes->count();
         }
    }
    public function getLikes(){
        $num_likes = DB::table('likes as l')
                ->select('l.tweet_id',DB::raw("count(l.tweet_id) as number_likes"),'t.tweet')
                ->leftJoin('tweets as t','l.tweet_id','=','t.id')
                ->groupBy('l.tweet_id')->get();
        return $num_likes;
    }
    public function reply(Request $request){
        Comment::create($request->all());
        return(['message' => 'Replied']);
    }
    public function tweetContent($id){
        $tweet = DB::table('tweets as t')
                ->select('t.tweet as tweet','u.username as user_name',
                DB::raw("CONCAT(u.fname,' ',u.lname) as user_fullname"),
                DB::raw("(SELECT COUNT(*) FROM comments c where c.tweet_id = t.id) as num_comments"),
                DB::raw("(SELECT COUNT(*) FROM likes l WHERE l.tweet_id = t.id) as num_likes"))
                    ->leftJoin('twitter_users as u','u.id','=','t.user_id')
                    ->where('t.id','=',$id)->get();
        $tweet['comment'] = DB::table('tweets as x')
                    ->select('y.comment as comment',DB::raw("concat(a.fname,' ',a.lname) as commenter_name,a.username as commenter_username"))
                    ->leftJoin('comments as y','y.tweet_id','=','x.id')
                    ->leftJoin('twitter_users as a','a.id','=','y.user_id')
                        ->where('x.id',$id)->get();
    return response()->json($tweet);
    }
    public function retweet(Request $request){
        if($request->isMethod('post')){
            $retweet = Retweet::create($request->all());
            return response()->json(['message' => 'Retweet']);
        }
        else{
            $retweet = DB::table('retweets as rt')
                    ->select('t.tweet as tweet','rt.caption as caption',DB::raw("CONCAT(u.fname,' ',u.lname) as retweet_name"))
                    ->leftJoin('tweets as t','t.id','=','rt.tweet_id')
                    ->leftJoin('twitter_users as u','u.id','=','rt.user_id')->get();
            return $retweet;
        }
    }
    public function profile($id){
        $data=[];
        $tweets = DB::table('tweets as t')
                    ->select('u.fname as firstname','u.lname as lastname','t.id as tweet_id','t.tweet as tweet',
                        DB::raw('CONCAT(u.fname," ",u.lname) as fullname'),'u.username as username','t.created_at as created_at')
                    ->leftJoin('twitter_users as  u','u.id','=','t.user_id')
                    ->where('u.id',$id)->get();
                $num_likes='';
                $num_comments='';
                $num_retweets='';
            foreach($tweets as $tweet){
                $likes = DB::table('likes as l')
                        ->select(DB::raw('COUNT(tweet_id) as likes'))
                        ->where('l.tweet_id','=',$tweet->tweet_id)->get();
                if(count($likes) > 0){
                    $num_likes = $likes;
                }
                else{
                    $num_likes = 0;
                }
            $data[]= [
                    'tweet_id' => $tweet->tweet_id,
                    'tweet' => $tweet->tweet,
                    'full_name' => $tweet->fullname,
                    'username' => $tweet->username,
                    'date_tweet' => Carbon::create($tweet->created_at)->diffForHumans(),
                    'num_likes' => $num_likes,
                    'firstname' => $tweet->firstname,
                    'lastname' => $tweet->lastname,
                ];
            }
        return response()->json($data);
    }
    public function profileInfo(Request $request,$id){
        if($request->isMethod('put')){
            if($request->profile_pic != null){
                $explode = explode(',',$request->profile_pic);
                $decode = base64_decode($explode[1]);
                if(str_contains($explode[0],'jpeg')){
                    $extension = 'jpg';
                }
                else{
                    $extension ='png';
                }
                $fileName = Str::random(40).'.'.$extension;
                $path = public_path().'/img/'.$fileName;
                file_put_contents($path,$decode);
            }
            else{
                $fileName = null;
            }

            $profile = TwitterUser::findorFail($id);
            $profile->fname = $request->firstname;
            $profile->lname = $request->lastname;
            $profile->address =  $request->address;
            $profile->bday = $request->bday;
            $profile->profile_pic =  $fileName;
            $profile->save();
           return "updated";
        }
        else{
            $profile = TwitterUser::findorFail($id);
            $data = [
                'full_name' => ucwords($profile->fname." ".$profile->lname),
                'address' => ucwords($profile->address),
                'contact' => $profile->contact,
                'username' => $profile->username,
                'join_at' => date("M j, Y",strtotime($profile->created_at)),
                'bday' => date("M j, Y",strtotime($profile->bday)),
                'bday_date' => $profile->bday,
                'firstname' => ucwords($profile->fname),
                'lastname' => ucwords($profile->lname),
                'user_id' => $profile->id,
                'profile_pic' => $profile->profile_pic
            ];
            return $data;
        }

    }
    public function logout(){
        Auth::guard('twitterUser')->logout();
        return redirect('/');
    }
}
