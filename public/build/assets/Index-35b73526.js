import{B as y,r as x}from"./Authenticated-54e21821.js";import{B as m}from"./Button-2142c334.js";import{c as o,a as r,u as f,w as a,F as p,H as v,o as s,b as e,i as u,r as h,n as _,t as g,h as k}from"./app-5e7199e3.js";import{C as b}from"./ConfirmationModal-1e62ec24.js";import"./default.css_vue_type_style_index_0_src_true_lang-280a1abf.js";import{r as C}from"./SearchIcon-ec79690f.js";import{r as w}from"./TrashIcon-016c97b9.js";import{r as A}from"./PencilIcon-607d942c.js";import"./ApplicationLogo-66f57c9a.js";import"./_plugin-vue_export-helper-c27b6911.js";/* empty css            */import"./transition-eb56e017.js";const $={class:"py-4 px-4"},B={class:"overflow-x-auto"},P={class:"mx-auto"},D={class:"align-middle inline-block w-full lg:w-1/2 px-2"},T={class:"flex pb-4 relative text-gray-400 focus-within:text-gray-600"},N={class:"text-sm font-medium text-gray-700"},I={key:0,class:"flex items-center border border-red-500 py-3 px-4"},M=e("span",{class:"mr-2"},"No permission added.",-1),O=[M],V=["onClick"],z={class:"flex items-center"},R={class:"select-none"},j={class:"flex flex-none items-center px-4 py-1 transition cursor-pointer group border border-indigo-200 border-l-0 text-gray-800",role:"button"},E={class:"flex items-center"},F={class:"space-x-2"},H={key:0,class:"flex flex-col py-2 px-4 border-x border-indigo-200"},L={key:0},S=e("span",null,"No sub permissions.",-1),q=[S],G={key:1,class:"flex flex-col"},J={class:"list-disc items-center translate-x-4"},K={class:"mb-1"},Q=e("div",{class:"flex space-x-6"},null,-1),U={components:{SearchIcon:C,TrashIcon:w,PencilIcon:A,ChevronRightIcon:x,ConfirmationModal:b,Head:v},data(){return{expandAccordion:!1,isOpen:!1,confirmationTitle:"",confirmationText:"",confirmationAlert:"",confirmationButton:"",confirmationMethod:"",confirmationRoute:"",confirmationData:"",selected:""}},methods:{toggleMenu(i){i==this.selected?this.expandAccordion=!this.expandAccordion:this.expandAccordion=!0,this.selected=i},addPermission(){this.$inertia.get(route("permissions.create"))},deletePermission(i){this.isOpen=!0,this.confirmationData=i},editPermission(i){this.$inertia.get(route("permissions.edit"),{permission_id:i})}}},le=Object.assign(U,{__name:"Index",setup(i){return(t,d)=>(s(),o(p,null,[r(f(v),{title:"Permissions"}),r(y,null,{header:a(()=>[]),default:a(()=>[e("div",$,[e("div",B,[e("div",P,[e("div",D,[e("div",T,[r(m,{onClick:d[0]||(d[0]=n=>t.addPermission())},{default:a(()=>[u(" Add Permission ")]),_:1})]),e("nav",N,[t.$page.props.permissions?(s(!0),o(p,{key:1},h(t.$page.props.permissions,(n,l)=>(s(),o("div",null,[e("div",{class:_(["flex",t.expandAccordion&&l===t.selected?"bg-indigo-400 text-gray-200":"bg-indigo-300 hover:bg-indigo-400 text-gray-800 hover:text-gray-200"])},[e("div",{class:"flex flex-1 justify-between items-center px-4 py-1 transition cursor-pointer group border border-indigo-200 border-r-0 relative",role:"button",onClick:c=>t.toggleMenu(l)},[e("div",z,[e("span",R,g(n.name),1)]),r(f(x),{class:_([{"rotate-90":t.expandAccordion&&l===t.selected},"shrink-0 w-4 h-4 ml-2 transition transform"])},null,8,["class"])],8,V),e("div",j,[e("div",E,[e("div",F,[r(m,{buttonType:"warning",onClick:c=>t.editPermission(n.id)},{default:a(()=>[u("Edit")]),_:2},1032,["onClick"]),r(m,{buttonType:"danger",onClick:c=>t.deletePermission(n.id)},{default:a(()=>[u("Delete")]),_:2},1032,["onClick"])])])])],2),t.expandAccordion&&l===t.selected?(s(),o("div",H,[n.permission_sub.length<1?(s(),o("div",L,q)):(s(),o("div",G,[e("ul",J,[(s(!0),o(p,null,h(n.permission_sub,(c,W)=>(s(),o("li",K,[e("span",null,g(c.name),1)]))),256))]),Q]))])):k("",!0)]))),256)):(s(),o("div",I,O))])])])]),r(b,{show:t.isOpen,onClose:d[1]||(d[1]=n=>t.isOpen=!1),confirmationAlert:"danger",confirmationTitle:"Delete Permission",confirmationText:"Are you sure want to delete this permission?",confirmationButton:"Delete",confirmationMethod:"delete",confirmationRoute:"permissions.destroy",confirmationData:t.confirmationData},null,8,["show","confirmationData"])])]),_:1})],64))}});export{le as default};