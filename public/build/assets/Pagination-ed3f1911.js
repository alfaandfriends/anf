import{_}from"./_plugin-vue_export-helper-c27b6911.js";import{o,c as d,d as r,j as g,k as l,t as c,F as p,h as f,n as h}from"./app-4e264255.js";const y={data(){return{url:""}},props:{page_data:Object,params:Object},methods:{objectToQueryString(n,a=""){const e=[];for(const s in n)if(n.hasOwnProperty(s)){const i=n[s],u=a?`${a}[${s}]`:s;typeof i=="object"&&!Array.isArray(i)?e.push(this.objectToQueryString(i,u)):e.push(`${encodeURIComponent(u)}=${encodeURIComponent(i)}`)}return e.join("&")},generateQueryString(){this.url=this.objectToQueryString(this.params)}},mounted(){this.generateQueryString()},updated(){this.generateQueryString()}},x={class:"px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-300"},b={class:"flex-1 flex justify-between sm:hidden"},v=["href"],w=["href"],j={class:"hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"},S={class:"text-sm text-gray-700"},C={class:"font-medium"},k={class:"font-medium"},Q={class:"font-medium"},T={id:"pagination",class:"relative z-0 inline-flex rounded-md shadow-sm -space-x-px"},N=["href","innerHTML"];function P(n,a,e,s,i,u){return o(),d("div",x,[r("div",b,[e.page_data.prev_page_url?(o(),d("a",{key:0,href:e.page_data.prev_page_url,onClick:a[0]||(a[0]=t=>n.handleClick(t,e.page_data.prev_page_url)),class:"relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Previous ",8,v)):g("",!0),e.page_data.next_page_url?(o(),d("a",{key:1,href:e.page_data.next_page_url,onClick:a[1]||(a[1]=t=>n.handleClick(t,e.page_data.prev_page_url)),class:"ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Next ",8,w)):g("",!0)]),r("div",j,[r("div",null,[r("p",S,[l(" Showing "),r("span",C,c(e.page_data.from),1),l(" to "),r("span",k,c(e.page_data.to),1),l(" of "),r("span",Q,c(e.page_data.total),1),l(" results ")])]),r("div",null,[r("nav",T,[(o(!0),d(p,null,f(e.page_data.links,(t,m)=>(o(),d("a",{key:m,href:t.url!==null&&t.url!==""?t.url+(this.url?"&"+this.url:""):null,class:h(t.active==!1&&t.url==null?"select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed":t.active?"select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium":"select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"),innerHTML:t.label},null,10,N))),128))])])])])}const L=_(y,[["render",P]]);export{L as P};