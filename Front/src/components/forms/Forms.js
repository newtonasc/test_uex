import axios from 'axios';

export default {
    name: 'v-form-contact',

    created() {
        this.$bus.$on('openFormContact', data => {
            this.clearForm();
            if(data.type == 'edit') {
                this.prepareData(data.contact);
            }
            this.type = data.type;
            this.$bvModal.show('modalFormContact');
            this.loadMaps();
        });        
    },

    mounted() {
        this.loadContacTypetList();
    },
    
    data() {
        return {            
            form: {
                id: 0,
                name: '',
                phone: '',
                cpf: '',
                address: '',
                number : '',
                neighborhood: '',
                city: '',
                state:'',
                cep: '',
                latitude: '',
                longitude: '',
                type_id: ''
            },
            type: null,
            loadingContactTypeList: false,
            listContactTypes: [],
            urlApi: 'http://localhost:8000/api',
            mapsApiKey: process.env.VUE_APP_MAP_KEY
        }
    },

    methods: {
        clearForm() {
            this.form = {
                id: 0,
                name: '',
                phone: '',
                cpf: '',
                address: '',
                number : '',
                neighborhood: '',
                city: '',
                state:'',
                cep: '',
                latitude: '',
                longitude: '',
                type_id: ''
            };
        },
        prepareData(data) {
            this.form = {
                id: data.id,
                name: data.name,
                phone: data.phone,
                cpf: data.cpf,
                address: data.address,
                number: data.number,
                neighborhood: data.neighborhood,
                city: data.city,
                state: data.state,
                cep: data.cep,
                latitude: data.latitude,
                longitude: data.longitude,
                type_id: data.type_id
            };
        },
        loadContacTypetList() {
            this.loadingContactTypeList = true;
            axios({
                url: `${this.urlApi}/contact-types`,
                data: {},
                method: 'GET'
            })
            .then(response => {
                for (const type of response.data.data) {
                    this.listContactTypes.push({ value: type.id, text: type.name });
                }
            })
            .catch(error => {
                this.displayNotification('error', error.message, 'Erro geral');
            })
            .finally(() => {
                this.loadingContactTypeList = false;                
            });
        },
        loadMaps() {
            setTimeout(() => {
                const autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('address'), {
                    bounds: new google.maps.LatLngBounds(new google.maps.LatLng(-25.441105, -49.276855))
                });
            }, 1000);            
        },
        changedAddress() {
            this.mapsErrorMsg = '';
            setTimeout(() => {
                delete axios.defaults.headers.common['Api-Token'];
                const address = document.getElementById('address').value;
                axios.get(`https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${this.mapsApiKey}`)
                .then(response => {
                    if (response.data.error_message) {
                        this.mapsErrorMsg = response.data.error_message;
                    } else {
                        const position = response.data.results[0].geometry.location;
                        const latlng = {
                            lat: position.lat,
                            lng: position.lng 
                        };
                        this.form.latitude = latlng.lat;
                        this.form.longitude = latlng.lng;
                        let groute = '';
                        let gnumber = '';
                        let gneighborhood = '';
                        let gcity = '';
                        let gstate = '';
                        let guf = '';
                        let gcep = '';
                        for(const item of response.data.results[0].address_components) {
                            if (item.types[0] === 'route') groute = item.long_name;
                            if (item.types[0] === 'street_number') gnumber = item.long_name;
                            if (item.types[2] === 'sublocality_level_1') gneighborhood = item.long_name;
                            if (item.types[0] === 'administrative_area_level_2') gcity = item.long_name;
                            if (item.types[0] === 'administrative_area_level_1') gstate = item.long_name;
                            if (item.types[0] === 'administrative_area_level_1') guf = item.short_name;
                            if (item.types[0] === 'postal_code') gcep = item.short_name;
                        }                        
                        if (groute || gnumber || gneighborhood) {
                            this.form.address = groute;
                            this.form.number = gnumber;
                            this.form.neighborhood = gneighborhood;
                        } else if (gcity || gstate) {
                            let separator = ' - ';
                            if (!gcity || !gstate) separator = '';
                            this.form.address = `${gcity}${separator}${gstate}`;
                            this.form.number = '';
                            this.form.neighborhood = '';
                            this.form.cep = '';
                        } 
                        if (gstate) {   
                            this.form.state = gstate;
                            this.form.city = gcity;                                                
                        } 
                        if (gcep) {
                            this.form.cep = gcep;
                        }                       
                    }
                })
                .catch(error => {
                    this.mapsErrorMsg = error.message;
                });
            }, 500);
        },
        close() {
            this.$bvModal.hide('modalFormContact');
        },
        save() {
            const id = this.form.id;
            delete this.form['id']; 
            let url = `${this.urlApi}/contacts`;
            let method = 'post';
            if (this.type == 'edit') {
                url = `${this.urlApi}/contacts/${id}`;
                method = 'put';
            }
            axios({
                url,
                data: this.form,
                method
            })
            .then(response => {
                if (response.data.success) {
                    this.displayNotification('success', response.data.message, this.type == 'edit' ? 'Edição' : 'Cadastro');
                    this.close();
                    this.$bus.$emit('updateList', null);
                }
            })
            .catch(error => {
                if (error.response) {
                    this.errorHandler(error.response.data.message);
                } else {
                    this.displayNotification('error', error.message, 'Erro geral');
                }
            });
        },
        displayNotification(type, body, title) {            
            const config = {
                timeout: 5000,
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true
            };
            this.$snotify[type](body, title, config);
        },
        errorHandler(error) {
            this.displayNotification('error', error, 'Campo requerido');
            console.log(error)
        }        
    }    
}