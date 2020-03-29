<template>
	<div class="content">
		<card>
		<template>
			<Slide>
			 <h4>Conversations</h4>
			<hr>
			<span v-for="(conversation, index) in conversations" :key="index">
				<a href="#" v-on:click.prevent="currentConversation = conversation">
					<i class="tim-icons icon-sound-wave"></i>
					<span class="text-muted">{{conversation.name}}</span>
				</a>
			</span>
			<span>
			<base-button round type="primary" @click="modals.newConversationModal = true">
				<i class="tim-icons icon-simple-add" style="margin-top: -3px;"></i> Nouvelle Conversation
			</base-button>
			</span>
			</Slide>
		</template>


			<template slot="header">
				<h5 class="title">{{currentConversation.name}}</h5>
				<p class="category">
				</p>
			</template>

			<!-- Choix du type du Noeud Modal -->
			<template>
								<base-button
					type="primary"
					@click="openSideBar"
					
				>
					Conversations
				</base-button>
				<base-button
					type="primary"
					@click="modals.actionModal = true"
					
				>
					Ajouter un nouveau Noeud
				</base-button>
				<modal :show.sync="modals.actionModal" centered modalClasses="modal-lg">
					<template slot="header">
						<h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau Noeud</h5>
					</template>
					<div class="row">
						<div
							v-for="(action, index) in actions"
							:key="index"
							class="font-icon-list col-lg-4 col-md-4 col-sm-4 col-xs-6 col-xs-6"
						>
							<div class="font-icon-detail" @click="handle_function_call(action.function)">
								<i class="tim-icons" :class="[`${action.icon}`]"></i>
								<p>{{action.description}}</p>
							</div>
						</div>
					</div>
					<template slot="footer">
						<base-button type="secondary" @click="modals.actionModal = false"
							>Annuler</base-button
						>
						
					</template>
				</modal>
			</template>

			<!-- Configuration d'un nouveau Message Modal -->
			<!-- <template>
				<modal :show.sync="modals.newMessageModal">
					<template slot="header">
						<input v-model="newNodeTitle" class="modalTitle" id="exampleModalLabel" />
					</template>
					<div class="row">
						<div class="col-md-12">
							<p>Saisissez votre message à envoyer ici</p>
						</div>
						<div class="col-md-12">
							<textarea
								v-model="messageContent"
								name=""
								id=""
								cols="60"
								rows="5"
								placeholder="Saisissez votre message à envoyer ici"
							></textarea>
						</div>
					</div>
					<template slot="footer">
						<base-button type="secondary" @click="modals.newMessageModal = false"
							>Annuler</base-button
						>
						<base-button type="primary" @click="addNode(0)">Enregistrer</base-button>
					</template>
				</modal>
			</template> -->

			<!-- Personnalsiation d'un Noeud Modal -->
			<Message-Modal
				:newNodeConfig="newNodeConfig"
				:optionsData="optionsData"
				:modals="modals"
				:addNewOption="addNewOption"
				:removeOption="removeOption"
				:updateMessage="updateMessage"
			></Message-Modal>

			<Request-Message-Modal
				:newMessageRequestConfig="newMessageRequestConfig"
				:modals="modals"
				:addNewOption="addNewOption"
				:updateMessage="updateMessage"
				:validationTypes="validationTypes"
				:actionButtonRequestMessage="actionButtonRequestMessage"
				:storedAttributes="storedAttributes"
			></Request-Message-Modal>

			<image-modal
				:newImageConfig="newImageConfig"
				:modals="modals"
				:saveImage="saveImage"
			></image-modal>

			<conversation-modal
				:newConversation="newConversation"
				:modals="modals"
				:addNewConversation="addNewConversation"
			></conversation-modal>

			<div class="reteContainer">
				<div id="rete" class="node-editor"></div>
			</div>
			<button @click="this.add">Add</button>
			<button @click="this.addNode">Add Node</button>
			<button @click="this.change">Change Name</button>
			<button @click="this.submit">Send</button>
			<button type="primary" block @click="notifyVue('top', 'right')">
				Top Left
			</button>
		</card>
	</div>
</template>

