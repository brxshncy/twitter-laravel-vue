<template>
<div class="row mt-4">
    <div class="col col-md-9">
        <div class="card">
            <div class="card-header text-center">
                 Who to follow?
            </div>
            <div class="card-body">
                    <div class="row" v-for="user in users" v-bind:key="user.id">
                            <div class="col">
                                <div class="container-profile">
                                    <div class="img">
                                           <img :src="user.profile_pic !=null ? '/img/'+user.profile_pic : '/img/user.png'" alt="" width="60px" height="60px">
                                    </div>
                                    <div class="user-info">
                                         {{ user.fname }}  {{ user.lname }}
                                        <small>@{{ user.username }}</small>
                                        <button class="btn-outline-info btn">Follow</button> 
                                    </div> 
                                </div>                                 
                            </div>
                        <hr>
                    </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props:["user_id"],  
    created(){
        this.getTwitterUsers()
        console.log(this.user_id)
    },
    data(){
        return{
            users:[],
        }
    },
    methods:{
        getTwitterUsers(){
            axios.get(`/api/twitterUsers/${this.user_id}`)
            .then((res) => {
                this.users = res.data
                console.log(this.users);
            })
            .catch((err) => console.log(err))
        }
    }
}
</script>
<style scoped>
.container-profile{
    display:flex;
    align-items:center;
}

</style>