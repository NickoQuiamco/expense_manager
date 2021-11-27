<template>
    <app-layout title="Dashboard" :role="role_id">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expenses Management
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-4">
                    <div class="main">
                        <table class="data-table" v-show="checkExpenses">
                            <tr>
                                <th width="30%">Expenses Category</th>
                                <th width="20%">Amount</th>
                                <th width="30%">Entry Date</th>
                                <th width="20%">Created At</th>
                                <th></th>
                            </tr>
                            <tr
                            v-for="expense in expenses"
                            :key="'k0'+expense.id"
                            @click.prevent="EditModal(expense)"
                            class="table-row"
                            >
                                <td> {{ expense.category.name }} </td>
                                <td>₱ {{ expense.amount }} </td>
                                <td> {{ expense.entry_date }} </td>
                                <td> {{ expense.created_at }} </td>
                                <td>
                                    <jet-button @click.stop="DeleteExpenses(expense.id)" class="md-12 px-3 py-1">Delete</jet-button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="main">
                        <jet-button @click.stop="StoreModal" class="md-12 px-4 py-2">Add Expense</jet-button>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal update ##### -->
        <form-dialog :show="show_modal" :form="form" @close="closeModal()" @submit="SubmitForm()" >
            <template #title>
                <div>
                    {{ form.id ? "Update Expenses" : " Add Expenses" }}
                </div>
            </template>
            <form @submit.prevent="EditSubmit">
                <div>
                    <jet-label for="amount" value="Amount" />
                    <jet-input id="amount" type="number" class="mt-1 block w-full" v-model="form.amount" required autofocus />
                </div>
                <div>
                    <jet-label for="entry_date" value="Entry Date" />
                    <jet-input id="entry_date" type="date" class="mt-1 block w-full" v-model="form.entry_date" required  />
                </div>
                <div>
                    <jet-label value="Category" />
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="left" width="60">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                            {{ getSelectedCategoryName }}
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <template v-for="category in exp_categories" :key="category.id">
                                            <jet-dropdown-link as="button" @click.prevent="SetCategoryName(category)">
                                                <div class="flex items-center">
                                                    <svg v-if="category.id === form.category_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <div> {{ category.name }} </div>
                                                </div>
                                            </jet-dropdown-link>
                                        </template>
                                    </div>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>
                </div>
            </form>
        </form-dialog>

    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ModalView from '@/Jetstream/DialogModal.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import FormDialog from '@/Jetstream/FormDialog.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'

export default defineComponent({
    props: [ 'expenses', 'exp_categories', 'role_id' ],
    components: {
        AppLayout,
        ModalView,
        JetInput,
        JetButton,
        JetLabel,
        FormDialog,
        JetDropdown,
        JetDropdownLink,
        JetResponsiveNavLink
    },
    data(){
        return{
            show_modal: false,
            form: {
                amount: null,
                category_id: null,
                entry_datae: null,
            }
        }
    },
    computed:{
        checkExpenses(){
            if(this.expenses.length >= 1 ) return true
            else return false
        },
        getSelectedCategoryName(){
            if(this.form.category_id != null){
                var selected_category = this.exp_categories.filter(data=>{
                    return data.id == this.form.category_id;
                })
                return selected_category[0].name
            }
            return "Select Category"
        }
    },
    methods: {
        SetCategoryName(data){
            this.form.category_id = data.id;
        },
        EditModal(data){
            this.form = data;
            this.show_modal = !this.show_modal;
        },
        SubmitForm(){
            if(this.form.id){
                this.$inertia.put('/expense/' + this.form.id, this.form);
            }else{
                this.$inertia.post('/expense/store', this.form);
            }
            this.form = {};
            this.show_modal = false;
        },
        DeleteExpenses(id){
            this.$inertia.delete('/expense/' + id);
            this.show_modal = false;
        },
        closeModal(){
            // console.log('modal close');
            this.show_modal = !this.show_modal;
            this.form = {};
        },
        StoreModal(){
            this.show_modal = !this.show_modal;
        }
    },
    mounted(){
    }
})
</script>

<style scope>
.footer-content{
    display: block;
    width: 100%;
}
.table-row{
    margin: 15px;
    cursor: pointer;
}
.main{
    display: flex;
    justify-content: center;
    align-items: center;
}
.data-table{
    width: 80%;
    padding: 15px;
    margin: 15px;
}
.data-table th{
    color: #6875f5;
    /* text-align: center; */
}
.data-table tr{
    padding: 8px;
    text-align: center;
}
</style>
