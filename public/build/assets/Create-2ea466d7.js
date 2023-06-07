import{c as r,a as c,u as p,w as u,F as m,H as S,L,v as T,o as a,b as e,d as V,e as h,n as b,E as j,f as g,r as _,t as n,i as d,h as x,p as D,k as P}from"./app-5e7199e3.js";import{B as z}from"./Authenticated-54e21821.js";import{B as v}from"./Button-2142c334.js";import{Z as C}from"./main-22d6030d.js";import{b as A}from"./toggle-3e87450c.js";import{s as y}from"./multiselect-cceda1f9.js";import{h as k}from"./default.css_vue_type_style_index_0_src_true_lang-280a1abf.js";/* empty css                                                         *//* empty css            */import"./ApplicationLogo-66f57c9a.js";import"./_plugin-vue_export-helper-c27b6911.js";const B={class:"md:grid md:grid-cols-2"},O={class:"md:mt-0 md:col-span-2"},$={class:"px-4 py-5 bg-indigo-50 space-y-6 sm:p-6"},M={class:"grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4"},F={class:"sm:row-span-3"},H={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},N=e("div",{class:"mb-5"},[e("h1",{class:"font-bold text-indigo-800"},"Admission Information"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),I={class:"grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4"},U={class:"mb-4"},E=e("label",{for:"class_name",class:"block text-sm font-bold text-gray-700"},[d(" Student Name "),e("span",{class:"text-red-500"},"*")],-1),Z={class:"mt-1 flex rounded-md.shadow-sm"},R={class:"mb-4"},G=e("label",{for:"centre",class:"block text-sm font-bold text-gray-700"},[d(" Centre "),e("span",{class:"text-red-500"},"*")],-1),J={class:"mt-1 flex rounded-md.shadow-sm"},K={class:"grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4"},Q={class:"grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4"},W={class:"mb-4"},X=e("label",{for:"programme",class:"block text-sm font-bold text-gray-700"},[d(" Admission Date "),e("span",{class:"text-red-500"},"*")],-1),Y={class:"mt-1 flex rounded-md shadow-sm"},q={class:"mb-4"},ee=e("label",{for:"programme",class:"block text-sm font-bold text-gray-700"},[d(" Programme "),e("span",{class:"text-red-500"},"*")],-1),se={class:"mt-1 flex rounded-md shadow-sm"},te=e("option",{value:""},"-- Select Programme --",-1),oe=["value"],le={class:"grid grid-cols-1 sm:grid-cols-3 gap-0 sm:gap-4"},ae={class:"mb-4"},re=e("label",{for:"class_type",class:"block text-sm font-bold text-gray-700"},[d(" Class Type "),e("span",{class:"text-red-500"},"*")],-1),ne={class:"mt-1 flex rounded-md shadow-sm"},ie=["disabled"],de=e("option",{value:""},"-- Select Type --",-1),ce=["value"],pe={class:"mb-4"},me=e("label",{for:"class_level",class:"block text-sm font-bold text-gray-700"},[d(" Class Level "),e("span",{class:"text-red-500"},"*")],-1),ue={class:"mt-1 flex rounded-md shadow-sm"},he=["disabled"],be=e("option",{value:""},"-- Select Level --",-1),_e=["value"],fe={class:"mb-4"},ge=e("label",{for:"class_method",class:"block text-sm font-bold text-gray-700"},[d(" Class Method "),e("span",{class:"text-red-500"},"*")],-1),xe={class:"mt-1 flex rounded-md shadow-sm"},ve=e("option",{value:""},"-- Select Method --",-1),ye=["value"],we={class:"flex items-center justify-end"},ke={class:"flex space-x-2"},Se={class:"grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4",ref:"available_classes"},Ce={key:0,class:"sm:row-span-3"},Le={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},Te=e("div",{class:"mb-5"},[e("h1",{class:"font-bold text-indigo-800"},"Classes Available"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),Ve={class:"grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4"},je={class:"mb-4"},De={class:"shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none"},Pe={class:"min-w-full divide-y divide-gray-200"},ze=e("thead",{class:"bg-blue-200"},[e("tr",{class:"px-2"},[e("th",{class:"px-2 py-1 text-left"},"#"),e("th",{class:"px-2 py-1 text-left"},"Day"),e("th",{class:"px-2 py-1 text-left"},"Time"),e("th",{class:"px-2 py-1 text-left"},"Capacity"),e("th",{class:"px-2 py-1 text-center"},"Action")])],-1),Ae={key:0},Be={colspan:"10",class:"py-2 text-center"},Oe={key:0,class:"flex justify-center py-4 items-center space-x-2"},$e=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"30",height:"30",fill:"currentColor",class:"bi bi-arrow-repeat animate-spin",viewBox:"0 0 16 16"},[e("path",{d:"M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"}),e("path",{"fill-rule":"evenodd",d:"M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"})],-1),Me=e("span",null,"Searching classes...",-1),Fe=[$e,Me],He={key:1},Ne={class:"hover:bg-gray-200"},Ie={class:"px-2 py-2 text-left"},Ue={class:"px-2 py-2 text-left"},Ee={class:"px-2 py-2 text-left"},Ze={class:"text-sm font-medium text-gray-900 flex items-center"},Re=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6 text-indigo-500",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor","stroke-width":"2"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"})],-1),Ge={class:"pl-2"},Je={class:"px-2 py-2 text-left"},Ke={class:"px-2 py-2 text-center"},Qe={class:"flex justify-center"},We=["onClick"],Xe={class:"grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4",ref:"class_fee"},Ye={key:0,class:"sm:row-span-3"},qe={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},es=e("div",{class:"mb-5"},[e("h1",{class:"font-bold text-indigo-800"},"Fee Information"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),ss={class:"flex p-4 justify-between bg-indigo-100 shadow rounded-md"},ts={class:"flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0 space-x-4"},os=e("div",{class:"text-green-500"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",fill:"currentColor",class:"bi bi-check-circle",viewBox:"0 0 16 16"},[e("path",{d:"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"}),e("path",{d:"M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"})])],-1),ls={class:"text-gray-700"},as={class:"flex pt-4 justify-end"},rs={components:{Head:S,Link:L,Datepicker:C,Toggle:A,Multiselect:y},props:{programme_list:Object,method_list:Object,centre_id:String},data(){return{class_types:[],class_levels:[],students:[],fee_info:{},selected_class_count:0,searching_students:!1,searching_classes:!1,disable_input:{class_type:!0,class_levels:!0},enable_container:{available_classes:!1,show_fee:!1},list:{available_classes:[]},search_form:{centre_id:this.centre_id?this.centre_id:"",programme_id:"",class_type:"",class_level:"",class_method:""},form:{date_admission:"",children_id:"",centre_id:this.centre_id?this.centre_id:"",fee:[],classes:[]}}},watch:{"search_form.programme_id":{handler(){this.search_form.programme_id&&(this.disable_input.class_type=!0,this.disable_input.class_levels=!0,this.search_form.class_type="",this.search_form.class_level="",axios.get(route("classes.get_class_types"),{params:{programme_id:this.search_form.programme_id}}).then(l=>{this.class_types=l.data,this.disable_input.class_type=!1}))},deep:!0},"search_form.class_type":{handler(){this.search_form.programme_id&&this.search_form.class_type&&(this.disable_input.class_levels=!0,this.search_form.class_level="",axios.get(route("classes.get_class_levels"),{params:{programme_id:this.search_form.programme_id,class_type:this.search_form.class_type}}).then(l=>{this.class_levels=l.data,this.disable_input.class_levels=!1}))},deep:!0}},methods:{submit(){this.$inertia.post(route("classes.store"),this.form,{preserveState:!0})},findStudents(l){T.debounce(s=>"400ms")(10),l&&(this.searching_students=!0,axios.get(route("students.find"),{params:{keyword:l}}).then(s=>{this.students=s.data,this.searching_students=!1}))},findClasses(){this.form.children_id&&this.search_form.centre_id&&this.search_form.programme_id&&this.search_form.class_level&&this.search_form.class_type&&this.search_form.class_method&&(this.searching_classes=!0,this.enable_container.show_fee=!1,this.list.available_classes=[],this.selected_class_count=0,axios.get(route("classes.find"),{params:{centre_id:this.search_form.centre_id,programme_id:this.search_form.programme_id,class_method:this.search_form.class_method,class_level:this.search_form.class_level,class_type:this.search_form.class_type}}).then(l=>{this.list.available_classes=l.data,this.enable_container.available_classes=!0,this.searching_classes=!1,this.form.classes=[],this.scrollToElement("available_classes")}))},getNormalFee(l,s){this.selected_class_count=1,this.getFee(l,s),this.form.classes.push(l)},getPlusFee(l,s,o){l.target.checked?(this.selected_class_count+=1,this.getFee(s,o,!0),this.form.classes.splice(o,0,s)):(this.selected_class_count-=1,this.getFee(s,o,!0),this.form.classes.splice(o,1))},getFee(l,s,o=!1){axios.get(route("programmes.get_fee"),{params:{class_id:o?"":l,class_type:this.search_form.class_type,class_count:this.selected_class_count}}).then(f=>{this.form.fee=[],this.form.fee=f.data,f.data.id?(this.enable_container.show_fee=!0,this.scrollToElement("class_fee")):this.enable_container.show_fee=!1})},clearStudents(){this.students=[]},scrollToElement(l){const s=this.$refs[l];s&&s.scrollIntoView({behavior:"smooth"})},addStudent(){this.$inertia.post(route("students.store"),this.form)}},mounted(){const s=new Date().toISOString().substring(0,10);this.form.date_admission=`${s}T05:59:00.000Z`}},gs=Object.assign(rs,{__name:"Create",setup(l){return(s,o)=>{const f=P("debounce");return a(),r(m,null,[c(p(S),{title:"Students"}),c(z,null,{header:u(()=>[]),default:u(()=>[e("div",B,[e("div",O,[e("form",{onSubmit:o[7]||(o[7]=V((...t)=>s.submit&&s.submit(...t),["prevent"]))},[e("div",$,[e("div",M,[e("div",F,[e("div",H,[N,e("div",I,[e("div",U,[E,e("div",Z,[h(c(p(y),{modelValue:s.form.children_id,"onUpdate:modelValue":o[0]||(o[0]=t=>s.form.children_id=t),onClose:s.clearStudents,valueProp:"id",loading:s.searching_students,placeholder:"Please enter some keywords",options:s.students,searchable:!0,noOptionsText:"Nothing found",noResultsText:"Nothing found",clearOnSelect:!0,canClear:!1,canDeselect:!1,"internal-search":!1,trackBy:"name",label:"name",classes:{container:s.$page.props.errors.centre_id?"relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none":"relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerOpenTop:"rounded-t-none",containerActive:"border border-indigo-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",multipleLabel:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5",search:"w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500",clear:"pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80",clearIcon:"bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",optionsTop:"flex-col-reverse",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent",spacer:"h-9 py-px box-content"}},null,8,["modelValue","onClose","loading","options","classes"]),[[f,s.findStudents]])])]),e("div",R,[G,e("div",J,[c(p(y),{modelValue:s.search_form.centre_id,"onUpdate:modelValue":o[1]||(o[1]=t=>s.search_form.centre_id=t),valueProp:"ID",searchable:!0,options:s.$page.props.allowed_centres,clearOnSelect:!1,canClear:!1,canDeselect:!1,trackBy:"label",label:"label",classes:{container:s.$page.props.errors.centre_id?"relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none":"relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerOpenTop:"rounded-t-none",containerActive:"border border-indigo-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",multipleLabel:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5",search:"w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500",clear:"pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80",clearIcon:"bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",optionsTop:"flex-col-reverse",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent",spacer:"h-9 py-px box-content"}},null,8,["modelValue","options","classes"])])])]),e("div",K,[e("div",Q,[e("div",W,[X,e("div",Y,[c(p(C),{class:b("w-full rounded-lg shadow-sm "),style:j(s.$page.props.errors.end_time?"--dp-border-color: #fa9e9e;":"--dp-border-color: rgb(209 213 219 / var(--tw-border-opacity)); --dp-icon-color: black"),"input-class-name":"date-picker",modelValue:s.form.date_admission,"onUpdate:modelValue":o[2]||(o[2]=t=>s.form.date_admission=t),"enable-time-picker":!1,"auto-apply":!0},null,8,["style","modelValue"])])]),e("div",q,[ee,e("div",se,[h(e("select",{name:"programme",id:"programme",class:b(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",s.$page.props.errors.programme?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[3]||(o[3]=t=>s.search_form.programme_id=t),autocomplete:"off"},[te,(a(!0),r(m,null,_(l.programme_list,(t,i)=>(a(),r("option",{value:t.id,key:i},n(t.name),9,oe))),128))],2),[[g,s.search_form.programme_id]])])])]),e("div",le,[e("div",ae,[re,e("div",ne,[h(e("select",{name:"class_type",id:"class_type",class:b(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",s.$page.props.errors.class_type?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[4]||(o[4]=t=>s.search_form.class_type=t),autocomplete:"off",disabled:s.disable_input.class_type},[de,(a(!0),r(m,null,_(s.class_types,(t,i)=>(a(),r("option",{value:t.id,key:i},n(t.name),9,ce))),128))],10,ie),[[g,s.search_form.class_type]])])]),e("div",pe,[me,e("div",ue,[h(e("select",{name:"class_level",id:"class_level",class:b(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",s.$page.props.errors.class_level?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[5]||(o[5]=t=>s.search_form.class_level=t),autocomplete:"off",disabled:s.disable_input.class_levels},[be,(a(!0),r(m,null,_(s.class_levels,(t,i)=>(a(),r("option",{value:t.level,key:t},n(t.level),9,_e))),128))],10,he),[[g,s.search_form.class_level]])])]),e("div",fe,[ge,e("div",xe,[h(e("select",{name:"class_method",id:"class_method",class:b(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",s.$page.props.errors.class_method?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":o[6]||(o[6]=t=>s.search_form.class_method=t),autocomplete:"off"},[ve,(a(!0),r(m,null,_(l.method_list,(t,i)=>(a(),r("option",{value:t.id,key:i},n(t.name),9,ye))),128))],2),[[g,s.search_form.class_method]])])])])]),e("div",we,[e("div",ke,[c(v,{onClick:s.findClasses},{default:u(()=>[d("Search Classes")]),_:1},8,["onClick"])])])])])]),e("div",Se,[s.enable_container.available_classes?(a(),r("div",Ce,[e("div",Le,[Te,e("div",Ve,[e("div",je,[e("div",De,[e("table",Pe,[ze,e("tbody",null,[!s.list.available_classes.data||s.list.available_classes.total==0?(a(),r("tr",Ae,[e("td",Be,[s.searching_classes?(a(),r("div",Oe,Fe)):x("",!0),s.list.available_classes.total==0?(a(),r("span",He,"No classes available")):x("",!0)])])):(a(!0),r(m,{key:1},_(s.list.available_classes.data,(t,i)=>(a(),r("tr",Ne,[e("td",Ie,n(i+1),1),e("td",Ue,n(t.class_day),1),e("td",Ee,[e("div",Ze,[Re,e("span",Ge,n(p(k)(t.start_time,"HH:mm:ss").format("h:mm A"))+" - "+n(p(k)(t.end_time,"HH:mm:ss").format("h:mm A")),1)])]),e("td",Je,n(t.capacity),1),e("td",Ke,[e("div",Qe,[t.class_type==1?(a(),D(v,{key:0,buttonType:"blue",onClick:w=>s.getNormalFee(t.class_id,i)},{default:u(()=>[d("Choose")]),_:2},1032,["onClick"])):(a(),r("input",{key:1,class:"h-5 w-5 border border-indigo-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer",type:"checkbox",onClick:w=>s.getPlusFee(w,t.class_id,i)},null,8,We))])])]))),256))])])])])])])])):x("",!0)],512),e("div",Xe,[s.enable_container.show_fee?(a(),r("div",Ye,[e("div",qe,[es,e("div",ss,[e("div",ts,[os,e("span",ls,n(s.form.fee.label)+" - "+n(s.form.fee.fee_amount),1)])]),e("div",as,[c(v,{buttonType:"info",onClick:s.addStudent},{default:u(()=>[d("Admit Student")]),_:1},8,["onClick"])])])])):x("",!0)],512)])],32)])])]),_:1})],64)}}});export{gs as default};