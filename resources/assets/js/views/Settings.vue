<template>
<v-container fluid class="pa-0">
    <v-card class="mb-5">
        <v-card-text v-if="loading">
            <p class="text-xs-center">
                <v-progress-circular indeterminate color="primary" class="mx-auto my-5"></v-progress-circular>
            </p>
        </v-card-text>

        <v-card-title v-if="!loading" primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Dados do Usuário</h2></v-card-title>
        <v-card-text v-if="!loading">
            <v-form v-model="userFormValid" ref="userForm">
                <v-layout row wrap mb-1>
                    <v-flex xs12 lg8 px-2>
                        <v-text-field
                        v-model="user.name"
                        label="Nome"
                        required
                        :rules="nameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6 lg2 px-2>
                        <v-text-field
                        v-model="user.cpf"
                        label="CPF"
                        disabled
                        readonly
                        mask="###.###.###-##"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6 lg2 px-2>
                        <v-text-field
                        v-model="user.rg"
                        label="RG"
                        disabled
                        readonly
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.phone"
                        label="Telefone"
                        mask="(##) ####-####"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.mobile_phone"
                        label="Celular"
                        mask="(##) # ####-####"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 lg6 px-2>
                        <v-text-field
                        v-model="user.email"
                        label="E-mail"
                        type="email"
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
                    <v-flex xs12 md4 lg3 px-2>
                        <v-text-field
                        v-model="user.district"
                        label="Bairro"
                        :rules="mediumTextRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs9 md6 lg7 px-2>
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
                    <v-flex xs12 px-2>
                        <v-text-field
                        v-model="user.observation"
                        label="Complemento"
                        :rules="mediumTextRules"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
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
            </v-form>
        </v-card-text>
    </v-card>

    <v-card class="mt-5" v-if="!loading">
        <v-card-title primary-title class="primary white--text pt-3 pb-2"><h2 class="headline">Alterar Senha</h2></v-card-title>
        <v-card-text>
            <v-form v-model="passwordFormValid" ref="passwordForm" lazy-validation>
                <v-layout row wrap class="mb-1">
                    <v-flex xs12 lg4>
                        <v-text-field
                        :type="'password'"
                        :rules="passwordRules"
                        v-model="password"
                        min="6"
                        counter="6"
                        label="Senha"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 lg4 offset-lg1>
                        <v-text-field
                        :type="'password'"
                        :rules="password_confirmationRules"
                        v-model="password_confirmation"
                        label="Confirme sua senha"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-form>
            <v-btn
              absolute
              dark
              fab
              bottom
              right
              color="success"
              :disabled="!passwordFormValid"
              @click.stop="changePassword()"
            >
              <v-icon>lock</v-icon>
            </v-btn>
        </v-card-text>
    </v-card>
</v-container>
</template>
<script>
    export default {
        data () {
            return {
                loading: true,
                user: {},
                password: '',
                passwordRules: [
                    v => v.length >= 6 || 'Senha deve ter no mínimo 6 dígitos.'
                ],
                password_confirmation: '',
                password_confirmationRules: [
                    v => v == this.password || 'As senhas devem ser iguais.'
                ],
                nameRules: [
                    v => !!v || 'Este campo não pode ser deixado em branco.',
                    v => v.length <= 150 || 'Este campo deve ter menos de 150 caracteres.'
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
            this.loading = true;
            this.fetchUser();
        },

        methods : {
            fetchUser() {
                axios
                .get('/api/users/current')
                .then(response => {
                    if(response.data.success){
                        this.user = response.data.user;
                    }
                    this.loading = false;
                })
                .catch(error =>{
                    console.log(error);
                });
            },

            save() {
                if (this.$refs.userForm.validate()) {
                    this.loading = true;
                    let data = this.user;
                    axios
                    .post('/api/users/update', data)
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

            changePassword() {
                if (this.$refs.passwordForm.validate()) {
                    this.loading = true;
                    let data = {
                        password: this.password
                    };
                    axios
                    .post('/api/users/password', data)
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

                if(cpf == '' || this.user.individual.is_company) return true;

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
                add = 0;    
                for (i=0; i < 9; i ++)       
                    add += parseInt(cpf.charAt(i)) * (10 - i);  
                    rev = 11 - (add % 11);  
                    if (rev == 10 || rev == 11)     
                        rev = 0;    
                    if (rev != parseInt(cpf.charAt(9)))     
                        return false;       
                // Valida 2o digito 
                add = 0;    
                for (i = 0; i < 10; i ++)        
                    add += parseInt(cpf.charAt(i)) * (11 - i);  
                rev = 11 - (add % 11);  
                if (rev == 10 || rev == 11) 
                    rev = 0;    
                if (rev != parseInt(cpf.charAt(10)))
                    return false;       
                return true;   
            },

            validarCNPJ(cnpj) {
                cnpj = cnpj.replace(/[^\d]+/g,'');
            
                if(cnpj == '' || !this.user.individual.is_company) return true;
                
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

            formatDate (date) {
                if (!date) return null

                this.user.individual.birthday = date;
                const [year, month, day] = date.split('-')
                return day + '/' + month + '/' + year;
            },

            buscaEndereco() {
                let cep = this.user.individual.postal_code;
                axios
                .get('/api/users/endereco/'+cep)
                .then(response => {
                    this.user.individual.address = response.data.logradouro;
                    this.user.individual.city = response.data.localidade;
                    this.user.individual.state = response.data.uf;
                    this.user.individual.district = response.data.bairro;
                })
                .catch(error =>{
                    console.log(error);
                });
            }
        }
    }
</script>