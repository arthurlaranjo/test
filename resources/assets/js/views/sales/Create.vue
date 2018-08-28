<template>
<v-container fluid pa-0>
    <v-card class="mb-5">
        <v-card-text v-if="loading">
            <p class="text-xs-center">
                <v-progress-circular indeterminate color="primary" class="mx-auto my-5"></v-progress-circular>
            </p>
        </v-card-text>

        <v-card-title v-if="!loading" primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Realizar Venda</h2></v-card-title>
        <v-card-text v-if="!loading">
            <v-form v-model="userFormValid" ref="userForm">
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg6 px-2>
                        <v-text-field
                        v-model="Produto.value"
                        label="Produto"
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
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg3 px-2>
                        <v-text-field
                        v-model="user.rg"
                        label="RG"
                        ></v-text-field>
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
                        v-model="user.password"
                        label="Senha"
                        :rules="passwordRules"
                        type="password"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md4 lg3 px-2>
                        <v-text-field
                        v-model="password_confirmation"
                        label="Confirme a senha"
                        :rules="password_confirmationRules"
                        type="password"
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
                        v-model="user.mobile_phone"
                        label="Celular"
                        mask="(##) # ####-####"
                        required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md3 lg2 px-2>
                        <v-text-field
                        v-model="user.cep"
                        label="CEP"
                        mask="#####-###"
                        @blur="buscaEndereco()"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md7 lg8 px-2>
                        <v-text-field
                        v-model="user.address"
                        label="Endereço"
                        :rules="longTextRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs2 md2 lg2 px-2>
                        <v-text-field
                        v-model="user.number"
                        label="Número"
                        mask="#######"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md5 lg5 px-2>
                        <v-text-field
                        v-model="user.district"
                        label="Bairro"
                        :rules="mediumTextRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md5 lg5 px-2>
                        <v-text-field
                        v-model="user.city"
                        label="Cidade"
                        :rules="mediumTextRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs3 md2 lg2 px-2>
                        <v-text-field
                        v-model="user.state"
                        label="UF"
                        mask="AA"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg5 px-2>
                        <v-text-field
                        v-model="user.observations"
                        label="Complemento"
                        :rules="mediumTextRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6 lg4 px-2>
                        <v-select
                            :items="userRole"
                            v-model="user.role"
                            label="Nível de acesso"
                            single-line
                            item-text="text"
                            item-value="value"
                        ></v-select>
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
                user: {
                    name: '',
                    cpf: '',
                    rg: '',
                    role: 'VENDEDOR',
                    adress: '',
                    number:'',
                    district: '',
                    city: '',
                    state: '',
                    phone: '',
                    observation: '',
                    mobile_phone: '',
                    password: '',
                    email: '',
                    cep: '',
                },
                userRole: [
                    { value: 'GERENTE', text: 'GERENTE' },
                    { value: 'VENDEDOR', text: 'VENDEDOR'}
                ],
                passwordRules: [
                    v => v.length >= 6 || 'Senha deve ter no mínimo 6 dígitos.'
                ],
                password_confirmation: '',
                password_confirmationRules: [
                    v => v == this.user.password || 'As senhas devem ser iguais.'
                ],
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

        },

        methods : {


            save() {
                console.log("oi");
                if (this.$refs.userForm.validate()) {
                    this.loading = true;
                    let data = this.user;
                    axios
                    .post('/api/users/store', data)
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