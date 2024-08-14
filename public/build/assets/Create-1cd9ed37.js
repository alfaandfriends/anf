import{x as d,v as r,u as l,P as e,F as n,q as c,y as t,B as u,K as _,bv as f,m as g,V as m}from"./@vue-64c42e7d.js";import{B as b}from"./Authenticated-6651b23d.js";import{B as a}from"./Button-df73f7a0.js";import{H as p,L as y}from"./@inertiajs-41d03628.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";const h={class:"md:grid md:grid-cols-2"},v={class:"md:mt-0 md:col-span-2"},x={class:"px-4 py-5 bg-white space-y-6 sm:p-6"},w={class:"grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4"},B={class:"sm:row-span-3"},C=t("div",{class:"mb-5"},[t("h1",{class:"text-indigo-800 font-bold"},"Class Type Information"),t("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),k={class:"grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4"},T={class:"mb-4"},V=t("label",{for:"class_type",class:"block text-sm text-gray-700 font-bold"},[m("Class Type"),t("span",{class:"text-red-500"},"*")],-1),z={class:"mt-1 flex rounded-md shadow-sm"},S={class:"flex items-end justify-start space-x-2"},L={components:{Head:p,Link:y},data(){return{form:{class_type:""}}},methods:{submit(){this.$inertia.post(route("settings.class_types.store"),this.form,{preserveState:!0})}}},Tt=Object.assign(L,{__name:"Create",setup(N){return(s,o)=>(c(),d(n,null,[r(l(p),{title:"General Setting"}),r(b,null,{header:e(()=>[]),default:e(()=>[t("div",h,[t("div",v,[t("form",{onSubmit:o[1]||(o[1]=u((...i)=>s.submit&&s.submit(...i),["prevent"]))},[t("div",x,[t("div",w,[t("div",B,[C,t("div",k,[t("div",T,[V,t("div",z,[_(t("input",{type:"text",name:"class_type",id:"class_type",class:g(["capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",s.$page.props.errors.class_type?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[0]||(o[0]=i=>s.form.class_type=i),autocomplete:"off"},null,2),[[f,s.form.class_type]])])])])])]),t("div",S,[r(a,{buttonType:"gray",url:s.route("settings.class_types")},{default:e(()=>[m("Cancel")]),_:1},8,["url"]),r(a,{type:"submit"},{default:e(()=>[m("Save ")]),_:1})])])],32)])])]),_:1})],64))}});export{Tt as default};