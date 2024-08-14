import"./Authenticated-6651b23d.js";import"./@inertiajs-41d03628.js";import{h as p}from"./moment-3968d9f3.js";import n from"./Header-48a15538.js";import{x as s,v as d,y as t,F as m,C as c,q as e,G as o,u as _,z as h}from"./@vue-64c42e7d.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";const x={id:"progress_report",class:"p-5 h-[297mm] w-[210mm]"},g=t("div",{class:"flex justify-center mb-5 h-[200px]"},[t("img",{src:"/images/progress_report/digital_art.png",class:"w-full h-[200px]",alt:""})],-1),y={class:"flex justify-center mb-5"},u={class:"w-full"},f=t("thead",null,[t("tr",{class:"border"},[t("th",{class:"border-2 border-gray-600 py-2 px-4 text-sm w-1/12"},"Date"),t("th",{class:"border-2 border-gray-600 py-2 px-4 text-sm w-7/12"},"Theme / Lesson / Activity / Outcome"),t("th",{class:"border-2 border-gray-600 py-2 px-4 text-sm w-4/12"},"Assessments through Observations")])],-1),b={key:0},v=t("td",{colspan:"10",class:"text-center"},"No record",-1),w=[v],k={class:"border-2 text-center border-gray-600 py-2 px-4 text-sm",colspan:"3"},z={class:"border-2 border-gray-600 py-2 px-4 align-middle"},M={class:"flex flex-col"},N={class:"border-2 border-gray-600 py-2 px-4 align-top divide-y"},O={class:"flex flex-col py-3 items-start"},A={class:"underline text-left font-semibold"},B={class:"text-left italic mb-3"},D={class:"text-left text-gray-700 font-bold"},j={class:"mt-3 space-y-0.5 text-gray-800"},L={class:"flex"},S={class:"flex"},V={key:0,xmlns:"http://www.w3.org/2000/svg",class:"mt-0.5 w-4 h-4 mr-2 flex-shrink-0",viewBox:"0 0 512 512"},C=t("path",{d:"M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"},null,-1),F=[C],J={key:1,xmlns:"http://www.w3.org/2000/svg",class:"mt-0.5 w-4 h-4 mr-2 flex-shrink-0",viewBox:"0 0 512 512"},q=t("path",{d:"M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"},null,-1),E=[q],G={class:"text-left"},H={class:"border-2 border-gray-600 py-2 px-4 text-sm align-top text-left"},T={props:{data:Object}},Ht=Object.assign(T,{__name:"DigitalArt",setup(i){return(Y,I)=>(e(),s("div",x,[g,d(n,{report_data:i.data},null,8,["report_data"]),t("div",y,[t("table",u,[f,t("tbody",null,[i.data.report_data.length?(e(!0),s(m,{key:1},c(i.data.report_data,(r,K)=>(e(),s("tr",k,[t("td",z,[t("div",M,o(_(p)(r.date).format("DD/MM/Y"))+" "+o(r.attendance_status_name),1)]),t("td",N,[JSON.parse(r.report_data).length?(e(!0),s(m,{key:0},c(JSON.parse(r.report_data),(a,P)=>(e(),s("div",O,[t("span",A,o(a.theme_name),1),t("span",B,o(a.lesson_name)+": "+o(a.activity_name),1),t("span",D,o(a.outcome_name),1),t("ul",j,[(e(!0),s(m,null,c(a.objectives,l=>(e(),s("li",L,[t("div",S,[l.achieved?(e(),s("svg",V,F)):(e(),s("svg",J,E)),t("span",G,o(l.name),1)])]))),256))])]))),256)):h("",!0)]),t("td",H,o(r.comments),1)]))),256)):(e(),s("tr",b,w))])])])]))}});export{Ht as default};