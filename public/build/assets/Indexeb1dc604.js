import{_ as I}from"./AuthenticatedLayout4b68b4d2.js";import{k as g,o as A,K as x,m as s,n as d,p as t,u as o,w as a,q as B,Z as C,s as r,t as h,v as e,x as N,y as V}from"./vendorb2c7101c.js";import{Q as Z,Z as _}from"./flowbite-vue4519d4b7.js";import"./sweetalert2.all5300f0ca.js";import Q from"./CrearModalc939fec1.js";import{D as c,l as $}from"./es-ESeb942a1a.js";import"./InputErrorb5789600.js";import"./InputLabel949fdd54.js";import"./Modal5c7d7f4d.js";import"./TextInput70c275a9.js";import"./PrimaryButton2bb40203.js";import"./multiselect2742171c.js";const j={class:"ml-4 col-span-full"},q={class:"px-5 col-span-12 flex justify-between items-center"},E={class:"p-4 mb-4 bg-white col-span-12 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800"},K={class:"overflow-x-auto"},L={class:"inline-block min-w-full align-middle"},M={class:"overflow-visible"},R={id:"tabla1",class:"pt-3 w-full text-sm text-left text-gray-600 dark:text-gray-400"},S=r("thead",{class:"text-md text-gray-700 bg-gray-200/80 border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400"},[r("tr",null,[r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500 w-20"}," ID "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Ticket "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Cliente "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Total Compra "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Total abonado "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Abono efectivo "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Abono tarjeta "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Resta por pagar "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Usuario "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"}," Fecha "),r("th",{scope:"col",class:"p-1 text-center border border-gray-300 dark:border-gray-500"},[r("i",{class:"fas fa-print"})])])],-1),U={scope:"row",class:"px-3 py-1 border text-center border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},z={scope:"row",class:"px-3 py-1 border border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},G={scope:"row",class:"px-3 py-1 border border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},H={scope:"row",class:"px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},J={scope:"row",class:"px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},O={scope:"row",class:"px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},P={scope:"row",class:"px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},W={scope:"row",class:"px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},X={scope:"row",class:"px-3 py-1 border border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},Y={scope:"row",class:"px-3 py-1 border border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white"},rr={scope:"row",class:"px-3 py-1 border border-gray-300 dark:border-gray-700 text-gray-900 text-center whitespace-nowrap dark:text-white"},er={class:"inline-block rounded bg-sky-300 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-sky-400"},tr=["href"],or=r("i",{class:"fas fa-print"},null,-1),ar=[or],l="Abonos",ur={__name:"Index",setup(sr){c.use(c);const n=g([]),w=g(null),k={responsive:!0,language:$,order:[9,"desc"]},u=()=>{B(()=>{w.value=new c("#tabla1",k)})};return A(()=>{console.log(x().props.lista_abonos),n.value=x().props.lista_abonos,u()}),(m,dr)=>(s(),d("div",null,[t(o(C),{title:l}),t(I,null,{default:a(()=>[r("div",j,[t(o(Z),null,{default:a(()=>[t(o(_),{href:"/",home:""},{default:a(()=>[h(" Inicio ")]),_:1}),t(o(_),null,{default:a(()=>[h(e(l))]),_:1})]),_:1})]),r("div",q,[r("h1",{class:"text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"},e(l)),t(Q)]),r("div",E,[r("div",K,[r("div",L,[r("div",M,[r("table",R,[S,r("tbody",null,[(s(!0),d(N,null,V(n.value,({id:p,codigo:i,total:f,monto_efectivo:b,cliente:v,monto_tarjeta:y,saldo:F,usuario:T,created_at:D},cr)=>(s(),d("tr",{key:p,class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700"},[r("td",U,e(p),1),r("td",z,e(i),1),r("td",G,e(v),1),r("td",H,e(f.toFixed(2)),1),r("td",J,e((b+y).toFixed(2)),1),r("td",O,e(b.toFixed(2)),1),r("td",P,e(y.toFixed(2)),1),r("td",W,e(F.toFixed(2)),1),r("td",X,e(T),1),r("td",Y,e(D),1),r("td",rr,[r("span",er,[r("a",{href:m.route("abonos.generar_ticket",i),target:"_blank"},ar,8,tr)])])]))),128))])])])])])])]),_:1})]))}};export{ur as default};