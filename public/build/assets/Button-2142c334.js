import{W as l,o,c as i,n as a,A as u,h as d,F as c}from"./app-5e7199e3.js";import{_ as b}from"./_plugin-vue_export-helper-c27b6911.js";const y={props:{type:{type:String,default:"button"},buttonType:{type:String,default:"info"},route:{type:String,default:""},class:{type:String,default:""}},methods:{setAction(){this.route?l.Inertia.visit(this.route):this.$emit("click")}}},p=["type"],f=["type"],g=["type"],h=["type"],m=["type"],x=["type"];function k(r,t,e,w,A,s){return o(),i(c,null,[e.buttonType=="success"?(o(),i("button",{key:0,type:e.type,class:a(["shadow-md inline-flex items-center bg-green-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:"px-4 py-2"]),onClick:t[0]||(t[0]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,p)):d("",!0),e.buttonType=="info"?(o(),i("button",{key:1,type:e.type,class:a(["shadow-md inline-flex items-center bg-indigo-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:"px-4 py-2"]),onClick:t[1]||(t[1]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,f)):d("",!0),e.buttonType=="warning"?(o(),i("button",{key:2,type:e.type,class:a(["shadow-md inline-flex items-center bg-yellow-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:" px-2 py-1"]),onClick:t[2]||(t[2]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,g)):d("",!0),e.buttonType=="danger"?(o(),i("button",{key:3,type:e.type,class:a(["shadow-md inline-flex items-center bg-red-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:" px-2 py-1"]),onClick:t[3]||(t[3]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,h)):d("",!0),e.buttonType=="blue"?(o(),i("button",{key:4,type:e.type,class:a(["shadow-md inline-flex items-center bg-blue-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:" px-2 py-1"]),onClick:t[4]||(t[4]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,m)):d("",!0),e.buttonType=="gray"?(o(),i("button",{key:5,type:e.type,class:a(["shadow-md inline-flex items-center bg-gray-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150 cursor-pointer",this.class?this.class:"px-4 py-2"]),onClick:t[5]||(t[5]=(...n)=>s.setAction&&s.setAction(...n))},[u(r.$slots,"default")],10,x)):d("",!0)],64)}const T=b(y,[["render",k]]);export{T as B};