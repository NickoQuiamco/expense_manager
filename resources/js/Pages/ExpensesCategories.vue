<template>
    <app-layout title="Dashboard" :role="role_id">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expense Categories Management
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-4">
                    <div class="main">
                        <table class="data-table" v-show="checkCategories">
                            <tr>
                                <th width="30%">Display Name</th>
                                <th width="30%">Description</th>
                                <th width="30%">Created At</th>
                                <th></th>
                            </tr>
                            <tr
                            v-for="category in categories"
                            :key="'k0'+category.id"
                            @click.prevent="EditModal(category)"
                            class="table-row"
                            >
                                <td> {{ category.name }} </td>
                                <td> {{ category.description }} </td>
                                <td> {{ category.created_at }} </td>
                                <td>
                                    <jet-button @click.stop="DeleteCategory(category.id)" class="md-12 px-3 py-1">Delete</jet-button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="main">
                        <jet-button @click.stop="StoreModal" class="md-12 px-4 py-2">Add Category</jet-button>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal update ##### -->
        <form-dialog :show="show_modal" :form="form" @close="closeModal()" @submit="SubmitForm()" >
            <template #title>
                <div>
                    {{ form.id ? "Update Category" : " Add Category " }}
                </div>
            </template>
            <form @submit.prevent="EditSubmit">
                <div>
                    <jet-label for="role_name" value="Role Name" />
                    <jet-input id="role_name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                </div>
                <div>
                    <jet-label for="description" value="Description" />
                    <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" required  />
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
import FormDialog from '@/Jetstream/FormDialog.vue'

export default defineComponent({
    props: ['categories', 'role_id'],
    components: {
        AppLayout,
        ModalView,
        JetInput,
        JetButton,
        JetLabel,
        FormDialog
    },
    data(){
        return{
            show_modal: false,
            form: {
                name: '',
                description:'',
            }
        }
    },
    computed:{
        checkCategories(){
            if(this.categories.length >= 1 ) return true
            else return false
        }
    },
    methods: {
        EditModal(role){
            this.form = role;
            this.show_modal = !this.show_modal;
        },
        SubmitForm(){
            if(this.form.id){
                this.$inertia.put('/expCategory/' + this.form.id, this.form);
            }else{
                this.$inertia.post('/expCategory/store', this.form);
            }
            this.form = {};
            this.show_modal = false;
        },
        DeleteCategory(id){
            this.$inertia.delete('/expCategory/' + id);
            this.show_modal = false;
        },
        closeModal(){
            // console.log('modal close');
            this.show_modal = !this.show_modal;
        },
        StoreModal(){
            this.show_modal = !this.show_modal;
        }
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
    width: 70%;
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
