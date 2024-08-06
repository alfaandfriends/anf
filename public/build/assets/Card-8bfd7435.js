import{c}from"./app-dce748c9.js";import{q as r,x as u,D as l,m as p,u as e,t as o,P as n,v as _,y as m,z as i}from"./@vue-7927adca.js";const $={__name:"Card",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("div",{class:p(e(c)("rounded-xl border bg-card text-card-foreground shadow",s.class))},[l(a.$slots,"default")],2))}},f={__name:"CardHeader",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("div",{class:p(e(c)("flex flex-col gap-y-1.5 p-6",s.class))},[l(a.$slots,"default")],2))}},y={__name:"CardTitle",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("h3",{class:p(e(c)("font-semibold leading-none tracking-tight",s.class))},[l(a.$slots,"default")],2))}},h={__name:"CardDescription",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("p",{class:p(e(c)("text-sm text-muted-foreground",s.class))},[l(a.$slots,"default")],2))}},g={__name:"CardContent",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("div",{class:p(e(c)("p-6 pt-0",s.class))},[l(a.$slots,"default")],2))}},C={__name:"CardFooter",props:{class:{type:null,required:!1}},setup(t){const s=t;return(a,d)=>(r(),u("div",{class:p(e(c)("flex items-center p-6 pt-0",s.class))},[l(a.$slots,"default")],2))}},k={class:"font-semibold leading-none tracking-tight"},x={__name:"Card",setup(t){return(s,a)=>(r(),o(e($),{class:"w-full"},{default:n(()=>[s.$slots.title?(r(),o(e(f),{key:0},{default:n(()=>[_(e(y),null,{default:n(()=>[m("h3",k,[l(s.$slots,"title")])]),_:3}),s.$slots.description?(r(),o(e(h),{key:0},{default:n(()=>[l(s.$slots,"description")]),_:3})):i("",!0)]),_:3})):(r(),o(e(f),{key:1,class:"py-3"})),s.$slots.content?(r(),o(e(g),{key:2,class:"grid gap-2"},{default:n(()=>[l(s.$slots,"content")]),_:3})):i("",!0),s.$slots.footer?(r(),o(e(C),{key:3,class:"flex justify-end space-x-2"},{default:n(()=>[l(s.$slots,"footer")]),_:3})):i("",!0)]),_:3}))}};export{x as _};