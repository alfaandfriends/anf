import{o as u}from"./transition-b5f370f4.js";import{y as r,z as l,a0 as f}from"./app-903e43fa.js";function a(t,n){if(t)return t;let e=n??"button";if(typeof e=="string"&&e.toLowerCase()==="button")return"button"}function v(t,n){let e=r(a(t.value.type,t.value.as));return l(()=>{e.value=a(t.value.type,t.value.as)}),f(()=>{var o;e.value||u(n)&&u(n)instanceof HTMLButtonElement&&!((o=u(n))!=null&&o.hasAttribute("type"))&&(e.value="button")}),e}export{v as b};