import axios from "axios";
import Cookies from "js-cookie";
import * as types from '../mutations_types'

//state
const  state = {
    user:null,
    token:Cookies.get('token'),
    auth_err:null,
    loading:false,
    islogged:false
}
//getters
const getters = {
    user : state => state.user,
    token:  state => state.token,
    check: state => state.islogged,
    authError : state => state.auth_err,
    isloading : state => state.loading
}

//mutations
const mutations = {
    [types.LOGIN](state){
      state.loading =  true;
      state.auth_err = null;
      state.islogged =false;
        //null means we dont get the error yet
    },
    //this methode will put the value of token
    [types.LOGIN_SUCCESS](state,{token,remember}){
        state.loading = false;
        state.auth_err = null;
        state.token = token;
        state.islogged = true;
        Cookies.set('token',token,{expires:remember ? 365 : null});
    },
    [types.LOGIN_FAILED](state,{error}){
        state.loading = false;
        state.auth_err = error;
        state.islogged = false;


    },

    [types.FETCH_USER_SUCCESS](state,{user}){
        state.user = user.data;
        state.islogged = true;

    },

    [types.FETCH_USER_FAILURE](state){
        state.token = null;
        Cookies.remove('token');
        state.islogged = true;


    },

    [types.LOGOUT](state){
        state.user = null;
        state.token = null;
        Cookies.remove('token');
        state.islogged = true;

    }
};

const actions = {
        login({commit}){
            //payload contain token and remember
            //commit use to call mutation
            commit(types.LOGIN)
        },
    //get the user by the token
   async fetchUser({commit}){
            try{
               const {data} = await axios.get('/api/v1/auth/user')
                commit(types.FETCH_USER_SUCCESS,{user:data})
            }catch(error){
                commit(types.FETCH_USER_FAILURE)

            }
    }
}

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions


}
