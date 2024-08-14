import{B as _}from"./Authenticated-6651b23d.js";import{H as u,L as c}from"./@inertiajs-41d03628.js";import{_ as f}from"./Card-dc9fb2d2.js";import{x as g,v as t,u as V,P as r,F as b,a5 as l,q as $,V as i,y as s}from"./@vue-64c42e7d.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";const C={class:"grid grid-cols-1 2xl:grid-cols-3 gap-4"},v=s("span",{class:"text-red-500"},"*",-1),h={components:{Head:u,Link:c},props:{user_id:String,user_centres:Object},data(){return{selected_centres:this.$page.props.user_centres?this.$page.props.user_centres:[]}},methods:{submit(){this.$inertia.post(this.route("edupreneurs.store"),{user_id:this.user_id,selected_centres:this.selected_centres})}}},be=Object.assign(h,{__name:"ManageUser",setup(B){return(e,o)=>{const n=l("Label"),m=l("Input"),d=l("ComboBox"),a=l("Button");return $(),g(b,null,[t(V(u),{title:"Edupreneurs"}),t(_,null,{header:r(()=>[]),default:r(()=>[t(f,null,{title:r(()=>[i("Assign Centre")]),content:r(()=>[s("div",C,[s("div",null,[t(n,null,{default:r(()=>[i("Name")]),_:1}),t(m,{type:"text",modelValue:e.$page.props.user_info.display_name,"onUpdate:modelValue":o[0]||(o[0]=p=>e.$page.props.user_info.display_name=p),disabled:""},null,8,["modelValue"])]),s("div",null,[t(n,null,{default:r(()=>[i("Email")]),_:1}),t(m,{type:"text",modelValue:e.$page.props.user_info.user_email,"onUpdate:modelValue":o[1]||(o[1]=p=>e.$page.props.user_info.user_email=p),disabled:""},null,8,["modelValue"])]),s("div",null,[t(n,null,{default:r(()=>[i("Centre"),v]),_:1}),t(d,{multiple:!0,items:e.$page.props.allowed_centres,"label-property":"label","value-property":"ID",error:e.$page.props.errors.centre_id,modelValue:e.selected_centres,"onUpdate:modelValue":o[2]||(o[2]=p=>e.selected_centres=p),"select-placeholder":"Select Centre","search-placeholder":"Search centre..."},null,8,["items","error","modelValue"])])])]),footer:r(()=>[t(a,{variant:"outline",onClick:o[3]||(o[3]=p=>e.$inertia.get(e.route("edupreneurs")))},{default:r(()=>[i("Cancel")]),_:1}),t(a,{onClick:e.submit},{default:r(()=>[i("Save")]),_:1},8,["onClick"])]),_:1})]),_:1})],64)}}});export{be as default};