<template>
<v-container fluid pa-0>
    <v-card class="mb-5">
        <v-card-text v-if="loading">
            <p class="text-xs-center">
                <v-progress-circular indeterminate color="primary" class="mx-auto my-5"></v-progress-circular>
            </p>
        </v-card-text>

        <v-card-title v-if="!loading" primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Editar Fornecedor</h2></v-card-title>
        <v-card-text v-if="!loading">
            <v-form v-model="userFormValid" ref="userForm">
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg8 px-2>
                        <v-text-field
                        v-model="supplier.name"
                        label="Nome"
                        required
                        :rules="nameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg4 px-2>
                        <v-text-field
                        v-model="supplier.cnpj"
                        label="CNPJ"
                        mask="##.###.###/####-##"
                        :rules="federalRules"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md3 lg3 px-2>
                        <v-text-field
                        v-model="supplier.phone"
                        label="Telefone"
                        mask="(##) ####-####"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md3 l3 px-2>
                        <v-text-field
                        v-model="supplier.mobile"
                        label="Celular"
                        mask="(##) # ####-####"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md3 l3 px-2>
                        <v-text-field
                        v-model="supplier.email"
                        label="Email"
                        type="email"
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
                supplier: {
                    name: '',
                    cnpj: '',
                    phone: '',
                    mobile_phone: '',
                    email: '',
                },
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
            this.fetchSupplier();
        },

        methods : {

            fetchSupplier() {
                axios
                .get('/api/suppliers/'+this.$route.params.id)
                .then(response => {
                    this.supplier = response.data;
                    this.loading = false;
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            save() {
                if (this.$refs.userForm.validate()) {
                    this.loading = true;
                    let data = this.supplier;
                    axios
                    .post('/api/suppliers/update', data)
                    .then(response => {
                        if(response.data.success){
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

            validarCNPJ(cnpj) {
                cnpj = cnpj.replace(/[^\d]+/g,'');
                
                if (cnpj.length != 14)
                    return false;
            
                // Elimina CNPJs invalidos conhecidos
                if (cnpj == "00000000000000" || 
                    cnpj == "11111111111111" || 
                    cnpj == "22222222222222" || 
                    cnpj == "33333333333333" || 
                    cnpj == "44444444444444" || 
                    cnpj == "55555555555555" || 
                    cnpj == "66666666666666" || 
                    cnpj == "77777777777777" || 
                    cnpj == "88888888888888" || 
                    cnpj == "99999999999999")
                    return false;
                    
                // Valida DVs
                let tamanho = cnpj.length - 2
                let numeros = cnpj.substring(0,tamanho);
                let digitos = cnpj.substring(tamanho);
                let soma = 0;
                let pos = tamanho - 7;
                for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                        pos = 9;
                }
                let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0))
                    return false;
                    
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0,tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1))
                    return false;
                    
                return true;
                
            },
        }
    }
</script>