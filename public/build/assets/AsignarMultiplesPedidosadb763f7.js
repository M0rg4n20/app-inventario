import{k as n,K as B,T as D,m as d,n as c,s,v as p,p as i,w as x,a as F,z,x as w,y,M as k,al as T,u as r,an as U,C as G,t as K,O as L}from"./vendorb2c7101c.js";import{_ as C}from"./InputErrorb5789600.js";import{_ as S}from"./InputLabel949fdd54.js";import{_ as P}from"./Modal5c7d7f4d.js";import{_ as W}from"./PrimaryButton2bb40203.js";import{S as M}from"./sweetalert2.all5300f0ca.js";import"./multiselect2742171c.js";const q={class:"p-2"},H=["onSubmit"],I={class:"px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2"},J={class:"col-span-6 shadow-default xl:col-span-6"},Q={class:"grid grid-cols-3 gap-4"},X=["id","onChange","value"],Y=["for"],Z={class:"col-span-6 shadow-default xl:col-span-6"},ee=s("hr",{class:"p-2"},null,-1),se={class:"grid grid-cols-3 gap-4"},ae=["id","value","onChange"],te=["for"],oe={class:"flex justify-end pt-0"},g="Colonia",b="pedidos",pe={__name:"AsignarMultiplesPedidos",props:{selectedOrders:Array},setup($){const A=$,u=n(!1),{user:E}=B().props.auth,e=D({ruta_id:"0",repartidor_id:"",responsable_id:"",selected_orders:"",rutasseleccionadas:n([]),cantidad_rutas:"",cantidad_disponible:""}),f=n({value:""}),v=n({value:""}),_=n([]),R=a=>{_.value.includes(a)||(_.value=[..._.value,a])},V=a=>{e.cantidad_rutas=a},N=a=>{F.get(route(b+".asignar",a)).then(o=>{u.value=!0;var t=o.data;f.value=t.rutas,v.value=t.repartidores,e.responsable_id=E.id})},h=()=>{u.value=!1,e.reset()},O=()=>{e.cantidad_disponible=3-e.cantidad_rutas;let a=e.rutasseleccionadas.length+e.cantidad_rutas,o="";console.log(a),console.log(e.cantidad_rutas),a==0&&e.cantidad_rutas>0?o="Esta repartidor ya tiene "+e.cantidad_rutas+" rutas asignadas, no puede asignar mas.":e.cantidad_rutas==0&&a>3?o="No puede asignar mas de 3 rutas a este repartidor.":o="Esta repartidor ya tiene "+e.cantidad_rutas+" rutas asignadas, no puede asignar mas de "+e.cantidad_disponible+" rutas .",a<=3?(e.selected_orders=A.selectedOrders,e.clearErrors(),e.post(route(b+".update-multiple"),{preserveScroll:!0,forceFormData:!0,onSuccess:()=>{u.value=!1,j(g+" Asignada"),L.get(route(b+".index")),e.reset()},onFinish:()=>{},onError:()=>{}})):M.fire({icon:"warning",title:o,width:350})},j=a=>{e.reset(),M.fire({width:350,title:a,icon:"success"})};return(a,o)=>(d(),c("div",null,[s("button",{type:"button",class:"m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700",onClick:N},"Asignar "+p(g)),i(P,{show:u.value,onClose:h,maxWidth:"md"},{default:x(()=>[s("div",q,[s("div",{class:"p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600"},[s("h2",{class:"text-lg font-medium text-gray-900"}," Asignar "+p(g))]),s("form",{onSubmit:z(O,["prevent"])},[s("div",I,[s("div",J,[i(S,{value:"Colonias",class:"block text-base font-medium leading-6 text-gray-900"}),s("div",Q,[(d(!0),c(w,null,y(f.value,(t,m)=>(d(),c("div",{key:m,class:"flex items-center space-x-2"},[k(s("input",{type:"checkbox",id:"ruta_"+t.value,"onUpdate:modelValue":o[0]||(o[0]=l=>r(e).rutasseleccionadas=l),onChange:l=>R(t.label),value:t.label},null,40,X),[[T,r(e).rutasseleccionadas]]),s("label",{for:"ruta_"+t.label},p(t.label),9,Y)]))),128))]),i(C,{class:"mt-1 text-xs",message:r(e).errors.ruta_id},null,8,["message"])]),s("div",Z,[ee,i(S,{value:"Repartidor",class:"block text-base font-medium leading-6 text-gray-900"}),s("div",se,[(d(!0),c(w,null,y(v.value,(t,m)=>(d(),c("div",{key:m,class:"flex items-center space-x-2"},[k(s("input",{type:"radio",id:"repartidor_"+t.value,"onUpdate:modelValue":o[1]||(o[1]=l=>r(e).repartidor_id=l),value:t.value,onChange:l=>V(t.cantidad_rutas)},null,40,ae),[[U,r(e).repartidor_id]]),s("label",{for:"repartidor_"+t.value},p(t.label),9,te)]))),128))]),i(C,{class:"mt-1 text-xs",message:r(e).errors.repartidor_id},null,8,["message"])])]),s("div",oe,[s("button",{onClick:h,type:"button",class:"inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700"}," Cancelar "),i(W,{class:G(["inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700",{"opacity-50":r(e).processing}]),disabled:r(e).processing},{default:x(()=>[K(" Guardar ")]),_:1},8,["class","disabled"])])],40,H)])]),_:1},8,["show"])]))}};export{pe as default};