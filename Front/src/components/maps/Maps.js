import axios from 'axios';

export default {
    name: 'v-maps',

    data() {
        return {
            mapsApiKey: 'AIzaSyDkRfQvApdiHD2NGc49Agpa8WflYjwgMCQ',
            position: {
                lat: -25.4437172,
                lng: -49.2789859
            },
            map: false,
            markers: [],
            infoWindow: [],
            iconHover: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
            contacts: []
        }
    },

    created() {
        this.$bus.$on('renderMap', contacts => {
            this.contacts = contacts;
            this.renderMap();
        });
        this.$bus.$on('markPin', marker => {
            if (!this.map) return;
            if (marker.status) {
                this.markers[marker.id].setIcon(this.iconHover);
            } else {
                this.markers[marker.id].setIcon(this.icon);
            }
        });
        this.$bus.$on('InfoWindowPin', id => {
            if (!this.map) return;
            this.closePreviousInfoWindow();
            this.infoWindow[id].open(this.map, this.markers[id]);
        });
    },

    mounted() {
        this.renderMap();
    },

    methods: {
        renderMap() {
            setTimeout(() => {
                let data = this.contacts;
                if (!data.length) {
                    data = this.defaultPosition();
                    const center = { 
                        lat: parseFloat(data[0].latitude),
                        lng: parseFloat(data[0].longitude)
                    };  
                    const mapParams = {
                        zoom: 10,
                        center: new google.maps.LatLng(center),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: true,
                        disableDoubleClickZoom: true,
                        zoomControlOptions: true,
                        streetViewControl: false
                    };
                    this.map = new google.maps.Map(document.getElementById('map'), mapParams);              
                    for (const point of data) {
                        this.markers[point.id] = new google.maps.Marker({
                            position: {
                                lat: parseFloat(point.latitude), 
                                lng: parseFloat(point.longitude)
                            },
                            icon: this.icon,
                            draggable: false,
                            map: this.map,
                            title: point.name
                        });
                        this.infoWindow[point.id] = new google.maps.InfoWindow({
                            content: `${point.address}, ${point.number}
                            ${point.neighborhood} - ${point.city}/${point.state}
                            ${point.cep}
                            `
                        });
                        this.markers[point.id].addListener('click', () => {
                            this.infoWindow[point.id].open(this.map, this.markers[point.id]);
                            this.$bus.$emit('checkContact', point.id);
                        });
                        this.infoWindow[point.id].addListener('closeclick', () => {
                            this.$bus.$emit('checkContact', 0);
                        });
                        this.markers[point.id].addListener('mouseover', () => {
                            this.$bus.$emit('markContact', point.id);
                        });
                        this.markers[point.id].addListener('mouseout', () => {
                            this.$bus.$emit('markContact', 0);
                        });
                    }
                } else {                            
                    const center = { 
                        lat: parseFloat(data[0].latitude),
                        lng: parseFloat(data[0].longitude)
                    };  
                    const mapParams = {
                        zoom: 10,
                        center: new google.maps.LatLng(center),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: true,
                        disableDoubleClickZoom: true,
                        zoomControlOptions: true,
                        streetViewControl: false
                    };
                    this.map = new google.maps.Map(document.getElementById('map'), mapParams);                 
                    for (const point of data) {
                        this.markers[point.id] = new google.maps.Marker({
                            position: {
                                lat: parseFloat(point.latitude), 
                                lng: parseFloat(point.longitude)
                            },
                            icon: this.icon,
                            draggable: false,
                            map: this.map,
                            title: point.name
                        });
                        this.infoWindow[point.id] = new google.maps.InfoWindow({
                            content: `${point.address}, ${point.number}
                            ${point.neighborhood} - ${point.city}/${point.state}
                            ${point.cep}
                            `
                        });
                        this.markers[point.id].addListener('click', () => {
                            this.infoWindow[point.id].open(this.map, this.markers[point.id]);
                            this.$bus.$emit('checkContact', point.id);
                        });
                        this.infoWindow[point.id].addListener('closeclick', () => {
                            this.$bus.$emit('checkContact', 0);
                        });
                        this.markers[point.id].addListener('mouseover', () => {
                            this.$bus.$emit('markContact', point.id);
                        });
                        this.markers[point.id].addListener('mouseout', () => {
                            this.$bus.$emit('markContact', 0);
                        });
                    }
                }
            }, 1000);
        },
        closePreviousInfoWindow() {
            for (const point of this.contacts) {
                this.infoWindow[point.id].close(this.map, this.markers[point.id]);
            };
        },
        defaultPosition() {
            return [{ 
                id: 0, 
                name: 'UEX Tecnologia', 
                address: 'Rua Pasteur', 
                number: '463', 
                neighborhood: 'Batel', 
                city: 'Curitiba', 
                state: 'Paraná',  
                cep: '80250-104', 
                latitude: '-25.4437172', 
                longitude: '-49.2789859'
            }]; 
        }
    }
}