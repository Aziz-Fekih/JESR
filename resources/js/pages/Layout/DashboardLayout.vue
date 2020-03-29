<template>
  <div class="wrapper">
    <!-- <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}"> -->

    <side-bar :background-color="backgroundColor" v-show="loggedIn && $route.name!='Home' 
    && $route.name!='Enregister un don'
    && $route.name!='Consulter les associations'
    && $route.name!='Consulter les Téléopérateurs' 
    && $route.name!='Consulter les demandes'"
    >    
      <!-- <mobile-menu slot="content"></mobile-menu> -->
   
      <sidebar-link to="/consulter/don" >
        <i class="tim-icons icon-gift-2"></i>
        <template >
          <p>Dons</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/acteurs">
        <i class="tim-icons icon-single-02"></i>
        <template>
          <p>Acteurs de l'etats</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/associations">
        <i class="tim-icons icon-pin"></i>
        <template >
          <p>Associations</p>
        </template>
      </sidebar-link>
       <sidebar-link to="/demandes">
        <i class="tim-icons icon-notes"></i>
        <template >
          <p>Demandes</p>
        </template>
      </sidebar-link>
    </side-bar>
    <!-- <sidebar-share :background-color.sync="backgroundColor"></sidebar-share> -->

    <div class="main-panel" :data="backgroundColor">
      <top-navbar></top-navbar>

      <dashboard-content @click.native="toggleSidebar"></dashboard-content>

      <content-footer></content-footer>
    </div>

  </div>
</template>
<style lang="scss"></style>
<script>

import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./DashboardContent.vue";
import SidebarShare from "./SidebarSharePlugin.vue";
import MobileMenu from "./MobileMenu.vue";
import SideBar from "../../components/SidebarPlugin/SideBar.vue";
import SidebarLink from "../../components/SidebarPlugin/SidebarLink.vue";



export default{
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter,
    MobileMenu,
    SideBar,
    SidebarLink,
    SidebarShare
  },
  data() {
    return {
      backgroundColor: "green"
    };
  },
  computed: {
    isRTL() {
      return this.$rtl.isRTL;
    },
    user(){
       return this.$store.getters.user
    },
    loggedIn(){
      return this.$store.getters.loggedIn;
    }
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }
  }
};
</script>
