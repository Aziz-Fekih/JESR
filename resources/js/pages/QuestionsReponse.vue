<template>
	<div class="content">
        <h3 align="left" style="color:black;">Bonjour, vous avez 1 Q&R(s)</h3>
		<div class="row">

			<div class="col-md-4">
				<card class="botCard">
                    <div class="centerBot">
					<h4 class="card-title">Ajouter une nouvelle Question et Réponse</h4>
                    <base-button round icon type="success" @click="modals.newFAQModal = true;">
                        <i class="tim-icons icon-simple-add"></i>
                    </base-button>
                    </div>
				</card>
			</div>

            <!-- <div class="col-md-4"  v-for="(bot, index) in bots" :key="index">
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
			</div> -->
            <faq-modal
                class="FAQModal"
                :modals="modals"
                :questions="questions"
                :newValues="newValues"
                :FAQ="FAQ"
                :addNewFAQ="addNewFAQ"
                :addNewReponse="addNewReponse"
                :addNewQuestion="addNewQuestion"
                :reponses="reponses"
                :deleteQuestion="deleteQuestion"
                :deleteReponse="deleteReponse"
            >
            </faq-modal>
		</div>
	</div>
</template>
<script>
import { Card, FaqModal } from "../components/index";
export default {
	components: {
        Card, FaqModal
    },
    data(){      
      
        return{
            modals:{
                newFAQModal: false,
            },
            FAQ:{
                nom: '',
                description: '',
            },
            newValues:{
                newQuestion: '',
                newReponse : ''
            },

            questions:[],
            reponses:[],
            deletedQuestion: [],
            deletedReponse: []
        }
    },
    methods:{
        addNewFAQ(){
            console.log(this.bots);
                if(this.questions.length > 0 && this.reponses.length > 0 && this.FAQ.nom != "")
                this.$store.dispatch('addNewFAQ',{
                    questions: this.questions,
                    reponses: this.reponses,
                    nom: this.FAQ.nom
                })
                .then(response => {
                    this.$store.dispatch("getBots");
              
                   //Notify;
                 })
        },
        addNewQuestion(){
            if(this.newValues.newQuestion){
                this.questions.push(this.newValues.newQuestion)
                this.newValues.newQuestion = '';
            }
        },
        addNewReponse(){
            if(this.newValues.newReponse){
                this.reponses.push(this.newValues.newReponse)
                this.newValues.newReponse = '';
            }
        },
        deleteQuestion(questionIndex){
            this.questions.splice(questionIndex, 1);
            this.deletedQuestion.push(this.questions[questionIndex]);
        },
        deleteReponse(reponseIndex){
            this.reponses.splice(reponseIndex, 1);
            this.deletedReponse.push(this.reponses[reponseIndex]);
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
.FAQModal{
    text-align: left;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
