import{v as e,Q as m,t as l,x as t,u as s,z as i,W as n,q as d,G as f}from"./@vue-2682a433.js";import{B as u}from"./Button-de817318.js";import{_ as c}from"./Guest-76a84cb6.js";import{_,a as w,b}from"./ValidationErrors-69dc5a1a.js";import{u as x,H as v}from"./@inertiajs-6e15fcc1.js";import"./app-1f657133.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./clsx-1229b3e0.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./class-variance-authority-52f2569e.js";import"./@radix-icons-96330712.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./ApplicationLogo-754713c8.js";const B={class:"flex justify-end mt-4"},co={__name:"ConfirmPassword",setup(V){const o=x({password:""}),p=()=>{o.post(route("password.confirm"),{onFinish:()=>o.reset()})};return(y,r)=>(l(),e(c,null,{default:m(()=>[t(s(v),{title:"Confirm Password"}),r[2]||(r[2]=i("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1)),t(_,{class:"mb-4"}),i("form",{onSubmit:f(p,["prevent"])},[i("div",null,[t(w,{for:"password",value:"Password"}),t(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(o).password,"onUpdate:modelValue":r[0]||(r[0]=a=>s(o).password=a),required:"",autocomplete:"off",autofocus:""},null,8,["modelValue"])]),i("div",B,[t(u,{class:d(["ml-4",{"opacity-25":s(o).processing}]),disabled:s(o).processing},{default:m(()=>r[1]||(r[1]=[n(" Confirm ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{co as default};