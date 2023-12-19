import{k as h,T as v,m as w,n as y,s as o,v as c,p as t,w as d,z as k,u as s,C,t as V,O as S}from"./vendor9df2f612.js";import{_ as u}from"./InputError36fdb8dd.js";import{_ as b}from"./InputLabel7da40d8f.js";import{_ as M}from"./Modale28fe8ea.js";import{_ as p}from"./TextInputaca9d9c1.js";import{_ as $}from"./PrimaryButton0ecc7f29.js";import{S as N}from"./sweetalert2.all2e5f4a54.js";const B={class:"space-y-4"},E={class:"p-2"},j=["onSubmit"],z={class:"px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2"},D={class:"col-span-6 shadow-default xl:col-span-6"},F={class:"col-span-6 shadow-default xl:col-span-6"},I={class:"flex justify-end pt-0"},l="Marca",f="marcas",J={__name:"CrearModal",setup(O){const a=h(!1),g=()=>{a.value=!0},m=()=>{a.value=!1,e.reset()},e=v({comentario:"",nombre:""}),_=()=>{e.clearErrors(),e.post(route(f+".store"),{preserveScroll:!0,forceFormData:!0,onSuccess:()=>{a.value=!1,x(l+" Creada"),S.get(route(f+".index"))},onFinish:()=>{},onError:()=>{}})},x=i=>{e.reset(),N.fire({width:350,title:i,icon:"success"})};return(i,r)=>(w(),y("section",B,[o("button",{type:"button",onClick:g,class:"m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700"}," Agregar "+c(l)),t(M,{show:a.value,onClose:m,maxWidth:"md"},{default:d(()=>[o("div",E,[o("div",{class:"p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600"},[o("h2",{class:"text-lg font-medium text-gray-900"}," Crear "+c(l))]),o("form",{onSubmit:k(_,["prevent"])},[o("div",z,[o("div",D,[t(b,{for:"nombre",value:"Nombre",class:"block text-base font-medium leading-6 text-gray-900"}),t(p,{id:"nombre",type:"text",modelValue:s(e).nombre,"onUpdate:modelValue":r[0]||(r[0]=n=>s(e).nombre=n),autocomplete:"nombre",placeholder:"Ingrese nombre"},null,8,["modelValue"]),t(u,{class:"mt-1 text-xs",message:s(e).errors.nombre},null,8,["message"])]),o("div",F,[t(b,{for:"comentario",value:"Comentario",class:"block text-base font-medium leading-6 text-gray-900"}),t(p,{id:"comentario",type:"text",modelValue:s(e).comentario,"onUpdate:modelValue":r[1]||(r[1]=n=>s(e).comentario=n),autocomplete:"comentario",placeholder:"Ingrese comentario"},null,8,["modelValue"]),t(u,{class:"mt-1 text-xs",message:s(e).errors.comentario},null,8,["message"])])]),o("div",I,[o("button",{onClick:m,type:"button",class:"inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700"}," Cancelar "),t($,{class:C(["inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700",{"opacity-50":s(e).processing}]),disabled:s(e).processing},{default:d(()=>[V(" Guardar ")]),_:1},8,["class","disabled"])])],40,j)])]),_:1},8,["show"])]))}};export{J as default};
