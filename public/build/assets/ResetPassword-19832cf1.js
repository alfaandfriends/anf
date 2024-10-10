import{v as u,Q as t,be as f,t as m,x as e,u as s,W as a,y as c,J as y,K as g,F as P,C as k,z as p,G as B}from"./@vue-2682a433.js";import{_ as C}from"./Guest-9e6984b1.js";import{u as $,H as F}from"./@inertiajs-6e15fcc1.js";import{_ as N}from"./Card-59ecf63d.js";import{_ as R,a as S}from"./index-bb5df5e3.js";import"./ApplicationLogo-754713c8.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./app-815148a9.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./clsx-1229b3e0.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./class-variance-authority-52f2569e.js";import"./@radix-icons-96330712.js";const q={class:"grid gap-4"},x={key:0,class:"mb-2 font-medium text-sm text-green-600"},L={class:"grid gap-2"},U={class:"grid gap-2"},E={class:"grid gap-2"},Fo={__name:"ResetPassword",props:{email:String,token:String},setup(V){const w=V,r=$({token:w.token,email:w.email,password:"",password_confirmation:""}),_=()=>{r.post(route("password.update"),{onFinish:()=>r.reset("password","password_confirmation")})};return(n,o)=>{const l=f("Label"),d=f("Input"),b=f("Button");return m(),u(C,null,{default:t(()=>[e(s(F),{title:"Reset Password"}),e(N,null,{title:t(()=>o[3]||(o[3]=[a("Reset Password")])),description:t(()=>o[4]||(o[4]=[a(" Please enter your email and set a new password. ")])),content:t(()=>[Object.keys(n.$page.props.errors).length>0?(m(),u(s(R),{key:0,variant:"destructive"},{default:t(()=>[(m(!0),c(P,null,y(n.$page.props.errors,(i,v)=>(m(),u(s(S),{key:v},{default:t(()=>[a(g(i),1)]),_:2},1024))),128))]),_:1})):k("",!0),p("form",{onSubmit:B(_,["prevent"])},[p("div",q,[n.status?(m(),c("div",x,g(n.status),1)):k("",!0),p("div",L,[e(l,{for:"email"},{default:t(()=>o[5]||(o[5]=[a("Email Address")])),_:1}),e(d,{id:"email",type:"email",modelValue:s(r).email,"onUpdate:modelValue":o[0]||(o[0]=i=>s(r).email=i),required:"",autofocus:"",autocomplete:"off"},null,8,["modelValue"])]),p("div",U,[e(l,{for:"password"},{default:t(()=>o[6]||(o[6]=[a("Password")])),_:1}),e(d,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(r).password,"onUpdate:modelValue":o[1]||(o[1]=i=>s(r).password=i),required:"",autocomplete:"off"},null,8,["modelValue"])]),p("div",E,[e(l,{for:"password_confirmation"},{default:t(()=>o[7]||(o[7]=[a("Confirm Password")])),_:1}),e(d,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:s(r).password_confirmation,"onUpdate:modelValue":o[2]||(o[2]=i=>s(r).password_confirmation=i),required:"",autocomplete:"off"},null,8,["modelValue"])]),e(b,{class:"w-full",onClick:_,disabled:s(r).processing},{default:t(()=>o[8]||(o[8]=[a("Reset Password")])),_:1},8,["disabled"])])],32)]),_:1})]),_:1})}}};export{Fo as default};