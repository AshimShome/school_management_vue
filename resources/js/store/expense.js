import axios from 'axios'

export default {
    namespaced: true,
    state: {
        expenses: [],
        next_page_url: '',
        expenseTypes: [],
    },
    getters: {
        expenses(state) {
            return state.expenses
        },
        next(state) {
            return state.next_page_url
        },
        expenseType(state) {
            return state.expenseTypes
        },
    },
    mutations: {
        // expense
        FETCH_EXPENSES(state, responseData) {
            state.expenses = responseData
        },
        FETCH_EXPENSES_NEXT_PAGE_URL(state, responseData) {
            state.next_page_url = responseData
        },
        ADD_MORE_EXPENSES(state, data) {
            state.next_page_url = data.next_page_url
            state.expenses = [...state.expenses, ...data.data]
        },
        REMOVE_EXPENSE(state, id) {
            state.expenses = state.expenses.filter(item => item.id !== id);
        },

        // expense type
        FETCH_EXPENSE_TYPE(state, responseData) {
            state.expenseTypes = responseData
        },
        ADD_EXPENSE_TYPE(state, data) {
            state.expenseTypes.push(data)
        },
        UPDATE_EXPENSE_TYPE(state, data) {
            const pos = state.expenseTypes.map((e) => e.id).indexOf(data.id);
            state.expenseTypes.splice(pos, 1, data)
        },
        REMOVE_EXPENSE_TYPE(state, id) {
            state.expenseTypes = state.expenseTypes.filter(item => item.id !== id);
        }
    },
    actions: {
        async fetchExpenses(context) {
            try {
                let response = await axios.get('/api/expenses')
                console.log(response.data.expenses)
                context.commit('FETCH_EXPENSES', response.data.data)
                context.commit('FETCH_EXPENSES_NEXT_PAGE_URL', response.data.next_page_url)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async fetchExpenseType(context) {
            try {
                let response = await axios.get('/api/expensetypes')
                context.commit('FETCH_EXPENSE_TYPE', response.data.expensetype)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        }
    }
}
