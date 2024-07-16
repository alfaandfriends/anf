import{o as r,c as n,a as c,u as $,w as p,F as u,_ as C,H as k,L as M,d as e,h as a,m as g,n as d,e as f,t as h,q as l,v,g as m,s as b}from"./app-6bcf983c.js";import{B as R}from"./Authenticated-868de988.js";import{B as w}from"./Button-0a182322.js";import{r as B}from"./TrashIcon-a4ca4e09.js";import{V as I}from"./vue-draggable-next.esm-bundler-707354af.js";import{C as q}from"./ConfirmationModal-4035e83d.js";import D from"./SingleChoice-1a5f63a2.js";import T from"./MultipleChoices-3dad7e48.js";import x from"./MatrixSorting-558cb842.js";import{m as L,p as E,x as U,I as S,y as A}from"./tabs-0744e49f.js";import"./ApplicationLogo-883fd7a0.js";import"./XIcon-4eb22bf4.js";import"./vue3-perfect-scrollbar-2f61efdb.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./TimeAgo-c9b67a4d.js";import"./moment-55cb88ed.js";import"./transition-e581087f.js";import"./keyboard-267470f8.js";import"./use-resolve-button-type-af0ef382.js";const V={class:"md:grid md:grid-cols-2"},O={class:"md:mt-0 md:col-span-2"},F={class:"px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full"},P={class:"grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4"},j={class:"sm:row-span-3 space-y-2"},N={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},z=e("div",{class:"mb-5"},[e("h1",{class:"text-indigo-800 font-bold"},"Information"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),H={class:"mb-3"},G=e("label",{for:"category_id",class:"block text-sm text-gray-700 font-bold"},[m("Category"),e("span",{class:"text-red-500"},"*")],-1),Q={class:"mt-1 flex rounded-md shadow-sm"},Y=e("option",{value:"",selected:""},"Please select question's category",-1),J=["value"],W={class:"mb-3"},X=e("label",{for:"name",class:"block text-sm text-gray-700 font-bold"},"Redirection (Correct)",-1),K={class:"mt-1 flex rounded-md shadow-sm space-x-2"},Z=e("option",{value:""},"No redirection",-1),ee=["value"],te={class:"mb-3"},oe=e("label",{for:"name",class:"block text-sm text-gray-700 font-bold"},"Redirection (Wrong)",-1),se={class:"mt-1 flex rounded-md shadow-sm space-x-2"},ie=e("option",{value:""},"No redirection",-1),re=["value"],ne={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},ae=e("div",{class:"mb-5"},[e("h1",{class:"text-indigo-800 font-bold"},"Questions"),e("div",{class:"border-b border-dashed border-indigo-900 mt-1"})],-1),de={class:"mb-5"},le={key:0,class:"bg-indigo-100 border-t-4 border-indigo-500 rounded-b text-indigo-900 px-4 py-3 shadow-md",role:"alert"},me=e("div",{class:"flex"},[e("div",{class:"py-1"},[e("svg",{class:"fill-current h-6 w-6 text-indigo-500 mr-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20"},[e("path",{d:"M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"})])]),e("div",null,[e("p",{class:"font-bold"},"In the question's input field, please wrap the answer keyword with [ ] for system to automatically replace the answer to blank spaces. "),e("p",{class:"text-indigo-600 font-semibold"},"ALFA like to [play] football."),e("br"),e("p",{class:"font-bold"},"Use | to set multiple correct answers."),e("p",{class:"text-indigo-600 font-semibold"},"ALFA like to [eat|drink|sleep].")])],-1),ce=[me],ue={class:"mb-3"},pe=e("label",{for:"question_type",class:"block text-sm text-gray-700 font-bold"},[m("Question Type"),e("span",{class:"text-red-500"},"*")],-1),ge={class:"mt-1 flex rounded-md shadow-sm"},fe=e("option",{value:"",selected:""},"Please select question's type",-1),he=["value"],_e={class:"mb-3"},be=e("label",{for:"question",class:"block text-sm text-gray-700 font-bold"},[m("Question"),e("span",{class:"text-red-500"},"*")],-1),ve={class:"mt-1 flex rounded-md shadow-sm"},we={class:"mb-3"},ye=e("label",{for:"remarks",class:"block text-sm text-gray-700 font-bold"},"Remarks / Additional notes",-1),ke={class:"mt-1 flex rounded-md shadow-sm"},qe={class:"mb-3"},De=e("label",{for:"name",class:"block text-sm text-gray-700 font-bold"},"Question Image",-1),Te={class:"space-y-1 text-center"},xe=e("svg",{class:"mx-auto h-12 w-12 text-gray-400",stroke:"currentColor",fill:"none",viewBox:"0 0 48 48","aria-hidden":"true"},[e("path",{d:"M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),$e={class:"flex text-sm text-gray-600"},Ce={class:"browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold"},Me={ref:"inside_image",id:"file",class:"sr-only",type:"file",accept:"image/*"},Re=e("p",{class:"pl-1"},"or drag and drop an image",-1),Be=e("p",{class:"text-xs text-gray-500"},"Image Format : PNG, JPG",-1),Ie={key:1,class:"w-1/4 relative group mt-2"},Le={class:"absolute w-full h-full hover:bg-black hover:opacity-75 hidden rounded group-hover:block"},Ee=e("div",{class:"pl-[0.65rem]"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-10 w-10",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor","stroke-width":"2"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"})])],-1),Ue=e("span",{class:"text-white"},"Remove",-1),Se=[Ee,Ue],Ae=["src"],Ve={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},Oe={class:"flex items-end justify-end space-x-2"},y=window.URL||window.webkitURL,Fe=/^image\/\w+$/,Pe=C({components:{Head:k,Link:M,TabGroup:L,TabList:E,Tab:U,TabPanels:S,TabPanel:A,ConfirmationModal:q,TrashIcon:B,draggable:I,SingleChoice:D,MultipleChoices:T,MatrixSorting:x},props:{dt_id:String,test_id:String,diagnostic_test_info:Object,diagnostic_test_answers:Object,redirect_url:String},data(){return{data:{type:Object,default:()=>({})},enabled:!0,isOpen:!1,showdtDetails:!0,showUpload:this.$page.props.diagnostic_test_info.question_image===null||this.$page.props.diagnostic_test_info.question_image==="",showImage:this.$page.props.diagnostic_test_info.question_image!==null||this.$page.props.diagnostic_test_info.question_image!=="",confirmationTitle:"",confirmationText:"",confirmationAlert:"",confirmationButton:"",confirmationMethod:"",confirmationData:"",confirmationRoute:"",dragging:!0,dtList:this.$page.props.diagnostic_test_list?this.$page.props.diagnostic_test_list:[],question_types:[{id:1,name:"Single Choice"},{id:2,name:"Multiple Choices"},{id:4,name:"Fill in the Blank"}],form:{dt_id:this.dt_id?this.dt_id:"",id:this.diagnostic_test_info?this.diagnostic_test_info.id:"",category_id:this.diagnostic_test_info?this.diagnostic_test_info.category_id:"",redirect_yes:this.diagnostic_test_info.redirect_yes_id!=null?this.diagnostic_test_info.redirect_yes_id:"",redirect_no:this.diagnostic_test_info.redirect_no_id!=null?this.diagnostic_test_info.redirect_no_id:"",question_type:this.diagnostic_test_info?this.diagnostic_test_info.question_type:"",question:this.diagnostic_test_info?this.diagnostic_test_info.question:"",remarks:this.diagnostic_test_info?this.diagnostic_test_info.remarks:"",delete_image:!1,image_url:"",image_file:"",question_answer_data:this.diagnostic_test_answers?this.diagnostic_test_answers:[]}}},methods:{submit(){this.$inertia.post(route("dt.settings.details.update"),this.form,{preserveState:!0})},read(s,t){return new Promise((i,o)=>{if(!s){i();return}Fe.test(s.type)?y?i({loaded:!0,name:s.name,type:s.type,url:y.createObjectURL(s)}):o(new Error("Your browser is not supported.")):o(new Error("Please select a valid image file."))})},change({target:s}){const{files:t}=s;t&&t.length>0&&this.read(t[0],s).then(i=>{this.form.image_url=i.url,this.form.image_file=t,this.showUpload=!1,this.showImage=!0,this.update(i)}).catch(this.alert)},dragover(s){s.preventDefault()},drop(s){const{files:t}=s.dataTransfer;s.preventDefault(),t&&t.length>0&&this.read(t[0],s).then(i=>{this.form.image_url=i.url,this.form.image_file=t,this.showUpload=!1,this.showImage=!0,this.update(i)}).catch(this.alert)},alert(s){window.alert(s&&s.message?s.message:s)},update(s){Object.assign(this.data,s)},removeImage(){this.form.image_url="",this.$page.props.diagnostic_test_info.question_image!=null&&(this.form.delete_image=!0),this.showImage=!1,this.showUpload=!0},blobToFile(s,t){return s.lastModifiedDate=new Date,s.name=t,s},dtEdit(){this.$inertia.get(route("dt.settings.details"),{dt_id:this.dt_id},{preserveScroll:!0})},dtDelete(s){this.confirmationTitle="Delete Diagnostic Test Item",this.confirmationText="Are you sure want to delete this item?",this.confirmationButton="Delete",this.confirmationMethod="delete",this.confirmationRoute="dt.settings.details.destroy",this.confirmationData=s,this.isOpen=!0},updateSorting(){this.$inertia.post(route("dt.settings.details.sort"),{sorted_list:this.dtList},{preserveScroll:!0})},conditionEdit(s){this.$inertia.get(route("dt.settings.conditions.edit"),{condition_id:s},{preserveScroll:!0})},conditionDelete(s){this.confirmationTitle="Delete Diagnostic Test Condition",this.confirmationText="Are you sure want to delete this condition?",this.confirmationButton="Delete",this.confirmationMethod="delete",this.confirmationRoute="dt.settings.conditions.destroy",this.confirmationData=s,this.isOpen=!0},categoriesEdit(s){this.$inertia.get(route("dt.settings.categories.edit"),{category_id:s},{preserveScroll:!0})},categoriesDelete(s){this.confirmationTitle="Delete Diagnostic Test Category",this.confirmationText="Are you sure want to delete this category?",this.confirmationButton="Delete",this.confirmationMethod="delete",this.confirmationRoute="dt.settings.categories.destroy",this.confirmationData=s,this.isOpen=!0},appendToForm(s){this.form.question_answer_data=s},imageLoadError(){this.showImage=!1,this.showUpload=!0}}}),at=Object.assign(Pe,{__name:"Edit",setup(s){return(t,i)=>(r(),n(u,null,[c($(k),{title:"Diagnostic Test"}),c(R,null,{header:p(()=>[]),default:p(()=>[e("div",V,[e("div",O,[e("div",F,[e("div",P,[e("div",j,[e("div",N,[z,e("div",H,[G,e("div",Q,[a(e("select",{name:"category_id",id:"category_id",class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.category_id?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[0]||(i[0]=o=>t.form.category_id=o),autocomplete:"off"},[Y,(r(!0),n(u,null,f(t.$page.props.diagnostic_test_categories,(o,_)=>(r(),n("option",{value:o.id,key:_},h(o.name),9,J))),128))],2),[[g,t.form.category_id]])])]),e("div",W,[X,e("div",K,[a(e("select",{class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.redirect_yes?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[1]||(i[1]=o=>t.form.redirect_yes=o),name:"",id:""},[Z,(r(!0),n(u,null,f(t.$page.props.diagnostic_test_list,o=>(r(),n("option",{value:o.id,key:o.id},h(o.question),9,ee))),128))],2),[[g,t.form.redirect_yes]])])]),e("div",te,[oe,e("div",se,[a(e("select",{class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.redirect_no?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[2]||(i[2]=o=>t.form.redirect_no=o),name:"",id:""},[ie,(r(!0),n(u,null,f(t.$page.props.diagnostic_test_list,o=>(r(),n("option",{value:o.id,key:o.id},h(o.question),9,re))),128))],2),[[g,t.form.redirect_no]])])])]),e("div",ne,[ae,e("div",de,[t.form.question_type==4?(r(),n("div",le,ce)):l("",!0)]),e("div",ue,[pe,e("div",ge,[a(e("select",{name:"question_type",id:"question_type",class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.question_type?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[3]||(i[3]=o=>t.form.question_type=o),autocomplete:"off"},[fe,(r(!0),n(u,null,f(t.question_types,(o,_)=>(r(),n("option",{value:o.id,key:_},h(o.name),9,he))),128))],2),[[g,t.form.question_type]])])]),e("div",_e,[be,e("div",ve,[a(e("textarea",{id:"question",class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.question?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[4]||(i[4]=o=>t.form.question=o),autocomplete:"off"},null,2),[[v,t.form.question]])])]),e("div",we,[ye,e("div",ke,[a(e("input",{type:"text",name:"remarks",id:"remarks",class:d(["focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm",t.$page.props.errors.remarks?"border-red-300":"border-gray-300"]),"onUpdate:modelValue":i[5]||(i[5]=o=>t.form.remarks=o),autocomplete:"off"},null,2),[[v,t.form.remarks]])])]),e("div",qe,[De,t.showUpload?(r(),n("div",{key:0,class:"mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md",onChange:i[6]||(i[6]=(...o)=>t.change&&t.change(...o)),onDragover:i[7]||(i[7]=(...o)=>t.dragover&&t.dragover(...o)),onDrop:i[8]||(i[8]=(...o)=>t.drop&&t.drop(...o))},[e("div",Te,[xe,e("div",$e,[e("label",Ce,[m("Click here "),e("input",Me,null,512)]),Re]),Be])],32)):l("",!0),t.showImage?(r(),n("div",Ie,[e("div",Le,[e("div",{class:"absolute cursor-pointer top-1/2 left-1/2 -translate-y-2/4 -translate-x-2/4 h-16 w-16 hover:text-red-500 text-red-600 transition ease-in-out hover:-translate-1 hover:scale-110 duration-100",alt:"Remove Image",onClick:i[9]||(i[9]=(...o)=>t.removeImage&&t.removeImage(...o))},Se)]),e("img",{class:"rounded w-full",src:t.form.image_url!=""?t.form.image_url:t.diagnostic_test_info.question_image?"/storage/"+t.diagnostic_test_info.question_image:"",alt:"",onError:i[10]||(i[10]=(...o)=>t.imageLoadError&&t.imageLoadError(...o))},null,40,Ae)])):l("",!0)])]),t.form.question_type==1?(r(),b(D,{key:0,onReceivedData:t.appendToForm,prop_answers:t.diagnostic_test_answers,action:"edit"},null,8,["onReceivedData","prop_answers"])):l("",!0),t.form.question_type==2?(r(),b(T,{key:1,onReceivedData:t.appendToForm,prop_answers:t.diagnostic_test_answers,action:"edit"},null,8,["onReceivedData","prop_answers"])):l("",!0),t.form.question_type==3?(r(),b(x,{key:2,onReceivedData:t.appendToForm,prop_answers:t.diagnostic_test_answers,action:"edit"},null,8,["onReceivedData","prop_answers"])):l("",!0),e("div",Ve,[e("div",Oe,[c(w,{buttonType:"gray",onClick:i[11]||(i[11]=o=>t.dtEdit())},{default:p(()=>[m("Cancel")]),_:1}),c(w,{onClick:t.submit},{default:p(()=>[m("Save ")]),_:1},8,["onClick"])])])])])])])]),c(q,{show:t.isOpen,onClose:i[12]||(i[12]=o=>t.isOpen=!1),confirmationAlert:"danger",confirmationTitle:t.confirmationTitle,confirmationText:t.confirmationText,confirmationButton:t.confirmationButton,confirmationMethod:t.confirmationMethod,confirmationRoute:t.confirmationRoute,confirmationData:t.confirmationData},null,8,["show","confirmationTitle","confirmationText","confirmationButton","confirmationMethod","confirmationRoute","confirmationData"])]),_:1})],64))}});export{at as default};