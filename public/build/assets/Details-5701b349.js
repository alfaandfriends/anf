import{B as w}from"./Authenticated-e54ea1c2.js";import{H as $,L as b}from"./@inertiajs-dde9cc4c.js";import{_ as y}from"./Card-1dc3a135.js";import{_ as B,a as C,b as f,c as l,d as D,e as i}from"./TableRow-c704adf7.js";import{h as L}from"./moment-a9aaa855.js";import{y as m,x as e,u as r,Q as t,F as g,be as N,t as n,W as s,v,z as d,C as R,J as V,K as u}from"./@vue-d42dd214.js";import"./ApplicationLogo-aa67088e.js";import"./radix-vue-d95f58a2.js";import"./@floating-ui-61ac2ed2.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-52f2569e.js";import"./clsx-1229b3e0.js";import"./app-9e9c0f86.js";import"./axios-1779699b.js";import"./pusher-js-fe63a254.js";import"./@vueform-cd27a95b.js";import"./cropperjs-ee227adc.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-4b397a2a.js";import"./tailwind-merge-3f7ff3b1.js";import"./@vueuse-7b89e231.js";import"./@radix-icons-4975f794.js";import"./@vuepic-1824abb1.js";import"./@babel-1b80a44a.js";import"./lodash.isequal-375e1553.js";import"./vue-227b0305.js";import"./lodash.clonedeep-ab16d4d4.js";import"./qs-19c2a829.js";import"./side-channel-0fc46420.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-c7e60009.js";import"./deepmerge-89e33937.js";import"./nprogress-cbfeb08c.js";import"./index-a78bcd26.js";import"./DialogDescription-befd605e.js";import"./lucide-vue-next-f56ff345.js";const Y={key:0,class:"flex items-center space-x-2"},F={key:1},T={id:"canvas",ref:"canvas",style:{display:"none"}},x={components:{Head:$,Link:b},data(){return{processing:!1,processing_item:[]}},methods:{viewReport(c){this.$inertia.get(route("diagnostic_test.report",c))}},created(){this.$page.props.answer_record.data.map(()=>{this.processing_item.push({process:!1})})}},Vt=Object.assign(x,{__name:"Details",setup(c){return(a,o)=>{const k=N("Button");return n(),m(g,null,[e(r($),{title:"Diagnostic Test"}),e(w,null,{header:t(()=>o[0]||(o[0]=[])),default:t(()=>[e(y,null,{content:t(()=>[e(r(B),null,{default:t(()=>[e(r(C),{class:"bg-gray-100"},{default:t(()=>[e(r(f),null,{default:t(()=>[e(r(l),null,{default:t(()=>o[1]||(o[1]=[s("#")])),_:1}),e(r(l),null,{default:t(()=>o[2]||(o[2]=[s("Level")])),_:1}),e(r(l),null,{default:t(()=>o[3]||(o[3]=[s("Result")])),_:1}),e(r(l),null,{default:t(()=>o[4]||(o[4]=[s("Date Taken")])),_:1}),e(r(l),{class:"text-center"},{default:t(()=>o[5]||(o[5]=[s("Action")])),_:1})]),_:1})]),_:1}),e(r(D),null,{default:t(()=>[a.$page.props.answer_record.data.length?R("",!0):(n(),v(r(f),{key:0},{default:t(()=>[e(r(i),{class:"text-center",colspan:"10"},{default:t(()=>o[6]||(o[6]=[d("div",{class:"p-3"}," No Record Found ",-1)])),_:1})]),_:1})),(n(!0),m(g,null,V(a.$page.props.answer_record.data,(p,_)=>(n(),v(r(f),null,{default:t(()=>[e(r(i),null,{default:t(()=>[s(u(a.$page.props.answer_record.from+_),1)]),_:2},1024),e(r(i),null,{default:t(()=>[s(u(p.dt_name),1)]),_:2},1024),e(r(i),null,{default:t(()=>[s(u(p.total_correct_answers+"/"+p.total_answers),1)]),_:2},1024),e(r(i),null,{default:t(()=>[s(u(r(L)(p.created_at).format("DD/MM/YYYY")),1)]),_:2},1024),e(r(i),{class:"text-center space-x-2"},{default:t(()=>[e(k,{onClick:z=>!a.processing_item[_].process&&!a.processing?a.viewReport(p.dt_details_id):""},{default:t(()=>[a.processing_item[_].process&&a.processing?(n(),m("div",Y,o[7]||(o[7]=[d("svg",{class:"inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]",viewBox:"0 0 24 24"},null,-1),d("span",null,"Generating...",-1)]))):(n(),m("span",F,"View Report"))]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),d("canvas",T,null,512)]),_:1})],64)}}});export{Vt as default};