import{y as d,x as e,u as m,Q as i,F as a,t as l,z as r,G as f,A as n,bH as y,q as p,bG as v,J as c,K as _,W as u}from"./@vue-2682a433.js";import{B as x}from"./Authenticated-07645ace.js";import{B as g}from"./Button-fe79e0ec.js";import{L as w,H as k}from"./@inertiajs-6e15fcc1.js";import{b}from"./@vueform-93d31398.js";import"./ApplicationLogo-754713c8.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-815148a9.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./@radix-icons-96330712.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./lucide-vue-next-62ff5c75.js";const B={class:"md:grid md:grid-cols-2"},V={class:"md:mt-0 md:col-span-2"},h={class:"px-4 py-5 bg-indigo-50 space-y-6 sm:p-6"},S={class:"grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4"},j={class:"sm:row-span-3"},z={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},C={class:"grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4"},L={class:"mb-4"},N={class:"grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4"},T={class:"mb-4"},$=["value"],G={class:"flex justify-between mt-4 items-center"},H={class:""},M={class:"flex flex-row-reverse items-center"},O={class:"flex space-x-2"},U={components:{Link:w,Toggle:b},data(){return{form:{display_name:"",role_group:1,status:!0}}},methods:{submit(){this.$inertia.post(route("roles.store"),this.form)}}},To=Object.assign(U,{__name:"Create",setup(A){return(t,o)=>(l(),d(a,null,[e(m(k),{title:"Roles"}),e(x,null,{header:i(()=>o[4]||(o[4]=[])),default:i(()=>[r("div",B,[r("div",V,[r("form",{onSubmit:o[3]||(o[3]=f((...s)=>t.submit&&t.submit(...s),["prevent"]))},[r("div",h,[r("div",S,[r("div",j,[r("div",z,[o[10]||(o[10]=r("div",{class:"mb-5"},[r("h1",{class:"text-indigo-800 font-bold"},"Role Information"),r("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1)),r("div",C,[r("div",L,[o[5]||(o[5]=r("label",{for:"display_name",class:"block text-sm font-bold text-gray-700"},"Name",-1)),n(r("input",{type:"text",class:p(["mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.display_name?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[0]||(o[0]=s=>t.form.display_name=s)},null,2),[[y,t.form.display_name]])])]),r("div",N,[r("div",T,[o[6]||(o[6]=r("label",{for:"display_name",class:"block text-sm font-bold text-gray-700"},"Group",-1)),n(r("select",{name:"",id:"",class:p(["mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.role_group?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[1]||(o[1]=s=>t.form.role_group=s)},[(l(!0),d(a,null,c(t.$page.props.role_groups,(s,D)=>(l(),d("option",{value:s.id,key:s.id},_(s.name),9,$))),128))],2),[[v,t.form.role_group]])])]),o[11]||(o[11]=r("div",{class:"border-b border-dashed border-indigo-900 mt-4 mb-5"},null,-1)),r("div",G,[r("div",H,[o[7]||(o[7]=r("label",{for:"",class:"font-sm pr-3"},"Status",-1)),e(m(b),{modelValue:t.form.status,"onUpdate:modelValue":o[2]||(o[2]=s=>t.form.status=s),classes:{container:"inline-block",toggle:"flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none",toggleOn:"bg-green-500 border-green-500 justify-start text-white",toggleOff:"bg-gray-400 border-gray-400 justify-end text-gray-700"}},null,8,["modelValue"])]),r("div",M,[r("div",O,[e(g,{buttonType:"gray",url:t.route("roles")},{default:i(()=>o[8]||(o[8]=[u(" Cancel ")])),_:1},8,["url"]),e(g,{type:"submit",disabled:t.form.processing},{default:i(()=>o[9]||(o[9]=[u(" Save ")])),_:1},8,["disabled"])])])])])])])])],32)])])]),_:1})],64))}});export{To as default};