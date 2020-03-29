<template>
	<div class="content">
        <h3 align="left" style="color:black;">Bonjour, vous avez 1 bot(s)</h3>
		<div class="row">

			<div class="col-md-4">
				<card class="botCard">
                    <div class="centerBot">
					<h4 class="card-title">Créer un nouveau Bot</h4>
                    <base-button round icon type="success" @click="modals.newBotModal = true;">
                        <i class="tim-icons icon-simple-add"></i>
                    </base-button>
                    </div>
				</card>
			</div>

            <div class="col-md-4"  v-for="(bot, index) in bots" :key="index">
                <card class="botCard" type="tasks">
                    <template slot="header">
                    <drop-down tag="div">
                        <button aria-label="Settings menu" data-toggle="dropdown" class="dropdown-toggle btn-rotate btn btn-link btn-icon">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a href="#pablo" class="dropdown-item">Statistique</a>
                            <a href="#pablo" class="dropdown-item">Configurer</a>
                            <a href="#pablo" class="dropdown-item">Supprimer</a>
                        </ul>
                        </drop-down>
                    </template>
                    <h4 class="card-title">{{bot.name}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{bot.categorie}}</h6>
                    <p class="card-text">{{bot.description}}</p>
                    <a href="#" v-on:click.prevent="openConversations(bot.id)" class="card-link">Conversations</a>
                    <a href="#" class="card-link">Questions & Réponses</a>
                </card>
			</div>
            <bot-modal
            :modals="modals"
            :categories="categories"
            :newBot="newBot"
            :addNewBot="addNewBot"
            >
            </bot-modal>
		</div>
	</div>
</template>
<script>
import { Card, BotModal } from "../components/index";
export default {
	components: {
        Card, BotModal
    },
    data(){
        return{
            modals:{
                newBotModal: false,
            },
            newBot:{
                nom: '',
                description: '',
                categorie: 'Personnel'
            },
            categories:[
                'Constumer Support',
                'E-commerce/Shopping',
                'Education',
                'Entertainment',
                'Marketing',
                'Travel',
                'Finance',
                'Games',
                'HR',
                'News',
                'Personnel',
                'Sports',
                'Autre'
            ]
        }
    },
    methods:{
        addNewBot(){
            console.log(this.bots);
            if(this.newBot.nom)
                this.$store.dispatch('addNewBot',{
                    nom : this.newBot.nom,
                    description: this.newBot.description,
                    categorie: this.newBot.categorie
                })
                .then(response => {
                    this.$store.dispatch("getBots");
                   this.modals.newBotModal = false;
                   //Notify;
                 })
        },
        openConversations(bot){
            this.$store.commit('setCurrentBot', bot);
            this.$router.push('/test');
        }
    },
    computed:{
      bots(){
        return this.$store.getters.bots;
      },
    },
    mounted(){
        this.$store.dispatch("getBots");
    } 
};
</script>
<style scoped>
.botCard{
    max-height: 300px;
    overflow-y: scroll;
}
.centerBot{
    padding: 25%;
}
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  border-radius: 0;
}

::-webkit-scrollbar-thumb {
  margin: 2px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.2);
}
</style>
