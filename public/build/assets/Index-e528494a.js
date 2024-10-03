import{B as V}from"./Authenticated-1ce11f58.js";import{H as b,L as w}from"./@inertiajs-4f2e6820.js";import{P as h}from"./Pagination-114a1053.js";import{_ as N}from"./Card-f87c93de.js";import{_ as L,a as x,b as l,c as m,d as A,e as p}from"./TableRow-4c575246.js";import{a as D}from"./@radix-icons-de95313b.js";import{y as _,x as e,u as r,Q as t,F as g,be as c,bf as E,t as i,z as $,A as F,W as s,v as u,C as v,J as I,K as d}from"./@vue-66b8c761.js";import"./ApplicationLogo-f9b7ff8a.js";import"./radix-vue-aa72069b.js";import"./@floating-ui-b481b296.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-96c5db8f.js";import"./axios-1779699b.js";import"./pusher-js-cb9cdec3.js";import"./@vueform-4cba997d.js";import"./cropperjs-c64556db.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-2d2eee44.js";import"./tailwind-merge-26e9d2f1.js";import"./@vueuse-b3927753.js";import"./@vuepic-9e573d95.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-802c39ac.js";import"./vue-978cb4c7.js";import"./lodash.clonedeep-6494eade.js";import"./qs-740c36f9.js";import"./side-channel-eec8ae42.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-d4161e53.js";import"./deepmerge-89e33937.js";import"./nprogress-5b8a22ad.js";import"./lucide-vue-next-bc441494.js";const S={class:"relative"},U={components:{Head:b,Link:w,Pagination:h},props:{filter:Object},data(){return{params:{search:this.$page.props.filter.search?this.$page.props.filter.search:"",centre_id:this.$page.props.filter.centre_id?this.$page.props.filter.centre_id:""}}},methods:{manageUser(f){this.$inertia.get(this.route("centre_manager.manage"),{user_id:f})},search(){this.$inertia.get(this.route("centre_manager"),this.params,{replace:!0,preserveState:!0})}}},Ae=Object.assign(U,{__name:"Index",setup(f){return(o,a)=>{const k=c("Input"),B=c("Button"),y=E("debounce");return i(),_(g,null,[e(r(b),{title:"Centre Manager"}),e(V,null,{header:t(()=>a[1]||(a[1]=[])),default:t(()=>[$("div",S,[e(r(D),{class:"absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"}),F(e(k,{type:"text",placeholder:"Search",class:"w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]",modelValue:o.params.search,"onUpdate:modelValue":a[0]||(a[0]=n=>o.params.search=n)},null,8,["modelValue"]),[[y,o.search,"800ms"]])]),e(N,null,{content:t(()=>[e(r(L),null,{default:t(()=>[e(r(x),{class:"bg-gray-100"},{default:t(()=>[e(r(l),null,{default:t(()=>[e(r(m),null,{default:t(()=>a[2]||(a[2]=[s("#")])),_:1}),e(r(m),null,{default:t(()=>a[3]||(a[3]=[s("Name")])),_:1}),e(r(m),null,{default:t(()=>a[4]||(a[4]=[s("Email")])),_:1}),e(r(m),{class:"text-center"},{default:t(()=>a[5]||(a[5]=[s("Action")])),_:1})]),_:1})]),_:1}),e(r(A),null,{default:t(()=>[o.$page.props.centre_managers.data.length?v("",!0):(i(),u(r(l),{key:0},{default:t(()=>[e(r(p),{class:"text-center",colspan:"10"},{default:t(()=>a[6]||(a[6]=[$("div",{class:"p-3"}," No Record Found ",-1)])),_:1})]),_:1})),(i(!0),_(g,null,I(o.$page.props.centre_managers.data,(n,C)=>(i(),u(r(l),null,{default:t(()=>[e(r(p),null,{default:t(()=>[s(d(o.$page.props.centre_managers.from+C),1)]),_:2},1024),e(r(p),null,{default:t(()=>[s(d(n.name),1)]),_:2},1024),e(r(p),null,{default:t(()=>[s(d(n.email),1)]),_:2},1024),e(r(p),{class:"text-center"},{default:t(()=>[o.$page.props.can.manage_centre_manager?(i(),u(B,{key:0,variant:"outline",onClick:j=>o.manageUser(n.id)},{default:t(()=>a[7]||(a[7]=[s("Edit")])),_:2},1032,["onClick"])):v("",!0)]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),e(h,{page_data:o.$page.props.centre_managers,params:o.params},null,8,["page_data","params"])]),_:1})],64)}}});export{Ae as default};