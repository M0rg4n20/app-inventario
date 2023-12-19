import{k as n,T as E,o as O,K as m,m as x,n as b,s as e,v as f,p as s,w as v,z as B,u as o,A as y,B as I,C as N,t as P,O as U}from"./vendor9df2f612.js";import{_ as i}from"./InputError36fdb8dd.js";import{_ as d}from"./InputLabel7da40d8f.js";import{_ as $}from"./Modale28fe8ea.js";import{_ as u}from"./TextInputaca9d9c1.js";import{_ as F}from"./PrimaryButton0ecc7f29.js";import{s as h}from"./multiselectf73eb494.js";import{S as w}from"./sweetalert2.all2e5f4a54.js";const D={class:"space-y-4"},Z={class:"p-2"},z=["onSubmit"],H={class:"px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2"},q={class:"grid grid-cols-12 gap-2 mt-0 col-span-12 xl:col-span-6"},G={class:"col-span-12 xl:col-span-12"},K={class:"grid grid-cols-12 mt-0 col-span-12 xl:col-span-6 text-start"},W={class:"col-span-6 xl:col-span-12"},J={class:"grid grid-cols-12 gap-2 col-span-12 xl:col-span-12 text-center"},L={class:"col-span-6 xl:col-span-4 flex pt-3 mt-4 justify-end"},Q={class:"col-span-12 xl:col-span-4"},R={class:"flex"},X=e("span",{class:"inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"},[e("i",{class:"fas fa-dollar-sign"})],-1),Y={key:0,class:"grid mt-3 grid-cols-12 gap-2 col-span-12 xl:col-span-12"},ee={class:"col-span-6 xl:col-span-4 flex pt-3 mt-4 justify-start"},te={class:"col-span-12 xl:col-span-4"},oe={class:"flex"},se=e("span",{class:"inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"},[e("i",{class:"fas fa-dollar-sign"})],-1),ae={class:"col-span-12 xl:col-span-4"},re={class:"flex"},le=e("span",{class:"inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"},[e("i",{class:"fas fa-credit-card"})],-1),de=e("div",{class:"flex justify-center mt-5 w-full"},[e("div",{id:"alert-border-4",class:"flex w-full items-center p-2 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800",role:"alert"},[e("svg",{class:"flex-shrink-0 w-4 h-4","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 20 20"},[e("path",{d:"M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"})]),e("div",{class:"ml-3 text-xs text-center font-medium"}," Antes de guardar verifique el ticket. ")])],-1),ne={class:"flex justify-end pt-0"},k="Abono",V="abonos",fe={__name:"CrearModal",setup(ie){const c=n(!1),j=n([]),C=n([]),S=()=>{c.value=!0},p=()=>{c.value=!1,t.reset()},t=E({monto_efectivo:"",metodo_pago_id:1,metodo_pago:"EFECTIVO",user_id:"",venta_id:"",num_tarjeta:"",monto_tarjeta:"",tipo_pago:"ABONO"}),_=n({value:"",closeOnSelect:!0,placeholder:"Seleccione",searchable:!0,options:[]}),g=n({value:"",closeOnSelect:!0,placeholder:"Seleccione",searchable:!1,options:[]}),M=()=>{g.value="",t.metodo_pago="",t.metodo_pago_id=""};O(()=>{_.value.options=m().props.ventas,j.value=m().props.ventas,g.value.options=m().props.metodos_pago,C.value=m().props.metodos_pago});const T=()=>{t.clearErrors(),t.post(route(V+".store"),{preserveScroll:!0,forceFormData:!0,onSuccess:a=>{c.value=!1,a.props.success?a.props.success&&a.props.message!=""&&w.fire({width:350,title:a.props.message,icon:"success"}):w.fire({width:350,title:a.props.message,icon:"error"}),U.get(route(V+".index"))},onFinish:()=>{},onError:()=>{}})},A=a=>{t.clearErrors()};return(a,r)=>(x(),b("section",D,[e("button",{type:"button",onClick:S,class:"m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700"}," Agregar "+f(k)),s($,{show:c.value,onClose:p,maxWidth:"md"},{default:v(()=>[e("div",Z,[e("div",{class:"p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600"},[e("h2",{class:"text-lg font-medium text-gray-900"}," Agregar "+f(k))]),e("form",{onSubmit:B(T,["prevent"])},[e("div",H,[e("div",q,[e("div",G,[s(d,{for:"venta_id",value:"Ticket - Cliente",class:"block text-base font-medium leading-6 text-gray-900"}),s(o(h),y({id:"venta_id",modelValue:o(t).venta_id,"onUpdate:modelValue":r[0]||(r[0]=l=>o(t).venta_id=l)},_.value,{onClear:M,onSelect:A}),null,16,["modelValue"]),s(i,{class:"mt-1 text-xs",message:o(t).errors.venta_id},null,8,["message"])])]),e("div",K,[e("div",W,[s(d,{for:"metodos",value:"Métodos de Pago",class:"block text-md font-medium leading-6 text-gray-900"}),s(o(h),y({modelValue:o(t).metodo_pago_id,"onUpdate:modelValue":r[1]||(r[1]=l=>o(t).metodo_pago_id=l)},g.value,{onSelect:a.setMetodoPago}),null,16,["modelValue","onSelect"]),s(i,{class:"mt-1 text-xs",message:o(t).errors.metodo_pago_id},null,8,["message"])]),e("div",J,[e("div",L,[s(d,{value:"Efectivo:",class:"m-1 pb-0 text-xs font-medium leading-6 text-gray-900"})]),e("div",Q,[s(d,{for:"monto",value:"Monto",class:"block mb-0 text-xs font-normal leading-6 text-gray-900"}),e("div",R,[X,s(u,{disabled:o(t).metodo_pago_id==2,class:"rounded bg-gray-50 border border-gray-300 text-gray-900 min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white",type:"number",step:"0.1",modelValue:o(t).monto_efectivo,"onUpdate:modelValue":r[2]||(r[2]=l=>o(t).monto_efectivo=l),onInput:a.sumaTotalPago},null,8,["disabled","modelValue","onInput"])]),s(i,{class:"mt-1 text-start w-full",message:o(t).errors.monto_efectivo},null,8,["message"])])]),o(t).metodo_pago_id==2||o(t).metodo_pago_id==3?(x(),b("div",Y,[e("div",ee,[s(d,{value:"Tarjeta Debito/Credito:",class:"m-0 pb-0 text-xs font-medium leading-6 text-gray-900"})]),e("div",te,[s(d,{for:"monto",value:"Monto",class:"block text-xs font-normal leading-6 text-gray-900"}),e("div",oe,[se,s(u,{class:"rounded bg-gray-50 border border-gray-300 text-gray-900 min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white",type:"number",step:"0.1",modelValue:o(t).monto_tarjeta,"onUpdate:modelValue":r[3]||(r[3]=l=>o(t).monto_tarjeta=l),onInput:a.sumaTotalPago},null,8,["modelValue","onInput"])]),s(i,{class:"mt-1 text-start w-full",message:o(t).errors.monto_tarjeta},null,8,["message"])]),e("div",ae,[s(d,{for:"tarjeta",value:"Tres últimos digitos",class:"block text-xs font-normal leading-6 text-gray-900"}),e("div",re,[le,s(u,{class:"rounded-none rounded-r bg-gray-50 border border-gray-300 text-gray-900 min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white",type:"text",modelValue:o(t).num_tarjeta,"onUpdate:modelValue":r[4]||(r[4]=l=>o(t).num_tarjeta=l)},null,8,["modelValue"])]),s(i,{class:"mt-1 text-start w-full",message:o(t).errors.num_tarjeta},null,8,["message"])])])):I("",!0)])]),de,e("div",ne,[e("button",{onClick:p,type:"button",class:"inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700"}," Cancelar "),s(F,{class:N(["inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700",{"opacity-50":o(t).processing}]),disabled:o(t).processing},{default:v(()=>[P(" Guardar ")]),_:1},8,["class","disabled"])])],40,z)])]),_:1},8,["show"])]))}};export{fe as default};
