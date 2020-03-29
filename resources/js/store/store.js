
import Axios from "axios";
export default {
    state: {
     token : localStorage.getItem('access_token') || null,
     user: localStorage.getItem('user') || null,
     bots : null,
     attributes : [],
     currentBot : localStorage.getItem('currentBot'),
     conversations : null,
     facebookPages : JSON.parse(localStorage.getItem("facebookPages") || "[]"),
     dons: JSON.parse(localStorage.getItem("dons") || "[]"),
     filtredDons: JSON.parse(localStorage.getItem("filtredDons") || "[]"),
     users: JSON.parse(localStorage.getItem("users") || "[]"),
     filtredUsers: JSON.parse(localStorage.getItem("filtredUsers") || "[]"),
     associations:  JSON.parse(localStorage.getItem("associations") || "[]"),
     filtredAssociations: JSON.parse(localStorage.getItem("filtredAssociations") || "[]"),
     articles:  JSON.parse(localStorage.getItem("articles") || "[]"),
     filtredArticles: JSON.parse(localStorage.getItem("filtredArticles") || "[]"),
     teles:  JSON.parse(localStorage.getItem("teles") || "[]"),
     filtredTele: JSON.parse(localStorage.getItem("filtredTele") || "[]"),
     lastWeekDons: [],
     apiurl:'',
     refresh: false,
     gouvernorats: [  {fr :"Ariana", ar: 'أريانة'},
     {fr :"Beja", ar: 'باجة'},
     {fr :"Ben Arous", ar: 'بن عروس'},
     {fr :"Bizerte", ar: 'بنزرت'},
     {fr :"Gabes", ar: 'قابس'},
     {fr :"Gafsa", ar: 'قفصة'},
     {fr :"Jendouba", ar: 'جندوبة'},
     {fr :"Kairouan", ar: 'القيروان'},
     {fr :"Kasserine", ar: 'القصرين'},
     {fr :"Kebili", ar: 'قبلي'},
     {fr :"Le Kef", ar: 'الكاف'},
     {fr :"Mahdia", ar: 'المهدية'},
     {fr :"La Manouba", ar: 'منوبة'},
     {fr :"Medenine", ar: 'مدنين'},
     {fr :"Monastir", ar: 'المنستير'},
     {fr :"Nabeul", ar: 'نابل'},
     {fr :"Sfax", ar: 'صفاقس'},
     {fr :"Sidi Bouzid", ar: 'سيدي بوزيد'},
     {fr :"Siliana", ar: 'سليانة'},
     {fr :"Sousse", ar: 'سوسة'},
     {fr :"Tataouine", ar: 'تطاوين'},
     {fr :"Tozeur", ar: 'توزر'},
     {fr :"Tunis", ar: 'تونس'},
     {fr :"Zaghouan",  ar: 'زغوان'},],
    },

    getters: {
        loggedIn(state){
            return state.token != null;
        },
        bots(state){
            return state.bots;
        },
        attributes(state){
            return state.attributes;
        },
        currentBot(state){
            return state.currentBot;
        },
        conversations(state){
            return state.conversations;
        },
        facebookPages(state){
            return state.facebookPages;
        },
        user(state){
            if(!state.user) {
                return {};
            }
            return JSON.parse(state.user);
        },
        dons(state){
            return state.dons;
        },
        filtredDons(state){
            return state.filtredDons;
        },
        gouvernorats(state){
            return state.gouvernorats
        },
        users(state){
            return state.users;
        },
        filtredUsers(state){
            return state.filtredUsers;
        },
        associations(state){
            return state.associations;
        },
        filtredAssociations(state){
            return state.filtredAssociations;
        },
        articles(state){
            return state.articles;
        },
        filtredArticles(state){
            return state.filtredArticles;
        },
        lastWeekDons(state){
            return state.lastWeekDons;
        },
        teles(state){
            return state.teles;
        },
        filtredTele(state){
            return state.filtredTele;
        },
        apiurl(state){
            return state.apiurl;
        },
        refresh(state){
            return state.refresh;
        }
    },
    mutations: {
        retrieveToken(state, token){
            state.token = token;
        },
        destroyToken(state){
            state.token = null;
        },
        setBots(state, bots){
            state.bots = bots;
        },
        retrieveAttributes(state, attributes){
            state.attributes = attributes;
        },
        pushAttribte(state, attribute){
            state.attributes.push(attribute);
        },
        setCurrentBot(state, bot){
            localStorage.setItem('currentBot', bot);
            state.currentBot = bot;
        },
        setConversations(state, conversations){
            state.conversations = conversations;
        },
        setPages(state, pages){
            state.facebookPages = pages;
        },
        setDons(state, dons){
            localStorage.setItem('dons', dons);
            state.dons = JSON.parse(dons || "[]");
        },
        setfiltredDons(state, dons){
            localStorage.setItem('filtredDons', dons);
            state.filtredDons = JSON.parse(dons|| "[]");
        },
        setUser(sate, user){
            sate.user = user;
        },
        setUsers(state, users){
            localStorage.setItem('users', users);
            state.users = JSON.parse(users|| "[]");
        },
        setfiltredUsers(state, users){
            localStorage.setItem('filtredUsers', users);
            state.filtredUsers = JSON.parse(users|| "[]");
        },
        setAssociations(state, associations){
            localStorage.setItem('associations', associations);
            state.associations = JSON.parse(associations|| "[]");
        },
        setFiltredAssociations(state, associations){
            localStorage.setItem('filtredAssociations', associations);
            state.filtredAssociations = JSON.parse(associations|| "[]");
        },
        setArticles(state, articles){
            localStorage.setItem('articles', articles);
            state.articles = JSON.parse(articles|| "[]");
        },
        setFiltredArticles(state, articles){
            localStorage.setItem('filtredArticles', articles);
            state.filtredArticles = JSON.parse(articles|| "[]");
        },
        setTele(state, users){
            localStorage.setItem('teles', users);
            state.teles = JSON.parse(users|| "[]");
        },
        setFiltredTele(state, users){
            localStorage.setItem('filtredTele', users);
            state.filtredTele = JSON.parse(users|| "[]");
        },

        setLastWeekDons(state, lastWeekDons){
            state.lastWeekDons = lastWeekDons;
        },
        toggleRefresh(state, refresh){
            state.refresh = refresh;
        }

    },
    actions: {
        retrieveUser(context){
            if(!context.getters.user){
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                return new Promise((resolve, reject) => {
                    Axios.get('/api/user')
                    .then(response => {
                        localStorage.setItem('user', JSON.stringify(response.data));
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error);
                    })
              })
            }
        },
        retrieveToken(context, credentials){
            return new Promise((resolve, reject) => {
                Axios.post(context.state.apiurl+'/api/login',{
                    username : credentials.username,
                    password: credentials.password
                })
                .then(response => {
                    const token = response.data.access_token;
                    localStorage.setItem('access_token', token);
                    context.commit('retrieveToken', token);
                        Axios.defaults.headers.common['Authorization'] = 'Bearer '+ token;
                        Axios.get(context.state.apiurl+'/api/user')
                        .then(response => {
                            localStorage.setItem('user', JSON.stringify(response.data));
                            context.commit('setUser', JSON.stringify(response.data));
                            resolve(response.data);
                        })
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        destroyToken(context){
            if(context.getters.loggedIn){ 
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                return new Promise((resolve, reject) => {
                    Axios.post(context.state.apiurl+'/api/logout')
                    .then(response => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        resolve(response);
                        
                    })
                    .catch(error => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        reject(error);
                    })
                })
            }
        },
        register(context, data){
            return new Promise((resolve, reject) => {
                Axios.post('/api/register',{
                    name : data.name,
                    email: data.email,
                    password: data.password
                })
                .then(response => {
                    resolve(response);
                    
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        retrieveConversations(context){
            if(context.getters.currentBot){
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                return new Promise((resolve, reject) => {
                    Axios.get('/api/getConversations',{
                        params: {
                            bot : context.getters.currentBot,
                        }
                    })
                    .then(response => {
                        context.commit('setConversations', response.data.conversations);
                        resolve(response.data.conversations);
                    })
                    .catch(error => {
                        reject(error);
                    })
              })
            }
        },
        addNewBot(context, data){
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
            return new Promise((resolve, reject) => {
                Axios.post('/api/addNewBot',{
                    nom : data.nom,
                    description: data.description,
                    categorie: data.categorie
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            })   
        },
        getBots(context){
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
            Axios.get('/api/getBots')
            .then(response => {
                context.commit('setBots', response.data.bots);
            })
        },
        retrieveAttributes(context, data){
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
            return new Promise((resolve, reject) => {
                Axios.get('/api/getAttributes',{
                    params: {
                        conversationID : 3,
                    }
                })
                .then(response => {
                    const attributes = response.data.attributes;
                    context.commit('retrieveAttributes', attributes);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        addNewConversation(context, data){
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
            return new Promise((resolve, reject) => {
                Axios.post('/api/newConversation',{
                    nom : data.newConversation.nom,
                    commentaire: data.newConversation.commentaire,
                    bot: context.getters.currentBot
                })
                .then(response => {
                    context.dispatch('retrieveConversations');
                    resolve(response.data.conversation);
                })
                .catch(error => {
                    reject(error);
                })
            })  
        },
        addNewFAQ(context, data){
            Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
            return new Promise((resolve, reject) => {
                Axios.post('/api/newFAQ',{
                    bot: context.getters.currentBot,
                    questions: data.questions,
                    reponses: data.reponses,
                    nom: data.nom,
                    
                })
                .then(response => {

                })
                .catch(error => {
                    reject(error);
                })
            })     
        },
        socialLogin(context, data){
            return new Promise((resolve, reject) => {
                Axios.post('/api/socialLogin',{
                    accessToken : data.accessToken,
                    provider: data.provider
                })
                .then(response => {
                    console.log(response);
                    const token = response.data.access_token;
                    localStorage.setItem('access_token', token);
                    context.commit('retrieveToken', token);
                    resolve(response);
                    
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getFacebookPages(context, data){
            return new Promise((resolve, reject) => {
                Axios.get('https://graph.facebook.com/2783653971689473/accounts',{
                    params: {
                        access_token: data.accessToken,
                    }
                })
                .then(response => {
                    const pages = response.data.data;
                    localStorage.setItem('facebookPages', JSON.stringify(pages));
                    context.commit('setPages', pages);
                    resolve(pages);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },

        DeployOnMessenger(context, data){
            return new Promise((resolve, reject) => {
                Axios.post('/api/deployOnMessenger',{
                    accessToken : data.accessToken,
                    pageId: data.id
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        newUser(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/register', data)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getUsers');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        updateUser(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/users/'+data.userId, data.user)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteUser(context, userId){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/users/'+ userId)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getUsers');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        newAssociation(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/association', data)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getAssociations');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        updateAssociation(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/association/'+data.associationId, data.association)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },    
        deleteAssociation(context, associationId){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/association/'+ associationId)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getAssociations');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        newDon(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/don', data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getDons(context){
            if(!context.getters.refresh || localStorage.getItem("dons") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/don')
                .then(response => {
                    
                    context.commit('setfiltredDons', JSON.stringify(response.data));
                    context.commit('setDons', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getAffectedDons(context, userId){
            if(!context.state.refresh || localStorage.getItem("dons") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/getaffecteddons/'+userId)
                .then(response => {
                    context.commit('setfiltredDons', JSON.stringify(response.data));
                    context.commit('setDons', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        
        updateEtatDon(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/don/'+data.donId,{
                    etat: data.etat
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getUsers(context){
            if(!context.state.refresh || localStorage.getItem("users") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/users')
                .then(response => {
                    
                    context.commit('setfiltredUsers', JSON.stringify(response.data));
                    context.commit('setUsers', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getActeurs(context){
            if(!context.state.refresh || localStorage.getItem("users") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/acteurs')
                .then(response => {
                    context.commit('setfiltredUsers', JSON.stringify(response.data));
                    context.commit('setUsers', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getTeleoperateurs(context){
            if(!context.state.refresh || localStorage.getItem("users") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+"/api/users?role='0'")
                .then(response => {
                    context.commit('setFiltredTele', JSON.stringify(response.data)); 
                    context.commit('setTele', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        
        getAssociations(context){
            if(!context.state.refresh || localStorage.getItem("associations") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/association')
                .then(response => {
                    context.commit('setFiltredAssociations', JSON.stringify(response.data));
                    context.commit('setAssociations', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getLastWeekDons(context){
            // if(!context.getters.dons)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/getLastWeekDons')
                .then(response => {
                    context.commit('setLastWeekDons', response.data); 
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getArticles(context){
            if(!context.state.refresh || localStorage.getItem("articles") === null)
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/article')
                .then(response => {
                    context.commit('setFiltredArticles', JSON.stringify(response.data));
                    context.commit('setArticles', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        newArticle(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/article', data)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getArticles');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        updateArticle(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/article/'+data.articleId, data.article)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },    
        deleteArticle(context, articleId){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/article/'+ articleId)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getArticles');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },

    }
};