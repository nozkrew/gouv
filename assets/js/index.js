import Vue from 'vue'
const axios = require('axios');

let vm = new Vue({
    el:'#cities_app',
    data: {
        departements:[],
        popMin:null,
        popMax:null,
        priceMin:null,
        priceMax:null,
    },
    methods:{
        searchCities: function(){

            var url = '/api/cities?';

            this.departements.length ? this.departements.forEach(element => url += 'departmentCode[]='+element+'&') : ''

            this.popMin ? url+= 'population.total[gt]='+this.popMin+'&' : ''
            this.popMax ? url+= 'population.total[lt]='+this.popMax+'&' : ''
            this.priceMin ? url+= 'price.priceMeter[gt]='+this.priceMin+'&' : ''
            this.priceMax ? url+= 'price.priceMeter[lt]='+this.priceMax+'&' : ''

            axios.get(url)
        }
    },
    mounted: function(){
        //recupération des paramètres de l'URL
        const queryString = window.location.search
        const urlParams = new URLSearchParams(queryString)

        this.departements = urlParams.getAll("search_cities[dpt][]")
        this.popMin = urlParams.get("search_cities[populationMin]")
        this.popMax = urlParams.get("search_cities[populationMax]")
        this.priceMin = urlParams.get("search_cities[priceMeterMin]")
        this.priceMax = urlParams.get("search_cities[priceMeterMax]")
    }
})