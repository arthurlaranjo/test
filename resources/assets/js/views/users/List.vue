<template>
    <v-container fluid pa-0>
        <v-card>
            <v-card-title primary-title class="primary white--text pt-3 pb-2">
                <h2 class="headline" py-0 my-0>Funcionários</h2>
            </v-card-title>
            <v-card-text>
                <v-layout row wrap>
                    <h3 class="mt-3">Busca: </h3>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md7 lg8 class="px-2">
                        <v-text-field
                        :type="'text'"
                        v-model="search.nome"
                        label="Nome"
                        :change="buscaNome()"
                        @keyup.enter="filter()"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg4 class="text-xs-right">
                        <v-btn 
                        class="pr-0"
                        color="info"
                        @click="filter()">
                            Buscar
                            <v-icon class="ml-2 mr-0 mb-0">
                                search
                            </v-icon>
                        </v-btn>
                        <v-btn
                        dark
                        color="success"
                        my-0
                        :to="{ name: 'users.create' }"
                        >
                            <v-icon>add</v-icon> Criar Usuário
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-data-table
                :headers="headers"
                :items="filtered"
                :loading="loading"
                :rows-per-page-text="'Itens por página: '"
                :rows-per-page-items="itemPerPage"
                :no-data-text="noData"
                :no-results-text="noResults"
                v-if="this.$vuetify.breakpoint.mdAndUp"
            >
                <v-progress-linear slot="progress" color="info" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="props">
                    <tr>
                        <td class="text-xs-right">{{ props.item.id }}</td>
                        <td class="text-xs-left">{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.cpf }}</td>
                        <td class="text-xs-left">{{ props.item.mobile_phone }}</td>
                        <td class="text-xs-left">{{ props.item.email }}</td>
                        <td class="text-xs-left">{{ props.item.role }}</td>
                        <td class="text-xs-center px-0">
                            <v-tooltip bottom>
                                <v-btn class="mx-0" slot="activator" flat icon color="warning" :to="{ name: 'users.edit', params: { id: props.item.id }}">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <span>Editar Usuário</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="props.item.deleted_at == null">
                                <v-btn class="mx-0" slot="activator" flat icon color="error" @click="deactivate(props.item.id)">
                                    <v-icon>delete_outline</v-icon>
                                </v-btn>
                                <span>Desativar Usuário</span>
                            </v-tooltip>
                            <v-tooltip bottom v-else>
                                <v-btn class="mx-0" slot="activator" flat icon color="success" @click="reactivate(props.item.id)">
                                    <v-icon>reply</v-icon>
                                </v-btn>
                                <span>Reativar Usuário</span>
                            </v-tooltip>
                        </td>
                    </tr>
                </template>
                <template slot="pageText" slot-scope="props">
                    Mostrando {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
            <v-data-table
                :headers="headersMobile"
                :items="filtered"
                :loading="loading"
                :rows-per-page-text="'Itens por página: '"
                :rows-per-page-items="itemPerPage"
                :no-data-text="noData"
                :no-results-text="noResults"
                v-else
            >
                <v-progress-linear slot="progress" color="success" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="props">
                    <tr>
                        <td class="text-xs-left">{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.role }}</td>
                        <td class="text-xs-center px-0">
                            <v-tooltip bottom>
                                <v-btn class="mx-0" slot="activator" flat icon color="info" :to="{ name: 'users.edit', params: { id: props.item.id }}">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <span>Editar Usuário</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="props.item.deleted_at == null">
                                <v-btn class="mx-0" slot="activator" flat icon color="error" @click="deactivate(props.item.id)">
                                    <v-icon>delete_outline</v-icon>
                                </v-btn>
                                <span>Desativar Usuário</span>
                            </v-tooltip>
                            <v-tooltip bottom v-else>
                                <v-btn class="mx-0" slot="activator" flat icon color="success" @click="reactivate(props.item.id)">
                                    <v-icon>reply</v-icon>
                                </v-btn>
                                <span>Reativar Usuário</span>
                            </v-tooltip>
                        </td>
                    </tr>
                </template>
                <template slot="pageText" slot-scope="props">
                    Mostrando {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        data () {
            return {
                loading: true,

                headers: [
                    {
                        text: 'ID',
                        align: 'right',
                        value: 'id'
                    },
                    { text: 'Nome', align: 'left', value: 'name' },
                    { text: 'CPF', align: 'left', value: 'cpf' },
                    { text: 'Celular', align: 'left', value: 'mobile_phone' },
                    { text: 'Email', align: 'left', value: 'email' },
                    { text: 'Função', align: 'left', value: 'role' },
                    { text: 'Ações', align: 'center', value: '', sort: false },
                ],
                headersMobile: [
                    { text: 'Nome', align: 'left', value: 'name' },
                    { text: 'Acesso', align: 'left', value: 'role' },
                    { text: 'Ações', align: 'center', value: '', sort: false },
                ],
                employees: [],
                filtered: [],
                itemPerPage: [10,15,20,25,{"text":"Todos","value":-1}],
                noData: 'Não há dados',
                noResults: 'Não foram encontrados dados',

                search: {
                    nome: '',
                }
            }
        },

        created () {
            this.fetchEmployees();
        },

        methods : {
            fetchEmployees() {
                axios
                .get('/api/users')
                .then(response => {
                    if(response.data.success){
                        this.employees = response.data.data;
                        this.employees.forEach(u => {
                            u.filters = {
                                nome: true,
                            };
                        });
                        this.filtered = this.employees;
                        this.loading = false;
                    }
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            buscaNome() {
                this.employees.forEach(u => {
                    let nome = u.name.toLowerCase();
                    let str = this.search.nome.toLowerCase();
                    if(nome.search(str) === -1){
                        u.filters.nome = false;
                    } else {
                        u.filters.nome = true;
                    }
                });
            },

            filter() {
                this.filtered = [];
                this.employees.forEach(u => {
                    if(this.show(u.filters)) this.filtered.push(u);
                })
            },

            show(filters) {
                for(let key in filters)
                    if (filters[key] === false) return false;
                return true;
            },

            deactivate(id) {
                axios
                .get('/api/users/'+id+'/deactivate')
                .then(response => {
                    if(response.data.success){
                        this.employees.forEach(e => {
                            if(e.id == id) {
                                e.deleted_at = 1;
                            }
                        });
                        this.$parent.showNotification('success', response.data.message);
                    }else{
                        this.$parent.showNotification('error', response.data.message);
                    }
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            reactivate(id) {
                axios
                .get('/api/users/'+id+'/reactivate')
                .then(response => {
                    if(response.data.success){
                        this.employees.forEach(e => {
                            if(e.id == id) {
                                e.deleted_at = null;
                            }
                        });
                        this.$parent.showNotification('success', response.data.message);
                    }else{
                        this.$parent.showNotification('error', response.data.message);
                    }
                })
                .catch(error =>{
                    console.log(error);
                });
            },
        }
    }
</script>