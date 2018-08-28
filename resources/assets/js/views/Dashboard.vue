<template>
<v-container>
    <v-layout row wrap> 
        <v-flex xs12 sm6 lg6 px-2>
        <v-card>
            <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Aniversariantes do mês</h3>
            </div>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="birthdays"
                    :loading="loading"
                    :no-data-text="noData"
                    :rows-per-page-items="[5]"
                >
                    <v-progress-linear slot="progress" color="info" indeterminate></v-progress-linear>
                    <template slot="items" slot-scope="props">
                        <tr>
                            <td class="text-xs-right">{{ props.item.name }}</td>
                            <td class="text-xs-left">{{ props.item.birthday }}</td>
                            <td class="text-xs-left">
                                <v-btn small icon color="success" 
                                    target="_blank" 
                                    :href="whatsappLink(props.item.mobile)">
                                    <v-icon>fab fa-whatsapp</v-icon>
                                </v-btn>
                                <v-btn small icon color="info" 
                                    target="_blank" 
                                    :href="facebookLink(props.item.facebook)">
                                    <v-icon>fab fa-facebook-f</v-icon>
                                </v-btn>
                                <v-btn small icon color="error" 
                                    target="_blank" 
                                    :href="instagramLink(props.item.instagram)">
                                    <v-icon>fab fa-instagram</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        Mostrando {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        </v-flex>
        <v-flex xs12 sm6 lg6 px-2 >
        <v-card>
            <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Curva ABC</h3>
            </div>
            </v-card-title>
            <v-card-media src="" height="200px">
            </v-card-media>
        </v-card>
        </v-flex>
    </v-layout>
    <v-layout row wrap my-3>
        <v-flex xs12 sm12 lg12 px-2 >
        <v-card>
            <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Produtos mais ociosos nos últimos 4 meses</h3>
            </div>
            </v-card-title>
            <v-card-media src="" height="200px">
            </v-card-media>
        </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
export default {
    data(){
        return{
            loading: true,
            birthdays: [],
            headers: [
                    { text: 'Nome', align: 'right', value: 'name' },
                    { text: 'Aniversário', align: 'left', value: 'birthday' },
                    { text: 'Redes Sociais', align: 'left'}
               
                ],
            noData: 'Não há aniversariantes este mês.'
        }
    },

    created () {
        this.fetchBirthdays();
    },

    methods : {
        fetchBirthdays() {
            axios
            .get('/api/customers/month-birthdays')
            .then(response => {
                if(response.data.success){
                    this.birthdays = response.data.data;
                    this.loading = false;
                }
            })
            .catch(error =>{
                console.log(error);
            });
        },

        whatsappLink(number) {
            return 'https://wa.me/'+number;
        },

        instagramLink(profile){
            return 

        },
        facebookLink(profile){
            return 

        }

    }


    
}


</script>
