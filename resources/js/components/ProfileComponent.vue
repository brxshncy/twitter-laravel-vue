<template>
    <div>
        <div class="row justify-content-center" v-if="profileUpdate">
            <div class="col">
                <div class="alert alert-info text-center">
                    <small>Profile Updated successfully!</small>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <div class="profile-box">
                            <div class="circular">
                                 <img :src="profile.profile_pic !== null ? '/img/'+profile.profile_pic : '/img/user.png' " 
                                 class="img-thumbnail profile_pic">
                            </div>
                            <div class="edit-btn">
                                 <button class="btn btn-outline-info edit_btn" data-toggle="modal" data-target="#edit-profile">Edit Profile</button>
                            </div> 
                        </div>
                        <hr>
                        <div class="profile-name-info">
                            <div class="name">
                                <b>{{ profile.full_name }}</b>
                            </div>
                            <div class="username">
                                @{{ profile.username }}
                            </div>
                        </div>
                        <div class="date-info mt-2">
                            <div class="address">
                              <i class="fas fa-map-marker-alt mr-1"></i>   {{ profile.address }}
                            </div>
                            <div class="bdate">
                               <i class="fas fa-birthday-cake mr-1"></i> Born {{ profile.bday }}
                            </div>
                            <div class="join_at">
                               <i class="fas fa-calendar-day mr-1"></i> Joined {{ profile.join_at }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" v-if="posts.length > 0">
            <div class="col">
                <div class="card p-1" v-for="post in posts" v-bind:key="post.tweet_id">
                    <ProfileTweets v-bind:post="post"></ProfileTweets>
                </div>     
            </div>
        </div>
        <div class="row justify-content-center" v-else>
            <div class="col col-md-7">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5>No recent tweets.</h5>
                            </div>
                        </div>
                    </div> 
                </div>     
            </div>
        </div>
<div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="profile-box1">
                        <div class="prof-pic">
                            <img :src="profile.profile_pic !==null ? '/img/'+profile.profile_pic: '/img/user.png'" class="img-thumbnail">
                        </div>
                        <div class="edit-btn">
                            <input type="file" @change="ProfileUpload">
                        </div> 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" v-model="profileFirstName">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input type="text"  class="form-control" v-model="profileLastName">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Location</label>
                                <input type="text" class="form-control" v-model="profile_address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Birthdate</label>
                                <input type="date" class="form-control" v-model="profile_bday">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="editProfile(profile.user_id)">Edit</button>
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
import ProfileTweets from './ProfileTweets';
export default {
 components:{ProfileTweets},
  created(){
      this.getPosts();
      this.getProfile();
      this.profile_fullname = this.profile;
  },
  data(){
      return{
          user_id: this.$route.params.user_id,
          posts:[],
          profile:'',
          profileFirstName:'',
          profileLastName:'',
          profile_address:'',
          profile_bday:'',
          loading:false,
          profileUpdate:false,
          profile_pic:'',
         // profile_fullname: this.profile.full_name,
      }
  },
methods:{
        getPosts(){
            axios.get(`/api/profile/${this.user_id}`)
            .then((res) => {
                this.posts = res.data;
            })
            .catch((err) => console.log(err));
        },
        getProfile(){
            axios.get(`/api/profile_info/${this.user_id}`)
            .then((res) => {
                this.profile = res.data;
                console.log(res.data);
                this.profileFirstName = res.data.firstname;
                this.profileLastName = res.data.lastname;
                this.profile_address = res.data.address;
                this.profile_bday = res.data.bday_date;
            })
            .catch((err) => console.log(err));
        },
        editProfile(userId){
           axios.put(`/api/profile_info/${this.user_id}`,{
               firstname: this.profileFirstName,
               lastname: this.profileLastName,
               address: this.profile_address,
               bday: this.profile_bday,
               profile_pic: this.profile_pic,
            })
           .then((res) => {
               console.log(res.data);
               this.getProfile();
               this.loading = true;
               this.profileUpdate = true;
               $('#edit-profile').hide();
               $('.modal-backdrop').remove();
            })
           .catch(err => console.log(err))
           .finally(() => {
               setInterval(()=>{
                   this.loading = false;  
               },1000)
               setInterval(()=>{
                    this.profileUpdate = false;
               },2500)
           })
        },
        ProfileUpload(e){
            console.log(e.target.files[0]);
            let fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) => {
               this.profile_pic = e.target.result;
            }
        }
    }
}
</script>
<style scoped>
.profile-box{
    display:flex;
    align-items:flex-end;
    justify-content: space-between;
}
.edit_btn{
    border-radius:24px;
}
.date-info{
    display:flex;
    justify-content: space-between;
    width:450px;
}
.profile-box1{
    display:flex;
    align-items:flex-end;
    justify-content: space-between;
}
.circular{
    width: 120px;
    height: 120px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    overflow:hidden;
    border:2px solid black;
}
.circular img{
  height: 100%;
  width: 100%;
  object-fit: cover;
}
</style>