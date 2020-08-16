<template>
<div>
    <div  class="row justify-content-center">
        <div class="col col-md-7">
                <div class="card p-1 bg-info" style="min-height:200px;" v-if="data">
                    <div class="card-body pb-0 pt-0">
                        <div class="row twitter-box">
                            <div style="profile-pic">
                                 <img src="/img/user.png" width="50px" height="50px" class="img-thumbnail">
                            </div>
                            <div class="tweet-content">
                              <h5><b>{{ data[0].user_fullname }}</b></h5><span> @{{ data[0].user_name}}</span>
                                <h3 style="margin-bottom:0">  {{ data[0].tweet }} </h3>
                                <section class="icon mt-0 pt-0" style="pointers-event:none;">
                                    <div class="comment">
                                        <i style="font-size:18px;" class="far fa-comment" data-toggle="modal" :data-target="'#tweet_id'"></i>
                                        <small class="ml-2 num_comments">{{ data[0].num_comments }}</small>   
                                    </div>                                          
                                    <div class="retweet">
                                        <i style="font-size:18px;" class="fas fa-retweet"></i>
                                    </div>
                                    <div class="like">
                                        <i style="font-size:18px;" class="far fa-heart"></i>
                                        <small class="ml-2">{{  data[0].num_likes }}</small>
                                    </div>      
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                 <div v-for="comment in data.comment" v-bind:key="comment.comment">
                        <CommentSection v-bind:data="data" v-bind:comment="comment"/>
                </div>
        </div>
    </div>
</div>    
</template>
<script>
import CommentSection from './CommentSection';
export default {
    components:{CommentSection},
    data(){
        return{
            tweet_id:this.$route.params.tweet_id,
            tweet:{},
            user_name:null,
            data:'',
        }
    },
    created(){
        console.log(this.tweet_id);
       axios.get(`/api/tweet-content/${this.tweet_id}`)
       .then((res)=>{
           //console.log(res.data);
           this.data= res.data;
       })
       .catch((err)=>console.log(err));
      
    }
}
</script>
<style>
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
.tweet-card:hover{
   opacity:0.5;
   filter:alpha(opacity=40);
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
</style>