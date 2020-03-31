import DashboardLayout from "./pages/Layout/DashboardLayout.vue";
// import Dashboard from "./pages/Dashboard.vue";
// import Icons from "./pages/Icons.vue";
// import Maps from "./pages/Maps.vue";
// import Notifications from "./pages/Notifications.vue";
// import UserProfile from "./pages/UserProfile.vue";
// import TableList from "./pages/TableList.vue";
// import Typography from "./pages/Typography.vue";
// import UpgradeToPRO from "./pages/UpgradeToPRO.vue";
// import Test from "./pages/Test.vue";
// import Bots from "./pages/Bots.vue";
// import FAQ from "./pages/QuestionsReponse.vue";
// import Deploy from "./pages/Deploy.vue";
// import Register from "./pages/Register.vue";

import Login from "./pages/Login.vue";
import Logout from "./pages/Logout.vue";
import newDon from "./pages/projetjet/newDon.vue";
import consulterDon from "./pages/projetjet/consulterDon.vue";
import Home from "./pages/projetjet/Home.vue";
import Users from "./pages/projetjet/Users.vue";
import Association from "./pages/projetjet/Association.vue";
import frontAssociation from "./pages/projetjet/front/Association.vue";
import frontActeur from "./pages/projetjet/front/Acteur.vue";
import Teleoperateur from "./pages/projetjet/front/Teleoperateur.vue";
import Article from "./pages/projetjet/Article.vue";
import frontArticle from "./pages/projetjet/front/Article.vue";
import Profil from "./pages/projetjet/Profile.vue";

const routes = [{
    path: "/",
    component: DashboardLayout,
    redirect: "Home",
    children: [
        // {
        //     path: "dashboard",
        //     name: "Dashboard",
        //     component: Dashboard,
        //     meta: {
        //         requiresAuth: true
        //     }
        // },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                requiresVisitor: true
            }
        },
        {
            path: '/logout',
            name: 'Logout',
            component: Logout
        },
        {
            path: "don",
            name: "Enregister un don",
            component: newDon,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "acteurs",
            name: "Gérer les acteurs",
            component: Users,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/consulter/don",
            name: "Consulter les dons",
            component: consulterDon,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "Home",
            name: "Home",
            component: Home,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: '/associations',
            name: 'Associations',
            component: Association,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/demandes',
            name: 'Demandes',
            component: Article,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/consulter/associations",
            name: "Consulter les associations",
            component: frontAssociation,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/consulter/acteurs",
            name: "Consulter les acteurs",
            component: frontActeur,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/consulter/teleoperateurs",
            name: "Consulter les Téléopérateurs",
            component: Teleoperateur,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/consulter/demandes",
            name: "Consulter les demandes",
            component: frontArticle,
            meta: {
                requiresAuth: false
            }
        },

        {
            path: "profil",
            name: "Mon profil",
            component: Profil,
            meta: {
                requiresAuth: true
            }
        },

    ],


},


    {
        path: '/auth/:provider/callback',
        component: {
            template: '<div class="auth-component"></div>'
        }
    },
    {
        path: '**',
        redirect: '/'
    },
];

export default routes;
