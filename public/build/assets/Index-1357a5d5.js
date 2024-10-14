import{B as h}from"./Authenticated-b1361f12.js";import"./moment-a9aaa855.js";import{H as k,L as A}from"./@inertiajs-6e15fcc1.js";import{P as y}from"./Pagination-09328d0e.js";import{_ as C,d as w,e as l,c as d,a as P,b as c}from"./TableRow-089a045b.js";import{_ as H}from"./TableCaption-f1cf5dfd.js";import{_ as L}from"./Card-fefd19ae.js";import{_ as B}from"./DeleteConfirmation-4db61d1d.js";import{a as S}from"./@radix-icons-96330712.js";import{C as j}from"./lucide-vue-next-4722c36e.js";import{y as $,x as r,u as a,Q as t,F as v,be as b,bf as F,t as n,z as p,A as I,v as m,C as f,W as s,J as z,K as g}from"./@vue-2682a433.js";import"./ApplicationLogo-754713c8.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-c86e7426.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";const E={class:"flex items-center justify-between"},R={class:"flex space-x-2"},J={class:"relative"},K={class:"flex items center justify-center space-x-2"},O={components:{Pagination:y,DeleteConfirmation:B,Head:k,Link:A,Table:C,TableBody:w,TableCaption:H,TableCell:l,TableHead:d,TableHeader:P,TableRow:c},data(){return{confirmation:{is_open:!1,route_name:"",id:""},params:{search:this.$page.props.filter.search?this.$page.props.filter.search:""}}},methods:{editProduct(u){this.$inertia.get(this.route("products.edit"),{product_id:u},{replace:!0,preserveState:!0})},deleteProduct(u){this.confirmation.route_name="products.destroy",this.confirmation.id=u,this.confirmation.is_open=!0},search(){this.$inertia.get(this.route("products"),this.params,{replace:!0,preserveState:!0})}}},Ee=Object.assign(O,{__name:"Index",setup(u){return(o,e)=>{const N=b("Input"),_=b("Button"),T=F("debounce");return n(),$(v,null,[r(a(k),{title:"Products"}),r(h,null,{header:t(()=>e[4]||(e[4]=[])),default:t(()=>[p("div",E,[p("div",R,[p("div",J,[r(a(S),{class:"absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"}),I(r(N,{type:"text",placeholder:"Search",class:"w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]",modelValue:o.params.search,"onUpdate:modelValue":e[0]||(e[0]=i=>o.params.search=i)},null,8,["modelValue"]),[[T,o.search,"800ms"]])])]),o.$page.props.can.create_products?(n(),m(_,{key:0,onClick:e[1]||(e[1]=i=>o.$inertia.get(o.route("products.create")))},{default:t(()=>[r(a(j),{class:"h-4 w-4"}),e[5]||(e[5]=p("span",{class:"ml-1 hidden sm:block"},"New Product",-1))]),_:1})):f("",!0)]),r(L,null,{content:t(()=>[r(a(C),null,{default:t(()=>[r(a(P),{class:"bg-gray-100"},{default:t(()=>[r(a(c),null,{default:t(()=>[r(a(d),null,{default:t(()=>e[6]||(e[6]=[s("#")])),_:1}),r(a(d),null,{default:t(()=>e[7]||(e[7]=[s("Name")])),_:1}),r(a(d),null,{default:t(()=>e[8]||(e[8]=[s("Description")])),_:1}),r(a(d),{class:"text-center"},{default:t(()=>e[9]||(e[9]=[s("Action")])),_:1})]),_:1})]),_:1}),r(a(w),null,{default:t(()=>[o.$page.props.products.data.length?f("",!0):(n(),m(a(c),{key:0},{default:t(()=>[r(a(l),{class:"text-center",colspan:"10"},{default:t(()=>e[10]||(e[10]=[p("div",{class:"p-3"}," No Record Found ",-1)])),_:1})]),_:1})),(n(!0),$(v,null,z(o.$page.props.products.data,(i,D)=>(n(),m(a(c),null,{default:t(()=>[r(a(l),null,{default:t(()=>[s(g(o.$page.props.products.from+D),1)]),_:2},1024),r(a(l),null,{default:t(()=>[s(g(i.name),1)]),_:2},1024),r(a(l),null,{default:t(()=>[s(g(i.description),1)]),_:2},1024),r(a(l),{class:"text-center"},{default:t(()=>[p("div",K,[o.$page.props.can.edit_products?(n(),m(_,{key:0,variant:"outline",onClick:V=>o.editProduct(i.id)},{default:t(()=>e[11]||(e[11]=[s("Edit")])),_:2},1032,["onClick"])):f("",!0),o.$page.props.can.delete_products?(n(),m(_,{key:1,variant:"destructive",onClick:e[2]||(e[2]=V=>o.deleteProduct(o.orproductder.id))},{default:t(()=>e[12]||(e[12]=[s("Delete")])),_:1})):f("",!0)])]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),r(y,{page_data:o.$page.props.products,params:o.params},null,8,["page_data","params"]),r(B,{open:o.confirmation.is_open,onClose:e[3]||(e[3]=i=>o.confirmation.is_open=!1),routeName:o.confirmation.route_name,id:o.confirmation.id},{title:t(()=>e[13]||(e[13]=[s("Delete Product")])),description:t(()=>e[14]||(e[14]=[s("Are you sure want to delete this product?")])),_:1},8,["open","routeName","id"])]),_:1})],64)}}});export{Ee as default};