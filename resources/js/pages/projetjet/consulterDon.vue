<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">Consulter les dons</h5>
      <div class="row filtre">
        <div class="col-md-2">
          <base-input  label="Filtrer par gouvernorat">
            <select class="form-control " @change="onFiltreGouvernoratChange($event)"
            >
                <option v-for="(gouvernorat, index) in gouvernorats"
                        :value="gouvernorat.fr" 
                        :key="index"
                        >{{gouvernorat.fr}}</option>
            </select>
          </base-input>
        </div>
        <div class="col-md-2">
          <base-input  label="Filtrer par etat">
            <select class="form-control " @change="onEtatFiltre($event)"
            >
                <option value="Traite">Traité</option>
                <option value="Non traite">Non traité</option>
                <option value="En cours">En cours</option>
            </select>
          </base-input>
        </div>
         <div class="col-md-2">
              <base-button class="addBtnClass" style="    margin-top: 23px;" type="warning" fill v-on:click="onFiltreAll()">Voir tous</base-button>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table tablesorter text-left">
            <thead class="text-primary">
            <tr>
                <slot name="columns">
                <th>-</th>
                <th>Nom du donateur</th>
                <th>Telephone</th>
                <!-- <th>Adresse</th> -->
                <th>Gouvernorat</th>
                <!-- <th>Date</th> -->
                <th>Affecté à</th>
                <th>Plus d'informations</th>
                <th>Etat</th>
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="7" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-for="(don, index) in filtredDons"
                        :key="index"
                        >
                <td>{{don.type_action}}</td>
                <td>{{don.nom}}</td>
                <td>{{don.telephone}}</td>
                <!-- <td>{{don.adresse.adresse}}</td> -->
                <td>{{don.gouvernorat}}</td>
                <!-- <td>{{don.created_at}}</td> -->
                <td><base-button simple type="primary" v-on:click="selectActeur(don.user)">Affecté à</base-button></td>
                <td><base-button simple type="primary" v-on:click="selectDon(don)">Plus d'informations</base-button></td>
                <td style="min-width: 180px;">      
                   <base-input>
                    <select class="form-control " @change="onEtatChange($event, don.id)" :disabled="parseInt(user.role) == 0 ? true : false"
                    :class="don.etat == 'Traite' ? 'traite' : don.etat == 'Non traite' ? 'nontraite' : 'encours'"
                    >
                        <option value="Traite" class="noneBg" v-bind:selected="don.etat == 'Traite' ? true : false">Traité</option>
                        <option value="En cours" v-bind:selected="don.etat == 'En cours' ? true : false">En cours </option>
                        <option value="Non traite" v-bind:selected="don.etat == 'Non traite' ? true : false">Non traité </option>
                    </select>
                  </base-input>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    <template slot="footer">
      <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
    </template>
  </card>
  	<modal :show.sync="modals.donModal">
		<template slot="header">
			Plus d'informations
		</template>
        <template>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Type du don:</span>
                  {{this.selectedDon.type_don}}
                 </p>
            </div>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Description:</span>
                  {{this.selectedDon.description}}
                 </p>
            </div>
            	<div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Adresse:</span>
                  {{this.selectedDon.adresse.adresse}}
               </p>
            </div>
            	<div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Date:</span>
                  {{this.selectedDon.created_at}}
               </p>
            </div> 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.donModal = false;"
				>Fermer</base-button
			>

		</template>
	</modal>
  	<modal :show.sync="modals.acteurModal">
		<template slot="header">
			Affecté à 
		</template>
        <template>
             <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Type d'acteur:</span>
                  {{this.selectedActeur.role == 1 ? 'UTSS' : 'CRCC'}}
               </p>
            </div>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Gouvernorat:</span>
                  {{this.selectedActeur.gouvernorat}}
                 </p>
            </div>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Nom et prénom:</span>
                  {{this.selectedActeur.lastname}} {{this.selectedActeur.name}}
                 </p>
            </div>
            	<div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Téléphone:</span>
                  {{this.selectedActeur.telephone}}
               </p>
            </div>

        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.acteurModal = false;"
				>Fermer</base-button
			>
		</template>
	</modal>

 </div>
 
</template>
<script>
import {
  Card,
  BaseInput
} from "../../components/index";

import BaseButton from '../../components/BaseButton';
import BaseTable from "../../components/BaseTable";
import { Modal } from "../../components/index";
export default{
  components:{
    Card,
    BaseInput,
    BaseButton,
    BaseTable,
    Modal
  },
  data() {
    return {
        modals:{
            donModal: false,
            acteurModal: false
        },
      loading: true,
      selectedDon: {
        adresse:{

        }
      },
      selectedActeur: {
        adresse:{

        }
      },
    }
 },
 methods:{
     saveDon(){
         if(this.modal.nom != '' || this.modal.adresse != '' || this.modal.description != '')
         this.$store.dispatch('newDon', this.model)
           .then(response => {
               console.log(response);
            //    this.acteur = response;
               this.modals.donModal = true;
           })
             
         },
        onEtatChange(event, donId) {
         if(parseInt(this.user.role) != 0)
         this.$store.dispatch('updateEtatDon', {
           donId: donId,
           etat: event.target.value
         })
           .then(response => {
            console.log(response);
            this.$notify({
              icon: "tim-icons icon-bell-55",
              horizontalAlign: 'right',
              verticalAlign: 'top',
              type: 'success',
              timeout: 4000,
              message: 'Etat du don modifé!'
              });
            })
        },
        selectDon(don){
          this.selectedDon = don;
          this.modals.donModal = true;
        },
        selectActeur(acteur){
          this.selectedActeur = acteur;
          console.log(this.selectedActeur );
          this.modals.acteurModal = true;
        },
        onFiltreGouvernoratChange(event){
          this.filtredDons = this.dons.filter(function (el) {
            return el.gouvernorat == event.target.value
          });
        },
        onEtatFiltre(event){
          this.filtredDons = this.dons.filter(function (el) {
            return el.etat == event.target.value
          });
        },
        onFiltreAll(){
          this.filtredDons = this.dons;
          }
        
        
     },
    mounted(){
        let filtre = 0;
         if(this.user.role == 1 || this.user.role == 2){
            this.$store.dispatch('getAffectedDons', this.user.id)
            .then((response)=>{
              this.loading = false;
            });
         }else{
            this.$store.dispatch('getDons')
             .then((response)=>{
              this.loading = false;
            });
         }
       
    },
    computed:{
      user(){
        return this.$store.getters.user;
      },
      dons: {
           get(){
            return this.$store.getters.dons;
           },
        },
      filtredDons: {
           get(){
            return this.$store.getters.filtredDons;
           },
           set(value) { this.$store.commit('setfiltredDons', JSON.stringify(value)); },
        },
        gouvernorats(){
          return this.$store.getters.gouvernorats
        }

    }
}
</script>
<style scoped>

.noneBg{
  background: transparent !important;
}
.traite{
    background: #32ff7e;
}
.encours{
    background: #18dcff;
}
.nontraite{
    background: #ff8d72;
}

.tim-icons .icon-single-02 {
    color:black !important;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
</style>
