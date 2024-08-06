import{B,_ as N,a as U,b as E,c as L}from"./Authenticated-8999fe17.js";import{H as v,L as z}from"./@inertiajs-751b4e3a.js";import{P as b}from"./Pagination-c4e11c15.js";import{_ as D}from"./Card-8bfd7435.js";import{_ as F,d as I,e as m,c as l,a as P,b as n}from"./TableRow-160e3af4.js";import{b as S}from"./@radix-icons-9a1732cf.js";import{E as j}from"./lucide-vue-next-4cc1c774.js";import{b5 as g,b6 as A,q as i,x as h,v as e,u as t,P as a,F as $,y as _,K as H,V as o,t as c,z as k,C as M,G as d}from"./@vue-7927adca.js";import"./ApplicationLogo-04b49080.js";import"./radix-vue-8d4617bd.js";import"./@floating-ui-1e8ef191.js";import"./class-variance-authority-f96983da.js";import"./app-dce748c9.js";import"./axios-9cbf0d09.js";import"./pusher-js-36ce843e.js";import"./@vueform-aef92a1c.js";import"./@vuepic-ba9c4d94.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-8efab0ec.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-e8993a83.js";import"./lodash.isequal-979ca240.js";import"./vue-446e1be1.js";import"./lodash.clonedeep-a2a90952.js";import"./qs-c5780410.js";import"./side-channel-c3de7aff.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-30e6e08c.js";import"./deepmerge-89e33937.js";import"./nprogress-2c66c043.js";const O={class:"relative"},q=_("div",{class:"p-3"}," No Record Found ",-1),G=_("span",{class:"sr-only"},"More",-1),K={components:{Head:v,Link:z,Pagination:b},props:{filter:Object},data(){return{params:{search:this.$page.props.filter.search?this.$page.props.filter.search:"",centre_id:this.$page.props.filter.centre_id?this.$page.props.filter.centre_id:""}}},methods:{manageUser(u){this.$inertia.get(this.route("centre_manager.manage"),{user_id:u})},search(){this.$inertia.get(this.route("centre_manager"),this.params,{replace:!0,preserveState:!0})}}},Se=Object.assign(K,{__name:"Index",setup(u){return(r,f)=>{const C=g("Input"),V=g("Button"),w=A("debounce");return i(),h($,null,[e(t(v),{title:"Centre Managers"}),e(B,null,{header:a(()=>[]),default:a(()=>[_("div",O,[e(t(S),{class:"absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"}),H(e(C,{type:"text",placeholder:"Search",class:"w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]",modelValue:r.params.search,"onUpdate:modelValue":f[0]||(f[0]=s=>r.params.search=s)},null,8,["modelValue"]),[[w,r.search,"800ms"]])]),e(D,null,{content:a(()=>[e(t(F),null,{default:a(()=>[e(t(I),{class:"bg-gray-100"},{default:a(()=>[e(t(m),null,{default:a(()=>[e(t(l),null,{default:a(()=>[o("#")]),_:1}),e(t(l),null,{default:a(()=>[o("Name")]),_:1}),e(t(l),null,{default:a(()=>[o("Email")]),_:1}),e(t(l),{class:"text-center"},{default:a(()=>[o("Action")]),_:1})]),_:1})]),_:1}),e(t(P),null,{default:a(()=>[r.$page.props.centre_managers.data.length?k("",!0):(i(),c(t(m),{key:0},{default:a(()=>[e(t(n),{class:"text-center",colspan:"10"},{default:a(()=>[q]),_:1})]),_:1})),(i(!0),h($,null,M(r.$page.props.centre_managers.data,(s,y)=>(i(),c(t(m),null,{default:a(()=>[e(t(n),{class:"cursor-pointer",onClick:p=>r.manageUser(s.id)},{default:a(()=>[o(d(r.$page.props.centre_managers.from+y),1)]),_:2},1032,["onClick"]),e(t(n),{class:"cursor-pointer",onClick:p=>r.manageUser(s.id)},{default:a(()=>[o(d(s.name),1)]),_:2},1032,["onClick"]),e(t(n),{class:"cursor-pointer",onClick:p=>r.manageUser(s.id)},{default:a(()=>[o(d(s.email),1)]),_:2},1032,["onClick"]),e(t(n),{class:"text-center"},{default:a(()=>[e(N,null,{default:a(()=>[e(U,{"as-child":""},{default:a(()=>[e(V,{size:"icon",variant:"outline",class:"h-8 w-8"},{default:a(()=>[e(t(j),{class:"h-3.5 w-3.5"}),G]),_:1})]),_:1}),e(E,{align:"end"},{default:a(()=>[r.$page.props.can.manage_centre_manager?(i(),c(L,{key:0,onClick:p=>r.manageUser(s.id)},{default:a(()=>[o("Edit")]),_:2},1032,["onClick"])):k("",!0)]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),e(b,{page_data:r.$page.props.centre_managers,params:r.params},null,8,["page_data","params"])]),_:1})],64)}}});export{Se as default};