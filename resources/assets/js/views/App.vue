<template>
    <v-layout row wrap>
        <v-toolbar dark color="primary" pr-5>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="white--text"><img src="/img/GVCLOGO.png" alt=""></v-toolbar-title>
            <v-spacer></v-spacer>
                <v-badge color="purple" left overlap>
                    <span slot="badge">{{shoppingCart.length}}</span>
                    <v-btn large flat icon color="white" @click.stop="openCheckout()">
                        <v-icon>shopping_cart</v-icon>
                    </v-btn>
                </v-badge>
                <v-btn
                    flat=""
                    target="_blank" 

                    :href="'https://servicos.spc.org.br/spc/controleacesso/autenticacao/entry.action'"
                >
                    <v-icon mr-2>
                        far fa-address-card
                    </v-icon>
                    consultar spc
                </v-btn>
        </v-toolbar>
        <v-navigation-drawer v-model="drawer" app enable-resize-watcher>
            <v-toolbar dark color="secondary">
                <v-list class="pl-3">
                    <v-list-tile-content>
                        <v-list-tile class="white--text subheading">{{this.user.name}}</v-list-tile>
                    </v-list-tile-content>
                </v-list>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <v-btn class="mx-0" slot="activator" icon :to="{ name: 'settings' }">
                        <v-icon>settings</v-icon>
                    </v-btn>
                    <span>Configurações</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <v-btn class="mx-0" slot="activator" icon @click="performLogout()">
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                    <span>Sair do Sistema</span>
                </v-tooltip>
            </v-toolbar>
            <v-list>
                <v-list-tile :to="{ name: 'dashboard' }">
                    <v-list-tile-action>
                        <v-icon>dashboard</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Painel</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: 'users.list' }">
                    <v-list-tile-action>
                        <v-icon>assignment_ind</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Funcionários</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: 'customers.list' }">
                    <v-list-tile-action>
                        <v-icon>people</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Clientes</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: 'products.list' }">
                    <v-list-tile-action>
                        <v-icon>category</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Produtos</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: 'suppliers.list' }">
                    <v-list-tile-action>
                        <v-icon>domain</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Fornecedores</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: '' }">
                    <v-list-tile-action>
                        <v-icon>shopping_cart</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Vendas</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: '' }">
                    <v-list-tile-action>
                        <v-icon>local_shipping</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Pedidos</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: '' }">
                    <v-list-tile-action>
                        <v-icon>attach_money</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Financeiro</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile :to="{ name: '' }">
                    <v-list-tile-action>
                        <v-icon>assignment</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Relatórios</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
            <v-dialog v-model="dialog" max-width="500px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Fechar Compra</span>
                    </v-card-title>
                    <v-card-text>
                        <v-select
                            :items="customers"
                            v-model="selectedCustomer"
                            autocomplete
                            label="Cliente"
                            single-line
                            item-text="name"
                            item-value="id"
                        ></v-select>
                        <v-data-table
                            :headers="headers"
                            :items="shoppingCart"
                            :rows-per-page-text="'Itens por página: '"
                            :rows-per-page-items="itemPerPage"
                            :no-data-text="noData"
                            :no-results-text="noResults"
                        >
                            <v-progress-linear slot="progress" color="info" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="props">
                                <tr>
                                    <td class="text-xs-left">{{ props.item.product.name }}</td>
                                    <td class="text-xs-left">{{ props.item.product.size }}</td>
                                    <td class="text-xs-left">{{ props.item.quantity }}</td>
                                    <td class="text-xs-left">
                                        {{ Number(props.item.product.value/100).toLocaleString('pt-br',  {style: "currency", currency: "BRL", minimumFractionDigits: 2}) }}
                                    </td>
                                    <td class="text-xs-left">
                                        {{ Number(Number(props.item.product.value/100) * props.item.quantity).toLocaleString('pt-br',  {style: "currency", currency: "BRL", minimumFractionDigits: 2}) }}
                                    </td>
                                </tr>
                            </template>
                            <template slot="pageText" slot-scope="props">
                                Mostrando {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                            </template>
                            <template slot="footer">
                                <td class="py-2">
                                    <strong>Total: </strong> {{ Number(this.total).toLocaleString('pt-br',  {style: "currency", currency: "BRL", minimumFractionDigits: 2}) }}
                                </td>
                            </template>
                        </v-data-table>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" flat @click.native="dialog = false">Cancelar</v-btn>
                    <v-btn color="success" @click.native="fecharPedido()">Adicionar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        <v-container fluid v-if="this.$vuetify.breakpoint.mdAndDown">
            <v-layout row wrap>
                <v-flex xs12>
                    <router-view></router-view>
                </v-flex>
            </v-layout>
        </v-container>
        <v-container v-else>
            <v-layout row wrap>
                <v-flex xs12>
                    <router-view></router-view>
                </v-flex>
            </v-layout>
        </v-container>
        <v-snackbar
            :timeout="5000"
            bottom
            right
            v-model="snackbar"
            :color="snackColor"
        >
            {{ snackbarText }}
            <v-btn icon dark flat @click.native="snackbar = false"><v-icon>close</v-icon></v-btn>
        </v-snackbar>
    </v-layout>
</template>
<script>
    export default {
        data () {
            return {
                snackbar: false,
                snackColor: 'default',
                snackbarText: '',
                drawer: null,
                customers: [],
                user: {},
                selectedCustomer: 0,
                shoppingCart: [],
                headers: [
                    { text: 'Nome', align: 'left', value: 'name' },
                    { text: 'Tamanho', align: 'left', value: 'size' },
                    { text: 'Preço Un.', align: 'left', value: 'value' },
                    { text: 'Quantidade.', align: 'left', value: 'quantity' },
                    { text: 'Total', align: 'left', value: '' },
                ],
                itemPerPage: [10,15,20,25,{"text":"Todos","value":-1}],
                noData: 'Não há dados',
                noResults: 'Não foram encontrados dados',
                dialog: false,
                total: 0,
            }
        },

        created () {
            this.findUser();
            this.fetchCustomers();
        },

        methods : {
            performLogout() {
                window.location.href = '/logout';
            },

            findUser() {
                axios
                .get('/api/users/current')
                .then(response => {
                    if(response.data.success){
                        this.user = response.data.user;
                    }
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            fetchCustomers() {
                axios
                .get('/api/customers/')
                .then(response => {
                    if(response.data.success){
                        this.customers = response.data.data;
                    }
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            showNotification(color, msg) {
                this.snackColor = color;
                this.snackbarText = msg;
                this.snackbar = true;
            },

            openCheckout() {
                this.calculaTotal();
                this.dialog = true;
            },

            fecharPedido() {
                this.dialog = false;
                let data = {
                    items: this.shoppingCart,
                    customer_id: this.selectedCustomer
                };
                console.log(data);
                axios
                .post('/api/products/checkout', data)
                .then(response => {
                    if(response.data.success) {
                        this.showNotification('success', response.data.message);
                    } else {
                        this.showNotification('error', response.data.message);
                    }
                })
                .catch( error => {
                    console.log(error);
                })
            },

            calculaTotal() {
                this.shoppingCart.forEach(i => {
                    this.total += (i.quantity * Number(i.product.value / 100));
                });
            }
        }
    }
</script>