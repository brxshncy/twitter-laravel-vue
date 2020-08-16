<template>
    <div class="card p-1 bg-info">
        <div class="card-body pb-0 pt-0 tweet-card"  style="cursor:pointer;">
            <div class="row twitter-box">
                <div style="profile-pic">
                    <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                </div>
                <div class="tweet-content">
                    <small><b>{{ comment.comment_name }}</b></small><span> @{{ comment.commenter_username}} replying to @{{ data[0].user_name }}</span>
                    <p style="margin-bottom:0">  {{comment.comment}} </p>
                <section class="icon mt-0 pt-0" style="pointers-event:none;">
                    <div class="comment">
                            <i style="font-size:18px;" class="far fa-comment" data-toggle="modal" :data-target="'#tweet_id'"></i>
                            <small class="ml-2 num_comments"></small>   
                    </div>                                          
                    <div class="retweet">
                            <i style="font-size:18px;" class="fas fa-retweet"></i>
                    </div>
                    <div class="like">
                            <i style="font-size:18px;" class="far fa-heart"></i>
                            <small class="ml-2"></small>
                    </div>      
                </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:["comment","data"],
    created(){
       // console.log(this.data);
    }
}
</script>