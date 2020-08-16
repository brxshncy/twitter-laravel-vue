<template>
<div>
    <div class="card-body pb-0 pt-0 tweet-card">
                <div class="row twitter-box">
                    <div style="profile-pic">
                        <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                    </div>
                    <div class="tweet-content">
                        <small><b>{{ post.full_name }}</b></small><span> @{{ post.username}}. {{ post.date_tweet }}</span>
                        <p style="margin-bottom:0; cursor:pointer;" v-on:click="seeContent()">  {{post.tweet}} </p>
                        <section class="icon mt-0 pt-0" style="pointers-event:none;">
                            <div class="comment">
                                <i style="font-size:18px; pointers-event:none;" class="far fa-comment" data-toggle="modal" :data-target="'#tweet_id'+post.tweet_id"></i>
                                <small class="ml-2 num_comments"></small>   
                            </div>                                          
                            <div class="retweet">
                                <i style="font-size:18px;" class="fas fa-retweet" data-toggle="modal" :data-target="'#retweet'+post.tweet_id"></i>
                                <small class="ml-2 num_comments"></small> 
                            </div>
                            <div class="like">
                                <i style="font-size:18px; pointers-event:none;" class="far fa-heart"></i>
                                <small class="ml-2">{{ post.num_likes[0].likes }}</small>
                            </div>      
                        </section>
                    </div>
                </div>
    </div> 
</div>
 
</template>
<script>
export default {
    props:["post"],
}
</script>