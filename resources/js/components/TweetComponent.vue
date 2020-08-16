<template>
<div class="">
    <div class="row justify-content-center">
        <div class="col">
            <TweetPost v-bind:userID="user_id"  v-on:tweetFeed="tweetFeed"></TweetPost>
            <div class="row justify-content-center mt-3">
                <div class="col">
                    <div class="card">
                         <div class="card-header">Feed</div>
                    </div>
                </div>             
            </div> 
            <div v-if="feeds.length > 0">
                <div v-for="feed in feeds" v-bind:key="feed.id">
                    <TweetFeed v-bind:retweets="retweets" v-on:tweetFeed="tweetFeed" v-on:comment="comment" v-bind:current_userId="user_id" v-bind:user="user" v-bind:feed="feed"></TweetFeed>
                </div>
            </div>
            <div v-else>
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <p>No recent tweets.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>         
        </div>
    </div>
 </div>
</template>
<script>
import TweetPost from './TweetPostComponent';
import TweetFeed from './TweetFeed';
import NewTweet from './NewTweet';
export default {
    props:['user','user_id'],
    components: {TweetPost,TweetFeed,NewTweet},
    data(){
        return{
            feeds:[],
            loadFeeds:'',
            retweets:[],
        }
    },
    created(){
        //this.loadTweets()
        //console.log("from tweet component: "+this.user_id)
        this.tweetFeed();
       // console.log(this.feeds);
    },
    methods: {
        comment(){
            console.log('tweet');
        },
        tweetFeed(){
            axios.get('api/home')
            .then((res) => {
                console.log(res.data);
                this.feeds = res.data;
                this.retweets = res.data.retweets;
            })
            .catch((err)=>console.log(err));
        },
    }
}
</script>
<style scoped>
.twitter-header{
    border-style: solid;
    border-color: #D3D3D3;
}
</style>