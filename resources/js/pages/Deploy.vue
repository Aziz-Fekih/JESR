<template>
	<div class="content">
        <h3 align="left" style="color:black;">Bonjour, </h3>
		<div class="row">

			<div class="col-md-4">
				<card class="botCard floating">
                    <div class="centerBot">
					<h4 class="card-title">Deployer sur <br>Web</h4>
                    <base-button round icon type="success" @click="modals.DeployMessenger = true;">
                        <i class="tim-icons icon-tap-02"></i>
                    </base-button>
                    </div>
				</card>
			</div>
			<div class="col-md-4">
				<card class="botCard floating">
                    <div class="centerBot">
					<h4 class="card-title">Deployer sur <br>Messenger</h4>
                    <base-button round icon type="success" @click="modals.DeployMessenger = true;">
                        <i class="tim-icons icon-tap-02"></i>
                    </base-button>
                    </div>
				</card>
			</div>
            <deploy-messenger
                class="alignLeft"
                :modals="modals"

            >
            </deploy-messenger>
		</div>
	</div>
</template>
<script>
import { Card, DeployMessenger } from "../components/index";
export default {
	components: {
        Card, DeployMessenger
    },
    data(){      
      
        return{
            modals:{
                DeployMessenger: false,
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
    overflow-y: default;
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
.alignLeft{
    text-align: left;
}
.modal-content .modal-body {
    text-align: left;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
