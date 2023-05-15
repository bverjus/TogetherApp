import{v as d,e as r,b as e,u as t,w as o,F as c,o as m,X as f,t as _,f as p,a,n as w,g,l as b}from"./app-a44d02fd.js";import{A as y}from"./AuthenticationCard-e1fb530e.js";import{_ as x}from"./AuthenticationCardLogo-3d903e75.js";import{_ as h,a as k}from"./TextInput-e9543068.js";import{_ as v}from"./InputLabel-8d9cf262.js";import{_ as V}from"./PrimaryButton-8f28b58f.js";import"./_plugin-vue_export-helper-c27b6911.js";const F=a("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$=["onSubmit"],C={class:"flex items-center justify-end mt-4"},D={__name:"ForgotPassword",props:{status:String},setup(l){const s=d({email:""}),n=()=>{s.post(route("password.email"))};return(S,i)=>(m(),r(c,null,[e(t(f),{title:"Forgot Password"}),e(y,null,{logo:o(()=>[e(x)]),default:o(()=>[F,l.status?(m(),r("div",N,_(l.status),1)):p("",!0),a("form",{onSubmit:b(n,["prevent"])},[a("div",null,[e(v,{for:"email",value:"Email"}),e(h,{id:"email",modelValue:t(s).email,"onUpdate:modelValue":i[0]||(i[0]=u=>t(s).email=u),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),e(k,{class:"mt-2",message:t(s).errors.email},null,8,["message"])]),a("div",C,[e(V,{class:w({"opacity-25":t(s).processing}),disabled:t(s).processing},{default:o(()=>[g(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],40,$)]),_:1})],64))}};export{D as default};