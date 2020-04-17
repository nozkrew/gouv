
import Vue from 'vue';

import 'core-js';

Vue.filter('round', function(value){
    if(!isNaN(value)){
        return value.toFixed(2);
    }
    return value;
});

let mv = new Vue({
    delimiters: ['${','}'],
    el:'#calculateur',
    data: {
        loyer:'',
        //coute lié au projet
        prix:'',
        mCarre:'',
        fraisNotaireEstime:'',
        fraisGarantieEstime: '',
        travaux: '',
        travauxEchelle:'',
        apport:'',
        ameublement:'',
        fraisNotaire: '',
        fraisGarantie:'',
        aEmprunter: 0,
        //pret
        dureePret: '',
        tauxPret:'',
        annuelPret:'',
        //charges annuelles
        taxeFonciere:'',
        chargeCopro:'',
        entretien:'',
        tauxEntretien:'',
        gerance:'',
        tauxGerance:'',
        pno:'',
        comptabilite:''
    },
    methods:{
        calculTravaux: function(){
            if(this.travauxEchelle === '' || this.mCarre === ''){
                return;
            }
            this.travaux = this.travauxEchelle * this.mCarre;
        },
        calculGerance: function(){
            if(this.loyer === '' || this.tauxGerance === ''){
                this.gerance = 0;
            }

            this.gerance = (this.loyer * 12) * (this.tauxGerance / 100);
        },
        calculEntretien: function(){
            if(this.loyer === '' || this.tauxEntretien === ''){
                this.entretien = 0;
            }

            this.entretien = (this.loyer * 12) * (this.tauxEntretien / 100);
        }
    },
    computed:{
        prixMetreCarre: function(){
            if(this.prix === '' || this.mCarre === ''){
                return 'N/A';
            }
            return this.prix / this.mCarre + " €";
        },
        rentaBrute: function(){
            if(this.prix === '' || this.loyer === ''){
                return 'N/A';
            }
            return this.loyer * 12 / this.prix * 100;
        },
        coutProjet: function(){
            this.aEmprunter = 0;
            this.aEmprunter += this.prix === '' ? 0 : parseInt(this.prix);
            this.aEmprunter += this.fraisNotaire === '' ? (this.fraisNotaireEstime === '' ? 0 : parseInt(this.fraisNotaireEstime)) : parseInt(this.fraisNotaire);
            this.aEmprunter += this.fraisGarantie === '' ? (this.fraisGarantieEstime === '' ? 0 : parseInt(this.fraisGarantieEstime)) : parseInt(this.fraisGarantie);
            this.aEmprunter += this.travauxEchelle === '' ? 0 : parseInt(this.travaux);
            this.aEmprunter += this.ameublement === '' ? 0 : parseInt(this.ameublement);
            this.aEmprunter -= this.apport === '' ? 0 : parseInt(this.apport);

            if(this.aEmprunter <= 0){
                return 'N/A';
            }

            return this.aEmprunter;
        },
        cAnnuelPret: function(){
            this.annuelPret = 0;
            if(this.aEmprunter <= 0 || this.dureePret === '' || this.tauxPret === ''){
                return 'N/A';
            }

            this.annuelPret = (( this.aEmprunter *( (this.tauxPret/100) /12))/( 1- Math.pow((1+( (this.tauxPret /100) /12)), (-this.dureePret * 12)) ))*12;

            return this.annuelPret;
        },
        cMensuelPret: function(){
            if(this.annuelPret <= 0){
                return 'N/A';
            }

            return this.annuelPret / 12;
        },
        recetteAnnuelle: function(){
            if(this.loyer === ""){
                return "N/A";
            }

            return this.loyer * 12;
        },
        chargeAnnuelle: function(){
            var charges = 0;
            
            charges += this.taxeFonciere === '' ? 0 : parseInt(this.taxeFonciere);
            charges += this.chargeCopro === '' ? 0 : parseInt(this.chargeCopro);
            charges += this.entretien === '' ? 0 : parseInt(this.entretien);
            charges += this.gerance === '' ? 0 : parseInt(this.gerance);
            charges += this.pno === '' ? 0 : parseInt(this.pno);
            charges += this.comptabilite === '' ? 0 : parseInt(this.comptabilite);

            if(charges == 0){
                return 'N/A';
            }

            return charges;
        },
        chargeAnnuelleAvecEmprunt: function(){
            var charges = 0;
            if(this.chargeAnnuelle !== 'N/A' ){
                charges += this.chargeAnnuelle;
            }
            if(this.annuelPret > 0){
                charges += this.annuelPret;
            }

            return charges === 0 ? 'N/A' : charges;
        },
        cashflowAnnuel: function(){
            var cashflow = 0;
            if(this.recetteAnnuelle !== 'N/A'){
                cashflow += this.recetteAnnuelle;
            }
            if(this.chargeAnnuelleAvecEmprunt !== 'N/A'){
                cashflow -= this.chargeAnnuelleAvecEmprunt;
            }

            return cashflow;
        },
        cashflowMensuel: function(){
            return this.cashflowAnnuel / 12;
        },
        classRenta: function(){
            if(isNaN(this.rentaBrute)){
                return 'badge-secondary';
            }

            if(this.rentaBrute < 10){
                return 'badge-danger';
            }

            if(this.rentaBrute == 10){
                return 'badge-warning';
            }

            if(this.rentaBrute > 10){
                return 'badge-success';
            }
        },
        classCashflow: function(){
            if(this.cashflowAnnuel < 0){
                return 'badge-danger';
            }
            if(this.cashflowAnnuel == 0){
                return 'badge-warning';
            }
            if(this.cashflowAnnuel > 0){
                return 'badge-success';
            }
        }

    },
    watch:{
        //Quel champs on souhaite surveiller
        prix: function(value){
            if(value === ''){
                this.fraisNotaire = '';
                this.fraisGarantie = '';
                return;
            }
            //Calcul des frais de notaire
            this.fraisNotaireEstime = value * 0.0822;
            //Calcul des frais de garantie
            this.fraisGarantieEstime = value * 0.02715;
        },
        mCarre: function(){
            this.calculTravaux();
        },
        travauxEchelle: function(){
            this.calculTravaux();
        },
        loyer: function(){
            this.calculGerance();
            this.calculEntretien();
        },
        tauxGerance:function(){
            this.calculGerance();
        },
        tauxEntretien: function(){
            this.calculEntretien();
        }
    }
});