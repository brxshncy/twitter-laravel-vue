<template>
<div class="">
    <div  class="row justify-content-center">
        <div class="col">
                <div class="card p-1" v-if="feed.retweets.RT_TWEET_ID == feed.tweet_id">
                    <div class="card-body pb-0 pt-0 tweet-card">
                        <div class="row twitter-box">
                            <div style="profile-pic">
                                 <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                            </div>
                            <div class="tweet-content-v">
                                <small><b>{{ feed.retweets.retweeter_fullname }}</b></small><span> retweeted {{ feed.retweets.retweet_date }}</span>
                                <p style="margin-bottom:0; cursor:pointer;" v-on:click="seeContent()">  {{feed.retweets.caption }} </p>
                                <div class="orig-tweet-section p-3 mb-2">
                                    <small style="margin-bottom:0; cursor:pointer;"> 
                                         <b> {{ feed.fname +" "+feed.lname }} </b>  
                                        <span>@{{ feed.username }}</span>
                                    </small>
                                    <p style="margin-bottom:0; cursor:pointer;">  {{ feed.tweet }} </p>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                 <div class="card p-1">
                   <div class="card-body pb-0 pt-0 tweet-card">
                        <div class="row twitter-box">
                            <div style="profile-pic">
                                 <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                            </div>
                            <div class="tweet-content">
                                <small><b>{{ feed.fname +" "+feed.lname }}</b></small><span> @{{ feed.username}}. {{ feed.tweet_date }}</span>
                                <p style="margin-bottom:0; cursor:pointer;" v-on:click="seeContent()">  {{feed.tweet}} </p>
                                <section class="icon mt-0 pt-0" style="pointers-event:none;">
                                    <div class="comment">
                                        <i style="font-size:18px; pointers-event:none;" class="far fa-comment" data-toggle="modal" :data-target="'#tweet_id'+feed.tweet_id"></i>
                                        <small class="ml-2 num_comments">{{ feed.comment[0].num_comments }}</small>   
                                    </div>                                          
                                    <div class="retweet">
                                        <i style="font-size:18px;" class="fas fa-retweet" data-toggle="modal" :data-target="'#retweet'+feed.tweet_id"></i>
                                        <small class="ml-2 num_comments">{{ feed.num_retweets[0].num_retweets }}</small> 
                                    </div>
                                    <div class="like">
                                        <i style="font-size:18px; pointers-event:none;" class="far fa-heart" @click="handleClick"></i>
                                        <small class="ml-2">{{  feed.likes[0].num_likes }}</small>
                                    </div>      
                                </section>
                            </div>
                        </div>
                    </div> 
            </div>
        </div>
    </div>
        <div class="modal fade" :id="'tweet_id'+feed.tweet_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> 
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </h5>
                        </div>
                        <div class="modal-body">
                           <div class="row twitter-box">
                                <div style="profile-pic">
                                    <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                                </div>
                                <div class="tweet-content">
                                    <small><b>{{ feed.fname +" "+feed.lname}}</b></small><span> @{{ feed.username}}</span>
                                    <p style="margin-bottom:0">  {{feed.tweet}} </p>
                                </div> 
                           </div>
                           <div class="row reply-to-content">
                               <div class="name-space">
                                 <!--<div class="vl"></div>-->
                               </div>
                               <div class="reply-to p-2">
                                  Replying to  @{{feed.username}}
                               </div>
                           </div>
                           <div class="row twitter-reply p-2">
                               <div class="gap">
                                    
                               </div>
                               <div class="reply-content">
                                   <textarea name="" id="" v-model="tweet_reply" rows="4" class="form-control tweet-text-area"  placeholder="Tweet your reply..."></textarea>
                               </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" v-on:click="reply()">Reply</button>
                        </div>
                        </div>
                    </div>
                </div>
        <div class="retweetmodal modal fade" :id="'retweet'+feed.tweet_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> 
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="caption">
                                        <div class="retweeter-profile-pic">
                                            <img src="/img/user.png" style="border-radius:50%;" width="50px" height="50px" class="img-thumbnail">
                                         </div>
                                        <div class="retweeter-comment">
                                            <textarea style="border:none;" v-model="retweet_caption" placeholder="Add a comment" rows="4" class="form-control retweet-text"></textarea>
                                            <div class="tweet-check">
                                                <div class="poster-header">
                                                    <img src="/img/user.png"  style="border-radius:50%;" width="30px" height="30px" class="img-thumbnail">
                                                    <b>{{feed.fname+" "+feed.lname}}</b> @{{feed.username}}
                                                </div>
                                                <div class="post">
                                                    {{ feed.tweet }}
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" v-on:click="retweet()">Retweet</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="lds-container">
                     <div class="lds-dual-ring" v-if="loading">  </div>
                </div>
           </div>
