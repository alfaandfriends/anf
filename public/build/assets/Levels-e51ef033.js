import{B as b}from"./Authenticated-b1361f12.js";import{H as V,L as h}from"./@inertiajs-6e15fcc1.js";import{_ as f}from"./Card-fefd19ae.js";import{_ as j,a as S,b as _,c as v,d as A,e as p}from"./TableRow-089a045b.js";import{_ as T}from"./DeleteConfirmation-4db61d1d.js";import{y as w,x as o,u as s,Q as t,F as L,be as g,t as d,z as l,W as i,v as u,C as k,J as D,K as N}from"./@vue-2682a433.js";import"./ApplicationLogo-754713c8.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-c86e7426.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./@radix-icons-96330712.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./lucide-vue-next-4722c36e.js";const E={class:"grid grid-cols-1 xl:grid-cols-2 gap-4 items-start"},F={class:"flex justify-end"},z={class:"flex justify-center space-x-2"},H={class:"grid grid-cols-1 gap-4"},I={class:"flex justify-end"},R={class:"grid grid-cols-1 gap-4"},U={class:"flex justify-end"},J={components:{Head:V,Link:h},data(){return{show_create:!1,show_edit:!1,confirmation:{is_open:!1,route_name:"",id:""},form:{id:"",level_name:""},errors:{level_name:!1}}},methods:{create(){this.form.level_name="",this.show_create=!0,this.show_edit=!1},edit(a,r){this.form.id=a,this.form.level_name=r,this.show_edit=!0,this.show_create=!1},store(){if(!this.form.level_name){this.errors.level_name=!0;return}this.$inertia.post(route("progress_report.settings.digital_art.levels.store"),this.form,{preserveState:!1})},update(){if(!this.form.level_name){this.errors.level_name=!0;return}this.$inertia.post(route("progress_report.settings.digital_art.levels.update"),this.form,{preserveState:!1})},destroy(a){this.confirmation.route_name="progress_report.settings.digital_art.levels.destroy",this.confirmation.id=a,this.confirmation.is_open=!0},viewThemes(a){this.$inertia.get(route("progress_report.settings.digital_art.themes"),{level_id:a})}}},Ee=Object.assign(J,{__name:"Levels",setup(a){return(r,e)=>{const m=g("Button"),y=g("Label"),C=g("Input");return d(),w(L,null,[o(s(V),{title:"Progress Report"}),o(b,null,{header:t(()=>e[3]||(e[3]=[])),default:t(()=>[l("div",E,[o(f,null,{title:t(()=>[l("div",F,[o(m,{onClick:r.create},{default:t(()=>e[4]||(e[4]=[i("New Level")])),_:1},8,["onClick"])])]),content:t(()=>[o(s(j),null,{default:t(()=>[o(s(S),{class:"bg-gray-100"},{default:t(()=>[o(s(_),null,{default:t(()=>[o(s(v),null,{default:t(()=>e[5]||(e[5]=[i("#")])),_:1}),o(s(v),null,{default:t(()=>e[6]||(e[6]=[i("Name")])),_:1}),o(s(v),{class:"text-center"},{default:t(()=>e[7]||(e[7]=[i("Action")])),_:1})]),_:1})]),_:1}),o(s(A),null,{default:t(()=>[r.$page.props.levels.length?k("",!0):(d(),u(s(_),{key:0},{default:t(()=>[o(s(p),{class:"text-center",colspan:"10"},{default:t(()=>e[8]||(e[8]=[l("div",{class:"p-3"}," No Record Found ",-1)])),_:1})]),_:1})),(d(!0),w(L,null,D(r.$page.props.levels,(n,B)=>(d(),u(s(_),null,{default:t(()=>[o(s(p),null,{default:t(()=>[i(N(B+1),1)]),_:2},1024),o(s(p),null,{default:t(()=>[i(N(n.name),1)]),_:2},1024),o(s(p),{class:"text-center"},{default:t(()=>[l("div",z,[o(m,{variant:"outline",onClick:$=>r.edit(n.id,n.name)},{default:t(()=>e[9]||(e[9]=[i("Edit")])),_:2},1032,["onClick"]),o(m,{variant:"destructive",onClick:$=>r.destroy(n.id)},{default:t(()=>e[10]||(e[10]=[i("Delete")])),_:2},1032,["onClick"]),o(m,{onClick:$=>r.viewThemes(n.id)},{default:t(()=>e[11]||(e[11]=[i("View Themes")])),_:2},1032,["onClick"])])]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),r.show_create?(d(),u(f,{key:0},{title:t(()=>e[12]||(e[12]=[i("Add Level")])),content:t(()=>[l("div",H,[l("div",null,[o(y,null,{default:t(()=>e[13]||(e[13]=[i("Name"),l("span",{class:"text-red-500"},"*",-1)])),_:1}),o(C,{type:"text",error:r.errors.level_name,modelValue:r.form.level_name,"onUpdate:modelValue":e[0]||(e[0]=n=>r.form.level_name=n)},null,8,["error","modelValue"])])])]),footer:t(()=>[l("div",I,[o(m,{onClick:r.store},{default:t(()=>e[14]||(e[14]=[i("Save")])),_:1},8,["onClick"])])]),_:1})):k("",!0),r.show_edit?(d(),u(f,{key:1},{title:t(()=>e[15]||(e[15]=[i("Edit Level")])),content:t(()=>[l("div",R,[l("div",null,[o(y,null,{default:t(()=>e[16]||(e[16]=[i("Name"),l("span",{class:"text-red-500"},"*",-1)])),_:1}),o(C,{type:"text",error:r.errors.level_name,modelValue:r.form.level_name,"onUpdate:modelValue":e[1]||(e[1]=n=>r.form.level_name=n)},null,8,["error","modelValue"])])])]),footer:t(()=>[l("div",U,[o(m,{onClick:r.update},{default:t(()=>e[17]||(e[17]=[i("Save")])),_:1},8,["onClick"])])]),_:1})):k("",!0)]),o(T,{open:r.confirmation.is_open,onClose:e[2]||(e[2]=n=>r.confirmation.is_open=!1),routeName:r.confirmation.route_name,id:r.confirmation.id},{title:t(()=>e[18]||(e[18]=[i("Delete Level")])),description:t(()=>e[19]||(e[19]=[i("Are you sure want to delete this level?")])),_:1},8,["open","routeName","id"])]),_:1})],64)}}});export{Ee as default};