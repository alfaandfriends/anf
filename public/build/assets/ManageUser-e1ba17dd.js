import{B as f}from"./Authenticated-07645ace.js";import{H as u,L as _}from"./@inertiajs-6e15fcc1.js";import{_ as g}from"./Card-59ecf63d.js";import{y as b,x as r,u as V,Q as o,F as $,be as l,t as C,W as s,z as i}from"./@vue-2682a433.js";import"./ApplicationLogo-754713c8.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-815148a9.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./@radix-icons-96330712.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./lucide-vue-next-62ff5c75.js";const v={class:"grid grid-cols-1 2xl:grid-cols-3 gap-4"},B={components:{Head:u,Link:_},props:{user_id:String,user_centres:Object},data(){return{selected_centres:this.$page.props.user_centres?this.$page.props.user_centres:[]}},methods:{submit(){this.$inertia.post(this.route("teachers.store"),{user_id:this.user_id,selected_centres:this.selected_centres})}}},fe=Object.assign(B,{__name:"ManageUser",setup(y){return(t,e)=>{const n=l("Label"),m=l("Input"),d=l("ComboBox"),a=l("Button");return C(),b($,null,[r(V(u),{title:"Teachers"}),r(f,null,{header:o(()=>e[4]||(e[4]=[])),default:o(()=>[r(g,null,{title:o(()=>e[5]||(e[5]=[s("Assign Centre")])),content:o(()=>[i("div",v,[i("div",null,[r(n,null,{default:o(()=>e[6]||(e[6]=[s("Name")])),_:1}),r(m,{type:"text",modelValue:t.$page.props.user_info.display_name,"onUpdate:modelValue":e[0]||(e[0]=p=>t.$page.props.user_info.display_name=p),disabled:""},null,8,["modelValue"])]),i("div",null,[r(n,null,{default:o(()=>e[7]||(e[7]=[s("Email")])),_:1}),r(m,{type:"text",modelValue:t.$page.props.user_info.user_email,"onUpdate:modelValue":e[1]||(e[1]=p=>t.$page.props.user_info.user_email=p),disabled:""},null,8,["modelValue"])]),i("div",null,[r(n,null,{default:o(()=>e[8]||(e[8]=[s("Centre"),i("span",{class:"text-red-500"},"*",-1)])),_:1}),r(d,{multiple:!0,items:t.$page.props.allowed_centres,"label-property":"label","value-property":"ID",error:t.$page.props.errors.centre_id,modelValue:t.selected_centres,"onUpdate:modelValue":e[2]||(e[2]=p=>t.selected_centres=p),"select-placeholder":"Select Centre","search-placeholder":"Search centre..."},null,8,["items","error","modelValue"])])])]),footer:o(()=>[r(a,{variant:"outline",onClick:e[3]||(e[3]=p=>t.$inertia.get(t.route("teachers")))},{default:o(()=>e[9]||(e[9]=[s("Cancel")])),_:1}),r(a,{onClick:t.submit},{default:o(()=>e[10]||(e[10]=[s("Save")])),_:1},8,["onClick"])]),_:1})]),_:1})],64)}}});export{fe as default};