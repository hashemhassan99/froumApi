export default function guest({next,store}) {
    //if the user has atoken he is already loged in
    if(store.getters['auth/token']){
        return next({name:"home"})
    } else {
        //else the user donot have atoken continue to login page
        return next();
    }

}