<script>
import { Slide } from 'vue-burger-menu'
import { createFlowEditor } from "../editor.js";
import {
	addButton,
	newNode,
	changeName,
	changeContent,
	updateNode,
	editor,
	nbNodes,
	updateRequestMsgNode,
	newRequestMsgNode,
	newImageNode,

} from "../editor.js";
import {
	Card,
	Modal,
	MessageModal,
	RequestMessageModal,
	ImageModal,
	ConversationModal
	// PassportClients,
	// PassportAuthorizedClients,
	// PassportPersonalAccessTokens
} from "../components/index";
import NotificationTemplate from "./Notifications/NotificationTemplate";
import BaseTable from "../components/BaseTable";
import draggable from "vuedraggable";
export default {
	components: {
		Card,
		Modal,
		BaseTable,
		draggable,
		MessageModal,
		RequestMessageModal,
		ImageModal,
		Slide,
		ConversationModal
		// PassportClients,
		// PassportAuthorizedClients,
		// PassportPersonalAccessTokens
	},
	data() {
		return {
			modals: {
				actionModal: false,
				newMessageModal: false,
				configNodeModal: false,
				requestMessageModal: false,
				imageModal: false,
				newConversationModal: false
			},
			newConversation :{
				nom : '',
				commentaire: ''
			},
			actions: [	{
							icon : "icon-simple-add",
							function : "openNewMessageModal",
							description: "Ajouter un simple Message"
						},
						{
							icon : "icon-key-25",
							function : "openNewMessageRequestModal",
							description: "Demander des données de l'utilisateur"
						},
						{
							icon : "icon-image-02",
							function : "openImageModal",
							description: "Envoyer une image"
						}
			],
			type: ["", "info", "success", "warning", "danger"],
			notifications: {
				topCenter: false
			},
			messageContent: "",
			newNodeTitle: "Nouveau Message ",
			selectedNode: null,
			newNodeConfig: {
				text: "",
				title: "Nouveau Message ",
				type: 'message'
			},
			newMessageRequestConfig: {
				title: "Demande de données ",
				text: "",
				keyRequest: "",
				typeRequest: "text",
				validationMessage: "",
				type: "request_message",
			},
			optionsData: [
				// {
				// 	title: "",
				// 	value: "",
				// 	key: -1,
				// 	order: 0
				// }
			],
			deletedOptions: [],
			nbOptions: 1,
			dragging: false,
			validationTypes: ["text", "email", "number", "phone"],
			action: "create",
			storedAttributes :[],
			oldAttribute: "",
			newImageConfig:{
				title: "Envoyer une image ",
				text : null,
				type: "image",
				imgId: null,
				file : null
			},
			images : [],
			imagesId :[],
			nbImages : 0,
			currentConversation : {name : 'Default'},
		};
	},
	methods: {
		openSideBar(){
			document.getElementsByClassName('bm-menu')[0].style.width ="300px";
		},
		add() {
			addButton(0, "A button");
			this.modals.newMessageModal = false;
		},
		change() {
			changeName(0, 2, "A test");
		},
		handle_function_call(function_name) {
			this[function_name]();
		},
		addNewNode(typeNode){
			switch (typeNode) {
				case 0: // Si Node à ajouter est de type Message Normal
					if(this.newNodeConfig.text){
						
						this.modals.configNodeModal = false;
						newNode(0, this.newNodeConfig, this.optionsData, this.deletedOptions);
							
					}else{
						//Notifier
					}
					break;
				case 1: // Si Node à ajouter est de type Message avec request
					if (
						this.newMessageRequestConfig.text &&
						this.newMessageRequestConfig.keyRequest &&
						(this.newMessageRequestConfig.validationMessage || (this.newMessageRequestConfig.typeRequest == 'text'))
					) {
						
						// this.$store.commit('pushAttribte', this.newMessageRequestConfig.keyRequest);
						this.storedAttributes.push(this.newMessageRequestConfig.keyRequest);
						this.modals.requestMessageModal = false;
						newRequestMsgNode(typeNodeNode, this.newMessageRequestConfig)
							.then(() => {
								this.resetMessageRequestConfig();
							});
					} else {
						this.notifyVue(
							"top",
							"right",
							4,
							"Veuillez préciser le message à envoyer!"
						);
					}
					break;
				case 2: // Si Node à ajouter est de type Image
					if(this.newImageConfig.text)
					newImageNode(typeNode, this.newImageConfig);
					break;
			}
			this.updateDblClickEvent();
		},
		addNode(typeNode) {
			if (typeNode == 0) {
				if (this.messageContent) {
					this.modals.newMessageModal = false;
					newNode(0, this.messageContent, this.newNodeTitle);

				} else {
				}
			} else if (typeNode == 1) {
				if (
					this.newMessageRequestConfig.text &&
					this.newMessageRequestConfig.keyRequest &&
					(this.newMessageRequestConfig.validationMessage || (this.newMessageRequestConfig.typeRequest == 'text'))
				) {
					newRequestMsgNode(
						1,
						this.newMessageRequestConfig,
					);
					
					// this.$store.commit('pushAttribte', this.newMessageRequestConfig.keyRequest);
					this.storedAttributes.push(this.newMessageRequestConfig.keyRequest);
					
					setTimeout(() => {
						this.resetMessageRequestConfig();
					}, 20);
					this.modals.requestMessageModal = false;
					
				} else {
					this.notifyVue(
						"top",
						"right",
						4,
						"Veuillez préciser le message à envoyer!"
					);
				}
			}else if(typeNode == 2){

				if(this.newImageConfig.text)
				newImageNode(2, this.newImageConfig);
			}
			this.updateDblClickEvent();
			
		},
		submit() {
			
			this.axios
				.post("http://localhost:8000/testApp", 
				{
					editor: editor.toJSON(),
					attr: this.storedAttributes,
					conversationID: this.currentConversation.id
				}
				)
				.then(function(response) {
					alert("success");
				})
				.catch(function(error) {
					alert("Oups");
				});

			if(this.images.length > this.nbImages){
				const config = {
					headers: { 'content-type': 'multipart/form-data' }
				}
				let self = this;
				let formData = new FormData();
				for (let i = 0; i < this.images.length; i++) {
					formData.append('images[' + i + ']', this.images[i])
				}
				formData.append('imagesId', this.imagesId);
				this.axios
					.post("http://localhost:8000/saveImages", formData, config)
					.then(function(response) {
						self.nbImages = self.images.length;
						alert("success");
					})
					.catch(function(error) {
						alert("Oups");
					});
			}
		},
		updateDblClickEvent() {
			setTimeout(() => {
				let nodes = document.querySelectorAll(".node");
				nodes.forEach(el => {
					el.addEventListener("dblclick", this.customizeMessage);
				});
			}, 500);
		},
		customizeMessage() {
			this.action = "update";
			this.selectedNode = editor.selected.list[0];
			if (this.selectedNode.data.type == "message") {
				this.newNodeConfig = this.selectedNode.data;
				this.modals.configNodeModal = true;
				this.deletedOptions = [];
				var globalOptions = [];
				var nbOptions = 1;
				let options = Object.fromEntries(this.selectedNode.outputs);
				Object.keys(options).forEach(function(key) {
					if (key != "1") {
						var newOption = {
							title: options[key].data.title,
							value: options[key].data.value,
							key: options[key].data.key,
							order: options[key].data.order
						};
						globalOptions.push(newOption);
						nbOptions++;
					}
				});
				this.nbOptions = nbOptions;
				globalOptions.sort((a, b) => a.order - b.order);
				this.optionsData = globalOptions;
			} else if (this.selectedNode.data.type == "request_message") {
				this.newMessageRequestConfig = this.selectedNode.data;
				this.modals.requestMessageModal = true;
				this.oldAttribute = this.selectedNode.data.keyRequest;
			}
		},
		updateMessage() {
			if (this.action == "create") {
				
				this.addNewNode(0);
			} else{
				updateNode(
					this.selectedNode.id,
					this.newNodeConfig,
					this.optionsData,
					this.deletedOptions,
					false
				);
				this.modals.configNodeModal = false;
				this.notifyVue("top", "right", 1, "Message modifié !");
				this.deletedOptions = [];
			}
		},
		saveImage(){
			let imgId= Math.floor(Date.now() / 1000) + '.'+this.getFileExtension1(this.newImageConfig.text.name);
			this.newImageConfig.imgId = imgId;
			this.images.push(this.newImageConfig.text);
			this.newImageConfig.text = imgId;
			this.addNode(2);
			this.imagesId.push(imgId);
			this.modals.imageModal = false;
		},
		getFileExtension1(filename) {
		return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
		},
		actionButtonRequestMessage() {
			if (this.action == "create") {
				this.addNode(1);
			} else if (this.action == "update") {
				if (this.oldAttribute != this.newMessageRequestConfig.keyRequest) {
					var index = this.attributes.indexOf(this.oldAttribute);
					if (index !== -1) {
						this.attributes[index] = this.newMessageRequestConfig.keyRequest;
					}
				}
				updateRequestMsgNode(this.selectedNode.id, this.newMessageRequestConfig);
				this.action = "create";
				this.modals.requestMessageModal = false;
				this.notifyVue("top", "right", 1, "Message modifié !");
			}
			
		},
		resetMessageRequestConfig() {
			this.newMessageRequestConfig.title = "Demande de données " + nbNodes;
			this.newMessageRequestConfig.text = "";
			this.newMessageRequestConfig.ValidationType = "text";
			this.newMessageRequestConfig.keyRequest = "";
			this.newMessageRequestConfig.validationMessage = "";
			this.newMessageRequestConfig.type ="request_message";
		},
		openNewMessageModal(){
			this.newNodeConfig.title = "Nouveau Message " + nbNodes;
			this.newNodeConfig.text = "";
			this.closeAllModals();
			this.modals.configNodeModal = true;
		},
		openNewMessageRequestModal(){
			this.closeAllModals();
			this.resetMessageRequestConfig();
			this.modals.requestMessageModal = true;
		},
		openImageModal(){
			this.closeAllModals();
			this.modals.imageModal = true;
		},
		closeAllModals(){
			this.action = 'create';
			this.modals.actionModal = false;
			this.modals.newMessageModal = false;
			this.modals.configNodeModal = false;
			this.modals.requestMessageModal = false;
		},
		addNewOption() {
			this.nbOptions++;
			var nbOp = this.nbOptions;
			this.optionsData.push({ title: "Nouveau Bouton", value: "", key: nbOp });
		},
		removeOption(key) {
			for (var i = 0; i < this.optionsData.length; i++)
				if (this.optionsData[i].key == key) {
					this.deletedOptions.push({ key: key });
					this.optionsData.splice(i, 1);
					break;
				}
		},
		notifyVue(verticalAlign, horizontalAlign, type, message) {
			const color = Math.floor(Math.random() * 4 + 1);
			this.$notify({
				icon: "tim-icons icon-bell-55",
				horizontalAlign: horizontalAlign,
				verticalAlign: verticalAlign,
				type: this.type[type],
				timeout: 4000,
				message: message
			});
		},
		getAttributes(){
			var self = this;
			this.$store.dispatch('retrieveAttributes',{
				conversationID: 3
			})
			 .then(response => {
				 	if(response.data.attributes)
						self.storedAttributes = response.data.attributes;
             });
			
			// this.axios
			// 	.get("http://localhost:8000/api/getAttributes", {
			// 		user: 1,
			// 		conversationID: 3
			// 	})
			// 	.then(function(response) {
			// 		self.storedAttributes = response.data.response;
			// 	})
			// 	.catch(function(error) {
			// 		alert(error);
			// 	});
		},
		addNewConversation(){
			if(this.newConversation.nom){
				this.$store.dispatch('addNewConversation', {
					newConversation: this.newConversation
				})
				.then(response => {
					this.modals.newConversationModal = false;
					this.currentConversation = response;

					//Notify
				});
			}
			
		}
	},
	mounted() {
		
		// editor.on("noderemoved", node => {
		// 	if (node.id != 1) {
		// 		this.notifyVue("top", "right", 3, "Message supprimé!");
		// 	} else if (node.id == 1) {
		// 		this.notifyVue("top", "right", 4, "Ce message ne peut pas être supprimé!");
		// 	}
		// });
		// editor.on("nodecreated", () => {
		// 	this.notifyVue("top", "right", 1, "Message ajouté!");
		// });
		this.getAttributes();
		
		this.$store.dispatch('retrieveConversations')
		.then((response) => {
			this.currentConversation = this.conversations.find(function(element){
				return element.tag == 'DEFAULT';
			});
		});

		console.log(this.user);
	},
	created(){
		
	},
	computed:{
		attributes(){
			return this.$store.getters.attributes;
		},
		currentBot(){
			return this.$store.getters.currentBot;
		},
		conversations(){
			return this.$store.getters.conversations;
		},
		user(){
			return this.$store.getters.user;
		}
		
	},
	watch: {
    currentConversation: function () {
			this.axios
				.get("http://localhost:8000/getConversation", {
					params: {
						conversationID: this.currentConversation.id
					}

				})
				.then(function(response) {
					createFlowEditor(response.data.conversation);
				})
				}
	}
};
</script>
<style>
@media screen and (max-width: 576px){
.footer .nav {
    float: left;
    padding-left: 15px;
	margin-top: -100px;
	z-index: 155;
	text-align: left;

}
.footer .copyright{
	padding-left: 15px !important;
	text-align: left;
}
.lastCard{
	margin-bottom: 80px;
}
}

