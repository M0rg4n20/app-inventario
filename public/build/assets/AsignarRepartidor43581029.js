import{k as c,K as E,T as V,m as u,n as p,s,p as n,w as g,v as m,z as $,t as v,u as a,x as B,y as D,M as F,am as N,C as R,a as j,O as z}from"./vendor9df2f612.js";import{_ as I}from"./InputError36fdb8dd.js";import{_ as O}from"./InputLabel7da40d8f.js";import{_ as T}from"./Modale28fe8ea.js";import{_ as G}from"./PrimaryButton0ecc7f29.js";import{S as K}from"./sweetalert2.all2e5f4a54.js";import"./multiselectf73eb494.js";const L={class:"p-2"},U=["onSubmit"],W={class:"px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2"},q={class:"col-span-6 shadow-default xl:col-span-6"},H={class:"col-span-6 shadow-default xl:col-span-6"},J=s("hr",{class:"p-2"},null,-1),P={class:"grid grid-cols-3 gap-4"},Q=["id","value"],X=["for"],Y={class:"flex justify-end pt-2"},h="Colonia",_="pedidos",ie={__name:"AsignarRepartidor",props:{categoriaId:{default:""}},setup(x){const w=x,o=c(!1),{user:y}=E().props.auth,e=V({id:"",ruta_id:"",repartidor_id:"",responsable_id:"",colonia:""}),k=c({value:""}),f=c({value:""}),C=()=>{S(w.categoriaId)},S=r=>{j.get(route(_+".asignar",r)).then(i=>{o.value=!0;var t=i.data;k.value=t.rutas,f.value=t.repartidores,e.id=t.envio.id,e.responsable_id=y.id,e.colonia=t.envio.colonia;const l=t.rutas.find(d=>d.label===t.envio.colonia);l&&(e.ruta_id=l.value)})},b=()=>{o.value=!1,e.reset()},A=()=>{e.clearErrors(),e.post(route(_+".update",e.id),{preserveScroll:!0,forceFormData:!0,onSuccess:()=>{o.value=!1,M(h+" Asignada"),z.get(route(_+".index")),e.reset()},onFinish:()=>{},onError:()=>{}})},M=r=>{e.reset(),K.fire({width:350,title:r,icon:"success"})};return(r,i)=>(u(),p("div",null,[s("button",{type:"button",class:"rounded bg-green-500 px-1 py-1 text-xs font-normal text-white mr-1 mb-1 hover:bg-green-700",onClick:C},"Asignar"),n(T,{show:o.value,onClose:b,maxWidth:"md"},{default:g(()=>[s("div",L,[s("div",{class:"p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600"},[s("h2",{class:"text-lg font-medium text-gray-900"}," Asignar "+m(h))]),s("form",{onSubmit:$(A,["prevent"])},[s("div",W,[s("div",q,[v(" Colonia: "),s("small",null,m(a(e).colonia),1)]),s("div",H,[J,n(O,{value:"Repartidor",class:"block text-base font-medium leading-6 text-gray-900"}),s("div",P,[(u(!0),p(B,null,D(f.value,(t,l)=>(u(),p("div",{key:l,class:"flex items-center space-x-2"},[F(s("input",{type:"radio",id:"repartidor_"+t.value,"onUpdate:modelValue":i[0]||(i[0]=d=>a(e).repartidor_id=d),value:t.value},null,8,Q),[[N,a(e).repartidor_id]]),s("label",{for:"repartidor_"+t.value},m(t.label),9,X)]))),128))]),n(I,{class:"mt-1 text-xs",message:a(e).errors.repartidor_id},null,8,["message"])])]),s("div",Y,[s("button",{onClick:b,type:"button",class:"inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700"}," Cancelar "),n(G,{class:R(["inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700",{"opacity-50":a(e).processing}]),disabled:a(e).processing},{default:g(()=>[v(" Guardar ")]),_:1},8,["class","disabled"])])],40,U)])]),_:1},8,["show"])]))}};export{ie as default};