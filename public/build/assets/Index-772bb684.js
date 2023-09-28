import{c as d,b as n,u as y,w as r,F as f,o,H as w,d as e,f as x,l as v,m as l,k as p,j as c,h as k,t as u}from"./app-7052c322.js";import{B as b}from"./Authenticated-c7518677.js";import{B as h}from"./Button-5191ca95.js";import{C as _}from"./ConfirmationModal-335d2d83.js";import{P as C}from"./Pagination-d0ea599f.js";import"./ApplicationLogo-9e030e92.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./XIcon-a8fe17f0.js";import"./default.css_vue_type_style_index_0_src_true_lang-ce744a16.js";import"./moment-fbc5633a.js";import"./transition-791eb036.js";const $={class:"py-4 px-4"},B={class:"overflow-x-auto"},D={class:"mx-auto"},P={class:"align-middle inline-block min-w-full"},E={class:"flex justify-between pb-4 relative text-gray-400 focus-within:text-gray-600 items-center"},T={class:"flex space-x-2"},A={class:"relative"},N=e("span",{class:"absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"w-4 h-4 text-gray-400",viewBox:"0 0 24 24",fill:"none"},[e("path",{d:"M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})])],-1),L={class:"flex"},M={class:"shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"},V={class:"min-w-full divide-y divide-gray-200"},j=e("thead",{class:"bg-gray-300"},[e("tr",null,[e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"#"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14"},"Name"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14"},"Description"),e("th",{class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Action")])],-1),S={class:"bg-white divide-y divide-gray-200"},F={key:0},z=e("td",{class:"text-center",colspan:"10"},[e("div",{class:"p-3"}," No Record Found! ")],-1),H=[z],R={class:"px-6 py-4 whitespace-nowrap"},I={class:"text-sm text-gray-700"},O={class:"px-6 py-4 whitespace-nowrap"},U={class:"text-sm font-medium text-gray-900"},Z={class:"px-6 py-4 whitespace-nowrap"},q={class:"text-sm font-medium text-gray-900"},G={class:"flex px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2"},J={components:{ConfirmationModal:_},data(){return{show_filter:!1,show_confirmation:!1,product_id:"",params:{search:this.$page.props.filter.search?this.$page.props.filter.search:""}}},watch:{params:{handler(){this.params&&this.$inertia.get(this.route("products"),this.params,{replace:!0,preserveState:!0})},deep:!0}},methods:{editProduct(a){this.$inertia.get(this.route("products.edit"),{product_id:a},{replace:!0,preserveState:!0})},deleteProduct(a){this.product_id=a,this.show_confirmation=!0}}},ie=Object.assign(J,{__name:"Index",setup(a){return(t,i)=>(o(),d(f,null,[n(y(w),{title:"Product"}),n(b,null,{header:r(()=>[]),default:r(()=>[e("div",$,[e("div",B,[e("div",D,[e("div",P,[e("div",E,[e("div",T,[e("div",A,[N,x(e("input",{type:"text",class:"h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md",placeholder:"Search","onUpdate:modelValue":i[0]||(i[0]=s=>t.params.search=s)},null,512),[[v,t.params.search]])])]),e("div",L,[t.$page.props.can.create_products?(o(),l(h,{key:0,route:t.route("products.create")},{default:r(()=>[p("Add New Product")]),_:1},8,["route"])):c("",!0)])]),e("div",M,[e("table",V,[j,e("tbody",S,[t.$page.props.products.data.length?c("",!0):(o(),d("tr",F,H)),(o(!0),d(f,null,k(t.$page.props.products.data,(s,m)=>(o(),d("tr",{class:"hover:bg-gray-200",key:m},[e("td",R,[e("div",I,u(m+1),1)]),e("td",O,[e("div",U,u(s.name),1)]),e("td",Z,[e("div",q,u(s.description),1)]),e("td",G,[t.$page.props.can.edit_products?(o(),l(h,{key:0,onClick:g=>t.editProduct(s.id),buttonType:"warning",title:"Edit Category"},{default:r(()=>[p(" Edit ")]),_:2},1032,["onClick"])):c("",!0),t.$page.props.can.delete_products?(o(),l(h,{key:1,onClick:g=>t.deleteProduct(s.id),buttonType:"danger",title:"Delete Product"},{default:r(()=>[p(" Delete ")]),_:2},1032,["onClick"])):c("",!0)])]))),128))])]),n(C,{page_data:t.$page.props.products},null,8,["page_data"])])])])]),n(_,{show:t.show_confirmation,onClose:i[1]||(i[1]=s=>t.show_confirmation=!1),confirmationAlert:"danger",confirmationTitle:"Delete Product",confirmationText:"Are you sure want to delete this product? All the variations and sub variations will deleted once you click the DELETE button. Are you sure?",confirmationButton:"DELETE",confirmationMethod:"delete",confirmationRoute:"products.destroy",confirmationData:t.product_id},null,8,["show","confirmationData"])])]),_:1})],64))}});export{ie as default};