import axios from 'axios'

export default {
    namespaced: true,
    state: {
        result_rules: [],
    },
    getters: {
        result_rules(state) {
            return state.result_rules
        },
    },
    mutations: {
        SET_RESULT_RULES(state, result_rules) {
            state.result_rules = result_rules
        },
        ADD_RESULT_RULE(state, data) {
            state.result_rules.push(data);
        },
        UPDATE_RESULT_RULE(state, data) {
            // state.result_rules.splice(state.result_rules.indexOf(data.id), 1, data)
            const pos = state.result_rules.map((e) => e.id).indexOf(data.id);
            state.result_rules.splice(pos, 1, data)
        },
        REMOVE_RESULT_RULE(state, id) {
            state.result_rules = state.result_rules.filter(term => term.id !== id);
        },
    },
    actions: {
        async fetchResultRules(context) {
            try {
                const response = await axios.get('/api/exam-result-rules')
                context.commit('SET_RESULT_RULES', response.data.data)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async removeResultRule(context, id) {
            try {
                const response = await axios.delete(`/api/exam-result-rules/${id}`);
                context.commit('REMOVE_RESULT_RULE', id);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error)
            }
        }
    }
}
