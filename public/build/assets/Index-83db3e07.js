import{q as i,G as k,c as l,b as s,u as g,w as r,F as y,ai as N,o as d,H as B,d as t,f as D,l as S,k as u,j as C,h as O,t as n}from"./app-5b70941e.js";import{B as P}from"./Authenticated-3d558274.js";import{B as x}from"./Button-7003fb3f.js";import{C as T}from"./ConfirmationModal-da935ed6.js";import{P as J}from"./Pagination-23fc8b76.js";import{r as j}from"./SearchIcon-acd73590.js";import A from"./Edit-b7d18f23.js";/* empty css            */import"./ApplicationLogo-9bc665dc.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./XIcon-6a638028.js";import"./default.css_vue_type_style_index_0_src_true_lang-5057ee22.js";import"./moment-fbc5633a.js";import"./transition-0f063a1d.js";import"./Modal-cac99ee2.js";import"./VueFinalModal.esm-7d242b85.js";import"./ValidationErrors-63b04435.js";import"./UploadPreview-a4846690.js";/* empty css                                                                      */const E={class:"py-4 px-4"},V={class:"overflow-x-auto"},F={class:"mx-auto"},I={class:"align-middle inline-block min-w-full px-2"},M={class:"flex justify-between mb-4"},$={class:"flex space-x-2"},z={class:"flex relative text-gray-400 focus-within:text-gray-600"},H={class:"shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"},L={class:"min-w-full divide-y divide-gray-200"},R=t("thead",{class:"bg-gray-300"},[t("tr",null,[t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"#"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14"},"Product Name"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Price"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Stock"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Sales"),t("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Action")])],-1),q={class:"bg-white divide-y divide-gray-200"},G={key:0},U=t("td",{class:"text-center",colspan:"10"},[t("div",{class:"p-3"}," No Record Found! ")],-1),K=[U],Q={class:"px-6 py-4 whitespace-nowrap"},W={class:"text-sm text-gray-700"},X={class:"flex items-center px-6 py-4 whitespace-nowrap"},Y=["src"],Z={class:"text-sm font-medium text-gray-900"},tt={class:"px-6 py-4 whitespace-nowrap"},et={class:"text-sm font-medium text-gray-900"},st={class:"px-6 py-4 whitespace-nowrap"},ot={class:"text-sm font-medium text-gray-900"},at={class:"px-6 py-4 whitespace-nowrap"},it={class:"text-sm font-medium text-gray-900"},rt={class:"px-6 py-4 whitespace-nowrap text-center text-sm font-medium"},nt={class:"flex justify-center"},ct={class:"flex pr-1"},lt={class:"flex"},Pt={__name:"Index",props:{products:{type:Object},categories:{type:Object}},setup(c){const h=i(!1),w=i(),p=i(!1),f=i(),m=i(),v=i(),b=o=>{p.value=!0,f.value=o};return k(()=>m.value,o=>{N.Inertia.visit(route("products",{search:o}),{method:"get"})},()=>v.value),(o,a)=>(d(),l(y,null,[s(g(B),{title:"Product"}),s(P,null,{header:r(()=>[]),default:r(()=>[t("div",E,[t("div",V,[t("div",F,[t("div",I,[t("div",M,[t("div",$,[t("div",z,[s(g(j),{class:"text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3",style:"top:30%"}),D(t("input",{class:"border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:ring-0 focus:border-gray-300 appearance-none block pl-10",type:"text","onUpdate:modelValue":a[0]||(a[0]=e=>m.value=e),placeholder:"Search"},null,512),[[S,m.value]])])]),s(x,{route:o.route("products.create")},{default:r(()=>[u("Add New Product")]),_:1},8,["route"])]),t("div",H,[t("table",L,[R,t("tbody",q,[c.products.data.length?C("",!0):(d(),l("tr",G,K)),(d(!0),l(y,null,O(c.products.data,(e,_)=>(d(),l("tr",{class:"hover:bg-gray-200",key:_},[t("td",Q,[t("div",W,n(_+1),1)]),t("td",X,[t("img",{class:"w-24 h-24 mr-4",src:"storage/"+e.images[0].path,alt:""},null,8,Y),t("div",Z,n(e.name),1)]),t("td",tt,[t("div",et,n(e.has_variation?JSON.parse(e.details)[0].row[0].price:JSON.parse(e.details)[0].price),1)]),t("td",st,[t("div",ot,n(e.has_variation?JSON.parse(e.details)[0].row[0].price:JSON.parse(e.details)[0].price),1)]),t("td",at,[t("div",it,n(e.has_variation?JSON.parse(e.details)[0].row[0].price:JSON.parse(e.details)[0].price),1)]),t("td",rt,[t("div",nt,[t("div",ct,[s(x,{route:o.route("products.edit",e.id),buttonType:"warning",title:"Edit Category"},{default:r(()=>[u(" Edit ")]),_:2},1032,["route"])]),t("div",lt,[s(x,{onClick:dt=>b(e.id),buttonType:"danger",title:"Delete Product"},{default:r(()=>[u(" Delete ")]),_:2},1032,["onClick"])])])])]))),128))])]),s(J,{page_data:c.products},null,8,["page_data"])])])])]),s(T,{show:p.value,onClose:a[1]||(a[1]=e=>p.value=!1),confirmationAlert:"danger",confirmationTitle:"Delete Product",confirmationText:"Are you sure want to delete this product?",confirmationButton:"Delete",confirmationMethod:"delete",confirmationRoute:"products.destroy",confirmationData:f.value},null,8,["show","confirmationData"]),s(A,{item:w.value,categories:c.categories,open:h.value,"onToggle:show":a[2]||(a[2]=e=>h.value=e)},null,8,["item","categories","open"])])]),_:1})],64))}};export{Pt as default};