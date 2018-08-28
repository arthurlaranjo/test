<template>
    <v-container fluid pa-0>
        <v-dialog v-model="dialog" persistent max-width="300px">
            <v-card>
                <v-card-title>
                <span class="headline">Quantidade</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 >
                                <v-text-field v-model="quantity" :rules="quantityRules" label="Quantidade" required></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" flat @click.native="dialog = false">Cancelar</v-btn>
                <v-btn color="success" @click.native="addProduct()">Adicionar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Produtos</h2></v-card-title>
            <v-card-text>
                <v-layout row wrap>
                    <h3 class="mt-3">Busca: </h3>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md8 lg8 class="px-2">
                        <v-text-field
                        :type="'text'"
                        v-model="search.nome"
                        label="Nome"
                        :change="buscaNome()"
                        @keyup.enter="filter()"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md3 lg2 class="text-xs-right">
                        <v-btn 
                        class="pr-0"
                        color="info"
                        @click="filter()">
                            Buscar
                            <v-icon class="ml-2 mr-0 mb-0">
                                search
                            </v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs12 md3 lg2 class="text-xs-right">
                        <v-btn 
                        class="pr-0"
                        color="success"
                        :to="{ name: 'products.create' }">
                            Produto
                            <v-icon class="ml-2 mr-0 mb-0">
                                add
                            </v-icon>
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
            >
                <v-progress-linear slot="progress" color="info" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="props">
                    <tr>
                        <td class="text-xs-left">{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.size }}</td>
                        <td class="text-xs-left">{{ props.item.quantity }}</td>
                        <td class="text-xs-left">{{ Number(props.item.value/100).toLocaleString('pt-br',  {style: "currency", currency: "BRL", minimumFractionDigits: 2}) }}</td>
                        <td class="text-xs-center px-0">
                            <v-tooltip bottom>
                                <v-btn class="mx-0" slot="activator" flat icon color="warning" :to="{ name: 'products.edit', params: { id: props.item.id }}">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <span>Editar Produto</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <v-btn class="mx-0" slot="activator" flat icon color="info" :to="{ name: 'products.edit', params: { id: props.item.id }}">
                                    <v-icon>style</v-icon>
                                </v-btn>
                                <span>Imprimir Etiqueta</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <v-btn class="mx-0" slot="activator" flat icon color="info" @click="openDialog(props.item)">
                                    <v-icon>add_shopping_cart</v-icon>
                                </v-btn>
                                <span>Realizar Pedido</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="props.item.deleted_at == null">
                                <v-btn class="mx-0" slot="activator" flat icon color="error" @click="deactivate(props.item.id)">
                                    <v-icon>delete_outline</v-icon>
                                </v-btn>
                                <span>Desativar Produto</span>
                            </v-tooltip>
                            <v-tooltip bottom v-else>
                                <v-btn class="mx-0" slot="activator" flat icon color="success" @click="reactivate(props.item.id)">
                                    <v-icon>reply</v-icon>
                                </v-btn>
                                <span>Reativar Produto</span>
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
                dialog: false,
                headers: [
                    { text: 'Nome', align: 'left', value: 'name' },
                    { text: 'Tamanho', align: 'left', value: 'size' },
                    { text: 'Quantidade', align: 'left', value: 'quantity' },
                    { text: 'Preço', align: 'left', value: 'value' },
                    { text: 'Ações', align: 'center', value: '', sort: false },
                ],
                quantityRules: [
                    v => !!v || 'O campo não pode ficar em branco.',
                    v => v <= this.maxQuantity || 'Quantidade maior que a em estoque.'
                ],
                products: [],
                filtered: [],
                itemPerPage: [10,15,20,25,{"text":"Todos","value":-1}],
                noData: 'Não há dados',
                noResults: 'Não foram encontrados dados',
                selectedProduct: {},
                quantity: 0,
                maxQuantity: 0,
                search: {
                    nome: '',
                }
            }
        },

        created () {
            this.fetchProducts();
        },

        methods : {
            fetchProducts() {
                axios
                .get('/api/products')
                .then(response => {
                    this.products = response.data;
                    this.products.forEach(u => {
                        u.filters = {
                            nome: true,
                        };
                    });
                    this.filtered = this.products;
                    this.loading = false;
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            buscaNome() {
                this.products.forEach(u => {
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
                this.products.forEach(u => {
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
                .get('/api/products/'+id+'/deactivate')
                .then(response => {
                    if(response.data.success){
                        this.products.forEach(e => {
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
                .get('/api/products/'+id+'/reactivate')
                .then(response => {
                    if(response.data.success){
                        this.products.forEach(e => {
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

            openDialog(product) {
                this.selectedProduct = product;
                this.maxQuantity = product.quantity;
                this.dialog = true;
            },

            addProduct() {
                
                let o = {
                    product: this.selectedProduct,
                    quantity: this.quantity,
                };
                this.$parent.shoppingCart.push(o);
                this.selectedProduct = {};
                this.quantity = 0;
                this.dialog = false;
            }
        }
    }
</script>