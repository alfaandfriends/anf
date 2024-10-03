import{_ as h}from"./Authenticated-83241459.js";import{H as w}from"./@inertiajs-4f2e6820.js";import{N as x}from"./vue-easy-lightbox-227c64d9.js";import{s as f}from"./@vueform-4cba997d.js";import{s as u}from"./simplebar-vue-38b188cf.js";import{y as a,x as n,u as p,z as r,K as v,Q as m,F as c,t as l,q as g,C as i,J as y}from"./@vue-66b8c761.js";import"./@heroicons-d367e696.js";import"./app-88d53e22.js";import"./axios-1779699b.js";import"./pusher-js-cb9cdec3.js";import"./@vuepic-d831316d.js";import"./@babel-1b80a44a.js";import"./cropperjs-c64556db.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-2d2eee44.js";import"./radix-vue-aa72069b.js";import"./@floating-ui-b481b296.js";import"./@internationalized-2f03b566.js";import"./clsx-1229b3e0.js";import"./tailwind-merge-26e9d2f1.js";import"./@vueuse-b3927753.js";import"./class-variance-authority-52f2569e.js";import"./@radix-icons-de95313b.js";import"./lodash.isequal-802c39ac.js";import"./vue-978cb4c7.js";import"./lodash.clonedeep-6494eade.js";import"./qs-740c36f9.js";import"./side-channel-eec8ae42.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-d4161e53.js";import"./deepmerge-89e33937.js";import"./nprogress-5b8a22ad.js";import"./@headlessui-2f73f476.js";import"./Button-79d0c069.js";import"./simplebar-core-3f5973b9.js";import"./lodash-es-9b1d07da.js";const k={class:"fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20"},$={class:"max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14"},S={class:"flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium"},A={key:0,class:"flex items-center space-y-3"},_={class:"mb-3 flex flex-col space-y-2 justify-between items-end mt-3"},L={key:1,class:"bg-white overflow-hidden shadow rounded-lg border p-6"},j={class:"grid grid-cols-2 gap-4 md:grid-cols-3"},C=["src","onClick"],H={key:0,class:"grid grid-cols-2 gap-4 md:grid-cols-3 mt-4"},D={key:2,class:"flex justify-center mx-1 mt-10"},V={key:3,class:"flex justify-center mx-1 mt-10"},Z={components:{Multiselect:f,simplebar:u},data(){return{lightbox:{open:!1,images:[{src:""}]},list:{levels:this.$page.props.levels},filter:{level_id:1},searching:{artworks:!1},loading:{artworks:!1}}},watch:{"filter.level_id":{handler(){this.getArtwork()},deep:!0}},methods:{getArtwork(){if(this.filter.level_id){if(this.searching.artworks)return;this.searching.artworks=!0,axios.get(route("parent.art_gallery.get_artworks"),{params:this.filter}).then(s=>{this.$page.props.artworks.data=s.data,this.searching.artworks=!1})}},showImage(s,e){this.lightbox.images[0].src=window.location.origin+"/storage/art_gallery/"+s,this.lightbox.open=!this.lightbox.open},handleArtworkScroll(){const s=this.$refs.artwork_container.$el.querySelector(".simplebar-content-wrapper"),e=s.scrollTop,t=s.scrollHeight,o=s.clientHeight;e+o>=t-100&&this.$page.props.artworks.next_page_url&&(this.loading.artworks||(this.loading.artworks=!0,axios.get(route("parent.student_artworks",this.filter.level_id),{params:{page:this.$page.props.artworks.current_page+1}}).then(d=>{d.data.data.forEach(b=>{this.$page.props.artworks.data.push(b)}),this.$page.props.artworks.current_page=d.data.current_page,this.$page.props.artworks.next_page_url=d.data.next_page_url,this.loading.artworks=!1})))}}},je=Object.assign(Z,{__name:"ArtGallery",setup(s){return(e,t)=>(l(),a(c,null,[n(p(w),{title:"Art Gallery"}),r("div",k,[r("span",null,v(e.$page.props.session_data.current_active_programme.name),1)]),n(h,null,{default:m(()=>[r("div",$,[n(p(u),{"data-simplebar-auto-hide":"true"},{default:m(()=>[r("div",S,[r("div",{class:g(["flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap",e.route().current("parent.stories")?"font-extrabold":""]),onClick:t[0]||(t[0]=o=>e.$inertia.get(e.route("parent.stories",e.$page.props.session_data.current_active_programme.encrypted_id)))},t[8]||(t[8]=[r("img",{src:"/images/parents/stories.png",class:"w-10 h-10",alt:""},null,-1),r("span",{class:"text-sm"},"Stories",-1)]),2),r("div",{class:g(["flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap",e.route().current("parent.progress_reports")?"font-extrabold":""]),onClick:t[1]||(t[1]=o=>e.$inertia.get(e.route("parent.progress_reports")))},t[9]||(t[9]=[r("img",{src:"/images/parents/progress_report.png",class:"w-10 h-10",alt:""},null,-1),r("span",{class:"text-sm"},"Progress Reports",-1)]),2),r("div",{class:g(["flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap",e.route().current("parent.invoices")?"font-extrabold":""]),onClick:t[2]||(t[2]=o=>e.$inertia.get(e.route("parent.invoices")))},t[10]||(t[10]=[r("img",{src:"/images/parents/fee_invoice.png",class:"w-10 h-10",alt:""},null,-1),r("span",{class:"text-sm"},"Invoices",-1)]),2),e.$page.props.session_data.current_active_programme.id==3||e.$page.props.session_data.current_active_programme.id==5?(l(),a("div",{key:0,class:g(["flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap",e.route().current("parent.art_gallery")?"font-extrabold":""]),onClick:t[3]||(t[3]=o=>e.$inertia.get(e.route("parent.art_gallery")))},t[11]||(t[11]=[r("img",{src:"/images/parents/art_gallery.png",class:"w-10 h-10",alt:""},null,-1),r("span",{class:"text-sm"},"Art Gallery",-1)]),2)):i("",!0),e.$page.props.session_data.current_active_programme.id==3||e.$page.props.session_data.current_active_programme.id==5?(l(),a("div",{key:1,class:g(["flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap",e.route().current("parent.art_book")?"font-extrabold":""]),onClick:t[4]||(t[4]=o=>e.$inertia.get(e.route("parent.art_book")))},t[12]||(t[12]=[r("img",{src:"/images/parents/art_book.png",class:"w-10 h-10",alt:""},null,-1),r("span",{class:"text-sm"},"Art Book",-1)]),2)):i("",!0)])]),_:1})]),r("div",{class:"max-w-xl mx-auto mt-10",onScroll:t[6]||(t[6]=o=>e.handleScroll()),ref:"scrollContainer"},[e.$page.props.artworks.data?(l(),a("div",A,t[13]||(t[13]=[r("h2",{class:"text-lg md:text-xl mx-1 font-extrabold"},"Art Gallery",-1)]))):i("",!0),r("div",_,[n(p(f),{modelValue:e.filter.level_id,"onUpdate:modelValue":t[5]||(t[5]=o=>e.filter.level_id=o),options:e.$page.props.levels,valueProp:"id",placeholder:"Select Level",label:"name",closeOnSelect:!0,canDeselect:!1,classes:{container:"relative mx-auto w-full flex items-center justify-end box-border rounded-lg shadow cursor-pointer border border-gray-200 rounded bg-white text-base leading-snug outline-none",containerDisabled:"cursor-default bg-gray-100",containerOpen:"rounded-b-none",containerOpenTop:"rounded-t-none",containerActive:"ring-0 ring-opacity-30",singleLabel:"flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5",singleLabelText:"overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full",multipleLabel:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5",search:"w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 rtl:pl-0 rtl:pr-3.5",tags:"flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 rtl:pl-0 rtl:pr-2",tag:"bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1",tagDisabled:"pr-2 opacity-50 rtl:pl-2",tagRemove:"flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group",tagRemoveIcon:"bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60",tagsSearchWrapper:"inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full",tagsSearch:"absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full",tagsSearchCopy:"invisible whitespace-pre-wrap inline-block h-px",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5",caret:"bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5",caretOpen:"rotate-180 pointer-events-auto",clear:"pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5",clearIcon:"bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block",spinner:"bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0 rtl:mr-0 rtl:ml-3.5",inifite:"flex items-center justify-center w-full",inifiteSpinner:"bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5",dropdown:"max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b",dropdownTop:"-translate-y-full top-px bottom-auto rounded-b-none rounded-t",dropdownHidden:"hidden",options:"flex flex-col p-0 m-0 list-none",optionsTop:"",group:"p-0 m-0",groupLabel:"flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal",groupLabelPointable:"cursor-pointer",groupLabelPointed:"bg-gray-300 text-gray-700",groupLabelSelected:"bg-indigo-600 text-white",groupLabelDisabled:"bg-gray-100 text-gray-300 cursor-not-allowed",groupLabelSelectedPointed:"bg-indigo-600 text-white opacity-90",groupLabelSelectedDisabled:"text-indigo-100 bg-indigo-600 bg-opacity-50 cursor-not-allowed",groupOptions:"p-0 m-0",option:"flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3",optionPointed:"text-gray-800 bg-gray-100",optionSelected:"text-white bg-indigo-500",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-indigo-500 opacity-90",optionSelectedDisabled:"text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed",noOptions:"py-2 px-3 text-gray-600 bg-white text-left",noResults:"py-2 px-3 text-gray-600 bg-white text-left",fakeInput:"bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent",spacer:"h-9 py-px box-content"}},null,8,["modelValue","options"])]),e.$page.props.artworks.data.length&&!e.searching.artworks?(l(),a("div",L,[n(p(u),{"data-simplebar-auto-hide":"true",class:"max-h-96",onScroll:e.handleArtworkScroll,ref:"artwork_container"},{default:m(()=>[r("div",j,[(l(!0),a(c,null,y(e.$page.props.artworks.data,o=>(l(),a("div",null,[r("img",{class:"object-cover object-center w-full h-40 max-w-full rounded-lg cursor-pointer",src:"/storage/art_gallery/"+o.filename,onClick:d=>e.showImage(o.filename,o.activity)},null,8,C)]))),256))]),e.loading.artworks?(l(),a("div",H,t[14]||(t[14]=[r("div",{class:"flex items-center justify-center h-40 mb-4 bg-gray-200 rounded animate-pulse"},[r("svg",{class:"w-10 h-10 text-gray-300","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 16 20"},[r("path",{d:"M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"}),r("path",{d:"M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"})])],-1),r("div",{class:"flex items-center justify-center h-40 mb-4 bg-gray-200 rounded animate-pulse"},[r("svg",{class:"w-10 h-10 text-gray-300","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 16 20"},[r("path",{d:"M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"}),r("path",{d:"M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"})])],-1),r("div",{class:"flex items-center justify-center h-40 mb-4 bg-gray-200 rounded animate-pulse"},[r("svg",{class:"w-10 h-10 text-gray-300","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 16 20"},[r("path",{d:"M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"}),r("path",{d:"M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"})])],-1)]))):i("",!0)]),_:1},8,["onScroll"])])):i("",!0),!e.$page.props.artworks.data.length&&!e.searching.artworks?(l(),a("div",D,t[15]||(t[15]=[r("span",{class:"text-slate-500"},"No Artworks Found",-1)]))):i("",!0),e.searching.artworks?(l(),a("div",V,t[16]||(t[16]=[r("span",{class:"text-slate-500"},"Searching for student's artworks...",-1)]))):i("",!0)],544)]),_:1}),n(p(x),{onHide:t[7]||(t[7]=o=>e.lightbox.open=!1),visible:e.lightbox.open,zoomDisabled:!0,rotateDisabled:!0,moveDisabled:!0,imgs:e.lightbox.images,index:0,dblclickDisabled:!0,maskClosable:!0},null,8,["visible","imgs"])],64))}});export{je as default};