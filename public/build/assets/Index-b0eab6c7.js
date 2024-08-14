import{B as d}from"./Authenticated-6651b23d.js";import{B as c}from"./Button-df73f7a0.js";import{H as l,L as u}from"./@inertiajs-41d03628.js";import{x as e,v as s,u as _,P as a,F as p,q as i,y as t,V as h,z as g,C as x,G as v}from"./@vue-64c42e7d.js";import"./ApplicationLogo-64527dd0.js";import"./radix-vue-2488f6ae.js";import"./@floating-ui-7a9770d8.js";import"./@internationalized-2f03b566.js";import"./class-variance-authority-f96983da.js";import"./app-98c3eb01.js";import"./axios-9cbf0d09.js";import"./pusher-js-2bcba7e2.js";import"./@vueform-ba82ac10.js";import"./@vuepic-339c593a.js";import"./date-fns-60a02367.js";import"./@babel-1b80a44a.js";import"./cropperjs-2c7c67ce.js";import"./laravel-vite-plugin-d10ca5e8.js";import"./vue-debounce-ed417ae1.js";import"./v-calendar-1cb1b359.js";import"./@popperjs-f3391c26.js";import"./clsx-0839fdbe.js";import"./tailwind-merge-642c57ff.js";import"./@vueuse-deae3e94.js";import"./@radix-icons-03b844c4.js";import"./moment-timezone-65f24d9a.js";import"./moment-3968d9f3.js";import"./lodash.isequal-60a7aae7.js";import"./vue-68dd36d7.js";import"./lodash.clonedeep-8b83a099.js";import"./qs-589f641c.js";import"./side-channel-1ba8a7fc.js";import"./get-intrinsic-88feedc6.js";import"./es-errors-82fd953f.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-1353c55e.js";import"./function-bind-61637ca6.js";import"./hasown-bc561cf0.js";import"./call-bind-9ec8ebd8.js";import"./set-function-length-ecd19468.js";import"./define-data-property-d38573ea.js";import"./es-define-property-cfa03815.js";import"./gopd-4c4454f6.js";import"./has-property-descriptors-68e2873e.js";import"./object-inspect-a3a9a537.js";import"./deepmerge-89e33937.js";import"./nprogress-34a09d83.js";import"./lucide-vue-next-48142e2c.js";const f={class:"py-4 px-4"},b={class:"overflow-x-auto"},y={class:"mx-auto"},k={class:"align-middle inline-block min-w-full p-2 space-y-6"},w={key:0,class:"flex lg:grow sm:justify-end"},B={key:1,class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-5 gap-10"},C=["onClick"],N=t("span",{class:"absolute inset-0 border-2 border-dashed border-black rounded"},null,-1),$={class:"rounded px-6 py-4 flex flex-col justify-between h-full transform items-center border-2 border-black bg-white transition-transform group-hover:-translate-x-2 group-hover:-translate-y-2"},V=["src"],L={class:"mt-2 text-xl font-medium sm:text-xl"},T={key:2,class:"bg-white shadow-md rounded border"},j=t("div",{class:"max-w-6xl mx-auto px-4 sm:px-6 py-12 lg:py-24"},[t("div",{class:"max-w-3xl mx-auto text-center"},[t("h2",{class:"text-3xl font-extrabold text-gray-900 sm:text-3xl"},"No math manipulatives have been added.")])],-1),z=[j],F={components:{Head:l,Link:u},methods:{openNewTab(m){window.open(route("math_manipulatives.play",{name:m}),"_blank")}}},Lt=Object.assign(F,{__name:"Index",setup(m){return(o,n)=>(i(),e(p,null,[s(_(l),{title:"Math Manipulatives"}),s(d,null,{header:a(()=>[]),default:a(()=>[t("div",f,[t("div",b,[t("div",y,[t("div",k,[o.$page.props.can.create_math_manipulatives?(i(),e("div",w,[s(c,{buttonType:"info",onClick:n[0]||(n[0]=r=>o.$inertia.get(o.route("math_manipulatives.configuration")))},{default:a(()=>[h("Configuration")]),_:1})])):g("",!0),o.$page.props.math_manipulatives.length?(i(),e("div",B,[(i(!0),e(p,null,x(o.$page.props.math_manipulatives,r=>(i(),e("div",{class:"group relative block cursor-pointer",onClick:H=>o.openNewTab(r.folder_name)},[N,t("div",$,[t("img",{src:"/math_manipulatives/thumbnails/"+r.thumbnail},null,8,V),t("h3",L,v(r.name),1)])],8,C))),256))])):(i(),e("div",T,z))])])])])]),_:1})],64))}});export{Lt as default};