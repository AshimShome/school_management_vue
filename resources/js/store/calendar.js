import axios from 'axios'

export default {
    namespaced: true,
    state: {
        // events: {},
        events: []
    },
    getters: {
        events(state){
            return state.events;
        }
    },
    mutations: {
        // FETCH_EVENTS(state, responseData){
        //     state.events = responseData
        // },
        ADD_EVENT: (state, event) => {
            state.events.push(event)
        },
        SET_EVENTS(state, events){
            state.events = events
        }
    },
    actions: {
        fetchEvents(context){
           axios.get('/api/calendars')
            .then(res=>{
                context.commit('SET_EVENTS', res.data.data);
            }).catch(err=>{
                console.log(err)
            })
        },
    }
}
