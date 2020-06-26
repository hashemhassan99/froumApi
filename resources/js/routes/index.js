import Login from '../pages/auth/Login';
import Home from '../pages/Home'
import Welcome from '../pages/welcome'
import VueRouter from 'vue-router'
import Vue from 'vue'
import guest from'../middlewares/guest'
import auth from "../middlewares/auth";
import checkAuth from "../middlewares/auth-check";
import middlewarePipeline from'../routes/middlewarePipeline'
import store from '../store/index'
import Register from '../pages/auth/Register'
import SingleDiscussion from '../pages/SingleDiscussion'
import Index from '../pages/index'




Vue.use(VueRouter)
const router = new VueRouter({
    mode : "history",
    routes:[
        {
            path:'/',
            component:Welcome,
            name:'welcome'
        },
        {
            path: "/register",
            component: Register,
            name: "register",
            meta: {
                middleware: [guest]
            }
        },
        {
            path:'/login',
            component:Login,
            name:'login',
            meta: {
                middleware: [guest]
            }
        },
      {
        path: "/home",
        component: Home,
        meta: {
          middleware: [auth, checkAuth]
        },
        children: [
          {
            path: "",
            component: Index,
            name: "home",
          },
          {
            path: "discussion/:channel/:discussion",
            component: SingleDiscussion,
            name: "discussion"
          }
        ]
      }

    ]
});
//this function will run before any request
router.beforeEach((to,from,next)=>{
    if(!to.meta.middleware) return next()
    //if there is amiddleware i will save it
    const middleware= to.meta.middleware
    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context,middleware,1)
    })

})
export default router;
