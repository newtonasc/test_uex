import axios from 'axios';
export default {
    name: 'v-contact-list',

    data() {
        return {
            loadingContactTypeList: false,
            loadingContactList: false,
            selectedContactType: 0,
            selectedContact: {},
            listContactTypes: [],
            listContacts: [],
            urlApi: 'http://localhost:8000/api',
            removeContact: '',
            contactId: null,
            activeId: 0,
            checkedId: 0, 
            termSearch: ''
        }
    }, 

    created() {
        this.$bus.$on('updateList', () => {
            this.loadContactList();
        });
        this.$bus.$on('markContact', id => {
            this.activeId = id;
        });  
        this.$bus.$on('checkContact', id => {
            this.checkedId = id;
        });  
    },

    mounted() {
        this.loadContacTypetList();
        this.loadContactList();
    },

    methods: {
        loadContacTypetList() {
            this.loadingContactTypeList = true;
            axios({
                url: `${this.urlApi}/contact-types`,
                data: {},
                method: 'GET'
            })
            .then(response => {
                this.listContactTypes.push({ value: 0, text: 'Todos' });
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
        loadContactList() {
            this.loadingContactList = true;
            axios({
                url: `${this.urlApi}/contacts`,
                data: {},
                method: 'GET'
            })
            .then(response => {
                this.listContacts = response.data.data;
            })
            .catch(error => {
                this.displayNotification('error', error.message, 'Erro geral');
            })
            .finally(() => {
                this.loadingContactList = false;
                this.$bus.$emit('renderMap', this.listContacts);
            });
        },
        add() {
            this.$bus.$emit('openFormContact', { type: 'new', contact: {} });
        },
        edit(contact) {
            this.selectedContact = {};
            this.selectedContact = contact;
            this.$bus.$emit('openFormContact', { type: 'edit', contact: this.selectedContact});
        },
        modalDelete(contact) {
            this.removeContact = {id: contact.id, name: contact.name };
            this.$bvModal.show('modalRemove');
        },
        remove(id) {
            if (!isNaN(id)) {
                axios.delete(`${this.urlApi}/contacts/${id}`)
                .then(response => {
                    this.$bvModal.hide('modalRemove');
                    if (response.data.success) this.displayNotification('success', response.data.message, 'Exclusão');                                       
                })
                .catch(error => {
                    if (error.response) {
                        this.errorHandler(error.response.data.message);
                    } else {
                        this.displayNotification('error', error.message, 'Erro geral');
                    }
                })
                .finally(() => {
                    this.loadContactList();
                });    
            }
        },
        selectContact(id){
            this.$bus.$emit('InfoWindowPin', id);
            this.checkedId = id;
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
            this.displayNotification('error', error, 'Erro geral');
            console.log(error)
        },
        showPin(id) {
            this.$bus.$emit('markPin', { id: id, status: true });
        },
        hidePin(id) {
            this.$bus.$emit('markPin', { id: id, status: false });
        },
        sentSearch() {
            if (!this.termSearch) return;
            this.loadingContactList = true;
            axios({
                url: `${this.urlApi}/contacts/search`,
                data: { 
                    term: this.termSearch,
                    filter: this.selectedContactType
                },
                method: 'POST'
            })
            .then(response => {
                this.listContacts = response.data.data;
            })
            .catch(error => {
                this.displayNotification('error', error.message, 'Erro geral');
            })
            .finally(() => {
                this.loadingContactList = false;
                this.$bus.$emit('renderMap', this.listContacts);
            });
        },
        cleanSearch() {
            this.termSearch = '';
            this.loadContactList();
        },
        changeContactType() {
            if (this.selectedContactType == 0) return this.loadContactList();
            this.loadingContactList = true;
            axios({
                url: `${this.urlApi}/contacts/filter`,
                data: { 
                    filter: this.selectedContactType
                 },
                method: 'POST'
            })
            .then(response => {
                this.listContacts = response.data.data;
            })
            .catch(error => {
                this.displayNotification('error', error.message, 'Erro geral');
            })
            .finally(() => {
                this.loadingContactList = false;
                this.$bus.$emit('renderMap', this.listContacts);
            });
        }
    }
}