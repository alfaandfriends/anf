import{B as v}from"./Authenticated-6651b23d.js";import{H as c,L as g}from"./@inertiajs-41d03628.js";import{_ as n}from"./Card-dc9fb2d2.js";import{_ as y}from"./DialogModal.vue_vue_type_script_setup_true_lang-00cfcd0f.js";import{x as V,v as l,u as b,P as t,F as C,a5 as i,q as $,V as a,y as r}from"./@vue-64c42e7d.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";const S={class:"grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4"},U=r("span",{class:"text-red-500"},"*",-1),B=r("span",{class:"text-red-500"},"*",-1),L=r("span",{class:"text-red-500"},"*",-1),k=r("span",{class:"text-red-500"},"*",-1),w=r("span",{class:"text-red-500"},"*",-1),D=r("span",{class:"text-red-500"},"*",-1),T=r("span",{class:"text-red-500"},"*",-1),I=r("span",{class:"text-red-500"},"*",-1),N=r("span",{class:"text-red-500"},"*",-1),P={class:"flex items-center justify-between"},j={class:"flex space-x-2 items-center"},A={class:"flex space-x-2"},E={components:{Head:c,Link:g,Card:n,Dialog:y},data(){return{disable_class_types:!0,disable_class_levels:!0,class_types:[],class_levels:[],form:{centre_id:this.$page.props.centre_id?Number(this.$page.props.centre_id):"",programme_id:"",programme_level_id:"",class_day:"",start_time:"",end_time:"",class_capacity:"",class_type:"",class_method:"",class_status:!0}}},watch:{"form.programme_id":{handler(){this.form.programme_id&&(this.disable_class_types=!0,this.disable_class_levels=!0,this.form.class_type="",this.form.programme_level_id="",axios.get(route("classes.get_class_types"),{params:{programme_id:this.form.programme_id}}).then(d=>{this.class_types=d.data,this.disable_class_types=!1}))},deep:!0},"form.class_type":{handler(){this.form.programme_id&&this.form.class_type&&(this.disable_class_levels=!0,this.form.programme_level_id="",axios.get(route("classes.get_class_levels"),{params:{programme_id:this.form.programme_id,class_type:this.form.class_type}}).then(d=>{this.class_levels=d.data,this.disable_class_levels=!1}))},deep:!0}},methods:{submit(){this.$inertia.post(route("classes.store"),this.form,{preserveState:!0})}}},Ne=Object.assign(E,{__name:"Create",setup(d){return(e,s)=>{const m=i("Label"),p=i("ComboBox"),u=i("Datepicker"),f=i("Input"),h=i("Switch"),_=i("Button");return $(),V(C,null,[l(b(c),{title:"Classes"}),l(v,null,{header:t(()=>[]),default:t(()=>[l(n,null,{title:t(()=>[a("Class Information")]),content:t(()=>[r("div",S,[r("div",null,[l(m,null,{default:t(()=>[a("Centre"),U]),_:1}),l(p,{items:e.$page.props.allowed_centres,"label-property":"label","value-property":"ID",error:e.$page.props.errors.centre_id,modelValue:e.form.centre_id,"onUpdate:modelValue":s[0]||(s[0]=o=>e.form.centre_id=o),"select-placeholder":"Select Centre","search-placeholder":"Search centre..."},null,8,["items","error","modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("Programme"),B]),_:1}),l(p,{items:e.$page.props.programme_list,"label-property":"name","value-property":"id",error:!!e.$page.props.errors.programme_id,modelValue:e.form.programme_id,"onUpdate:modelValue":s[1]||(s[1]=o=>e.form.programme_id=o),"select-placeholder":"Select Programme","search-placeholder":"Search programme..."},null,8,["items","error","modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("Class Type"),L]),_:1}),l(p,{items:e.class_types,"label-property":"name","value-property":"id",error:!!e.$page.props.errors.class_type,modelValue:e.form.class_type,"onUpdate:modelValue":s[2]||(s[2]=o=>e.form.class_type=o),"select-placeholder":"Select Class Type","search-placeholder":"Search class type...",disabled:e.disable_class_types},null,8,["items","error","modelValue","disabled"])]),r("div",null,[l(m,null,{default:t(()=>[a("Class Level"),k]),_:1}),l(p,{items:e.class_levels,"label-property":"level","value-property":"id",error:!!e.$page.props.errors.programme_level_id,modelValue:e.form.programme_level_id,"onUpdate:modelValue":s[3]||(s[3]=o=>e.form.programme_level_id=o),"select-placeholder":"Select Class Level","search-placeholder":"Search class level...",disabled:e.disable_class_levels},null,8,["items","error","modelValue","disabled"])]),r("div",null,[l(m,null,{default:t(()=>[a("Class Day"),w]),_:1}),l(p,{items:e.$page.props.day_list,"label-property":"name","value-property":"id",error:!!e.$page.props.errors.class_day,modelValue:e.form.class_day,"onUpdate:modelValue":s[4]||(s[4]=o=>e.form.class_day=o),"select-placeholder":"Select Class Level","search-placeholder":"Search class level..."},null,8,["items","error","modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("Class Method"),D]),_:1}),l(p,{items:e.$page.props.method_list,"label-property":"name","value-property":"id",error:!!e.$page.props.errors.class_method,modelValue:e.form.class_method,"onUpdate:modelValue":s[5]||(s[5]=o=>e.form.class_method=o),"select-placeholder":"Select Class Level","search-placeholder":"Search class level..."},null,8,["items","error","modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("Start Time"),T]),_:1}),l(u,{mode:"time",modelValue:e.form.start_time,"onUpdate:modelValue":s[6]||(s[6]=o=>e.form.start_time=o)},null,8,["modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("End Time"),I]),_:1}),l(u,{mode:"time",modelValue:e.form.end_time,"onUpdate:modelValue":s[7]||(s[7]=o=>e.form.end_time=o)},null,8,["modelValue"])]),r("div",null,[l(m,null,{default:t(()=>[a("Class Capacity"),N]),_:1}),l(f,{type:"number",error:!!e.$page.props.errors.class_capacity,modelValue:e.form.class_capacity,"onUpdate:modelValue":s[8]||(s[8]=o=>e.form.class_capacity=o)},null,8,["error","modelValue"])])])]),_:1}),l(n,null,{content:t(()=>[r("div",P,[r("div",j,[l(m,null,{default:t(()=>[a("Active")]),_:1}),l(h,{modelValue:e.form.class_status,"onUpdate:modelValue":s[9]||(s[9]=o=>e.form.class_status=o)},null,8,["modelValue"])]),r("div",A,[l(_,{variant:"outline",onClick:s[10]||(s[10]=o=>e.$inertia.get(e.route("classes")))},{default:t(()=>[a("Cancel")]),_:1}),l(_,{onClick:e.submit},{default:t(()=>[a("Save")]),_:1},8,["onClick"])])])]),_:1})]),_:1})],64)}}});export{Ne as default};