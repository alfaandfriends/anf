import{A as u,h as d,B as l,o as i,c as p}from"./app-d624affc.js";const h=["value"],k={__name:"Checkbox",props:{checked:{type:[Array,Boolean],default:!1},value:{default:null}},emits:["update:checked"],setup(e,{emit:a}){const s=a,n=e,o=u({get(){return n.checked},set(t){s("update:checked",t)}});return(t,c)=>d((i(),p("input",{type:"checkbox",value:e.value,"onUpdate:modelValue":c[0]||(c[0]=r=>o.value=r),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,8,h)),[[l,o.value]])}};export{k as _};