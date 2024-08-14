import{t as u,P as e,a5 as l,q as n,v as o,u as t,V as m,x as f,C as y,G as v,F as V,z as g,y as s,B as x}from"./@vue-64c42e7d.js";import{_ as B}from"./Guest-89288d41.js";import{u as C,H as L}from"./@inertiajs-41d03628.js";import{_ as $}from"./Card-dc9fb2d2.js";import{_ as F,a as P}from"./index-fbdc3183.js";import"./ApplicationLogo-64527dd0.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./class-variance-authority-f96983da.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";const q=s("h3",null,"Admin Login",-1),N={class:"grid gap-4"},U={class:"grid gap-2"},j={class:"grid gap-2"},R={class:"flex justify-between"},S=s("span",null,"Remember me",-1),E={class:"flex justify-center"},H=["href"],Ue={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(h){const r=C({username:"",password:"",remember:!1}),c=()=>{r.post(route("admin.login"),{onFinish:()=>r.reset("admin.password")})};return(d,a)=>{const p=l("Label"),_=l("Input"),w=l("Checkbox"),b=l("Button");return n(),u(B,null,{default:e(()=>[o(t(L),{title:"Log in"}),o($,null,{title:e(()=>[q]),description:e(()=>[m(" Please enter your credentials to log in. ")]),content:e(()=>[Object.keys(d.$page.props.errors).length>0?(n(),u(t(F),{key:0,variant:"destructive"},{default:e(()=>[(n(!0),f(V,null,y(d.$page.props.errors,(i,k)=>(n(),u(t(P),{key:k},{default:e(()=>[m(v(i),1)]),_:2},1024))),128))]),_:1})):g("",!0),s("form",{onSubmit:x(c,["prevent"])},[s("div",N,[s("div",U,[o(p,{for:"email"},{default:e(()=>[m("Email / Username")]),_:1}),o(_,{type:"email",modelValue:t(r).username,"onUpdate:modelValue":a[0]||(a[0]=i=>t(r).username=i),required:"",autofocus:"",autocomplete:"off"},null,8,["modelValue"])]),s("div",j,[o(p,{for:"password"},{default:e(()=>[m("Password")]),_:1}),o(_,{type:"password",modelValue:t(r).password,"onUpdate:modelValue":a[1]||(a[1]=i=>t(r).password=i),required:"",autocomplete:"off"},null,8,["modelValue"])]),s("div",R,[o(p,{for:"terms",class:"flex space-x-2 items-center text-sm cursor-pointer"},{default:e(()=>[o(w,{id:"terms",checked:t(r).remember,"onUpdate:checked":a[2]||(a[2]=i=>t(r).remember=i)},null,8,["checked"]),S]),_:1})]),o(b,{class:"w-full",onClick:c,disabled:t(r).processing},{default:e(()=>[m("Log in")]),_:1},8,["disabled"]),s("div",E,[h.canResetPassword?(n(),f("a",{key:0,href:d.route("admin.password.request")},[o(p,{class:"hover:underline cursor-pointer"},{default:e(()=>[m("Forgot your password?")]),_:1})],8,H)):g("",!0)])])],32)]),_:1})]),_:1})}}};export{Ue as default};