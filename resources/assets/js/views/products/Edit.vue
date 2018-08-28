<template>
<v-container fluid pa-0>
    <v-card class="mb-5">
        <v-card-text v-if="loading">
            <p class="text-xs-center">
                <v-progress-circular indeterminate color="primary" class="mx-auto my-5"></v-progress-circular>
            </p>
        </v-card-text>

        <v-card-title v-if="!loading" primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Novo Produto</h2></v-card-title>
        <v-card-text v-if="!loading">
            <v-form v-model="userFormValid" ref="userForm">
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg6 px-2>
                        <v-text-field
                        v-model="product.name"
                        label="Nome"
                        required
                        :rules="nameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg2 px-2>
                        <v-text-field
                        v-model="product.size"
                        label="Tamanho"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg4 px-2>
                        <v-text-field
                        v-model="product.description"
                        label="Descrição"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.value"
                        prefix="R$ "
                        @change="maskMoney()"
                        label="Valor à Vista"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.forward_value"
                        prefix="R$ "
                        @change="maskMoneyFW()"
                        label="Valor à Prazo"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg3 px-2>
                        <v-text-field
                        v-model="product.code"
                        label="Código"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.quantity"
                        label="Quantidade"
                        mask="#########"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.unity"
                        label="Unidade"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.interest"
                        suffix="%"
                        label="Juros a.m."
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg2 px-2>
                        <v-text-field
                        v-model="product.installments"
                        label="Parcelas"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-form>
            <v-layout row wrap>
                <v-spacer></v-spacer>
                <v-btn
                    dark
                    color="success"
                    @click.stop="save()"
                    >
                    Salvar 
                    <v-icon>save</v-icon>
                </v-btn>
            </v-layout>
            
        </v-card-text>
    </v-card>
</v-container>
</template>
<script>
    export default {
        data () {
            return {
                loading: true,
                product: {},
                nameRules: [
                    v => !!v || 'Este campo não pode ser deixado em branco.',
                    v => v.length <= 150 || 'Este campo deve ter menos de 150 caracteres.'
                ],
                federalRules: [
                    v => v.length <= 15 || 'Este campo deve ter menos de 15 caracteres.',
                    v => this.validarCNPJ(v) || 'Documento deve ser válido.'
                ],
                longTextRules: [
                    v => (!!v) ?  v.length <= 150 : true || 'Este campo deve ter menos de 150 caracteres.'
                ],
                mediumTextRules: [
                    v => (!!v) ?  v.length <= 200 : true || 'Este campo deve ter menos de 100 caracteres.'
                ],

                userFormValid: false,
            }
        },

        created () {
            this.findProduct();
        },

        methods : {

            findProduct() {
                axios
                .get('/api/products/'+this.$route.params.id)
                .then(response => {
                    this.product = response.data;
                    this.maskMoney();
                    this.maskMoneyFW();
                    this.loading = false;
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            save() {
                if (this.$refs.userForm.validate()) {
                    this.loading = true;
                    let data = this.product;
                    data.value = data.value.replace(',', '');
                    data.forward_value = data.forward_value.replace(',', '');
                    axios
                    .post('/api/products/store', data)
                    .then(response => {
                        if(response.data.success){
                            this.maskMoney();
                            this.maskMoneyFW();
                            this.$parent.showNotification('success', response.data.message);
                        } else {
                            this.$parent.showNotification('error', response.data.message);
                        }

                        this.loading = false;
                    })
                    .catch(error =>{
                        console.log(error);
                    });
                }
            },

            maskMoney(){
                let str = String(this.product.value).replace(',', '');
                const splitAt = index => x => [x.slice(0, index), x.slice(index)]

                if(str.length == 0) return null;

                if(str.length <= 2) this.product.value = ','+str;

                else this.product.value = splitAt(str.length - 2)(str).join(',');
            },

            maskMoneyFW(){
                let str = String(this.product.forward_value).replace(',', '');
                const splitAt = index => x => [x.slice(0, index), x.slice(index)]

                if(str.length == 0) return null;

                if(str.length <= 2) this.product.forward_value = ','+str;

                else this.product.forward_value = splitAt(str.length - 2)(str).join(',');
            },
        }
    }
</script>