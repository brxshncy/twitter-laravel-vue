<template>
<div class="mb-5">
    <Navbar :user_id="user_id"></Navbar>
    <h4>Welcome {{user}}</h4>
    <div class="container-fluid">
       <!-- <router-view :user_id="user_id"></router-view> -->
       <div class="row">
         <div class="col">asdas</div>
         <div class="col col-md-4">
           <router-view :user_id="user_id"></router-view>
          </div>
          <div class="col">
              <WhoToFollow :user_id="user_id"></WhoToFollow>
          </div>
       </div>
    </div>
</div>
</template>
<script>
import Navbar from './NavbarComponent';
import WhoToFollow from './WhoToFollow';
export default {
     props:['user','user_id'],
     components: {Navbar,WhoToFollow},
 
}
</script>
<style>
.lds-container{
   display:flex;
   justify-content: center;
   align-items:center;
}
.lds-dual-ring {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 0 auto;
  border-radius: 50%;
  border: 6px solid #89cff0;
  border-color: #89cff0 transparent #89cff0 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>