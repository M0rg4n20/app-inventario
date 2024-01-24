import{k as g,o as E,K as I,m as l,n as i,p as t,u as c,w as s,q as T,Z as M,s as e,t as n,x as N,y as V,v as r,z as Z}from"./vendorb2c7101c.js";import{_ as $}from"./AuthenticatedLayout4b68b4d2.js";import{Q as q,Z as y}from"./flowbite-vue4519d4b7.js";import{S as f}from"./sweetalert2.all5300f0ca.js";import{_ as A}from"./StockColorca688f93.js";import Q from"./CrearModal4035201c.js";import z from"./EditarModalaa833ba4.js";import{D as b,l as F}from"./es-ESeb942a1a.js";import"./InputErrorb5789600.js";import"./InputLabel949fdd54.js";import"./Modal5c7d7f4d.js";import"./multiselect2742171c.js";import"./TextInput70c275a9.js";import"./PrimaryButton2bb40203.js";const K={class:"ml-4 col-span-full"},L={class:"px-5 col-span-full flex justify-between items-center"},G=e("h1",{class:"text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"},"Productos",-1),H={class:"p-4 mb-4 bg-white col-span-12 pb-5 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800"},J={class:"overflow-x-auto"},O={class:"lg:inline-block min-w-full mt-4"},R={class:"overflow-hidden"},U={id:"tabla1",class:"pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400"},W=e("thead",{class:"text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400"},[e("tr",null,[e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," ID ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center text-center"}," Nombre ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center text-center"}," Imagen ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Código ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Categoría ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Stock ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Precio compra ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Precio venta ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Precio mayorista ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Agregado ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Acciones ")])])],-1),X={scope:"row",class:"p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white"},Y={scope:"row",class:"p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white"},ee={scope:"row",class:"p-1 border dark:border-gray-700"},re=["src"],te={scope:"row",class:"p-1 border dark:border-gray-700"},oe={scope:"row",class:"p-1 border dark:border-gray-700"},se={scope:"row",class:"p-1 border dark:border-gray-700"},ae={scope:"row",class:"p-1 border dark:border-gray-700"},de={scope:"row",class:"p-1 border dark:border-gray-700"},ce={scope:"row",class:"p-1 border dark:border-gray-700"},le={scope:"row",class:"p-1 border dark:border-gray-700"},ie={scope:"row",class:"p-1 border dark:border-gray-700"},ne={class:"inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700"},be={class:"inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700"},pe=["onClick"],ue=e("i",{class:"fas fa-trash-alt"},null,-1),_e=[ue],Te={__name:"Index",setup(ge){b.use(b);const p=g([]),m=g(null),h={responsive:!0,language:F,stateSave:!0},x=()=>{T(()=>{m.value=new b("#tabla1",h)})};E(()=>{p.value=I().props.productos.data,x()});const k=(a,u)=>{f.mixin({buttonsStyling:!0}).fire({width:350,title:"Seguro de eliminar "+u,text:"Se eliminará definitivamente",icon:"question",showCancelButton:!0,confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",cancelButtonColor:"red",confirmButtonColor:"#2563EB"}).then(d=>{d.isConfirmed&&formDelete.delete(route("productos.destroy",a),{preserveScroll:!0,onSuccess:()=>{v("Eliminado")}})})},v=a=>{f.fire({width:350,title:a,icon:"success"})};return(a,u)=>(l(),i("div",null,[t(c(M),{title:"Productos"}),t($,null,{default:s(()=>[e("div",K,[t(c(q),null,{default:s(()=>[t(c(y),{href:"/",home:""},{default:s(()=>[n(" Inicio ")]),_:1}),t(c(y),null,{default:s(()=>[n(" Productos ")]),_:1})]),_:1})]),e("div",L,[G,t(Q)]),e("div",H,[e("div",J,[e("div",O,[e("div",R,[e("table",U,[W,e("tbody",null,[(l(!0),i(N,null,V(p.value,({id:o,nombre:d,imagen_1:w,codigo:j,categoria:C,stock:_,precio_compra:S,precio_venta:B,precio_mayorista:P,agregado:D},ye)=>(l(),i("tr",{key:o,class:"bg-white text-center dark:bg-gray-800 dark:border-gray-700"},[e("th",X,r(o),1),e("th",Y,r(d),1),e("td",ee,[e("img",{class:"rounded-full shadow-2xl border-2 w-10 h-10 object-contain",src:w,alt:"image description"},null,8,re)]),e("td",te,r(j),1),e("td",oe,r(C),1),e("td",se,[t(A,{cantidad:_},{default:s(()=>[n(r(_),1)]),_:2},1032,["cantidad"])]),e("td",ae,r(S),1),e("td",de,r(B),1),e("td",ce,r(P),1),e("td",le,r(D),1),e("td",ie,[e("span",ne,[t(z,{"cliente-id":o},null,8,["cliente-id"])]),e("span",be,[e("button",{onClick:Z(fe=>k(o,d),["prevent"])},_e,8,pe)])])]))),128))])])])])])])]),_:1})]))}};export{Te as default};