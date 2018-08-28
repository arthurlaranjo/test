<template>
<v-container fluid pa-0>
    <v-card class="mb-5">
        <v-card-text v-if="loading">
            <p class="text-xs-center">
                <v-progress-circular indeterminate color="primary" class="mx-auto my-5"></v-progress-circular>
            </p>
        </v-card-text>

        <v-card-title v-if="!loading" primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Editar Cliente</h2></v-card-title>
        <v-card-text v-if="!loading">
            <v-form v-model="userFormValid" ref="userForm">
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg6 px-2>
                        <v-text-field
                        v-model="user.name"
                        label="Nome"
                        required
                        :rules="nameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.cpf"
                        label="CPF"
                        mask="###.###.###-##"
                        :rules="federalRules"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg3 px-2>
                        <v-menu
                            ref="birthday"
                            :close-on-content-click="false"
                            v-model="birthday"
                            :nudge-right="40"
                            :return-value.sync="date"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >   
                            <v-text-field
                            slot="activator"
                            v-model="birthdayFormatted"
                            label="Nascimento"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="date" @input="$refs.birthday.save(date)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg6 px-2>
                        <v-text-field
                        v-model="user.email"
                        label="Email"
                        type="email"
                        ></v-text-field>
                    </v-flex>
                    
                    <v-flex xs9 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.cep"
                        label="CEP"
                        mask="##.###-###"
                        required
                        @blur="buscaEndereco()"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs9 md4 lg6 px-2>
                        <v-text-field
                        v-model="user.address"
                        label="Endereço"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.district"
                        label="Bairro"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.number"
                        label="Número"
                        required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs9 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.city"
                        label="Cidade"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md4 lg2 px-2>
                        <v-text-field
                        v-model="user.state"
                        label="Estado"
                        required
                        mask="AA"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md4 lg5 px-2>
                        <v-text-field
                        v-model="user.observation"
                        label="Complemento"
                        required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.phone"
                        label="Telefone"
                        mask="(##) ####-####"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.mobile"
                        label="Celular"
                        mask="(##) # ####-####"
                        required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.instagram"
                        label="Instagram"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.facebook"
                        label="Facebook"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-form>
            <v-layout row wrap class="mb-1">
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
                loading: false,
                user: {},
                birthday: false,
                birthdayFormatted: null,
                date: null,
                
                
                nameRules: [
                    v => !!v || 'Este campo não pode ser deixado em branco.',
                    v => v.length <= 150 || 'Este campo deve ter menos de 150 caracteres.'
                ],
                federalRules: [
                    v => v.length <= 15 || 'Este campo deve ter menos de 15 caracteres.',
                    v => this.validarCPF(v) || 'Documento deve ser válido.'
                ],
                stateRules: [
                    v => (!!v) ?  v.length <= 15 : true || 'Este campo deve ter menos de 15 caracteres.'
                ],
                longTextRules: [
                    v => (!!v) ?  v.length <= 150 : true || 'Este campo deve ter menos de 150 caracteres.'
                ],
                mediumTextRules: [
                    v => (!!v) ?  v.length <= 200 : true || 'Este campo deve ter menos de 100 caracteres.'
                ],

                userFormValid: false,
                passwordFormValid: false,
            }
        },

        created () {
            this.findCustomer();
        },

        watch: {
            date (val) {
                this.birthdayFormatted = this.formatDate(this.date);
            }
        },

        methods : {

            findCustomer() {
                axios
                .get('/api/customers/'+this.$route.params.id)
                .then(response => {
                    this.user = response.data;
                    this.date = this.user.birthday
                    this.loading = false;
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            formatDate (date) {
                if (!date) return null

                this.user.birthday = date;
                const [year, month, day] = date.split('-')
                return day + '/' + month + '/' + year;
            },

            save() {
                if (this.$refs.userForm.validate()) {
                    this.loading = true;
                    let data = this.user;
                    axios
                    .post('/api/customers/update', data)
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

            validarCPF(cpf) {  
                cpf = cpf.replace(/[^\d]+/g,'');

                // Elimina CPFs invalidos conhecidos    
                if (cpf.length != 11 || 
                    cpf == "00000000000" || 
                    cpf == "11111111111" || 
                    cpf == "22222222222" || 
                    cpf == "33333333333" || 
                    cpf == "44444444444" || 
                    cpf == "55555555555" || 
                    cpf == "66666666666" || 
                    cpf == "77777777777" || 
                    cpf == "88888888888" || 
                    cpf == "99999999999")
                        return false;       
                // Valida 1o digito 
                var add = 0;    
                for (let i=0; i < 9; i ++)       
                    add += parseInt(cpf.charAt(i)) * (10 - i);  
                    var rev = 11 - (add % 11);  
                    if (rev == 10 || rev == 11)     
                        rev = 0;    
                    if (rev != parseInt(cpf.charAt(9)))     
                        return false;       
                // Valida 2o digito 
                add = 0;    
                for (let i = 0; i < 10; i ++)        
                    add += parseInt(cpf.charAt(i)) * (11 - i);  
                rev = 11 - (add % 11);  
                if (rev == 10 || rev == 11) 
                    rev = 0;    
                if (rev != parseInt(cpf.charAt(10)))
                    return false;       
                return true;   
            },

            buscaEndereco() {
                let cep = this.user.cep;
                axios
                .get('/api/users/endereco/'+cep)
                .then(response => {
                    this.user.address = response.data.logradouro;
                    this.user.city = response.data.localidade;
                    this.user.state = response.data.uf;
                    this.user.district = response.data.bairro;
                })
                .catch(error =>{
                    console.log(error);
                });
            }
        }
    }
</script>