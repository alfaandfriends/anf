import{r as k,o as i,c as l,a as r,u as f,w as a,F as v,H as C,d as e,g as p,p as h,h as $,v as M,e as y,t as d,n as H,q as _}from"./app-d1c4c8a8.js";import{B as T}from"./Authenticated-58013c6d.js";import{B as c}from"./Button-13ac79a8.js";import{M as w}from"./Modal-6ee81068.js";import{C as B}from"./ConfirmationModal-5d7f613e.js";import{h as b}from"./moment-fbc5633a.js";import z from"./Invoice-7f1bbb8b.js";import D from"./PackingSlip-69d06851.js";import{P as x}from"./Pagination-a81759ad.js";import"./ApplicationLogo-3000f0b3.js";import"./XIcon-e84b46f6.js";import"./toggle-74204010.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./VueFinalModal.esm-5364a075.js";import"./transition-5c218837.js";const L={class:"py-4 px-4"},j={key:0,class:"flex justify-end mb-3"},V=e("hr",{class:"my-3 border border-dashed border-gray-400"},null,-1),S={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3"},O={class:"relative w-full"},P=e("svg",{class:"absolute top-2.5 left-3 h-5 w-5 text-gray-400",viewBox:"0 0 24 24",fill:"none"},[e("path",{d:"M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),N={class:"overflow-x-auto"},A={class:"shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"},U={class:"min-w-full divide-y divide-gray-200"},R=e("thead",{class:"bg-gray-300"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"#"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-6/14"},"Name"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Date"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Attachments"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14"},"Shipment Tracking"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"Status"),e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"Action")])],-1),E={class:"bg-white divide-y divide-gray-200"},F={key:0},I=e("td",{class:"text-center",colspan:"10"},[e("div",{class:"p-3"}," No Record Found! ")],-1),G=[I],Y={class:""},q={class:"px-6 py-4 whitespace-nowrap"},J={class:"text-sm text-gray-700"},Z={class:"px-6 py-4 whitespace-nowrap"},K={class:"text-sm font-medium text-gray-900"},Q={class:"px-6 py-4 whitespace-nowrap"},W={class:"text-sm font-medium text-gray-900"},X={class:"px-6 py-4 whitespace-nowrap space-x-2"},ee=["onClick"],te=["onClick"],se={class:"px-6 py-4 whitespace-nowrap"},oe={key:0,class:"flex flex-col text-sm font-medium text-gray-900"},ae={class:"font-bold text-gray-600"},ie={class:"font-semibold text-indigo-700"},re={key:1,class:""},ne={class:"px-6 py-4 whitespace-nowrap"},le={class:"text-sm font-medium text-gray-900"},de=["onClick"],ce={class:"px-6 py-4 whitespace-nowrap text-center text-sm font-medium"},pe={class:"flex space-x-2 justify-center"},he={class:"p-4 md:p-6 overflow-y-auto no-scrollbar"},ge={class:"bg-gray-50"},ue={class:"container"},_e={class:"flex flex-col text-gray-50"},me={key:0,class:"flex md:px-4"},fe=e("h3",{class:"font-semibold text-md italic mb-1 text-slate-700"},"Sorry, no status has been added right now.",-1),ve=[fe],we={class:"flex space-x-2 md:space-x-4"},ye=e("div",{class:"relative"},[e("div",{class:"h-full w-6 flex items-center justify-center"},[e("div",{class:"h-full w-1 bg-green-600 pointer-events-none"})]),e("div",{class:"w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-green-600 shadow text-center"},[e("i",{class:"fas fa-check-circle text-white"})])],-1),be={class:"bg-green-600 col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full"},xe={class:"font-semibold text-sm mb-1"},ke={class:"leading-tight text-xs text-justify w-full"},Ce={class:"flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b"},$e={class:"flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold"},Me=e("h3",{class:"text-gray-900 text-xl font-semibold"}," Invoice ",-1),He=e("svg",{class:"w-5 h-5",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},[e("path",{"fill-rule":"evenodd",d:"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),Te=[He],Be={class:"flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b"},ze=e("svg",{class:"w-4 h-4",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",viewBox:"0 0 16 16"},[e("path",{d:"M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"}),e("path",{d:"M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"})],-1),De=e("span",null,"Print",-1),Le={class:"flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold"},je=e("h3",{class:"text-gray-900 text-xl font-semibold"}," Packing Slip ",-1),Ve=e("svg",{class:"w-5 h-5",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},[e("path",{"fill-rule":"evenodd",d:"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),Se=[Ve],Oe={class:"flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b"},Pe=e("svg",{class:"w-4 h-4",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",viewBox:"0 0 16 16"},[e("path",{d:"M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"}),e("path",{d:"M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"})],-1),Ne=e("span",null,"Print",-1),Ae={components:{Pagination:x},data(){return{show_invoice:!1,show_packing_slip:!1,show_delete_order:!1,confirmation_data:"",show_tracking_status:!1,tracking_status:[],params:{search:this.$page.props.filter.search?this.$page.props.filter.search:""},invoice_data:[],packing_slip_data:[],generating:[]}},methods:{viewTrackingStatus(n){this.tracking_status=JSON.parse(n),this.show_tracking_status=!0},editOrder(n){this.$inertia.get(route("orders.edit"),{order_id:n})},deleteOrder(n){this.confirmation_data=n,this.show_delete_order=!0},viewInvoice(n,t){this.generating[t].invoice||(this.generating[t].invoice=!0,axios.get(route("orders.invoice.generate"),{responseType:"blob",params:{order_id:n}}).then(o=>{const g=new Blob([o.data],{type:"application/pdf"}),s=URL.createObjectURL(g);window.open(s,"_blank"),this.generating[t].invoice=!1}).catch(o=>{console.error("Error fetching PDF:",o),this.generating[t].invoice=!1}))},viewPackingSlip(n,t){this.generating[t].packing_slip||(this.generating[t].packing_slip=!0,axios.get(route("orders.packing_slip.generate"),{responseType:"blob",params:{order_id:n}}).then(o=>{const g=new Blob([o.data],{type:"application/pdf"}),s=URL.createObjectURL(g);window.open(s,"_blank"),this.generating[t].packing_slip=!1}).catch(o=>{console.error("Error fetching PDF:",o),this.generating[t].packing_slip=!1}))},search(){this.$inertia.get(this.route("orders"),this.params,{replace:!0,preserveState:!0})}},created(){this.$page.props.orders.data.forEach(n=>{this.generating.push({invoice:!1,packing_slip:!1})})}},tt=Object.assign(Ae,{__name:"Index",setup(n){return(t,o)=>{const g=k("debounce");return i(),l(v,null,[r(f(C),{title:"Orders"}),r(T,null,{header:a(()=>[]),default:a(()=>[e("div",L,[t.$page.props.can.create_orders?(i(),l("div",j,[r(c,{route:t.route("orders.create")},{default:a(()=>[p("Add New Order")]),_:1},8,["route"])])):h("",!0),V,e("div",S,[e("div",O,[P,$(e("input",{type:"text",class:"h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md","onUpdate:modelValue":o[0]||(o[0]=s=>t.params.search=s)},null,512),[[g,t.search,"800ms"],[M,t.params.search]])])]),e("div",N,[e("div",A,[e("table",U,[R,e("tbody",E,[!t.$page.props.orders.data||!t.$page.props.orders.data.length?(i(),l("tr",F,G)):(i(!0),l(v,{key:1},y(t.$page.props.orders.data,(s,u)=>(i(),l("tr",Y,[e("td",q,[e("div",J,d(u+1),1)]),e("td",Z,[e("div",K,d(s.parent_full_name),1)]),e("td",Q,[e("div",W,d(f(b)(s.created_at).format("DD/MM/Y")),1)]),e("td",X,[e("span",{onClick:m=>t.viewInvoice(s.id,u),class:"font-semibold border border-blue-600 bg-blue-100 hover:bg-blue-200 text-blue-700 whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer"},d(t.generating[u].invoice?"Generating...":"Invoice"),9,ee),e("span",{onClick:m=>t.viewPackingSlip(s.id,u),class:"font-semibold border border-blue-600 bg-blue-100 hover:bg-blue-200 text-blue-700 whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer"},d(t.generating[u].packing_slip?"Generating...":"Packing Slip"),9,te)]),e("td",se,[s.shipping_provider_name?(i(),l("div",oe,[e("small",ae,d(s.shipping_provider_name),1),e("span",ie,d(s.tracking_number),1)])):(i(),l("div",re,"-"))]),e("td",ne,[e("div",le,[e("span",{onClick:m=>t.viewTrackingStatus(s.tracking_status),class:H(["border whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer",[s.class_name]])},d(s.status_name),11,de)])]),e("td",ce,[e("div",pe,[t.$page.props.can.edit_orders?(i(),_(c,{key:0,onClick:m=>t.editOrder(s.id),buttonType:"warning"},{default:a(()=>[p("Edit")]),_:2},1032,["onClick"])):h("",!0),t.$page.props.can.delete_orders?(i(),_(c,{key:1,onClick:m=>t.deleteOrder(s.id),buttonType:"danger"},{default:a(()=>[p("Delete")]),_:2},1032,["onClick"])):h("",!0)])])]))),256))])]),t.$page.props.orders.data.length?(i(),_(x,{key:0,page_data:t.$page.props.orders,params:t.params},null,8,["page_data","params"])):h("",!0)])]),r(B,{show:t.show_delete_order,onClose:o[1]||(o[1]=s=>t.show_delete_order=!1),confirmationAlert:"danger",confirmationTitle:"Delete Order",confirmationText:"Are you sure want to delete this order?",confirmationButton:"Delete",confirmationMethod:"delete",confirmationRoute:"orders.destroy",confirmationData:t.confirmation_data},null,8,["show","confirmationData"])]),r(w,{showModal:t.show_tracking_status,modalType:"sm",onHideModal:o[3]||(o[3]=s=>t.show_tracking_status=!1)},{content:a(()=>[e("div",he,[e("body",ge,[e("div",ue,[e("div",_e,[!t.tracking_status||!t.tracking_status.length?(i(),l("div",me,ve)):(i(!0),l(v,{key:1},y(t.tracking_status,s=>(i(),l("div",we,[ye,e("div",be,[e("h3",xe,d(s.name),1),e("p",ke,d(f(b)(s.datetime).format("DD/MM/Y HH:mm A")),1)])]))),256))])])])])]),footer:a(()=>[e("div",Ce,[r(c,{buttonType:"gray",onClick:o[2]||(o[2]=s=>t.show_tracking_status=!1)},{default:a(()=>[p("Close")]),_:1})])]),_:1},8,["showModal"]),t.show_invoice?(i(),_(w,{key:0,showModal:t.show_invoice,modalType:"md",onHideModal:o[6]||(o[6]=s=>t.show_invoice=!1)},{header:a(()=>[e("div",$e,[Me,e("button",{type:"button",onClick:o[4]||(o[4]=s=>t.show_invoice=!1),class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center","data-modal-toggle":"default-modal"},Te)])]),content:a(()=>[r(z,{invoice_data:t.invoice_data},null,8,["invoice_data"])]),footer:a(()=>[e("div",Be,[r(c,{buttonType:"blue",class:"px-4 py-2 space-x-2",onClick:t.print},{default:a(()=>[ze,De]),_:1},8,["onClick"]),r(c,{buttonType:"gray",onClick:o[5]||(o[5]=s=>t.show_invoice=!1)},{default:a(()=>[p("Close")]),_:1})])]),_:1},8,["showModal"])):h("",!0),t.show_packing_slip?(i(),_(w,{key:1,showModal:t.show_packing_slip,modalType:"md",onHideModal:o[9]||(o[9]=s=>t.show_packing_slip=!1)},{header:a(()=>[e("div",Le,[je,e("button",{type:"button",onClick:o[7]||(o[7]=s=>t.show_packing_slip=!1),class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center","data-modal-toggle":"default-modal"},Se)])]),content:a(()=>[r(D,{packing_slip_data:t.packing_slip_data},null,8,["packing_slip_data"])]),footer:a(()=>[e("div",Oe,[r(c,{buttonType:"blue",class:"px-4 py-2 space-x-2",onClick:t.print},{default:a(()=>[Pe,Ne]),_:1},8,["onClick"]),r(c,{buttonType:"gray",onClick:o[8]||(o[8]=s=>t.show_packing_slip=!1)},{default:a(()=>[p("Close")]),_:1})])]),_:1},8,["showModal"])):h("",!0)]),_:1})],64)}}});export{tt as default};