</template>
<script>
export default {
    props:['user','feed','current_userId','loadFeed','retweets'],
    data(){
        return{
            likes: 0,
            user_id: this.current_userId,
            tweet_id: this.feed.tweet_id,
            tweet_reply:'',
            retweet_caption:'',
            loading:false,
        }
    },
    mounted(){
         /*  axios.get('api/likee',{user_id:this.current_userId,tweet_id:this.tweet_id})
           .then((res)=> {
               console.log(JSON.stringify(res.data))
               //this.likes = res.data
            })
           .catch((err)=>console.log(err))*/
    },
    methods:{
        handleClick(){
           axios.post('api/like',{user_id:this.current_userId,tweet_id:this.feed.tweet_id})
           .then((res) =>{ 
             
               this.likes = res.data
               this.$emit('tweetFeed');
            })
           .catch((err)=>console.log(err))
        },
        reply(){
             axios.post('api/reply',{user_id:this.current_userId,tweet_id:this.feed.tweet_id,comment:this.tweet_reply})
            .then((res)=>{
                this.loading = true,
                $('#tweet_id'+this.feed.tweet_id).hide();
                $(document.body).removeClass('modal-open');
                $('.modal-backdrop').remove();
            })
            .catch((err)=>console.log(err))
            .finally(()=>{
                setInterval(()=>{
                    this.loading=false;
                },1500);
                this.$emit('tweetFeed');
            });
        },
        seeContent(e){
            this.$router.push('tweet-content/'+this.tweet_id);
        },
        retweet(){
            axios.post('api/retweet',{
                user_id:this.current_userId,
                tweet_id:this.feed.tweet_id,
                caption:this.retweet_caption
            })
            .then((res)=>{
                this.loading = true,
                $('#retweet'+this.feed.tweet_id).hide();
                $(document.body).removeClass('modal-open');
                $('.modal-backdrop').remove();
                console.log(res.data)
            })
            .catch((err)=>console.log(err))
            .finally(()=>{
                setInterval(()=>{
                    this.loading=false;
                },1500);
                this.$emit('tweetFeed');
            });
        }
    }
}
</script>
<style scoped>

*:focus{
    outline:none;
}
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
.tweet-content-v{
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
.orig-tweet-section{
    border:1px solid #ccc;
    border-radius:25px;
    padding:50px;
    display:flex;
    flex-direction:column;
    justify-content: space-between;
    margin-top: 5px;
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
    border-radius:50px;
    color:#228B22;
}
.like:hover{
    background-color: #FA8072;
    border-radius:25px;
    color:#DC143C;
}
.twitter-reply{
     display:flex;
     padding:5px;
 }
.reply-content{
     flex:2;
     border:1px solid #ccc;
     flex-basis:70%;
 }
.gap{
    flex:1;
}
.reply-to-content{
    display:flex;
}
.name-space{
    flex:1;
   margin:auto;
}
.reply-to{
    flex:2;
    flex-basis:70%;
}
.vl {
  border-left: 6px solid green;
  height: 39px;
}
.tweet-text-area{
    border:none;
    outline:none;
    overflow:auto;
    border-color:Transparent;
}
.caption{
    display:flex;
    flex-direction: row;
    justify-content: space-between;
}
.retweeter-profile-pic{
    flex:1
}
.retweeter-comment{
    flex:2;
    flex-basis:70%;
    padding:10px;
}
.retweet-text:focus{
    outline:0px !important;
    -webkit-appearance:none;
    box-shadow: none !important;
}
.tweet-check{
    border:1px solid #ccc;
    padding:10px;
    border-radius:25px;
}
</style>