import{B as y}from"./Authenticated-e54ea1c2.js";import{H as f,L as v}from"./@inertiajs-dde9cc4c.js";import{_ as s}from"./Card-1dc3a135.js";import{_ as V}from"./DialogModal-27aa9903.js";import{y as g,x as e,u as $,Q as l,F as b,be as n,t as C,W as m,z as t}from"./@vue-d42dd214.js";import"./ApplicationLogo-aa67088e.js";import"./radix-vue-d95f58a2.js";import"./@floating-ui-61ac2ed2.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-9e9c0f86.js";import"./axios-1779699b.js";import"./pusher-js-fe63a254.js";import"./@vueform-cd27a95b.js";import"./cropperjs-ee227adc.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-4b397a2a.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-7b89e231.js";import"./@radix-icons-4975f794.js";import"./@vuepic-1824abb1.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-375e1553.js";import"./vue-227b0305.js";import"./lodash.clonedeep-ab16d4d4.js";import"./qs-19c2a829.js";import"./side-channel-0fc46420.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-c7e60009.js";import"./deepmerge-89e33937.js";import"./nprogress-cbfeb08c.js";import"./index-a78bcd26.js";import"./DialogDescription-befd605e.js";import"./lucide-vue-next-f56ff345.js";const _={class:"grid grid-cols-1 2xl:grid-cols-3 gap-4"},B={class:"flex items-center justify-end"},S={class:"flex space-x-2"},k={components:{Head:f,Link:v,Card:s,Dialog:V},data(){return{form:{promo_name:"",country_id:"",duration_id:"",type_id:"",promo_value:""}}},methods:{submit(){this.$inertia.post(route("fee.promos.store"),this.form,{preserveState:!0})}}},Co=Object.assign(k,{__name:"Create",setup(L){return(r,o)=>{const i=n("Label"),u=n("Input"),a=n("ComboBox"),d=n("Button");return C(),g(b,null,[e($(f),{title:"Promotions"}),e(y,null,{header:l(()=>o[6]||(o[6]=[])),default:l(()=>[e(s,null,{title:l(()=>o[7]||(o[7]=[m("Promotion Information")])),content:l(()=>[t("div",_,[t("div",null,[e(i,null,{default:l(()=>o[8]||(o[8]=[m("Name"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),e(u,{type:"text",error:r.$page.props.errors.promo_name,modelValue:r.form.promo_name,"onUpdate:modelValue":o[0]||(o[0]=p=>r.form.promo_name=p)},null,8,["error","modelValue"])]),t("div",null,[e(i,null,{default:l(()=>o[9]||(o[9]=[m("Country"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),e(a,{items:r.$page.props.countries,"label-property":"name","value-property":"id",error:r.$page.props.errors.country_id,modelValue:r.form.country_id,"onUpdate:modelValue":o[1]||(o[1]=p=>r.form.country_id=p),"select-placeholder":"Select Country","search-placeholder":"Search country..."},null,8,["items","error","modelValue"])]),t("div",null,[e(i,null,{default:l(()=>o[10]||(o[10]=[m("Duration"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),e(a,{items:r.$page.props.durations,"label-property":"name","value-property":"id",error:r.$page.props.errors.duration_id,modelValue:r.form.duration_id,"onUpdate:modelValue":o[2]||(o[2]=p=>r.form.duration_id=p),"select-placeholder":"Select Duration","search-placeholder":"Search duration..."},null,8,["items","error","modelValue"])]),t("div",null,[e(i,null,{default:l(()=>o[11]||(o[11]=[m("Type of Promotion"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),e(a,{items:r.$page.props.types,"label-property":"name","value-property":"id",error:r.$page.props.errors.type_id,modelValue:r.form.type_id,"onUpdate:modelValue":o[3]||(o[3]=p=>r.form.type_id=p),"select-placeholder":"Select Type","search-placeholder":"Search type..."},null,8,["items","error","modelValue"])]),t("div",null,[e(i,null,{default:l(()=>o[12]||(o[12]=[m("Amount"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),e(u,{type:"number",error:r.$page.props.errors.promo_value,modelValue:r.form.promo_value,"onUpdate:modelValue":o[4]||(o[4]=p=>r.form.promo_value=p)},null,8,["error","modelValue"])])])]),_:1}),e(s,null,{content:l(()=>[t("div",B,[t("div",S,[e(d,{variant:"outline",onClick:o[5]||(o[5]=p=>r.$inertia.get(r.route("fee.promos")))},{default:l(()=>o[13]||(o[13]=[m("Cancel")])),_:1}),e(d,{onClick:r.submit},{default:l(()=>o[14]||(o[14]=[m("Save")])),_:1},8,["onClick"])])])]),_:1})]),_:1})],64)}}});export{Co as default};