<template>
  <nav class="navbar navbar-expand-lg navbar-absolute"
       :class="{'bg-white': showMenu, 'navbar-transparent': !showMenu}">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle d-none" :class="{toggled: $sidebar.showSidebar}">
          <button type="button"
                  class="navbar-toggler"
                  @click="toggleSidebar">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
    <a class="navbar-brand" href="javascript:void(0)">   <router-link :to="'/home?ar='+ar">  <img style='width: 80px;' src='/images/logo.png' /></router-link></a>
      </div>
      <button class="navbar-toggler" type="button"
              @click="toggleMenu"
              data-toggle="collapse"
              data-target="#navigation"
              aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse show text-left" v-show="showMenu">
        <ul class="navbar-nav" :class="$rtl.isRTL ? 'mr-auto' : 'ml-auto'">
          <!-- <li class="search-bar input-group"  @click="searchModalVisible = true">
            <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split"></i>
              <span class="d-lg-none d-md-block">Search</span>
            </button>
          </li>
          <modal :show.sync="searchModalVisible"
                 class="modal-search"
                 id="searchModal"
                 :centered="false"
                 :show-close="true">
            <input slot="header" v-model="searchQuery" type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
          </modal> -->

          <drop-down  v-if="!loggedIn">
             <router-link :to="'/don?ar='+ar">
              <base-button type="warning" fill >{{!ar ?'Faire un don' : 'التبرع'}}</base-button>
               </router-link>
          </drop-down>
         <drop-down  v-if="!loggedIn">
             <router-link :to="'/home?ar='+ar">
              <a href="javascript:void(0)" style="color: black;" class="nav-link">{{!ar ?'Accueil' : 'الاستقبال'}}</a>
               </router-link>
          </drop-down>
         <drop-down  v-if="!loggedIn">
             <router-link :to="'/consulter/associations?ar='+ar">
                <a href="javascript:void(0)" style="color: black;" class="nav-link">{{!ar ?'Associations&nbsp;partenaires' : ' المنظمات&nbsp;و&nbsp;الجمعيات&nbsp;الشريكة'}}</a>
               </router-link>
          </drop-down>
         <drop-down  v-if="!loggedIn&&false">
             <router-link :to="'/consulter/acteurs?ar='+ar">
              <a href="javascript:void(0)" style="color: black;" class="nav-link">{{!ar ?'Acteurs&nbsp;etat' : 'قائمة&nbsp;الجهات&nbsp;الحكومية'}}</a>
               </router-link>
          </drop-down>
         <drop-down  v-if="!loggedIn">
             <router-link :to="'/consulter/teleoperateurs?ar='+ar">
              <a href="javascript:void(0)" style="color: black;" class="nav-link">{{!ar ? "Bénévoles Assitants" : 'متطوعون&nbsp;لارشادك'}}</a>
               </router-link>
          </drop-down>
          <drop-down  v-if="loggedIn">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="../../assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>

                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><router-link to="/consulter/don"><a href="javascript:void(0)" class="nav-item dropdown-item">Dashboard</a></router-link></li>
                  <li class="nav-link"><router-link to="/profil"><a href="javascript:void(0)" class="nav-item dropdown-item">Changer<br>Mot de passe</a></router-link></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><router-link to="/logout"><a href="javascript:void(0)" class="nav-item dropdown-item">Log out</a></router-link></li>
                </ul>
              </drop-down>

         <drop-down  v-if="!loggedIn">
             <router-link :to="this.$route.path">
              <a href="javascript:void(0)" style="color: black;" class="nav-link">Français</a>
               </router-link>
          </drop-down>
         <drop-down  v-if="!loggedIn">
             <router-link :to="this.$route.path+'?ar=true'">
              <a href="javascript:void(0)" style="color: black;" class="nav-link">العربية</a>
               </router-link>
          </drop-down>

        </ul>
      </div>
    </div>
  </nav>
</template>
<script>

import DropDown from "../../components/Dropdown.vue";
import Modal from "../../components/Modal.vue";
import {
  SidebarPlugin
} from "../../components/index";

  export default{
    components:{
      DropDown,
      Modal,
      SidebarPlugin
    },
    data() {
      return {
        searchModalVisible: false,
        searchQuery: '',
        showMenu: false,
      };
    },
    methods:{
      toggleSidebar(){
        this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
      },
      toggleMenu(){
        this.showMenu  = !this.showMenu;
      }
    },
    computed:{
      isRTL() {
        return this.$rtl.isRTL;
      },
      ar() {
          if(this.$route.query.ar)
            return this.$route.query.ar
          return '';
       },
      loggedIn(){
      return this.$store.getters.loggedIn;
    }
    }
  }
</script>
<style>
</style>
