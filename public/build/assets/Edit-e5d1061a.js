import{B as g}from"./Authenticated-e54ea1c2.js";import{H as l,L as f}from"./@inertiajs-dde9cc4c.js";import{_ as s}from"./Card-1dc3a135.js";import{y as _,x as o,u as y,Q as r,F as $,be as p,t as c,W as i,z as m}from"./@vue-d42dd214.js";import"./ApplicationLogo-aa67088e.js";import"./radix-vue-d95f58a2.js";import"./@floating-ui-61ac2ed2.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-9e9c0f86.js";import"./axios-1779699b.js";import"./pusher-js-fe63a254.js";import"./@vueform-cd27a95b.js";import"./cropperjs-ee227adc.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-4b397a2a.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-7b89e231.js";import"./@radix-icons-4975f794.js";import"./@vuepic-1824abb1.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-375e1553.js";import"./vue-227b0305.js";import"./lodash.clonedeep-ab16d4d4.js";import"./qs-19c2a829.js";import"./side-channel-0fc46420.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-c7e60009.js";import"./deepmerge-89e33937.js";import"./nprogress-cbfeb08c.js";import"./index-a78bcd26.js";import"./DialogDescription-befd605e.js";import"./lucide-vue-next-f56ff345.js";const b={class:"grid grid-cols-1 gap-4"},v={components:{Head:l,Link:f},data(){return{form:{category_id:this.$page.props.category_info?this.$page.props.category_info.id:"",dt_id:this.$page.props.category_info?this.$page.props.category_info.dt_id:"",category_name:this.$page.props.category_info?this.$page.props.category_info.name:""}}},methods:{submit(){this.$inertia.post(route("dt.settings.categories.update"),this.form,{preserveState:!0})}}},ft=Object.assign(v,{__name:"Edit",setup(B){return(e,t)=>{const d=p("Label"),u=p("Input"),a=p("Button");return c(),_($,null,[o(y(l),{title:"Diagnostic Test"}),o(g,null,{header:r(()=>t[2]||(t[2]=[])),default:r(()=>[o(s,null,{title:r(()=>t[3]||(t[3]=[i("Category")])),content:r(()=>[m("div",b,[m("div",null,[o(d,null,{default:r(()=>t[4]||(t[4]=[i("Label"),m("span",{class:"text-red-500"},"*",-1)])),_:1}),o(u,{type:"text",error:e.$page.props.errors.category_name,modelValue:e.form.category_name,"onUpdate:modelValue":t[0]||(t[0]=n=>e.form.category_name=n)},null,8,["error","modelValue"])])])]),_:1}),o(s,null,{footer:r(()=>[o(a,{variant:"outline",onClick:t[1]||(t[1]=n=>e.$inertia.get(e.route("dt.settings.details",{dt_id:e.$page.props.diagnostic_test_id})))},{default:r(()=>t[5]||(t[5]=[i("Cancel")])),_:1}),o(a,{onClick:e.submit},{default:r(()=>t[6]||(t[6]=[i("Save")])),_:1},8,["onClick"])]),_:1})]),_:1})],64)}}});export{ft as default};