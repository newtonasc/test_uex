import Contact from '@/components/contact/Contact.vue';
import Forms from '@/components/forms/Forms.vue';
import Maps from '@/components/maps/Maps.vue';
export default {
    name: 'principal',

    components: {
        'v-contact-list': Contact,
        'v-contact-forms': Forms,
        'v-maps': Maps
    },
}