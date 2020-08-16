<template>
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Twitter</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <router-link to="/home" href="#" class="nav-link">Home <span class="sr-only">(current)</span></router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Messages</a>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{path: '/profile/'+user_id} " class="nav-link">Profile</router-link>
                    </li>
                     <li class="nav-item">
                        <a  class="nav-link" @click="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
</template>
<script>
export default {
    props:['user_id'],
    methods:{
        logout(){
            axios.get('api/logout')
            .then((res)=> window.location.href="/")
            .catch((err)=>console.log(err));
        }
    }
}
</script>