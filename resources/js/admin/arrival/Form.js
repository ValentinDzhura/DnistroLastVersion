import AppForm from '../app-components/Form/AppForm';

Vue.component('arrival-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                description:  '' ,
                begin:  '' ,
                end:  '' ,
                tour_name:  '' ,
                
            }
        }
    }

});