import{x as n,v as s,u as w,P as r,F as h,q as l,y as e,V as i,z as c,C as x,G as _,K as f,bv as u,m as v}from"./@vue-64c42e7d.js";import{B as k}from"./Authenticated-6651b23d.js";import{B as m}from"./Button-df73f7a0.js";import{r as C,a as B,b as T}from"./@heroicons-3c270557.js";import{H as g,L as $}from"./@inertiajs-41d03628.js";import{C as b}from"./ConfirmationModal-617f2ef8.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";import"./@headlessui-28549402.js";const D={class:"py-4 px-4"},L={class:"grid grid-cols-2 gap-4"},N={class:"flex justify-end pb-4 relative text-gray-400 focus-within:text-gray-600 items-center"},V={class:"flex"},R={class:"grid grid-cols-2 gap-4"},S={class:"space-y-2"},j={class:"shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"},O={class:"min-w-full divide-y divide-gray-200"},z=e("thead",{class:"bg-gray-300"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12"},"#"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12"},"Level"),e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12"},"Action")])],-1),A={class:"bg-white divide-y divide-gray-200"},P={key:0},E=e("td",{class:"text-center",colspan:"10"},[e("div",{class:"p-3"}," No Record Found ")],-1),F=[E],I={class:"hover:bg-gray-200"},M={class:"px-6 py-4 whitespace-nowrap"},H={class:"text-sm font-medium text-gray-700"},U={class:"px-6 py-4 whitespace-nowrap"},q={class:"flex flex-col space-y-1 text-sm text-gray-900"},G={class:"font-semibold"},K={class:"px-6 py-4 whitespace-nowrap text-center text-sm font-medium"},J={class:"flex justify-center space-x-2"},Q={key:0,class:"space-y-2"},W={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},X=e("div",{class:"mb-5 border-b-indigo-500 border-b border-dashed"},[e("h2",{class:"font-display font-bold text-indigo-600"},"New Level")],-1),Y={class:"grid grid-cols-1 gap-0 sm:gap-4"},Z={class:"mb-4"},ee=e("label",{for:"level_name",class:"block text-sm text-gray-700 font-bold"},[i(" Name "),e("span",{class:"text-red-500"},"*")],-1),te={class:"mt-1 flex rounded-md shadow-sm"},oe={class:"px-6 py-4 bg-white border border-gray-200 rounded-lg shadow-md"},se={class:"flex justify-end"},re={key:1,class:"space-y-2"},ie={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},ae=e("div",{class:"mb-5 border-b-indigo-500 border-b border-dashed"},[e("h2",{class:"font-display font-bold text-indigo-600"},"Edit Level")],-1),de={class:"grid grid-cols-1 gap-0 sm:gap-4"},ne={class:"mb-4"},le=e("label",{for:"level_name",class:"block text-sm text-gray-700 font-bold"},[i(" Name "),e("span",{class:"text-red-500"},"*")],-1),me={class:"mt-1 flex rounded-md shadow-sm"},ce={class:"px-6 py-4 bg-white border border-gray-200 rounded-lg shadow-md"},pe={class:"flex justify-end"},he={components:{SearchIcon:C,TrashIcon:B,PencilIcon:T,Head:g,Link:$,ConfirmationModal:b},data(){return{isOpen:!1,confirmationData:"",confirmationRoute:"",show_create:!1,show_edit:!1,form:{id:"",level_name:""},errors:{level_name:!1}}},methods:{create(){this.form.level_name="",this.show_create=!0,this.show_edit=!1},edit(a,t){this.form.id=a,this.form.level_name=t,this.show_edit=!0,this.show_create=!1},store(){if(!this.form.level_name){this.errors.level_name=!0;return}this.$inertia.post(route("progress_report.settings.math.levels.store"),this.form,{preserveState:!1})},update(){if(!this.form.level_name){this.errors.level_name=!0;return}this.$inertia.post(route("progress_report.settings.math.levels.update"),this.form,{preserveState:!1})},destroy(a){this.confirmationRoute="progress_report.settings.math.levels.destroy",this.confirmationData=a,this.isOpen=!0},viewTermBook(a){this.$inertia.get(route("progress_report.settings.math.terms_books"),{level_id:a})}}},ct=Object.assign(he,{__name:"Levels",setup(a){return(t,d)=>(l(),n(h,null,[s(w(g),{title:"Progress Report"}),s(k,null,{header:r(()=>[]),default:r(()=>[e("div",D,[e("div",L,[e("div",N,[e("div",V,[s(m,{onClick:t.create},{default:r(()=>[i("New Level")]),_:1},8,["onClick"])])])]),e("div",R,[e("div",S,[e("div",j,[e("table",O,[z,e("tbody",A,[t.$page.props.levels.length?c("",!0):(l(),n("tr",P,F)),(l(!0),n(h,null,x(t.$page.props.levels,(o,y)=>(l(),n("tr",I,[e("td",M,[e("div",H,_(++y),1)]),e("td",U,[e("div",q,[e("span",G,_(o.name),1)])]),e("td",K,[e("div",J,[s(m,{buttonType:"warning",onClick:p=>t.edit(o.id,o.name)},{default:r(()=>[i("Edit")]),_:2},1032,["onClick"]),s(m,{buttonType:"danger",onClick:p=>t.destroy(o.id)},{default:r(()=>[i("Delete")]),_:2},1032,["onClick"]),s(m,{buttonType:"blue",onClick:p=>t.viewTermBook(o.id)},{default:r(()=>[i("View Terms / Books")]),_:2},1032,["onClick"])])])]))),256))])])])]),t.show_create?(l(),n("div",Q,[e("div",W,[X,e("div",Y,[e("div",Z,[ee,e("div",te,[f(e("input",{type:"text",name:"level_name",id:"level_name",class:v(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.errors.level_name?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":d[0]||(d[0]=o=>t.form.level_name=o),autocomplete:"off"},null,2),[[u,t.form.level_name]])])])])]),e("div",oe,[e("div",se,[s(m,{onClick:t.store},{default:r(()=>[i("Save")]),_:1},8,["onClick"])])])])):c("",!0),t.show_edit?(l(),n("div",re,[e("div",ie,[ae,e("div",de,[e("div",ne,[le,e("div",me,[f(e("input",{type:"text",name:"level_name",id:"level_name",class:v(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.errors.level_name?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":d[1]||(d[1]=o=>t.form.level_name=o),autocomplete:"off"},null,2),[[u,t.form.level_name]])])])])]),e("div",ce,[e("div",pe,[s(m,{onClick:t.update},{default:r(()=>[i("Save")]),_:1},8,["onClick"])])])])):c("",!0)])]),s(b,{show:t.isOpen,onClose:d[2]||(d[2]=o=>t.isOpen=!1),confirmationAlert:"danger",confirmationTitle:"Delete Level",confirmationText:"Are you sure want to delete this level? Please be aware that deleting this will also result in the deletion of all associated data. This action cannot be undone.",confirmationButton:"Delete",confirmationMethod:"delete",confirmationRoute:t.confirmationRoute,confirmationData:t.confirmationData},null,8,["show","confirmationRoute","confirmationData"])]),_:1})],64))}});export{ct as default};