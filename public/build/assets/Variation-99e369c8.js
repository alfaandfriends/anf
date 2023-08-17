import{q as V,G as U,s as T,c as l,d as e,f as m,l as v,b as x,w as C,e as B,j as f,t as y,F as _,h,k as w,o as r}from"./app-5b70941e.js";import{B as I}from"./Button-7003fb3f.js";import N from"./VariationOption-5691647c.js";import{U as M}from"./UploadPreview-a4846690.js";/* empty css            */import"./_plugin-vue_export-helper-c27b6911.js";/* empty css                                                                      */const P={class:"w-full"},$={class:"flex"},L={class:"w-full bg-white shadow-md rounded-md overflow-hidden"},q={class:"border-b border-gray-200 px-4 py-6"},z={class:"mb-4"},G=e("label",{for:"variation_1",class:"block text-sm text-gray-700 font-bold"},[w(" Name "),e("span",{class:"text-red-500"},"*")],-1),K={class:"mt-1 flex rounded-md shadow-sm"},H={class:"mb-4"},J=e("hr",{class:"bg-gray-500 mx-auto my-4"},null,-1),Q={class:"flex items-center justify-end py-2"},W={key:0,class:"border-b border-gray-200 px-4 py-6"},X={class:"mb-4"},Y=e("label",{for:"variation_2",class:"block text-sm text-gray-700 font-bold"},[w(" Name "),e("span",{class:"text-red-500"},"*")],-1),Z={class:"mt-1 flex rounded-md shadow-sm"},ee={class:"mb-4"},te=e("hr",{class:"bg-gray-500 mx-auto my-4"},null,-1),oe={class:"flex items-center justify-end py-2"},ae={class:"flex items-center justify-center my-10"},se=e("span",{class:"text-center"},"Add variation",-1),ne=[se],ie={class:"min-w-full divide-y divide-gray-200"},le={class:"bg-gray-300"},re={scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12"},de={key:0,scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12"},ce=e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12"},"Price",-1),ue=e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12"},"Stock",-1),pe=e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12"},"SKU",-1),me={class:"bg-white divide-y divide-gray-200"},ve={class:"px-6 py-4 whitespace-nowrap"},xe={class:"flex flex-col items-center p-2 m-2"},_e=["for"],he={key:0,class:"px-6 py-4 whitespace-nowrap"},fe=["for"],ye={class:"px-6 py-4 whitespace-nowrap"},we=["name","id","onUpdate:modelValue"],ge={class:"px-6 py-4 whitespace-nowrap"},be=["name","id","onUpdate:modelValue"],ke={class:"px-6 py-4 whitespace-nowrap"},Ve=["name","id","onUpdate:modelValue"],Ee={__name:"Variation",props:{productVariations:{type:Array,default:[]},hasSecondVariation:{type:Boolean,default:!1}},emits:["update:variation","delete:variation"],setup(b,{emit:c}){const g=b,o=V({name:"variation 1",options:[{name:"",image:"",url:"",rows:[{name:"",price:"",stock:"",sku:""}]}]}),a=V({show:!1,name:"variation 2",options:[{name:""}]}),A=()=>{a.value.show=!0,o.value.name2=a.value.name,o.value.options.forEach(s=>{s.rows[0].name=a.value.options[0]}),c("update:variation",o.value)},D=()=>{o.value={name:"variation 1",options:[{name:"",image:"",url:"",rows:[{name:"",price:"",stock:"",sku:""}]}]},c("delete:variation")},E=()=>{a.value={show:!1,name:"variation 2",options:[{name:""}]}},S=()=>{o.value.options.push({name:"",image:"",url:"",rows:[{name:"",price:"",stock:"",sku:""}]}),c("update:variation",o.value)},j=()=>{a.value.options.push({name:""}),o.value.options.forEach(s=>{s.rows.push({name:"",price:"",stock:"",sku:""}),s.rows[a.value.options.length-1].name=a.value.options[a.value.options.length-1]}),c("update:variation",o.value)},F=(s,t)=>{o.value.options.splice(t,1),c("update:variation",o.value)},O=(s,t)=>{a.value.options.splice(t,1),c("update:variation",o.value)},R=(s,t)=>{if(s){const n=new FileReader;n.onload=()=>{k(t,n.result,s)},n.readAsDataURL(s)}else k(t,null,"")},k=(s,t,n)=>{o.value.options.forEach((u,i)=>{i===s&&(u.url=t,u.image=n)})};return U(o.value,(s,t)=>{console.log("variation 1 updated:",s)}),U(a.value,(s,t)=>{console.log("variation 2 updated:",s)}),T(()=>{if(g.productVariations.length!=0){const s=g.productVariations;o.value.options.splice(0,1),a.value.options.splice(0,1),s.forEach(t=>{o.value.options.push({name:t.name,image:null,url:t.url?"../../storage/"+t.url:"",rows:t.row}),g.hasSecondVariation&&(a.value.show=!0,a.value.options.push({name:t.row[0].name}))}),c("update:variation",o.value)}}),(s,t)=>(r(),l("div",P,[e("div",$,[e("div",L,[e("div",q,[e("div",z,[G,e("div",K,[m(e("input",{type:"text",name:"variation_1",id:"variation_1","onUpdate:modelValue":t[0]||(t[0]=n=>o.value.name=n),onInput:t[1]||(t[1]=n=>c("update:variation",o.value)),class:"focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm"},null,544),[[v,o.value.name]])])]),e("div",H,[x(N,{options:o.value.options,variationIndex:1,"onAdd:option":S,"onRemove:option":F},null,8,["options"])]),J,e("div",Q,[x(I,{onClick:B(D,["stop"]),buttonType:"danger"},{default:C(()=>[w("Delete")]),_:1},8,["onClick"])])]),a.value.show?(r(),l("div",W,[e("div",X,[Y,e("div",Z,[m(e("input",{type:"text",name:"variation_2",id:"variation_2","onUpdate:modelValue":t[2]||(t[2]=n=>a.value.name=n),onInput:t[3]||(t[3]=n=>c("update:variation",a.value)),class:"focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm"},null,544),[[v,a.value.name]])])]),e("div",ee,[x(N,{options:a.value.options,variationIndex:2,"onAdd:option":j,"onRemove:option":O},null,8,["options"])]),te,e("div",oe,[x(I,{onClick:B(E,["stop"]),buttonType:"danger"},{default:C(()=>[w("Delete")]),_:1},8,["onClick"])])])):f("",!0)])]),e("div",ae,[a.value.show?f("",!0):(r(),l("div",{key:0,onClick:A,class:"w-full text-center border border-solid border-black hover:bg-gray-100 cursor-pointer px-6 py-4"},ne))]),e("table",ie,[e("thead",le,[e("tr",null,[e("th",re,y(o.value.name),1),a.value.show?(r(),l("th",de,y(a.value.name),1)):f("",!0),ce,ue,pe])]),e("tbody",me,[(r(!0),l(_,null,h(o.value.options,(n,u)=>(r(),l("tr",{class:"hover:bg-gray-200",key:u},[e("td",ve,[e("div",xe,[x(M,{previewUrl:n.url,"onUpdate:value":i=>R(i,u)},null,8,["previewUrl","onUpdate:value"]),e("label",{for:n.name,class:"text-sm text-gray-500 text-center"},y(n.name),9,_e)])]),a.value.show?(r(),l("td",he,[(r(!0),l(_,null,h(n.rows,(i,d)=>(r(),l("div",{class:"flex flex-col items-center p-2 m-2",key:d},[e("label",{for:i.name,class:"text-sm text-gray-500 text-center"},y(b.productVariations?i.name:i.name.name),9,fe)]))),128))])):f("",!0),e("td",ye,[(r(!0),l(_,null,h(n.rows,(i,d)=>(r(),l("div",{key:d,class:"text-sm font-medium text-gray-900 mb-2"},[m(e("input",{type:"text",placeholder:"input",name:"variation_option_price"+d,id:"variation_option_price"+d,class:"focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm","onUpdate:modelValue":p=>i.price=p,autocomplete:"off"},null,8,we),[[v,i.price]])]))),128))]),e("td",ge,[(r(!0),l(_,null,h(n.rows,(i,d)=>(r(),l("div",{key:d,class:"text-sm font-medium text-gray-900 mb-2"},[m(e("input",{type:"text",placeholder:"0",name:"variation_option_stock"+d,id:"variation_option_stock"+d,class:"focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm","onUpdate:modelValue":p=>i.stock=p,autocomplete:"off"},null,8,be),[[v,i.stock]])]))),128))]),e("td",ke,[(r(!0),l(_,null,h(n.rows,(i,d)=>(r(),l("div",{key:d,class:"text-sm font-medium text-gray-900 mb-2"},[m(e("input",{type:"text",placeholder:"input",name:"variation_option_sku"+d,id:"variation_option_sku"+d,class:"focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm","onUpdate:modelValue":p=>i.sku=p,autocomplete:"off"},null,8,Ve),[[v,i.sku]])]))),128))])]))),128))])])]))}};export{Ee as default};