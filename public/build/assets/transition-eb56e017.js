import{Z as lt,_ as O,F as je,S as j,$ as N,Q as Re,a0 as D,q as g,x as h,C as F,s as T,a1 as R,J as ee,P as at,D as ot,u as it,a2 as ut,n as st}from"./app-5e7199e3.js";function C(e,t,...n){if(e in t){let l=t[e];return typeof l=="function"?l(...n):l}let r=new Error(`Tried to handle "${e}" but there is no handler defined. Only defined handlers are: ${Object.keys(t).map(l=>`"${l}"`).join(", ")}.`);throw Error.captureStackTrace&&Error.captureStackTrace(r,C),r}var se=(e=>(e[e.None=0]="None",e[e.RenderStrategy=1]="RenderStrategy",e[e.Static=2]="Static",e))(se||{}),H=(e=>(e[e.Unmount=0]="Unmount",e[e.Hidden=1]="Hidden",e))(H||{});function L({visible:e=!0,features:t=0,ourProps:n,theirProps:r,...l}){var a;let o=Ne(r,n),i=Object.assign(l,{props:o});if(e||t&2&&o.static)return he(i);if(t&1){let s=(a=o.unmount)==null||a?0:1;return C(s,{[0](){return null},[1](){return he({...l,props:{...o,hidden:!0,style:{display:"none"}}})}})}return he(i)}function he({props:e,attrs:t,slots:n,slot:r,name:l}){var a,o;let{as:i,...s}=Me(e,["unmount","static"]),u=(a=n.default)==null?void 0:a.call(n,r),d={};if(r){let f=!1,y=[];for(let[c,p]of Object.entries(r))typeof p=="boolean"&&(f=!0),p===!0&&y.push(c);f&&(d["data-headlessui-state"]=y.join(" "))}if(i==="template"){if(u=ke(u??[]),Object.keys(s).length>0||Object.keys(t).length>0){let[f,...y]=u??[];if(!dt(f)||y.length>0)throw new Error(['Passing props on "template"!',"",`The current component <${l} /> is rendering a "template".`,"However we need to passthrough the following props:",Object.keys(s).concat(Object.keys(t)).map(v=>v.trim()).filter((v,P,I)=>I.indexOf(v)===P).sort((v,P)=>v.localeCompare(P)).map(v=>`  - ${v}`).join(`
`),"","You can apply a few solutions:",['Add an `as="..."` prop, to ensure that we render an actual element instead of a "template".',"Render a single element as the child so that we can forward the props onto that element."].map(v=>`  - ${v}`).join(`
`)].join(`
`));let c=Ne((o=f.props)!=null?o:{},s),p=lt(f,c);for(let v in c)v.startsWith("on")&&(p.props||(p.props={}),p.props[v]=c[v]);return p}return Array.isArray(u)&&u.length===1?u[0]:u}return O(i,Object.assign({},s,d),{default:()=>u})}function ke(e){return e.flatMap(t=>t.type===je?ke(t.children):[t])}function Ne(...e){if(e.length===0)return{};if(e.length===1)return e[0];let t={},n={};for(let r of e)for(let l in r)l.startsWith("on")&&typeof r[l]=="function"?(n[l]!=null||(n[l]=[]),n[l].push(r[l])):t[l]=r[l];if(t.disabled||t["aria-disabled"])return Object.assign(t,Object.fromEntries(Object.keys(n).map(r=>[r,void 0])));for(let r in n)Object.assign(t,{[r](l,...a){let o=n[r];for(let i of o){if(l instanceof Event&&l.defaultPrevented)return;i(l,...a)}}});return t}function Me(e,t=[]){let n=Object.assign({},e);for(let r of t)r in n&&delete n[r];return n}function dt(e){return e==null?!1:typeof e.type=="string"||typeof e.type=="object"||typeof e.type=="function"}let ct=0;function ft(){return++ct}function G(){return ft()}var He=(e=>(e.Space=" ",e.Enter="Enter",e.Escape="Escape",e.Backspace="Backspace",e.Delete="Delete",e.ArrowLeft="ArrowLeft",e.ArrowUp="ArrowUp",e.ArrowRight="ArrowRight",e.ArrowDown="ArrowDown",e.Home="Home",e.End="End",e.PageUp="PageUp",e.PageDown="PageDown",e.Tab="Tab",e))(He||{});function E(e){var t;return e==null||e.value==null?null:(t=e.value.$el)!=null?t:e.value}let Be=Symbol("Context");var $=(e=>(e[e.Open=1]="Open",e[e.Closed=2]="Closed",e[e.Closing=4]="Closing",e[e.Opening=8]="Opening",e))($||{});function pt(){return Fe()!==null}function Fe(){return j(Be,null)}function vt(e){N(Be,e)}var mt=Object.defineProperty,ht=(e,t,n)=>t in e?mt(e,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[t]=n,De=(e,t,n)=>(ht(e,typeof t!="symbol"?t+"":t,n),n);class gt{constructor(){De(this,"current",this.detect()),De(this,"currentId",0)}set(t){this.current!==t&&(this.currentId=0,this.current=t)}reset(){this.set(this.detect())}nextId(){return++this.currentId}get isServer(){return this.current==="server"}get isClient(){return this.current==="client"}detect(){return typeof window>"u"||typeof document>"u"?"server":"client"}}let te=new gt;function J(e){if(te.isServer)return null;if(e instanceof Node)return e.ownerDocument;if(e!=null&&e.hasOwnProperty("value")){let t=E(e);if(t)return t.ownerDocument}return document}let we=["[contentEditable=true]","[tabindex]","a[href]","area[href]","button:not([disabled])","iframe","input:not([disabled])","select:not([disabled])","textarea:not([disabled])"].map(e=>`${e}:not([tabindex='-1'])`).join(",");var M=(e=>(e[e.First=1]="First",e[e.Previous=2]="Previous",e[e.Next=4]="Next",e[e.Last=8]="Last",e[e.WrapAround=16]="WrapAround",e[e.NoScroll=32]="NoScroll",e))(M||{}),Ie=(e=>(e[e.Error=0]="Error",e[e.Overflow=1]="Overflow",e[e.Success=2]="Success",e[e.Underflow=3]="Underflow",e))(Ie||{}),bt=(e=>(e[e.Previous=-1]="Previous",e[e.Next=1]="Next",e))(bt||{});function Ue(e=document.body){return e==null?[]:Array.from(e.querySelectorAll(we)).sort((t,n)=>Math.sign((t.tabIndex||Number.MAX_SAFE_INTEGER)-(n.tabIndex||Number.MAX_SAFE_INTEGER)))}var We=(e=>(e[e.Strict=0]="Strict",e[e.Loose=1]="Loose",e))(We||{});function qe(e,t=0){var n;return e===((n=J(e))==null?void 0:n.body)?!1:C(t,{[0](){return e.matches(we)},[1](){let r=e;for(;r!==null;){if(r.matches(we))return!0;r=r.parentElement}return!1}})}function rn(e){let t=J(e);Re(()=>{t&&!qe(t.activeElement,0)&&B(e)})}function B(e){e==null||e.focus({preventScroll:!0})}let yt=["textarea","input"].join(",");function wt(e){var t,n;return(n=(t=e==null?void 0:e.matches)==null?void 0:t.call(e,yt))!=null?n:!1}function Et(e,t=n=>n){return e.slice().sort((n,r)=>{let l=t(n),a=t(r);if(l===null||a===null)return 0;let o=l.compareDocumentPosition(a);return o&Node.DOCUMENT_POSITION_FOLLOWING?-1:o&Node.DOCUMENT_POSITION_PRECEDING?1:0})}function ln(e,t){return Z(Ue(),t,{relativeTo:e})}function Z(e,t,{sorted:n=!0,relativeTo:r=null,skipElements:l=[]}={}){var a;let o=(a=Array.isArray(e)?e.length>0?e[0].ownerDocument:document:e==null?void 0:e.ownerDocument)!=null?a:document,i=Array.isArray(e)?n?Et(e):e:Ue(e);l.length>0&&i.length>1&&(i=i.filter(p=>!l.includes(p))),r=r??o.activeElement;let s=(()=>{if(t&5)return 1;if(t&10)return-1;throw new Error("Missing Focus.First, Focus.Previous, Focus.Next or Focus.Last")})(),u=(()=>{if(t&1)return 0;if(t&2)return Math.max(0,i.indexOf(r))-1;if(t&4)return Math.max(0,i.indexOf(r))+1;if(t&8)return i.length-1;throw new Error("Missing Focus.First, Focus.Previous, Focus.Next or Focus.Last")})(),d=t&32?{preventScroll:!0}:{},f=0,y=i.length,c;do{if(f>=y||f+y<=0)return 0;let p=u+f;if(t&16)p=(p+y)%y;else{if(p<0)return 3;if(p>=y)return 1}c=i[p],c==null||c.focus(d),f+=s}while(c!==o.activeElement);return t&6&&wt(c)&&c.select(),c.hasAttribute("tabindex")||c.setAttribute("tabindex","0"),2}function ge(e,t,n){te.isServer||D(r=>{document.addEventListener(e,t,n),r(()=>document.removeEventListener(e,t,n))})}function St(e,t,n=h(()=>!0)){function r(a,o){if(!n.value||a.defaultPrevented)return;let i=o(a);if(i===null||!i.getRootNode().contains(i))return;let s=function u(d){return typeof d=="function"?u(d()):Array.isArray(d)||d instanceof Set?d:[d]}(e);for(let u of s){if(u===null)continue;let d=u instanceof HTMLElement?u:E(u);if(d!=null&&d.contains(i)||a.composed&&a.composedPath().includes(d))return}return!qe(i,We.Loose)&&i.tabIndex!==-1&&a.preventDefault(),t(a,i)}let l=g(null);ge("mousedown",a=>{var o,i;n.value&&(l.value=((i=(o=a.composedPath)==null?void 0:o.call(a))==null?void 0:i[0])||a.target)},!0),ge("click",a=>{l.value&&(r(a,()=>l.value),l.value=null)},!0),ge("blur",a=>r(a,()=>window.document.activeElement instanceof HTMLIFrameElement?window.document.activeElement:null),!0)}var de=(e=>(e[e.None=1]="None",e[e.Focusable=2]="Focusable",e[e.Hidden=4]="Hidden",e))(de||{});let Ee=F({name:"Hidden",props:{as:{type:[Object,String],default:"div"},features:{type:Number,default:1}},setup(e,{slots:t,attrs:n}){return()=>{let{features:r,...l}=e,a={"aria-hidden":(r&2)===2?!0:void 0,style:{position:"fixed",top:1,left:1,width:1,height:0,padding:0,margin:-1,overflow:"hidden",clip:"rect(0, 0, 0, 0)",whiteSpace:"nowrap",borderWidth:"0",...(r&4)===4&&(r&2)!==2&&{display:"none"}}};return L({ourProps:a,theirProps:l,slot:{},attrs:n,slots:t,name:"Hidden"})}}});function Ot(){return/iPhone/gi.test(window.navigator.platform)||/Mac/gi.test(window.navigator.platform)&&window.navigator.maxTouchPoints>0}function Tt(e,t,n){te.isServer||D(r=>{window.addEventListener(e,t,n),r(()=>window.removeEventListener(e,t,n))})}var z=(e=>(e[e.Forwards=0]="Forwards",e[e.Backwards=1]="Backwards",e))(z||{});function $t(){let e=g(0);return Tt("keydown",t=>{t.key==="Tab"&&(e.value=t.shiftKey?1:0)}),e}function _e(e,t,n,r){te.isServer||D(l=>{e=e??window,e.addEventListener(t,n,r),l(()=>e.removeEventListener(t,n,r))})}function Ve(e){typeof queueMicrotask=="function"?queueMicrotask(e):Promise.resolve().then(e).catch(t=>setTimeout(()=>{throw t}))}function Ge(e){if(!e)return new Set;if(typeof e=="function")return new Set(e());let t=new Set;for(let n of e.value){let r=E(n);r instanceof HTMLElement&&t.add(r)}return t}var Ye=(e=>(e[e.None=1]="None",e[e.InitialFocus=2]="InitialFocus",e[e.TabLock=4]="TabLock",e[e.FocusLock=8]="FocusLock",e[e.RestoreFocus=16]="RestoreFocus",e[e.All=30]="All",e))(Ye||{});let Q=Object.assign(F({name:"FocusTrap",props:{as:{type:[Object,String],default:"div"},initialFocus:{type:Object,default:null},features:{type:Number,default:30},containers:{type:[Object,Function],default:g(new Set)}},inheritAttrs:!1,setup(e,{attrs:t,slots:n,expose:r}){let l=g(null);r({el:l,$el:l});let a=h(()=>J(l)),o=g(!1);T(()=>o.value=!0),R(()=>o.value=!1),Lt({ownerDocument:a},h(()=>o.value&&!!(e.features&16)));let i=Pt({ownerDocument:a,container:l,initialFocus:h(()=>e.initialFocus)},h(()=>o.value&&!!(e.features&2)));At({ownerDocument:a,container:l,containers:e.containers,previousActiveElement:i},h(()=>o.value&&!!(e.features&8)));let s=$t();function u(c){let p=E(l);p&&(v=>v())(()=>{C(s.value,{[z.Forwards]:()=>{Z(p,M.First,{skipElements:[c.relatedTarget]})},[z.Backwards]:()=>{Z(p,M.Last,{skipElements:[c.relatedTarget]})}})})}let d=g(!1);function f(c){c.key==="Tab"&&(d.value=!0,requestAnimationFrame(()=>{d.value=!1}))}function y(c){if(!o.value)return;let p=Ge(e.containers);E(l)instanceof HTMLElement&&p.add(E(l));let v=c.relatedTarget;v instanceof HTMLElement&&v.dataset.headlessuiFocusGuard!=="true"&&(Je(p,v)||(d.value?Z(E(l),C(s.value,{[z.Forwards]:()=>M.Next,[z.Backwards]:()=>M.Previous})|M.WrapAround,{relativeTo:c.target}):c.target instanceof HTMLElement&&B(c.target)))}return()=>{let c={},p={ref:l,onKeydown:f,onFocusout:y},{features:v,initialFocus:P,containers:I,...A}=e;return O(je,[!!(v&4)&&O(Ee,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:u,features:de.Focusable}),L({ourProps:p,theirProps:{...t,...A},slot:c,attrs:t,slots:n,name:"FocusTrap"}),!!(v&4)&&O(Ee,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:u,features:de.Focusable})])}}}),{features:Ye}),_=[];if(typeof window<"u"&&typeof document<"u"){let e=function(t){t.target instanceof HTMLElement&&t.target!==document.body&&_[0]!==t.target&&(_.unshift(t.target),_=_.filter(n=>n!=null&&n.isConnected),_.splice(10))};window.addEventListener("click",e,{capture:!0}),window.addEventListener("mousedown",e,{capture:!0}),window.addEventListener("focus",e,{capture:!0}),document.body.addEventListener("click",e,{capture:!0}),document.body.addEventListener("mousedown",e,{capture:!0}),document.body.addEventListener("focus",e,{capture:!0})}function Ft(e){let t=g(_.slice());return ee([e],([n],[r])=>{r===!0&&n===!1?Ve(()=>{t.value.splice(0)}):r===!1&&n===!0&&(t.value=_.slice())},{flush:"post"}),()=>{var n;return(n=t.value.find(r=>r!=null&&r.isConnected))!=null?n:null}}function Lt({ownerDocument:e},t){let n=Ft(t);T(()=>{D(()=>{var r,l;t.value||((r=e.value)==null?void 0:r.activeElement)===((l=e.value)==null?void 0:l.body)&&B(n())},{flush:"post"})}),R(()=>{B(n())})}function Pt({ownerDocument:e,container:t,initialFocus:n},r){let l=g(null),a=g(!1);return T(()=>a.value=!0),R(()=>a.value=!1),T(()=>{ee([t,n,r],(o,i)=>{if(o.every((u,d)=>(i==null?void 0:i[d])===u)||!r.value)return;let s=E(t);s&&Ve(()=>{var u,d;if(!a.value)return;let f=E(n),y=(u=e.value)==null?void 0:u.activeElement;if(f){if(f===y){l.value=y;return}}else if(s.contains(y)){l.value=y;return}f?B(f):Z(s,M.First|M.NoScroll)===Ie.Error&&console.warn("There are no focusable elements inside the <FocusTrap />"),l.value=(d=e.value)==null?void 0:d.activeElement})},{immediate:!0,flush:"post"})}),l}function At({ownerDocument:e,container:t,containers:n,previousActiveElement:r},l){var a;_e((a=e.value)==null?void 0:a.defaultView,"focus",o=>{if(!l.value)return;let i=Ge(n);E(t)instanceof HTMLElement&&i.add(E(t));let s=r.value;if(!s)return;let u=o.target;u&&u instanceof HTMLElement?Je(i,u)?(r.value=u,B(u)):(o.preventDefault(),o.stopPropagation(),B(s)):B(r.value)},!0)}function Je(e,t){for(let n of e)if(n.contains(t))return!0;return!1}let be=new Map,X=new Map;function xe(e,t=g(!0)){D(n=>{var r;if(!t.value)return;let l=E(e);if(!l)return;n(function(){var o;if(!l)return;let i=(o=X.get(l))!=null?o:1;if(i===1?X.delete(l):X.set(l,i-1),i!==1)return;let s=be.get(l);s&&(s["aria-hidden"]===null?l.removeAttribute("aria-hidden"):l.setAttribute("aria-hidden",s["aria-hidden"]),l.inert=s.inert,be.delete(l))});let a=(r=X.get(l))!=null?r:0;X.set(l,a+1),a===0&&(be.set(l,{"aria-hidden":l.getAttribute("aria-hidden"),inert:l.inert}),l.setAttribute("aria-hidden","true"),l.inert=!0)})}let Ke=Symbol("ForcePortalRootContext");function Dt(){return j(Ke,!1)}let Se=F({name:"ForcePortalRoot",props:{as:{type:[Object,String],default:"template"},force:{type:Boolean,default:!1}},setup(e,{slots:t,attrs:n}){return N(Ke,e.force),()=>{let{force:r,...l}=e;return L({theirProps:l,ourProps:{},slot:{},slots:t,attrs:n,name:"ForcePortalRoot"})}}});function xt(e){let t=J(e);if(!t){if(e===null)return null;throw new Error(`[Headless UI]: Cannot find ownerDocument for contextElement: ${e}`)}let n=t.getElementById("headlessui-portal-root");if(n)return n;let r=t.createElement("div");return r.setAttribute("id","headlessui-portal-root"),t.body.appendChild(r)}let Qe=F({name:"Portal",props:{as:{type:[Object,String],default:"div"}},setup(e,{slots:t,attrs:n}){let r=g(null),l=h(()=>J(r)),a=Dt(),o=j(Xe,null),i=g(a===!0||o==null?xt(r.value):o.resolveTarget());return D(()=>{a||o!=null&&(i.value=o.resolveTarget())}),R(()=>{var s,u;let d=(s=l.value)==null?void 0:s.getElementById("headlessui-portal-root");d&&i.value===d&&i.value.children.length<=0&&((u=i.value.parentElement)==null||u.removeChild(i.value))}),()=>{if(i.value===null)return null;let s={ref:r,"data-headlessui-portal":""};return O(at,{to:i.value},L({ourProps:s,theirProps:e,slot:{},attrs:n,slots:t,name:"Portal"}))}}}),Xe=Symbol("PortalGroupContext"),Ct=F({name:"PortalGroup",props:{as:{type:[Object,String],default:"template"},target:{type:Object,default:null}},setup(e,{attrs:t,slots:n}){let r=ot({resolveTarget(){return e.target}});return N(Xe,r),()=>{let{target:l,...a}=e;return L({theirProps:a,ourProps:{},slot:{},attrs:t,slots:n,name:"PortalGroup"})}}}),ze=Symbol("StackContext");var Oe=(e=>(e[e.Add=0]="Add",e[e.Remove=1]="Remove",e))(Oe||{});function jt(){return j(ze,()=>{})}function Rt({type:e,enabled:t,element:n,onUpdate:r}){let l=jt();function a(...o){r==null||r(...o),l(...o)}T(()=>{ee(t,(o,i)=>{o?a(0,e,n):i===!0&&a(1,e,n)},{immediate:!0,flush:"sync"})}),R(()=>{t.value&&a(1,e,n)}),N(ze,a)}let Ze=Symbol("DescriptionContext");function kt(){let e=j(Ze,null);if(e===null)throw new Error("Missing parent");return e}function Nt({slot:e=g({}),name:t="Description",props:n={}}={}){let r=g([]);function l(a){return r.value.push(a),()=>{let o=r.value.indexOf(a);o!==-1&&r.value.splice(o,1)}}return N(Ze,{register:l,slot:e,name:t,props:n}),h(()=>r.value.length>0?r.value.join(" "):void 0)}F({name:"Description",props:{as:{type:[Object,String],default:"p"},id:{type:String,default:()=>`headlessui-description-${G()}`}},setup(e,{attrs:t,slots:n}){let r=kt();return T(()=>R(r.register(e.id))),()=>{let{name:l="Description",slot:a=g({}),props:o={}}=r,{id:i,...s}=e,u={...Object.entries(o).reduce((d,[f,y])=>Object.assign(d,{[f]:it(y)}),{}),id:i};return L({ourProps:u,theirProps:s,slot:a.value,attrs:t,slots:n,name:l})}}});function Mt(e){let t=ut(e.getSnapshot());return R(e.subscribe(()=>{t.value=e.getSnapshot()})),t}function ce(){let e=[],t={addEventListener(n,r,l,a){return n.addEventListener(r,l,a),t.add(()=>n.removeEventListener(r,l,a))},requestAnimationFrame(...n){let r=requestAnimationFrame(...n);t.add(()=>cancelAnimationFrame(r))},nextFrame(...n){t.requestAnimationFrame(()=>{t.requestAnimationFrame(...n)})},setTimeout(...n){let r=setTimeout(...n);t.add(()=>clearTimeout(r))},style(n,r,l){let a=n.style.getPropertyValue(r);return Object.assign(n.style,{[r]:l}),this.add(()=>{Object.assign(n.style,{[r]:a})})},group(n){let r=ce();return n(r),this.add(()=>r.dispose())},add(n){return e.push(n),()=>{let r=e.indexOf(n);if(r>=0)for(let l of e.splice(r,1))l()}},dispose(){for(let n of e.splice(0))n()}};return t}function Ht(e,t){let n=e(),r=new Set;return{getSnapshot(){return n},subscribe(l){return r.add(l),()=>r.delete(l)},dispatch(l,...a){let o=t[l].call(n,...a);o&&(n=o,r.forEach(i=>i()))}}}function Bt(){let e;return{before({doc:t}){var n;let r=t.documentElement;e=((n=t.defaultView)!=null?n:window).innerWidth-r.clientWidth},after({doc:t,d:n}){let r=t.documentElement,l=r.clientWidth-r.offsetWidth,a=e-l;n.style(r,"paddingRight",`${a}px`)}}}function It(){if(!Ot())return{};let e;return{before(){e=window.pageYOffset},after({doc:t,d:n,meta:r}){function l(o){return r.containers.flatMap(i=>i()).some(i=>i.contains(o))}n.style(t.body,"marginTop",`-${e}px`),window.scrollTo(0,0);let a=null;n.addEventListener(t,"click",o=>{if(o.target instanceof HTMLElement)try{let i=o.target.closest("a");if(!i)return;let{hash:s}=new URL(i.href),u=t.querySelector(s);u&&!l(u)&&(a=u)}catch{}},!0),n.addEventListener(t,"touchmove",o=>{o.target instanceof HTMLElement&&!l(o.target)&&o.preventDefault()},{passive:!1}),n.add(()=>{window.scrollTo(0,window.pageYOffset+e),a&&a.isConnected&&(a.scrollIntoView({block:"nearest"}),a=null)})}}}function Ut(){return{before({doc:e,d:t}){t.style(e.documentElement,"overflow","hidden")}}}function Wt(e){let t={};for(let n of e)Object.assign(t,n(t));return t}let V=Ht(()=>new Map,{PUSH(e,t){var n;let r=(n=this.get(e))!=null?n:{doc:e,count:0,d:ce(),meta:new Set};return r.count++,r.meta.add(t),this.set(e,r),this},POP(e,t){let n=this.get(e);return n&&(n.count--,n.meta.delete(t)),this},SCROLL_PREVENT({doc:e,d:t,meta:n}){let r={doc:e,d:t,meta:Wt(n)},l=[It(),Bt(),Ut()];l.forEach(({before:a})=>a==null?void 0:a(r)),l.forEach(({after:a})=>a==null?void 0:a(r))},SCROLL_ALLOW({d:e}){e.dispose()},TEARDOWN({doc:e}){this.delete(e)}});V.subscribe(()=>{let e=V.getSnapshot(),t=new Map;for(let[n]of e)t.set(n,n.documentElement.style.overflow);for(let n of e.values()){let r=t.get(n.doc)==="hidden",l=n.count!==0;(l&&!r||!l&&r)&&V.dispatch(n.count>0?"SCROLL_PREVENT":"SCROLL_ALLOW",n),n.count===0&&V.dispatch("TEARDOWN",n)}});function qt(e,t,n){let r=Mt(V),l=h(()=>{let a=e.value?r.value.get(e.value):void 0;return a?a.count>0:!1});return ee([e,t],([a,o],[i],s)=>{if(!a||!o)return;V.dispatch("PUSH",a,n);let u=!1;s(()=>{u||(V.dispatch("POP",i??a,n),u=!0)})},{immediate:!0}),l}var _t=(e=>(e[e.Open=0]="Open",e[e.Closed=1]="Closed",e))(_t||{});let Te=Symbol("DialogContext");function ne(e){let t=j(Te,null);if(t===null){let n=new Error(`<${e} /> is missing a parent <Dialog /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(n,ne),n}return t}let ie="DC8F892D-2EBD-447C-A4C8-A03058436FF4",an=F({name:"Dialog",inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},open:{type:[Boolean,String],default:ie},initialFocus:{type:Object,default:null},id:{type:String,default:()=>`headlessui-dialog-${G()}`}},emits:{close:e=>!0},setup(e,{emit:t,attrs:n,slots:r,expose:l}){var a;let o=g(!1);T(()=>{o.value=!0});let i=g(0),s=Fe(),u=h(()=>e.open===ie&&s!==null?(s.value&$.Open)===$.Open:e.open),d=g(null),f=g(null),y=h(()=>J(d));if(l({el:d,$el:d}),!(e.open!==ie||s!==null))throw new Error("You forgot to provide an `open` prop to the `Dialog`.");if(typeof u.value!="boolean")throw new Error(`You provided an \`open\` prop to the \`Dialog\`, but the value is not a boolean. Received: ${u.value===ie?void 0:e.open}`);let c=h(()=>o.value&&u.value?0:1),p=h(()=>c.value===0),v=h(()=>i.value>1),P=j(Te,null)!==null,I=h(()=>v.value?"parent":"leaf"),A=h(()=>s!==null?(s.value&$.Closing)===$.Closing:!1),Y=h(()=>P||A.value?!1:p.value),re=h(()=>{var m,b,w;return(w=Array.from((b=(m=y.value)==null?void 0:m.querySelectorAll("body > *"))!=null?b:[]).find(S=>S.id==="headlessui-portal-root"?!1:S.contains(E(f))&&S instanceof HTMLElement))!=null?w:null});xe(re,Y);let le=h(()=>v.value?!0:p.value),ae=h(()=>{var m,b,w;return(w=Array.from((b=(m=y.value)==null?void 0:m.querySelectorAll("[data-headlessui-portal]"))!=null?b:[]).find(S=>S.contains(E(f))&&S instanceof HTMLElement))!=null?w:null});xe(ae,le),Rt({type:"Dialog",enabled:h(()=>c.value===0),element:d,onUpdate:(m,b)=>{if(b==="Dialog")return C(m,{[Oe.Add]:()=>i.value+=1,[Oe.Remove]:()=>i.value-=1})}});let pe=Nt({name:"DialogDescription",slot:h(()=>({open:u.value}))}),U=g(null),k={titleId:U,panelRef:g(null),dialogState:c,setTitleId(m){U.value!==m&&(U.value=m)},close(){t("close",!1)}};N(Te,k);function K(){var m,b,w;return[...Array.from((b=(m=y.value)==null?void 0:m.querySelectorAll("html > *, body > *, [data-headlessui-portal]"))!=null?b:[]).filter(S=>!(S===document.body||S===document.head||!(S instanceof HTMLElement)||S.contains(E(f))||k.panelRef.value&&S.contains(k.panelRef.value))),(w=k.panelRef.value)!=null?w:d.value]}let ve=h(()=>!(!p.value||v.value));St(()=>K(),(m,b)=>{k.close(),Re(()=>b==null?void 0:b.focus())},ve);let me=h(()=>!(v.value||c.value!==0));_e((a=y.value)==null?void 0:a.defaultView,"keydown",m=>{me.value&&(m.defaultPrevented||m.key===He.Escape&&(m.preventDefault(),m.stopPropagation(),k.close()))});let x=h(()=>!(A.value||c.value!==0||P));return qt(y,x,m=>{var b;return{containers:[...(b=m.containers)!=null?b:[],K]}}),D(m=>{if(c.value!==0)return;let b=E(d);if(!b)return;let w=new ResizeObserver(S=>{for(let oe of S){let W=oe.target.getBoundingClientRect();W.x===0&&W.y===0&&W.width===0&&W.height===0&&k.close()}});w.observe(b),m(()=>w.disconnect())}),()=>{let{id:m,open:b,initialFocus:w,...S}=e,oe={...n,ref:d,id:m,role:"dialog","aria-modal":c.value===0?!0:void 0,"aria-labelledby":U.value,"aria-describedby":pe.value},W={open:c.value===0};return O(Se,{force:!0},()=>[O(Qe,()=>O(Ct,{target:d.value},()=>O(Se,{force:!1},()=>O(Q,{initialFocus:w,containers:K,features:p.value?C(I.value,{parent:Q.features.RestoreFocus,leaf:Q.features.All&~Q.features.FocusLock}):Q.features.None},()=>L({ourProps:oe,theirProps:S,slot:W,attrs:n,slots:r,visible:c.value===0,features:se.RenderStrategy|se.Static,name:"Dialog"}))))),O(Ee,{features:de.Hidden,ref:f})])}}}),on=F({name:"DialogOverlay",props:{as:{type:[Object,String],default:"div"},id:{type:String,default:()=>`headlessui-dialog-overlay-${G()}`}},setup(e,{attrs:t,slots:n}){let r=ne("DialogOverlay");function l(a){a.target===a.currentTarget&&(a.preventDefault(),a.stopPropagation(),r.close())}return()=>{let{id:a,...o}=e;return L({ourProps:{id:a,"aria-hidden":!0,onClick:l},theirProps:o,slot:{open:r.dialogState.value===0},attrs:t,slots:n,name:"DialogOverlay"})}}});F({name:"DialogBackdrop",props:{as:{type:[Object,String],default:"div"},id:{type:String,default:()=>`headlessui-dialog-backdrop-${G()}`}},inheritAttrs:!1,setup(e,{attrs:t,slots:n,expose:r}){let l=ne("DialogBackdrop"),a=g(null);return r({el:a,$el:a}),T(()=>{if(l.panelRef.value===null)throw new Error("A <DialogBackdrop /> component is being used, but a <DialogPanel /> component is missing.")}),()=>{let{id:o,...i}=e,s={id:o,ref:a,"aria-hidden":!0};return O(Se,{force:!0},()=>O(Qe,()=>L({ourProps:s,theirProps:{...t,...i},slot:{open:l.dialogState.value===0},attrs:t,slots:n,name:"DialogBackdrop"})))}}});F({name:"DialogPanel",props:{as:{type:[Object,String],default:"div"},id:{type:String,default:()=>`headlessui-dialog-panel-${G()}`}},setup(e,{attrs:t,slots:n,expose:r}){let l=ne("DialogPanel");r({el:l.panelRef,$el:l.panelRef});function a(o){o.stopPropagation()}return()=>{let{id:o,...i}=e,s={id:o,ref:l.panelRef,onClick:a};return L({ourProps:s,theirProps:i,slot:{open:l.dialogState.value===0},attrs:t,slots:n,name:"DialogPanel"})}}});let un=F({name:"DialogTitle",props:{as:{type:[Object,String],default:"h2"},id:{type:String,default:()=>`headlessui-dialog-title-${G()}`}},setup(e,{attrs:t,slots:n}){let r=ne("DialogTitle");return T(()=>{r.setTitleId(e.id),R(()=>r.setTitleId(null))}),()=>{let{id:l,...a}=e;return L({ourProps:{id:l},theirProps:a,slot:{open:r.dialogState.value===0},attrs:t,slots:n,name:"DialogTitle"})}}});function Vt(e){let t={called:!1};return(...n)=>{if(!t.called)return t.called=!0,e(...n)}}function ye(e,...t){e&&t.length>0&&e.classList.add(...t)}function ue(e,...t){e&&t.length>0&&e.classList.remove(...t)}var $e=(e=>(e.Finished="finished",e.Cancelled="cancelled",e))($e||{});function Gt(e,t){let n=ce();if(!e)return n.dispose;let{transitionDuration:r,transitionDelay:l}=getComputedStyle(e),[a,o]=[r,l].map(i=>{let[s=0]=i.split(",").filter(Boolean).map(u=>u.includes("ms")?parseFloat(u):parseFloat(u)*1e3).sort((u,d)=>d-u);return s});return a!==0?n.setTimeout(()=>t("finished"),a+o):t("finished"),n.add(()=>t("cancelled")),n.dispose}function Ce(e,t,n,r,l,a){let o=ce(),i=a!==void 0?Vt(a):()=>{};return ue(e,...l),ye(e,...t,...n),o.nextFrame(()=>{ue(e,...n),ye(e,...r),o.add(Gt(e,s=>(ue(e,...r,...t),ye(e,...l),i(s))))}),o.add(()=>ue(e,...t,...n,...r,...l)),o.add(()=>i("cancelled")),o.dispose}function q(e=""){return e.split(" ").filter(t=>t.trim().length>1)}let Le=Symbol("TransitionContext");var Yt=(e=>(e.Visible="visible",e.Hidden="hidden",e))(Yt||{});function Jt(){return j(Le,null)!==null}function Kt(){let e=j(Le,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}function Qt(){let e=j(Pe,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}let Pe=Symbol("NestingContext");function fe(e){return"children"in e?fe(e.children):e.value.filter(({state:t})=>t==="visible").length>0}function et(e){let t=g([]),n=g(!1);T(()=>n.value=!0),R(()=>n.value=!1);function r(a,o=H.Hidden){let i=t.value.findIndex(({id:s})=>s===a);i!==-1&&(C(o,{[H.Unmount](){t.value.splice(i,1)},[H.Hidden](){t.value[i].state="hidden"}}),!fe(t)&&n.value&&(e==null||e()))}function l(a){let o=t.value.find(({id:i})=>i===a);return o?o.state!=="visible"&&(o.state="visible"):t.value.push({id:a,state:"visible"}),()=>r(a,H.Unmount)}return{children:t,register:l,unregister:r}}let tt=se.RenderStrategy,Xt=F({props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:n,slots:r,expose:l}){let a=g(0);function o(){a.value|=$.Opening,t("beforeEnter")}function i(){a.value&=~$.Opening,t("afterEnter")}function s(){a.value|=$.Closing,t("beforeLeave")}function u(){a.value&=~$.Closing,t("afterLeave")}if(!Jt()&&pt())return()=>O(Zt,{...e,onBeforeEnter:o,onAfterEnter:i,onBeforeLeave:s,onAfterLeave:u},r);let d=g(null),f=g("visible"),y=h(()=>e.unmount?H.Unmount:H.Hidden);l({el:d,$el:d});let{show:c,appear:p}=Kt(),{register:v,unregister:P}=Qt(),I={value:!0},A=G(),Y={value:!1},re=et(()=>{!Y.value&&f.value!=="hidden"&&(f.value="hidden",P(A),u())});T(()=>{let x=v(A);R(x)}),D(()=>{if(y.value===H.Hidden&&A){if(c&&f.value!=="visible"){f.value="visible";return}C(f.value,{hidden:()=>P(A),visible:()=>v(A)})}});let le=q(e.enter),ae=q(e.enterFrom),pe=q(e.enterTo),U=q(e.entered),k=q(e.leave),K=q(e.leaveFrom),ve=q(e.leaveTo);T(()=>{D(()=>{if(f.value==="visible"){let x=E(d);if(x instanceof Comment&&x.data==="")throw new Error("Did you forget to passthrough the `ref` to the actual DOM node?")}})});function me(x){let m=I.value&&!p.value,b=E(d);!b||!(b instanceof HTMLElement)||m||(Y.value=!0,c.value&&o(),c.value||s(),x(c.value?Ce(b,le,ae,pe,U,w=>{Y.value=!1,w===$e.Finished&&i()}):Ce(b,k,K,ve,U,w=>{Y.value=!1,w===$e.Finished&&(fe(re)||(f.value="hidden",P(A),u()))})))}return T(()=>{ee([c],(x,m,b)=>{me(b),I.value=!1},{immediate:!0})}),N(Pe,re),vt(h(()=>C(f.value,{visible:$.Open,hidden:$.Closed})|a.value)),()=>{let{appear:x,show:m,enter:b,enterFrom:w,enterTo:S,entered:oe,leave:W,leaveFrom:en,leaveTo:tn,...Ae}=e,nt={ref:d},rt={...Ae,...p&&c&&te.isServer?{class:st([n.class,Ae.class,...le,...ae])}:{}};return L({theirProps:rt,ourProps:nt,slot:{},slots:r,attrs:n,features:tt,visible:f.value==="visible",name:"TransitionChild"})}}}),zt=Xt,Zt=F({inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:n,slots:r}){let l=Fe(),a=h(()=>e.show===null&&l!==null?(l.value&$.Open)===$.Open:e.show);D(()=>{if(![!0,!1].includes(a.value))throw new Error('A <Transition /> is used but it is missing a `:show="true | false"` prop.')});let o=g(a.value?"visible":"hidden"),i=et(()=>{o.value="hidden"}),s=g(!0),u={show:a,appear:h(()=>e.appear||!s.value)};return T(()=>{D(()=>{s.value=!1,a.value?o.value="visible":fe(i)||(o.value="hidden")})}),N(Pe,i),N(Le,u),()=>{let d=Me(e,["show","appear","unmount","onBeforeEnter","onBeforeLeave","onAfterEnter","onAfterLeave"]),f={unmount:e.unmount};return L({ourProps:{...f,as:"template"},theirProps:{},slot:{},slots:{...r,default:()=>[O(zt,{onBeforeEnter:()=>t("beforeEnter"),onAfterEnter:()=>t("afterEnter"),onBeforeLeave:()=>t("beforeLeave"),onAfterLeave:()=>t("afterLeave"),...n,...f,...d},r.default)]},attrs:{},features:tt,visible:o.value==="visible",name:"Transition"})}}});export{ln as D,We as F,L as H,Et as I,on as K,se as N,Z as O,Zt as S,Me as T,un as Y,de as a,He as b,Ie as c,Ve as d,M as e,Ee as f,qe as g,Xt as h,vt as i,$ as l,J as m,E as o,Fe as p,an as q,G as t,C as u,rn as v,St as y};