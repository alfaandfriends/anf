import{m as u,x as f,p,w as s,o as a,a as i,u as e,H as _,c as h,h as g,b as o,i as n,n as y,L as b,d as v}from"./app-e501deca.js";import{B as x}from"./Button-c51487b6.js";import{_ as k}from"./Guest-035b6f3e.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ApplicationLogo-c140f20f.js";const w=o("div",{class:"mb-4 text-sm text-gray-600"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1),B={key:0,class:"mb-4 font-medium text-sm text-green-600"},V=["onSubmit"],E={class:"mt-4 flex items-center justify-between"},H={__name:"VerifyEmail",props:{status:String},setup(r){const c=r,t=u(),d=()=>{t.post(route("verification.send"))},l=f(()=>c.status==="verification-link-sent");return(m,L)=>(a(),p(k,null,{default:s(()=>[i(e(_),{title:"Email Verification"}),w,e(l)?(a(),h("div",B," A new verification link has been sent to the email address you provided during registration. ")):g("",!0),o("form",{onSubmit:v(d,["prevent"])},[o("div",E,[i(x,{class:y({"opacity-25":e(t).processing}),disabled:e(t).processing},{default:s(()=>[n(" Resend Verification Email ")]),_:1},8,["class","disabled"]),i(e(b),{href:m.route("logout"),method:"post",as:"button",class:"underline text-sm text-gray-600 hover:text-gray-900"},{default:s(()=>[n("Log Out")]),_:1},8,["href"])])],40,V)]),_:1}))}};export{H as default};