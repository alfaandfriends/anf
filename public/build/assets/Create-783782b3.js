import{B as f}from"./Authenticated-b1361f12.js";import{H as g,L as V}from"./@inertiajs-6e15fcc1.js";import{_ as n}from"./Card-fefd19ae.js";import{y as v,x as o,u as y,Q as l,F as $,be as m,t as h,W as p,z as t}from"./@vue-2682a433.js";import"./ApplicationLogo-754713c8.js";import"./radix-vue-1c0958bf.js";import"./@floating-ui-46419ac1.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-c86e7426.js";import"./axios-1779699b.js";import"./pusher-js-747fa3ad.js";import"./@vueform-93d31398.js";import"./cropperjs-1d139b1c.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-ae9c59f1.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-bada8fb2.js";import"./@radix-icons-96330712.js";import"./@vuepic-72648ebd.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-aa94bca8.js";import"./vue-210fd32b.js";import"./lodash.clonedeep-15f95254.js";import"./qs-d67e8c34.js";import"./side-channel-51e4be2c.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-110a5121.js";import"./deepmerge-89e33937.js";import"./nprogress-47dccea4.js";import"./lucide-vue-next-4722c36e.js";const C={class:"grid grid-cols-1 2xl:grid-cols-3 gap-4"},b={class:"grid grid-cols-1 2xl:grid-cols-2 gap-4"},B={class:"grid grid-cols-1 2xl:grid-cols-2 gap-4"},S={class:"flex justify-end"},w={class:"flex space-x-2"},L={components:{Head:g,Link:V},data(){return{form:{name:"",age:"",language:"",chart_type:this.$page.props.chart_types[0].id,lower_score:"",lower_score_direction:"",higher_score:"",higher_score_direction:""}}},methods:{submit(){this.$inertia.post(route("dt.settings.store"),this.form,{preserveState:!0})}}},ye=Object.assign(L,{__name:"Create",setup(U){return(r,e)=>{const s=m("Label"),d=m("Input"),i=m("ComboBox"),u=m("Button");return h(),v($,null,[o(y(g),{title:"Diagnostic Test"}),o(f,null,{header:l(()=>e[9]||(e[9]=[])),default:l(()=>[o(n,null,{title:l(()=>e[10]||(e[10]=[p("Basic Information")])),content:l(()=>[t("div",C,[t("div",null,[o(s,null,{default:l(()=>e[11]||(e[11]=[p("Name"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),o(d,{type:"text",error:r.$page.props.errors.name,modelValue:r.form.name,"onUpdate:modelValue":e[0]||(e[0]=a=>r.form.name=a)},null,8,["error","modelValue"])]),t("div",null,[o(s,null,{default:l(()=>e[12]||(e[12]=[p("Age"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),o(i,{items:r.$page.props.ages,"label-property":"name","value-property":"id",error:r.$page.props.errors.age,modelValue:r.form.age,"onUpdate:modelValue":e[1]||(e[1]=a=>r.form.age=a),"select-placeholder":"Select Age","search-placeholder":"Search age..."},null,8,["items","error","modelValue"])]),t("div",null,[o(s,null,{default:l(()=>e[13]||(e[13]=[p("Language"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),o(i,{items:r.$page.props.languages,"label-property":"name","value-property":"id",error:r.$page.props.errors.language,modelValue:r.form.language,"onUpdate:modelValue":e[2]||(e[2]=a=>r.form.language=a),"select-placeholder":"Select Language","search-placeholder":"Search language..."},null,8,["items","error","modelValue"])])])]),_:1}),o(n,null,{title:l(()=>e[14]||(e[14]=[p("Conditions")])),content:l(()=>[t("div",b,[t("div",null,[o(s,null,{default:l(()=>e[15]||(e[15]=[p("If score less than"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),o(d,{type:"text",error:r.$page.props.errors.lower_score,modelValue:r.form.lower_score,"onUpdate:modelValue":e[3]||(e[3]=a=>r.form.lower_score=a)},null,8,["error","modelValue"])]),t("div",null,[o(s,null,{default:l(()=>e[16]||(e[16]=[p("Go to")])),_:1}),o(i,{canClear:!0,items:r.$page.props.dt_list,"label-property":"name","value-property":"id",error:r.$page.props.errors.lower_score_direction,modelValue:r.form.lower_score_direction,"onUpdate:modelValue":e[4]||(e[4]=a=>r.form.lower_score_direction=a),"select-placeholder":"Default (No Redirection)","search-placeholder":"Search redirection..."},null,8,["items","error","modelValue"])]),t("div",null,[o(s,null,{default:l(()=>e[17]||(e[17]=[p("If score more than"),t("span",{class:"text-red-500"},"*",-1)])),_:1}),o(d,{type:"text",error:r.$page.props.errors.higher_score,modelValue:r.form.higher_score,"onUpdate:modelValue":e[5]||(e[5]=a=>r.form.higher_score=a)},null,8,["error","modelValue"])]),t("div",null,[o(s,null,{default:l(()=>e[18]||(e[18]=[p("Language")])),_:1}),o(i,{canClear:!0,items:r.$page.props.dt_list,"label-property":"name","value-property":"id",error:r.$page.props.errors.higher_score_direction,modelValue:r.form.higher_score_direction,"onUpdate:modelValue":e[6]||(e[6]=a=>r.form.higher_score_direction=a),"select-placeholder":"Default (No Redirection)","search-placeholder":"Search language..."},null,8,["items","error","modelValue"])])])]),_:1}),o(n,null,{title:l(()=>e[19]||(e[19]=[p("Chart")])),content:l(()=>[t("div",B,[t("div",null,[o(s,null,{default:l(()=>e[20]||(e[20]=[p("Chart Type")])),_:1}),o(i,{items:r.$page.props.chart_types,"label-property":"name","value-property":"id",error:r.$page.props.errors.chart_type,modelValue:r.form.chart_type,"onUpdate:modelValue":e[7]||(e[7]=a=>r.form.chart_type=a),"select-placeholder":"Select Chart","search-placeholder":"Search chart..."},null,8,["items","error","modelValue"])])])]),_:1}),o(n,null,{content:l(()=>[t("div",S,[t("div",w,[o(u,{variant:"outline",onClick:e[8]||(e[8]=a=>r.$inertia.get(r.route("dt.settings")))},{default:l(()=>e[21]||(e[21]=[p("Cancel")])),_:1}),o(u,{onClick:r.submit},{default:l(()=>e[22]||(e[22]=[p("Save")])),_:1},8,["onClick"])])])]),_:1})]),_:1})],64)}}});export{ye as default};