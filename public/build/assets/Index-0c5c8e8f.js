import{b6 as D,q as n,x as d,v as l,u as c,P as a,F as m,y as e,V as u,z as g,B as S,K as C,bv as O,C as P,G as s,t as f}from"./@vue-7927adca.js";import{B as j}from"./Authenticated-8999fe17.js";import{B as i}from"./Button-65508d11.js";import{r as A,a as T,b as B}from"./@heroicons-9fa5d0e6.js";import{H as x,L as $}from"./@inertiajs-751b4e3a.js";import{C as h}from"./ConfirmationModal-0631fbe4.js";import{P as y}from"./Pagination-c4e11c15.js";import{M as w}from"./Modal-97d3581f.js";import{s as b}from"./@vueform-aef92a1c.js";import{F as v}from"./fslightbox-vue-25d8c851.js";import"./ApplicationLogo-04b49080.js";import"./radix-vue-8d4617bd.js";import"./@floating-ui-1e8ef191.js";import"./class-variance-authority-f96983da.js";import"./app-dce748c9.js";import"./axios-9cbf0d09.js";import"./pusher-js-36ce843e.js";import"./@vuepic-ba9c4d94.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-8efab0ec.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-e8993a83.js";import"./@radix-icons-9a1732cf.js";import"./lodash.isequal-979ca240.js";import"./vue-446e1be1.js";import"./lodash.clonedeep-a2a90952.js";import"./qs-c5780410.js";import"./side-channel-c3de7aff.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-30e6e08c.js";import"./deepmerge-89e33937.js";import"./nprogress-2c66c043.js";import"./lucide-vue-next-4cc1c774.js";import"./@headlessui-d829f326.js";import"./vue-final-modal-522b0d3f.js";const V={class:"py-4 px-4"},z={key:0,class:"flex space-x-1 justify-end mb-3"},M=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-5 w-5",viewBox:"0 0 512 512"},[e("path",{d:"M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"})],-1),I=e("hr",{class:"my-3 border border-dashed border-gray-400"},null,-1),R={class:"relative w-full"},F=e("svg",{class:"absolute top-2.5 left-3 h-5 w-5 text-gray-400",viewBox:"0 0 24 24",fill:"none"},[e("path",{d:"M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),H={class:"w-full"},N={class:"w-full"},U={class:"w-full"},E={class:"w-full self-center"},G={class:"overflow-x-auto"},q={class:"shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg"},K={class:"min-w-full divide-y divide-gray-200"},Z=e("thead",{class:"bg-gray-300"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14"},"#"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14"},"Name"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Level"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Theme"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Lesson - Title"),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Activity"),e("th",{scope:"col",class:"px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14"},"Action")])],-1),J={class:"bg-white divide-y divide-gray-200"},Q={key:0},W=e("td",{class:"text-center",colspan:"10"},[e("div",{class:"p-3"}," No Record Found ")],-1),X=[W],Y={class:"px-6 py-4 whitespace-nowrap"},ee={class:"text-sm font-medium text-gray-700"},te={class:"px-6 py-4 whitespace-nowrap"},oe={class:"text-sm font-medium text-gray-900"},re={class:"px-6 py-4 whitespace-nowrap"},le={class:"text-sm font-medium text-gray-900"},ae={class:"px-6 py-4 whitespace-nowrap"},ne={class:"text-sm font-medium text-gray-900"},se={class:"px-6 py-4 whitespace-nowrap"},ie={class:"text-sm font-medium text-gray-900"},pe={class:"px-6 py-4 whitespace-nowrap"},de={class:"text-sm font-medium text-gray-900"},ce={class:"px-6 py-4 whitespace-nowrap text-center text-sm font-medium"},ue={class:"flex justify-center space-x-2"},ge={class:"flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold"},be=e("h3",{class:"text-gray-900 text-xl font-semibold"}," Student's Artwork ",-1),me=e("svg",{class:"w-5 h-5",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},[e("path",{"fill-rule":"evenodd",d:"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),fe=[me],xe={class:""},he={class:"flex justify-center w-full"},ye=["src"],we={class:"flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b"},ve={components:{SearchIcon:A,TrashIcon:T,PencilIcon:B,ConfirmationModal:h,Head:x,Link:$,Modal:w,Pagination:y,Multiselect:b,FsLightbox:v},props:{filter:Object},computed:{baseUrl(){return window.location.origin}},data(){return{isOpen:!1,open_modal:!1,confirmationData:"",confirmationRoute:"",lightbox:{open:!1,src:[]},student_status:[{id:1,name:"Active"},{id:0,name:"Inactive"}],params:{search:this.filter.search?this.filter.search:"",level:this.filter.level?this.filter.level:"",theme:this.filter.theme?this.filter.theme:"",status:this.filter.status?this.filter.status:""},imageExists:!1,artwork:{lesson:"",activity:"",file_location:""}}},methods:{viewArtwork(p){fetch(window.location.origin+"/storage/art_gallery/"+p).then(t=>{t.ok?this.lightbox.src=[window.location.origin+"/storage/art_gallery/"+p]:this.lightbox.src=[window.location.origin+"/images/no_image.jpg"],this.lightbox.open=!this.lightbox.open})},deleteArtwork(p){this.confirmationRoute="art_gallery.destroy",this.confirmationData=p,this.isOpen=!0},search(){this.$inertia.get(this.route("art_gallery"),this.params,{replace:!0,preserveState:!0})}}},ht=Object.assign(ve,{__name:"Index",setup(p){return(t,r)=>{const _=D("debounce");return n(),d(m,null,[l(c(x),{title:"Art Gallery"}),l(j,null,{header:a(()=>[]),default:a(()=>[e("div",V,[t.$page.props.can.create_art_gallery?(n(),d("div",z,[l(i,{url:t.route("art_gallery.create")},{default:a(()=>[u("Upload Artwork")]),_:1},8,["url"]),l(i,{url:t.route("art_gallery.setting.levels")},{default:a(()=>[M]),_:1},8,["url"])])):g("",!0),I,e("div",{class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3",onClick:r[4]||(r[4]=S(()=>{},["stop"]))},[e("div",R,[F,C(e("input",{type:"text",class:"h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md","onUpdate:modelValue":r[0]||(r[0]=o=>t.params.search=o)},null,512),[[_,t.search,"800ms"],[O,t.params.search]])]),e("div",H,[l(c(b),{onSelect:t.search,onDeselect:t.search,valueProp:"id",modelValue:t.params.level,"onUpdate:modelValue":r[1]||(r[1]=o=>t.params.level=o),options:t.$page.props.levels,clearOnSelect:!1,closeOnDeselect:!0,canClear:!1,canDeselect:!0,trackBy:"name",label:"name",placeholder:"All Levels",classes:{container:"relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerActive:"border-2 border-gray-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",search:"w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500",clear:"pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800",clearIcon:"fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",spinner:"bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",noOptions:"py-2 px-3 text-gray-600 bg-white text-left",noResults:"py-2 px-3 text-gray-600 bg-white text-left",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent"}},null,8,["onSelect","onDeselect","modelValue","options"])]),e("div",N,[l(c(b),{onSelect:t.search,onDeselect:t.search,valueProp:"id",modelValue:t.params.theme,"onUpdate:modelValue":r[2]||(r[2]=o=>t.params.theme=o),options:t.$page.props.themes,clearOnSelect:!1,closeOnDeselect:!0,canClear:!1,canDeselect:!0,trackBy:"name",label:"name",placeholder:"All Themes",classes:{container:"relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerActive:"border-2 border-gray-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",search:"w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500",clear:"pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800",clearIcon:"fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",spinner:"bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",noOptions:"py-2 px-3 text-gray-600 bg-white text-left",noResults:"py-2 px-3 text-gray-600 bg-white text-left",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent"}},null,8,["onSelect","onDeselect","modelValue","options"])]),e("div",U,[l(c(b),{onSelect:t.search,onDeselect:t.search,valueProp:"id",modelValue:t.params.status,"onUpdate:modelValue":r[3]||(r[3]=o=>t.params.status=o),options:t.student_status,clearOnSelect:!1,canClear:!1,canDeselect:!0,closeOnDeselect:!0,trackBy:"name",label:"name",placeholder:"Status",classes:{container:"relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerActive:"border-2 border-gray-300",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",search:"w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500",clear:"pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800",clearIcon:"fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",spinner:"bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none w-full",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-black-700",groupLabelSelected:"bg-gray-100 text-black",groupLabelSelectedPointed:"bg-gray-100 text-black opacity-90",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed",noOptions:"py-2 px-3 text-gray-600 bg-white text-left",noResults:"py-2 px-3 text-gray-600 bg-white text-left",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent"}},null,8,["onSelect","onDeselect","modelValue","options"])]),e("div",E,[l(i,{buttonType:"gray",class:"py-2 px-3",url:t.route("art_gallery")},{default:a(()=>[u("Clear Search")]),_:1},8,["url"])])]),e("div",G,[e("div",q,[e("table",K,[Z,e("tbody",J,[t.$page.props.arts.data.length?g("",!0):(n(),d("tr",Q,X)),(n(!0),d(m,null,P(t.$page.props.arts.data,(o,k)=>(n(),d("tr",{class:"hover:bg-gray-200",key:o.id},[e("td",Y,[e("div",ee,s(++k),1)]),e("td",te,[e("div",oe,s(o.student_name),1)]),e("td",re,[e("div",le,s(o.level),1)]),e("td",ae,[e("div",ne,s(o.theme),1)]),e("td",se,[e("div",ie,s(o.lesson),1)]),e("td",pe,[e("div",de,s(o.activity),1)]),e("td",ce,[e("div",ue,[t.$page.props.can.edit_art_gallery?(n(),f(i,{key:0,buttonType:"blue",onClick:L=>t.viewArtwork(o.art_file_location)},{default:a(()=>[u("View")]),_:2},1032,["onClick"])):g("",!0),t.$page.props.can.delete_art_gallery?(n(),f(i,{key:1,buttonType:"danger",onClick:L=>t.deleteArtwork(o.artwork_id)},{default:a(()=>[u("Delete")]),_:2},1032,["onClick"])):g("",!0)])])]))),128))])])]),l(y,{page_data:t.$page.props.arts,params:t.params},null,8,["page_data","params"]),l(w,{showModal:t.open_modal,modalType:"sm",onHideModal:r[7]||(r[7]=o=>t.open_modal=!1)},{header:a(()=>[e("div",ge,[be,e("button",{type:"button",onClick:r[5]||(r[5]=o=>t.open_modal=!1),class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center","data-modal-toggle":"default-modal"},fe)])]),content:a(()=>[e("div",xe,[e("div",he,[e("img",{src:t.artwork.file_location,class:"object-scale-down",alt:""},null,8,ye)])])]),footer:a(()=>[e("div",we,[l(i,{buttonType:"gray",onClick:r[6]||(r[6]=o=>t.open_modal=!1)},{default:a(()=>[u("Close")]),_:1})])]),_:1},8,["showModal"])]),l(h,{show:t.isOpen,onClose:r[8]||(r[8]=o=>t.isOpen=!1),confirmationAlert:"danger",confirmationTitle:"Delete Artwork",confirmationText:"Are you sure want to delete this artwork?",confirmationButton:"Delete",confirmationMethod:"delete",confirmationRoute:t.confirmationRoute,confirmationData:t.confirmationData},null,8,["show","confirmationRoute","confirmationData"]),l(c(v),{toggler:t.lightbox.open,sources:t.lightbox.src,exitFullscreenOnClose:!0},null,8,["toggler","sources"])])]),_:1})],64)}}});export{ht as default};