@media screen and (max-width: 768px){
.addBtnClass{
   float: left !important
}

}
.addBtnClass{
   float: right
}
.floating{
	transition: all 0.5s;
}
.floating:hover{
    -webkit-box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    -moz-box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    transform: translateY(-8px);
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
#rete {
	margin: 0 auto;
	width: 99%;
	height: 100%;
	border: 1px solid rgba(207, 199, 199, 0.322);
}
.reteContainer {
	width: 95%;
	height: 600px;
}
path {
	stroke-width: 1px;
}

.node > .output div:not(:first-child) {
	border: 1px solid #7f7ff7;
	border-radius: 20px;
	padding-left: 5px;
	padding-right: 5px;
}
.modal.show .modal-dialog {
	-webkit-transform: translate(0, 0%);
	transform: translate(0, 0%);
}
.font-icon-detail {
	cursor: pointer;
}
/* .modal-content {
	
} */
.modalTitle {
	border: none;
}

.addBtn {
	width: 100% !important;
}

.modal {
	overflow-y: auto;
}
.textcomplete-item:hover{
	background: #c7ecee;
}
.textcomplete-dropdown{
	overflow-y: scroll;
	max-height: 300px;
}
.textcomplete-dropdown li{
    padding: 10px;
}
.font-icon-list{
	min-width: 220px;
}
.font-icon-detail{
	min-height: 200px;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
.inputIcons{
    color:black !important;
}

#rete .node{
	width: 280px;
	background-color: #ffffff66;
	color :rgba(29, 37, 59, 0.5);
	border: white;
	border-radius: 20px;
	padding: 8px;
	-webkit-box-shadow: 10px 10px 17px 0px rgba(0,0,0,0.22);
	-moz-box-shadow: 10px 10px 17px 0px rgba(0,0,0,0.22);
	box-shadow: 10px 10px 17px 0px rgba(0,0,0,0.22);
}
#rete .node div{
	background-color: transparent;
	color :#323233;
}
.selected{
	    border: grey 1.5px solid !important;
}
#rete .node .socket{
    width: 18px;
    height: 18px;
}
#rete .node .output {
    margin: 10px;
    border-radius: 20px;
    border: 1px solid white;
