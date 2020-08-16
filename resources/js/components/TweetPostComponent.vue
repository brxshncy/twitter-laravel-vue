<template>
    <div>
        <div class="row justify-content-center mt-4">
               <div class="col">
                   <div class="card">
                       <div class="card-header">
                           Home
                       </div>
                       <div class="card-body">
                           <div class="row justify-content-center">
                               <div class="col">
                                   <textarea class="form-control" v-model="tweet" placeholder="What's happening?" name="" rows="3"></textarea>
                               </div>
                           </div>
                           <div class="row mt-1">
                               <div class="col"></div>
                               <div class="col text-right">
                                   <button class="btn btn-info" v-on:click="postTweet()">Tweet</button>
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
    props:['userID'],
    data(){
        return{
            user_id:this.userID,
            tweet:'',
      }
    },
    mounted(){
       // console.log(this.user_id);
    },
    methods:{
        postTweet(){
            axios.post('api/home',{user_id:this.user_id,tweet:this.tweet})
            .then((res)=> this.$emit('tweetFeed'))
            .catch((err)=>console.log(err));
            this.tweet='';
        }
    }
}
</script>