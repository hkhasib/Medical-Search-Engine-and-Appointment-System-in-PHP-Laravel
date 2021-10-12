/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from "vue";
import {set} from "lodash/object";
require('./bootstrap');

window.Vue = require('vue').default;
const loginApp = new Vue({
    el: '#login-app',
    data: function () {
        return {
            disabled: true,
            'username': true,
            'password': false,
            'loginButton': true,
            'usernameValue': "",
            'passwordValue': ""
        }
    },
    methods:{
        showPasswordField:function (){
if (this.usernameValue.length>2){
return this.password = true;
}
else {
    this.disabled =true;
    return this.password = false;
}},
        showLoginButton:function (){
            if (this.passwordValue.length>2){
                return this.disabled =false;
            }
            else {
                return this.disabled =true;
            }
        }
    }
});