-webkit-box-shadow: 3px 3px 9px -2px rgba(0,0,0,0.29);
-moz-box-shadow: 3px 3px 9px -2px rgba(0,0,0,0.29);
box-shadow: 3px 3px 9px -2px rgba(0,0,0,0.29);
}

#rete  .node .output-title{
	overflow-wrap: break-word !important;
    width: 180px;
}

#rete .node textarea {
  border: white;
  background: rgb(226, 225, 225);
  color: black;
  border-radius: 12px;
  padding: 5px;
  width: 100%;
  height: 70px;
  cursor: pointer;
}
#rete .node input{
  border: white;
  background: rgb(226, 225, 225);
  color: black;
  border-radius: 12px;
  padding: 5px;
  width:100%;

}

.node > .output div:not(:first-child) {
    background-color: grey !important;
	border: grey;
	margin-right: 10px;
}
.node > .output div:not(:first-child):hover {
    background-color: white !important;
	border: 2px grey solid;
}
#rete .node .output:hover {
    background-color: rgb(236, 234, 234);
}
.node > .input div {
	 border: transparent;	 
}
#rete .node .input{
  margin-left: -10px !important;
}
.connection .main-path {
	stroke-width: 1.5px;
	stroke: grey;
	z-index: 5
}

.bm-menu{
	position: absolute;
	background-color: white;
	border-right: 1px solid #9a909054;
	overflow-y: scroll;
}
.bm-burger-button{
	display: none;
}
.bm-item-list  span{
	padding: .2em;
	font-weight: 300;
	    font-size: 15px;
	color: black
}
.bm-item-list >h4{
	margin-left: 10px;
}
.bm-item-list>* {
	padding: .2em;
}
.bm-item-list> a>i {
	margin-top: 3px;
}


hr{
	width: 200px;
	margin-right:50px;
}
.form-control {
	    border-radius: 0.1285rem;
}
@-webkit-keyframes rotating /* Safari and Chrome */ {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 2s linear infinite;
  -moz-animation: rotating 2s linear infinite;
  -ms-animation: rotating 2s linear infinite;
  -o-animation: rotating 2s linear infinite;
  animation: rotating 2s linear infinite;
}

.login{
    font-size: 22px;  
    color: #2ed573;
}
</style>
