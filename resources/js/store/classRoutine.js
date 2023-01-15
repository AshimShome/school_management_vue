import axios from 'axios'

export default {
    namespaced: true,
    state: {
        routines: [],
    },
    getters: {
        routines(state){
            return state.routines
        },
        pagination(state){
            return state.pagination
        },
    },
    mutations: {
        SET_ROUTINES(state, routines){
            state.routines = routines
        },
        ADD_ROUTINE (state, data){
            state.routines.push(data);
        },
        UPDATE_ROUTINE(state, data){
            state.routines.splice(state.routines.indexOf(data.id), 1, data)
        },
        REMOVE_ROUTINE(state, id){
            console.log(id);
            state.routines = state.routines.filter(routine=>routine.id !== id);
        },
    },
    actions: {
        fetchRoutines(context, data){
            axios.post(`/api/get-class-routines`, data).then((response) => {
                context.commit('SET_ROUTINES', response.data.data)
            }).catch((err) => {
              console.log(err);
            });
        },
        removeRoutine(context, id){
            axios.delete(`/api/remove-class-routines/${id}`).then(response=>{
                context.commit('REMOVE_ROUTINE', id);
            })
            .catch(err=>{
                console.log(err)
            })
        }
    }
}
