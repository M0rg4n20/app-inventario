import{k as f,o as E,K as I,T as N,m as i,n as b,p as o,u as a,w as n,q as V,Z,s as e,t as p,v as t,O as y,x as $,y as q,E as F,z as M}from"./vendorb2c7101c.js";import{_ as O}from"./AuthenticatedLayout4b68b4d2.js";import{Q,Z as m}from"./flowbite-vue4519d4b7.js";import{S as x}from"./sweetalert2.all5300f0ca.js";import{D as u,l as A}from"./es-ESeb942a1a.js";const K={class:"ml-4 col-span-full"},L={class:"px-5 col-span-full flex justify-between items-center"},G={class:"p-4 mb-4 bg-white col-span-12 pb-5 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800"},H={class:"overflow-x-auto"},J={class:"lg:inline-block min-w-full mt-4"},P={class:"overflow-hidden"},R={id:"tabla1",class:"pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400"},U=e("thead",{class:"text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400"},[e("tr",null,[e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," ID ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center text-center"}," Código ticket ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Cliente ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Vendedor ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Neto ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Total ")]),e("th",{scope:"col",class:"border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Fecha ")]),e("th",{scope:"col",class:"w-36 border border-gray-300 dark:border-gray-500"},[e("div",{class:"flex justify-center"}," Acciones ")])])],-1),W={scope:"row",class:"p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white"},X={scope:"row",class:"p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white"},Y={scope:"row",class:"p-1 border dark:border-gray-700"},ee={scope:"row",class:"p-1 border dark:border-gray-700"},te={scope:"row",class:"p-1 border dark:border-gray-700"},re={scope:"row",class:"p-1 border dark:border-gray-700"},se={scope:"row",class:"p-1 border dark:border-gray-700"},oe={scope:"row",class:"p-1 border text-end dark:border-gray-700"},ae={class:"inline-block rounded bg-yellow-300 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-yellow-400"},ne=["href"],de=e("i",{class:"fas fa-money-bill"},null,-1),le=[de],ce={class:"inline-block rounded bg-sky-300 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-sky-400"},ie=["href"],be=e("i",{class:"fas fa-print"},null,-1),ue=[be],_e={class:"inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700"},ge=e("i",{class:"fas fa-edit"},null,-1),he={class:"inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700"},fe=["onClick"],pe=e("i",{class:"fas fa-trash-alt"},null,-1),ye=[pe],_="Cotizaciones",g="cotizaciones",Se={__name:"Index",setup(me){u.use(u);const h=f([]),k=f(null),v={responsive:!0,language:A,order:[1,"desc"]},w=()=>{V(()=>{k.value=new u("#tabla1",v)})};E(()=>{h.value=I().props.cotizaciones.data,w()});const C=N({id:""}),j=(r,d)=>{x.mixin({buttonsStyling:!0}).fire({width:350,title:"Seguro de eliminar "+d,text:"Se eliminará definitivamente",icon:"question",showCancelButton:!0,confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",cancelButtonColor:"red",confirmButtonColor:"#2563EB"}).then(l=>{l.isConfirmed&&C.delete(route(g+".destroy",r),{preserveScroll:!0,onSuccess:()=>{B("Eliminado"),y.get(route(g+".index"))}})})},B=r=>{x.fire({width:350,title:r,icon:"success"})};return(r,d)=>(i(),b("div",null,[o(a(Z),{title:_}),o(O,null,{default:n(()=>[e("div",K,[o(a(Q),null,{default:n(()=>[o(a(m),{href:"/",home:""},{default:n(()=>[p(" Inicio ")]),_:1}),o(a(m),null,{default:n(()=>[p(t(_))]),_:1})]),_:1})]),e("div",L,[e("h1",{class:"text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"},t(_)),e("button",{type:"button",onClick:d[0]||(d[0]=s=>a(y).get(r.route(g+".create"))),class:"m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700"}," Crear Cotización ")]),e("div",G,[e("div",H,[e("div",J,[e("div",P,[e("table",R,[U,e("tbody",null,[(i(!0),b($,null,q(h.value,({id:s,cliente:l,codigo:c,vendedor:S,neto:z,total:T,fecha:D},xe)=>(i(),b("tr",{key:s,class:"bg-white text-center dark:bg-gray-800 dark:border-gray-700"},[e("th",W,t(s),1),e("th",X,t(c),1),e("td",Y,t(l),1),e("td",ee,t(S),1),e("td",te,t(z),1),e("td",re,t(T),1),e("td",se,t(D),1),e("td",oe,[e("span",ae,[e("a",{href:r.route("ventas.generar",s),target:"_self"},le,8,ne)]),e("span",ce,[e("a",{href:r.route("cotizaciones.generar_ticket",c),target:"_blank"},ue,8,ie)]),e("span",_e,[o(a(F),{href:r.route("cotizaciones.edit",s)},{default:n(()=>[ge]),_:2},1032,["href"])]),e("span",he,[e("button",{onClick:M(ke=>j(s,c),["prevent"])},ye,8,fe)])])]))),128))])])])])])])]),_:1})]))}};export{Se as default};