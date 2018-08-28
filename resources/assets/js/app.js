/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import VueAxios from 'vue-axios'
import colors from 'vuetify/es5/util/colors'

Vue.use(VueRouter)
Vue.use(Vuetify, {
    theme: {
        primary: '#235d7d',
        secondary: '#3b7697',
        info: '#659bf7',
        warning:'#ffee58',
        success: '#66bb6a',
        error: '#f24141'

    }
})
Vue.use(VueAxios, axios)

import App from './views/App'
import Dashboard from './views/Dashboard'
import Settings from './views/Settings'
import UserList from './views/users/List'
import UserEdit from './views/users/Edit'
import UserCreate from './views/users/Create'
import SuppliersList from './views/suppliers/List'
import CreateSupplier from './views/suppliers/Create'
import EditSupplier from './views/suppliers/Edit'
import ListProducts from './views/products/List'
import CreateProduct from './views/products/Create'
import EditProduct from './views/products/Edit'
import CustomerList from './views/customers/List'
import CustomerCreate from './views/customers/Create'
import CustomerEdit from './views/customers/Edit'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/configuracoes',
            name: 'settings',
            component: Settings
        },
        {
            path: '/funcionarios',
            name: 'users.list',
            component: UserList

        },
        {
            path: '/funcionarios/:id',
            name: 'users.edit',
            component: UserEdit
        },
        {
            path: '/funcionarios/novo',
            name: 'users.create',
            component: UserCreate
        },
        {
            path: '/fornecedores',
            name: 'suppliers.list',
            component: SuppliersList
        },
        {
            path: '/fornecedores/novo',
            name: 'suppliers.create',
            component: CreateSupplier
        },
        {
            path: '/fornecedores/:id',
            name: 'suppliers.edit',
            component: EditSupplier
        },
        {
            path: '/clientes/',
            name: 'customers.list',
            component: CustomerList
        },
        {
            path: '/cliente/novo',
            name: 'customers.create',
            component: CustomerCreate
        },
        {
            path: '/cliente/:id',
            name: 'customer.edit',
            component: CustomerEdit
        },
        {
            path: '/produtos/',
            name: 'products.list',
            component: ListProducts
        },
        {
            path: '/produtos/novo',
            name: 'products.create',
            component: CreateProduct
        },
        {
            path: '/produtos/:id',
            name: 'products.edit',
            component: EditProduct
        },
        {
            path:'/clientes',
            name:'customers.list',
            component:CustomerList
        },
        {
        path:'/clientes/novo',
        name:'customers.create',
        component:CustomerCreate

        },
        {
            path:'/clientes/:id',
            name:'customers.edit',
            component:CustomerEdit
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
