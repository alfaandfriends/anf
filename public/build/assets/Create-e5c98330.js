import{c as n,b as o,u as c,w as a,F as m,H as l,L as p,o as u,d as s,e as _,f,l as g,n as b,k as i}from"./app-c0ce435d.js";import{B as y}from"./Authenticated-395bc6e6.js";import{B as d}from"./Button-465ea343.js";import"./ApplicationLogo-39485cc1.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./XIcon-084af2a1.js";import"./default.css_vue_type_style_index_0_src_true_lang-a2b621a6.js";import"./moment-fbc5633a.js";const h={class:"md:grid md:grid-cols-2"},v={class:"md:mt-0 md:col-span-2"},w={class:"px-4 py-5 bg-white space-y-6 sm:p-6"},x={class:"grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4"},B={class:"sm:row-span-3"},k=s("div",{class:"mb-5"},[s("h1",{class:"text-indigo-800 font-bold"},"Class Type Information"),s("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),C={class:"grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4"},T={class:"mb-4"},z=s("label",{for:"class_type",class:"block text-sm text-gray-700 font-bold"},[i("Class Type"),s("span",{class:"text-red-500"},"*")],-1),S={class:"mt-1 flex rounded-md shadow-sm"},V={class:"flex items-end justify-start space-x-2"},L={components:{Head:l,Link:p},data(){return{form:{class_type:""}}},methods:{submit(){this.$inertia.post(route("settings.class_types.store"),this.form,{preserveState:!0})}}},G=Object.assign(L,{__name:"Create",setup(N){return(e,t)=>(u(),n(m,null,[o(c(l),{title:"General Setting"}),o(y,null,{header:a(()=>[]),default:a(()=>[s("div",h,[s("div",v,[s("form",{onSubmit:t[1]||(t[1]=_((...r)=>e.submit&&e.submit(...r),["prevent"]))},[s("div",w,[s("div",x,[s("div",B,[k,s("div",C,[s("div",T,[z,s("div",S,[f(s("input",{type:"text",name:"class_type",id:"class_type",class:b(["capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",e.$page.props.errors.class_type?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":t[0]||(t[0]=r=>e.form.class_type=r),autocomplete:"off"},null,2),[[g,e.form.class_type]])])])])])]),s("div",V,[o(d,{buttonType:"gray",route:e.route("settings.class_types")},{default:a(()=>[i("Cancel")]),_:1},8,["route"]),o(d,{type:"submit"},{default:a(()=>[i("Save ")]),_:1})])])],32)])])]),_:1})],64))}});export{G as default};