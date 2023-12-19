import{I as S,K as a,o as y,k as n,m as c,n as p,p as s,u as o,w as i,x as w,Z as O,s as t,t as k,V as d,y as $,v as D,O as L}from"./vendor9df2f612.js";import{_ as P,h as Y}from"./AuthenticatedLayouta4b2ee4f.js";import{Q as X,Z as V}from"./flowbite-vue17772b29.js";import{i as B}from"./es.es96ee115e.js";import{s as C,a as I,e as j,b as A,c as E}from"./index3b59ec08.js";const N={class:"ml-4 col-span-full"},R=t("div",{class:"px-5 col-span-full flex justify-between items-center"},[t("h1",{class:"text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"}," Reporte de ventas")],-1),W={class:"grid grid-cols-1 col-span-full gap-4 xl:grid-cols-12 xl:gap-4 mt-0 2xl:grid-cols-12"},Z={class:"col-span-1 md:col-span-3 xl:col-span-3"},q={class:"grid grid-cols-1 col-span-full gap-4 xl:grid-cols-12 xl:gap-4 mt-0 2xl:grid-cols-12"},Q={class:"col-span-1 md:col-span-12 xl:col-span-12 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800"},T=t("h3",{class:"flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white"},"Gráfico de Ventas ",-1),G={class:"col-span-1 md:col-span-6 xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800"},H=t("h3",{class:"flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white"},"Clientes con más compras",-1),K={class:"border-t border-gray-200 dark:border-gray-600"},U={class:"col-span-1 md:col-span-6 xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800"},J=t("h3",{class:"flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white"},"Vendedores con más ventas",-1),ee={class:"border-t border-gray-200 dark:border-gray-600"},te={class:"col-span-1 md:col-span-6 xl:col-span-6 bg-white p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800"},se=t("h3",{class:"flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white"},"Productos más vendidos",-1),oe={class:"border-t border-gray-200 dark:border-gray-600"},ae={class:"pt-2",id:"faq",role:"tabpanel","aria-labelledby":"faq-tab"},re={role:"list",class:"divide-y divide-gray-200 dark:divide-gray-700"},ne={class:"py-1"},le={class:"flex items-center justify-between"},ie={class:"flex items-center min-w-0"},de=["src"],ce={class:"ml-3"},pe={class:"font-normal text-sm text-gray-900 truncate dark:text-white"},fe={class:"inline-flex items-center text-sm font-normal text-gray-900 dark:text-white"},ve={__name:"ReporteVenta",setup(ue){const z=S([]);a().props,a().props,a().props,a().props;const{datos_grafico_ventas:f}=a().props,{datos_grafico_vendidos:l}=a().props;a().props;const{vendedores_mas_ventas:u}=a().props,{clientes_mas_compras:m}=a().props;y(()=>{z.data=l});const F=[{text:"Hoy",onClick(){return[new Date,new Date]}},{text:"Ayer",onClick(){return[C(new Date,1),C(new Date,1)]}},{text:"Este mes",onClick(){return[I(new Date),j(new Date)]}},{text:"Este año",onClick(){return[A(new Date),E(new Date)]}}],h=n([new Date,new Date]),M=e=>{L.get("/",{inicio:Y(e[0]).format("YYYY-MM-DD"),fin:Y(e[1]).format("YYYY-MM-DD")},{preserveState:!1})},g=n({chart:{type:"area",stacked:!1,toolbar:{show:!0,offsetX:0,offsetY:0,tools:{download:!0,selection:!1,zoom:!1,zoomin:!1,zoomout:!1,pan:!1,reset:!1,customIcons:[]},export:{csv:{filename:"ventas",columnDelimiter:",",headerCategory:"anio",headerValue:"value",dateFormatter(e){return new Date(e).toDateString()}},svg:{filename:"ventas"},png:{filename:"ventas"}}}},dataLabels:{enabled:!1,formatter:function(e){return"$ "+e.toFixed(2)},offsetY:-6,style:{fontSize:"10px",colors:["#304758"]}},markers:{size:3,strokeWidth:2},series:[{name:"Ventas",data:f.datos}],stroke:{width:[2,2],curve:"straight"},xaxis:{categories:f.categoria},plotOptions:{bar:{horizontal:!1}},yaxis:[{axisTicks:{show:!1},axisBorder:{show:!0},labels:{formatter:function(e){return"$ "+e.toFixed(2)}},title:{text:"Ventas",style:{}}}],legend:{horizontalAlign:"left",offsetX:20}}),x=n({series:l.datos,theme:{palette:"palette1"},chart:{type:"donut",toolbar:{show:!0,offsetX:-20,offsetY:-10,tools:{download:!0,selection:!1,zoom:!1,zoomin:!1,zoomout:!1,pan:!1,reset:!1,customIcons:[]},export:{csv:{filename:"Productos vendidos",columnDelimiter:",",headerCategory:"productos",headerValue:"value",dateFormatter(e){return new Date(e).toDateString()}},svg:{filename:"Productos vendidos"},png:{filename:"Productos vendidos"}}}},labels:l.categoria,responsive:[{breakpoint:480,options:{chart:{width:200},legend:{position:"bottom"}}}],plotOptions:{pie:{size:400,donut:{size:"50%"}}}}),b=n({series:[{name:"Ventas",data:u.datos}],chart:{type:"bar",height:350},toolbar:{show:!0,offsetX:-20,offsetY:-10,export:{csv:{filename:"Vendedores",columnDelimiter:",",headerCategory:"Vendedores",headerValue:"value",dateFormatter(e){return new Date(e).toDateString()}},svg:{filename:"Vendedores"},png:{filename:"Vendedores"}}},plotOptions:{bar:{horizontal:!1,columnWidth:"55%",distributed:!0,endingShape:"rounded",dataLabels:{position:"top"}}},dataLabels:{enabled:!0,formatter:function(e){return"$ "+e.toFixed(2)},offsetY:-20,style:{fontSize:"12px",colors:["#304758"]}},stroke:{show:!0,width:2,colors:["transparent"]},xaxis:{labels:{rotate:-45},categories:u.categoria},yaxis:{labels:{formatter:function(e){return"$ "+e}}},fill:{opacity:1},tooltip:{y:{formatter:function(e){return"$ "+e.toFixed(2)}}}}),_=n({series:[{name:"Compras",data:m.datos}],chart:{type:"bar",height:350},toolbar:{show:!0,offsetX:-20,offsetY:-10,export:{csv:{filename:"Clientes",columnDelimiter:",",headerCategory:"Clientes",headerValue:"value",dateFormatter(e){return new Date(e).toDateString()}},svg:{filename:"Clientes"},png:{filename:"Clientes"}}},plotOptions:{bar:{horizontal:!1,columnWidth:"55%",distributed:!0,endingShape:"rounded",dataLabels:{position:"top"}}},dataLabels:{enabled:!0,formatter:function(e){return"$ "+e.toFixed(2)},offsetY:-20,style:{fontSize:"12px",colors:["#304758"]}},stroke:{show:!0,width:2,colors:["transparent"]},xaxis:{labels:{rotate:-45},categories:m.categoria},yaxis:{labels:{formatter:function(e){return"$ "+e}}},fill:{opacity:1},tooltip:{y:{formatter:function(e){return"$ "+e.toFixed(2)}}}});return y(()=>{}),(e,v)=>(c(),p(w,null,[s(o(O),{title:"Panel"}),s(P,null,{default:i(()=>[t("div",N,[s(o(X),null,{default:i(()=>[s(o(V),{href:"/",home:""},{default:i(()=>[k(" Inicio ")]),_:1}),s(o(V),null,{default:i(()=>[k(" Reporte de ventas ")]),_:1})]),_:1})]),R,t("div",W,[t("div",Z,[s(o(B),{onChange:M,type:"date",range:"","value-type":"YYYY-MM-DD",format:"DD/MM/YYYY",value:h.value,"onUpdate:value":v[0]||(v[0]=r=>h.value=r),shortcuts:F,lang:"es",placeholder:"seleccione Fecha"},null,8,["value"])])]),t("div",q,[t("div",Q,[T,s(o(d),{height:"350px",options:g.value,series:g.value.series},null,8,["options","series"])]),t("div",G,[H,t("div",K,[s(o(d),{height:"350px",options:_.value,series:_.value.series},null,8,["options","series"])])]),t("div",U,[J,t("div",ee,[s(o(d),{height:"350px",options:b.value,series:b.value.series},null,8,["options","series"])])]),t("div",te,[se,s(o(d),{height:"350px",options:x.value,series:x.value.series},null,8,["options","series"]),t("div",oe,[t("div",ae,[t("ul",re,[(c(!0),p(w,null,$(o(l).tabla,(r,me)=>(c(),p("li",ne,[t("div",le,[t("div",ie,[t("img",{class:"flex-shrink-0 w-8 h-8",src:r.imagen,alt:"image"},null,8,de),t("div",ce,[t("p",pe,D(r.nombre),1)])]),t("div",fe,D(r.porcentaje),1)])]))),256))])])])])])]),_:1})],64))}};export{ve as default};
