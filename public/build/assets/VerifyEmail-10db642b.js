import{s as u,A as f,o as a,q as p,w as s,a as o,u as e,H as _,c as g,p as h,d as i,g as n,n as y,L as v,k}from"./app-3e76377a.js";import{B as b}from"./Button-f0eed526.js";import{_ as x}from"./Guest-662b33f8.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ApplicationLogo-e040e52e.js";const w=i("div",{class:"mb-4 text-sm text-gray-600"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1),B={key:0,class:"mb-4 font-medium text-sm text-green-600"},V=["onSubmit"],E={class:"mt-4 flex items-center justify-between"},A={__name:"VerifyEmail",props:{status:String},setup(r){const c=r,t=u(),d=()=>{t.post(route("verification.send"))},l=f(()=>c.status==="verification-link-sent");return(m,L)=>(a(),p(x,null,{default:s(()=>[o(e(_),{title:"Email Verification"}),w,l.value?(a(),g("div",B," A new verification link has been sent to the email address you provided during registration. ")):h("",!0),i("form",{onSubmit:k(d,["prevent"])},[i("div",E,[o(b,{class:y({"opacity-25":e(t).processing}),disabled:e(t).processing},{default:s(()=>[n(" Resend Verification Email ")]),_:1},8,["class","disabled"]),o(e(v),{href:m.route("logout"),method:"post",as:"button",class:"underline text-sm text-gray-600 hover:text-gray-900"},{default:s(()=>[n("Log Out")]),_:1},8,["href"])])],40,V)]),_:1}))}};export{A as default};