<template>
<div class="mb-5">
        <div  class="row justify-content-center">
            <div class="col col-md-7">
                        <div class="card p-1">
                            <div class="card-body pb-0 pt-0">
                                <div class="row twitter-box">
                                    <div style="profile-pic">
                                        <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                                    </div>
                                    <div class="tweet-content">
                                        <small><b>{{ loadFeed.FNAME + loadFeed.LNAME }}</b></small><span> @{{ loadFeed.USERNAME }}</span>
                                        <p style="margin-bottom:0"> {{ loadFeed.TWEET }}  </p>
                                        <section class="icon mt-0 pt-0">
                                            <div class="comment">
                                                <i style="font-size:18px;" class="far fa-comment"></i>
                                            </div>
                                            <div class="retweet">
                                                <i style="font-size:18px;" class="fas fa-retweet"></i>
                                            </div>
                                             <div class="like">
                                                <i style="font-size:18px;" class="far fa-heart" ></i>
                                                <small class="ml-2"></small>
                                            </div>
                                           
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
</template>
<script>
export default {
    props:['loadFeed'],
    data(){
        return{
            likes: 0,

        }
    },
}
</script>
<style scoped>
.twitter-box{
    display:flex;
}
.twitter-box div{
    padding:7px;
}
.profile-pic{
    flex:1
}
.tweet-content{
    flex:2;
}
.icon{
    display:flex;
    justify-content: space-around;
    padding:0;
    flex-basis:70%;

}
.icon div{
    flex-direction:row;
    padding-bottom:0;
}
.comment, .retweet,.like{
    cursor:pointer;
}
.comment:hover{
    background-color: #AFEEEE;
    border-radius:25px;
    color:#00CED1;
}
.retweet:hover{
    background-color:#90EE90;
    border-radius:25px;
    color:#228B22;
}

.like:hover{
    background-color: #FA8072;
    border-radius:25px;
    color:#DC143C;
}
</style>