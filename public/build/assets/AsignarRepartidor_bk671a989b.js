import{k as c,K as O,T as $,m as p,n as m,s as t,p as o,w as x,v as h,z as B,u as a,A as w,x as D,y as F,M as N,am as U,C as j,t as z,a as I,O as T}from"./vendor9df2f612.js";import{_}from"./InputError36fdb8dd.js";import{_ as g}from"./InputLabel7da40d8f.js";import{_ as G}from"./Modale28fe8ea.js";import{_ as K}from"./PrimaryButton0ecc7f29.js";import{S as L}from"./sweetalert2.all2e5f4a54.js";import{s as y}from"./multiselectf73eb494.js";const P={class:"p-2"},W=["onSubmit"],q={class:"px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2"},H={class:"col-span-6 shadow-default xl:col-span-6"},J={class:"col-span-6 shadow-default xl:col-span-6"},Q={class:"col-span-6 shadow-default xl:col-span-6"},X=t("hr",{class:"p-2"},null,-1),Y={class:"grid grid-cols-3 gap-4"},Z=["id","value"],ee=["for"],se={class:"flex justify-end pt-0"},k="Ruta",f="pedidos",ne={__name:"AsignarRepartidor,bk",props:{categoriaId:{default:""}},setup(S){const V=S,i=c(!1),{user:C}=O().props.auth,e=$({id:"",ruta_id:"",repartidor_id:"",responsable_id:"",colonia:""}),b=c({value:"",closeOnSelect:!0,placeholder:"Seleccione",searchable:!0,options:[]}),n=c({value:"",closeOnSelect:!0,placeholder:"Seleccione",searchable:!0,options:[]}),A=()=>{R(V.categoriaId)},R=d=>{I.get(route(f+".asignar",d)).then(r=>{i.value=!0;var s=r.data;b.value.options=s.rutas,n.value.options=s.repartidores,e.id=s.envio.id,e.responsable_id=C.id,e.colonia=s.envio.colonia;const l=s.rutas.find(u=>u.label===s.envio.colonia);l&&(e.ruta_id=l.value,console.log(e.ruta_id,l.value))})},v=()=>{i.value=!1,e.reset()},M=()=>{e.clearErrors(),e.post(route(f+".update",e.id),{preserveScroll:!0,forceFormData:!0,onSuccess:()=>{i.value=!1,E(k+" Asignada"),T.get(route(f+".index")),e.reset()},onFinish:()=>{},onError:()=>{}})},E=d=>{e.reset(),L.fire({width:350,title:d,icon:"success"})};return(d,r)=>(p(),m("div",null,[t("button",{type:"button",class:"rounded bg-green-500 px-1 py-1 text-xs font-normal text-white mr-1 mb-1 hover:bg-green-700",onClick:A},"Asignar"),o(G,{show:i.value,onClose:v,maxWidth:"md"},{default:x(()=>[t("div",P,[t("div",{class:"p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600"},[t("h2",{class:"text-lg font-medium text-gray-900"}," Asignar "+h(k))]),t("form",{onSubmit:B(M,["prevent"])},[t("div",q,[t("div",H,[o(g,{for:"ruta",value:"Ruta",class:"block text-base font-medium leading-6 text-gray-900"}),o(a(y),w({id:"ruta",modelValue:a(e).ruta_id,"onUpdate:modelValue":r[0]||(r[0]=s=>a(e).ruta_id=s)},b.value),null,16,["modelValue"]),o(_,{class:"mt-1 text-xs",message:a(e).errors.ruta_id},null,8,["message"])]),t("div",J,[o(g,{for:"repartidor",value:"Repartidor",class:"block text-base font-medium leading-6 text-gray-900"}),o(a(y),w({id:"repartidor",modelValue:a(e).repartidor_id,"onUpdate:modelValue":r[1]||(r[1]=s=>a(e).repartidor_id=s)},n.value),null,16,["modelValue"]),o(_,{class:"mt-1 text-xs",message:a(e).errors.repartidor_id},null,8,["message"])]),t("div",Q,[X,o(g,{value:"Repartidor",class:"block text-base font-medium leading-6 text-gray-900"}),t("div",Y,[(p(!0),m(D,null,F(n.value,(s,l)=>(p(),m("div",{key:l,class:"flex items-center space-x-2"},[N(t("input",{type:"radio",id:"repartidor_"+s.value,"onUpdate:modelValue":r[2]||(r[2]=u=>a(e).repartidor_id=u),value:s.value},null,8,Z),[[U,a(e).repartidor_id]]),t("label",{for:"repartidor_"+s.value},h(s.label),9,ee)]))),128))]),o(_,{class:"mt-1 text-xs",message:a(e).errors.repartidor_id},null,8,["message"])])]),t("div",se,[t("button",{onClick:v,type:"button",class:"inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700"}," Cancelar "),o(K,{class:j(["inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700",{"opacity-50":a(e).processing}]),disabled:a(e).processing},{default:x(()=>[z(" Guardar ")]),_:1},8,["class","disabled"])])],40,W)])]),_:1},8,["show"])]))}};export{ne as default};
