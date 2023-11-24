import{o as g,c as m,b as s,u as a,w as l,F as f,H as u,L as x,d as e,e as h,f as i,l as d,k as p}from"./app-dba1bceb.js";import{B as y}from"./Authenticated-4a9b1652.js";import{B as c}from"./Button-a8767c17.js";import{r as _}from"./PencilIcon-c5f7ec59.js";import{r as w}from"./SearchIcon-8d828b7c.js";import{r as v}from"./TrashIcon-ede4d593.js";import{s as b}from"./multiselect-8071905d.js";import"./ApplicationLogo-801b171d.js";import"./XIcon-5243c0a0.js";import"./toggle-5a1a5286.js";import"./moment-fbc5633a.js";import"./_plugin-vue_export-helper-c27b6911.js";const k={class:"md:grid md:grid-cols-2"},S={class:"md:mt-0 md:col-span-2"},L={class:"px-4 py-5 bg-indigo-50 space-y-6 sm:p-6"},B={class:"grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4"},O={class:"sm:row-span-3"},$={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},C=e("div",{class:"mb-5"},[e("h1",{class:"font-bold text-indigo-800"},"Centre Assigments"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),I={class:"grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4"},T={class:""},V=e("label",{for:"name",class:"block text-sm font-bold text-gray-700"},"Name",-1),P={class:""},j=e("label",{for:"email",class:"block text-sm font-bold text-gray-700"},"Email",-1),D={class:""},z=e("label",{for:"centres",class:"block text-sm font-bold text-gray-700"},"Centres",-1),A={class:"mt-1 flex rounded-md shadow-sm"},E=e("div",{class:"border-b border-dashed border-indigo-900 mt-4 mb-5"},null,-1),M={class:"flex flex-row-reverse items-center"},N={class:"flex space-x-2"},U={components:{SearchIcon:w,TrashIcon:v,PencilIcon:_,Head:u,Link:x,Multiselect:b},props:{user_id:String,user_centres:Object},created(){var n=this.selected_centres;Object.keys(this.user_centres).forEach(function(t){n.push(parseInt(t))})},data(){return{options:[{select_all:"Select All Centres",libs:this.$page.props.allowed_centres}],selected_centres:[]}},methods:{submit(){this.$inertia.post(this.route("edupreneurs.store"),{user_id:this.user_id,selected_centres:this.selected_centres})}}},ee=Object.assign(U,{__name:"ManageUser",setup(n){return(t,o)=>(g(),m(f,null,[s(a(u),{title:"Edupreneurs"}),s(y,null,{header:l(()=>[]),default:l(()=>[e("div",k,[e("div",S,[e("form",{onSubmit:o[3]||(o[3]=h((...r)=>t.submit&&t.submit(...r),["prevent"]))},[e("div",L,[e("div",B,[e("div",O,[e("div",$,[C,e("div",I,[e("div",T,[V,i(e("input",{id:"name",type:"text",class:"mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-200",readonly:"","onUpdate:modelValue":o[0]||(o[0]=r=>t.$page.props.user_info.display_name=r)},null,512),[[d,t.$page.props.user_info.display_name]])]),e("div",P,[j,i(e("input",{id:"email",type:"text",class:"mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-200",readonly:"","onUpdate:modelValue":o[1]||(o[1]=r=>t.$page.props.user_info.user_email=r)},null,512),[[d,t.$page.props.user_info.user_email]])]),e("div",D,[z,e("div",A,[s(a(b),{id:"centres",mode:"multiple",modelValue:t.selected_centres,"onUpdate:modelValue":o[2]||(o[2]=r=>t.selected_centres=r),valueProp:"ID",multiple:!0,searchable:!0,options:t.options,closeOnSelect:!1,clearOnSelect:!1,canClear:!1,hideSelected:!1,groups:!0,groupOptions:"libs",groupLabel:"select_all",groupSelect:!0,placeholder:"Select Centres",trackBy:"label",label:"label",classes:{container:t.$page.props.errors.centre_id?"relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]":"relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerOpenTop:"rounded-t-none",containerActive:"border border-indigo-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",multipleLabel:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5",search:"w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-9",tags:"flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2",tag:"bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap",tagDisabled:"pr-2 opacity-50",tagRemove:"flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group",tagRemoveIcon:"bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60",tagsSearchWrapper:"inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full",tagsSearch:"absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full",tagsSearchCopy:"invisible whitespace-pre-wrap inline-block h-px",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black",clear:"pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80",clearIcon:"bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",optionsTop:"flex-col-reverse",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",noResults:"py-2 px-3 text-gray-600 bg-white text-left",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent",spacer:"h-9 py-px box-content"}},null,8,["modelValue","options","classes"])])])]),E,e("div",M,[e("div",N,[s(c,{buttonType:"gray",route:t.route("edupreneurs")},{default:l(()=>[p("Cancel")]),_:1},8,["route"]),s(c,{type:"submit"},{default:l(()=>[p("Save")]),_:1})])])])])])])],32)])])]),_:1})],64))}});export{ee as default};