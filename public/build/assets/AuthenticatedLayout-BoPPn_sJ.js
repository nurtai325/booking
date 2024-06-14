import{r as x,j as t,a as b,g as I,R as L}from"./app-s-vluceZ.js";import{A as P}from"./ApplicationLogo-C5lMxjHX.js";import{q as z}from"./transition-DqACsE_Z.js";const S=x.createContext({open:!1,setOpen:()=>{},toggleOpen:()=>{}}),y=({children:e})=>{const[r,n]=x.useState(!1),o=()=>{n(s=>!s)};return t.jsx(S.Provider,{value:{open:r,setOpen:n,toggleOpen:o},children:t.jsx("div",{className:"relative",children:e})})},A=({children:e})=>{const{open:r,setOpen:n,toggleOpen:o}=x.useContext(S);return t.jsxs(t.Fragment,{children:[t.jsx("div",{onClick:o,children:e}),r&&t.jsx("div",{className:"fixed inset-0 z-40",onClick:()=>n(!1)})]})},$=({align:e="right",width:r="48",contentClasses:n="py-1 bg-white dark:bg-white",children:o})=>{const{open:s,setOpen:a}=x.useContext(S);let i="origin-top";e==="left"?i="ltr:origin-top-left rtl:origin-top-right start-0":e==="right"&&(i="ltr:origin-top-right rtl:origin-top-left end-0");let d="";return r==="48"&&(d="w-48"),t.jsx(t.Fragment,{children:t.jsx(z,{as:x.Fragment,show:s,enter:"transition ease-out duration-200",enterFrom:"opacity-0 scale-95",enterTo:"opacity-100 scale-100",leave:"transition ease-in duration-75",leaveFrom:"opacity-100 scale-100",leaveTo:"opacity-0 scale-95",children:t.jsx("div",{className:`absolute z-50 mt-2 rounded-md shadow-lg ${i} ${d}`,onClick:()=>a(!1),children:t.jsx("div",{className:"rounded-md ring-1 ring-black ring-opacity-5 "+n,children:o})})})})},B=({className:e="",children:r,...n})=>t.jsx(b,{...n,className:"block w-full px-4 py-2 text-start text-sm leading-5 text-black dark:text-black hover:bg-gray-100 dark:hover:bg-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 transition duration-150 ease-in-out "+e,children:r});y.Trigger=A;y.Content=$;y.Link=B;const p=y;function M({active:e=!1,className:r="",children:n,...o}){return t.jsx(b,{...o,className:"inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none "+(e?"border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100 focus:border-indigo-700 ":"border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 ")+r,children:n})}function E({active:e=!1,className:r="",children:n,...o}){return t.jsx(b,{...o,className:`w-full flex items-start ps-3 pe-4 py-2 border-l-4 ${e?"border-indigo-400 dark:border-indigo-600 text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300":"border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600"} text-base font-medium focus:outline-none transition duration-150 ease-in-out ${r}`,children:n})}var F={VITE_APP_NAME:"Laravel",VITE_REVERB_APP_KEY:"bjijte4t6evng2vznpkc",VITE_REVERB_HOST:"localhost",VITE_REVERB_PORT:"8000",VITE_REVERB_SCHEME:"http",BASE_URL:"/build/",MODE:"production",DEV:!1,PROD:!0,SSR:!1};const N=e=>{let r;const n=new Set,o=(l,f)=>{const u=typeof l=="function"?l(r):l;if(!Object.is(u,r)){const c=r;r=f??(typeof u!="object"||u===null)?u:Object.assign({},r,u),n.forEach(g=>g(r,c))}},s=()=>r,m={setState:o,getState:s,getInitialState:()=>v,subscribe:l=>(n.add(l),()=>n.delete(l)),destroy:()=>{(F?"production":void 0)!=="production"&&console.warn("[DEPRECATED] The `destroy` method will be unsupported in a future version. Instead use unsubscribe function returned by subscribe. Everything will be garbage-collected if store is garbage-collected."),n.clear()}},v=r=e(o,s,m);return m},W=e=>e?N(e):N;var V={exports:{}},T={},D={exports:{}},O={};/**
 * @license React
 * use-sync-external-store-shim.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var h=x;function q(e,r){return e===r&&(e!==0||1/e===1/r)||e!==e&&r!==r}var H=typeof Object.is=="function"?Object.is:q,K=h.useState,U=h.useEffect,Y=h.useLayoutEffect,G=h.useDebugValue;function J(e,r){var n=r(),o=K({inst:{value:n,getSnapshot:r}}),s=o[0].inst,a=o[1];return Y(function(){s.value=n,s.getSnapshot=r,j(s)&&a({inst:s})},[e,n,r]),U(function(){return j(s)&&a({inst:s}),e(function(){j(s)&&a({inst:s})})},[e]),G(n),n}function j(e){var r=e.getSnapshot;e=e.value;try{var n=r();return!H(e,n)}catch{return!0}}function Q(e,r){return r()}var X=typeof window>"u"||typeof window.document>"u"||typeof window.document.createElement>"u"?Q:J;O.useSyncExternalStore=h.useSyncExternalStore!==void 0?h.useSyncExternalStore:X;D.exports=O;var Z=D.exports;/**
 * @license React
 * use-sync-external-store-shim/with-selector.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var k=x,ee=Z;function te(e,r){return e===r&&(e!==0||1/e===1/r)||e!==e&&r!==r}var re=typeof Object.is=="function"?Object.is:te,ne=ee.useSyncExternalStore,oe=k.useRef,se=k.useEffect,ae=k.useMemo,ie=k.useDebugValue;T.useSyncExternalStoreWithSelector=function(e,r,n,o,s){var a=oe(null);if(a.current===null){var i={hasValue:!1,value:null};a.current=i}else i=a.current;a=ae(function(){function m(c){if(!v){if(v=!0,l=c,c=o(c),s!==void 0&&i.hasValue){var g=i.value;if(s(g,c))return f=g}return f=c}if(g=f,re(l,c))return g;var w=o(c);return s!==void 0&&s(g,w)?g:(l=c,f=w)}var v=!1,l,f,u=n===void 0?null:n;return[function(){return m(r())},u===null?void 0:function(){return m(u())}]},[r,n,o,s]);var d=ne(e,a[0],a[1]);return se(function(){i.hasValue=!0,i.value=d},[d]),ie(d),d};V.exports=T;var de=V.exports;const le=I(de);var C={VITE_APP_NAME:"Laravel",VITE_REVERB_APP_KEY:"bjijte4t6evng2vznpkc",VITE_REVERB_HOST:"localhost",VITE_REVERB_PORT:"8000",VITE_REVERB_SCHEME:"http",BASE_URL:"/build/",MODE:"production",DEV:!1,PROD:!0,SSR:!1};const{useDebugValue:ce}=L,{useSyncExternalStoreWithSelector:ue}=le;let _=!1;const ge=e=>e;function xe(e,r=ge,n){(C?"production":void 0)!=="production"&&n&&!_&&(console.warn("[DEPRECATED] Use `createWithEqualityFn` instead of `create` or use `useStoreWithEqualityFn` instead of `useStore`. They can be imported from 'zustand/traditional'. https://github.com/pmndrs/zustand/discussions/1937"),_=!0);const o=ue(e.subscribe,e.getState,e.getServerState||e.getInitialState,r,n);return ce(o),o}const R=e=>{(C?"production":void 0)!=="production"&&typeof e!="function"&&console.warn("[DEPRECATED] Passing a vanilla store will be unsupported in a future version. Instead use `import { useStore } from 'zustand'`.");const r=typeof e=="function"?W(e):e,n=(o,s)=>xe(r,o,s);return Object.assign(n,r),n},fe=e=>e?R(e):R;function he(){const e=localStorage.getItem("language");return e==="kz"||e===null}const me=fe(e=>({kz:he(),invert:()=>{localStorage.getItem("language")==="kz"?localStorage.setItem("language","ru"):localStorage.setItem("language","kz"),e(r=>({kz:!r.kz}))}}));function ye({user:e,header:r,children:n}){const[o,s]=x.useState(!1),{kz:a,invert:i}=me(d=>d);return t.jsxs("div",{className:"min-h-screen bg-white dark:bg-white",children:[t.jsxs("nav",{className:"bg-white dark:bg-blue-500 dark:shadow-2xl",children:[t.jsx("div",{className:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8",children:t.jsxs("div",{className:"flex justify-between h-16",children:[t.jsxs("div",{className:"flex",children:[t.jsx("div",{className:"shrink-0 flex items-center",children:t.jsx(b,{href:"/",children:t.jsx(P,{className:"block h-9 w-auto fill-current text-gray-800 dark:text-white"})})}),t.jsx("div",{className:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex",children:t.jsx(M,{href:route("dashboard"),active:route().current("dashboard"),children:a?"Кесте":"Расписание"})})]}),t.jsx("button",{onClick:i,className:"w-4 h-4 ml-auto mt-4 text-white text-lg",children:a?"ru":"kz"}),t.jsx("div",{className:"hidden sm:flex sm:items-center sm:ms-6",children:t.jsx("div",{className:"ms-3 relative",children:t.jsxs(p,{children:[t.jsx(p.Trigger,{children:t.jsx("span",{className:"inline-flex rounded-md",children:t.jsxs("button",{type:"button",className:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black dark:text-black bg-white dark:bg-white hover:text-gray-600 dark:hover:text-gray-500 focus:outline-none transition ease-in-out duration-150",children:[e.name,t.jsx("svg",{className:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor",children:t.jsx("path",{fillRule:"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z",clipRule:"evenodd"})})]})})}),t.jsxs(p.Content,{children:[t.jsx(p.Link,{href:route("profile.edit"),children:"Профиль"}),t.jsx(p.Link,{href:route("logout"),method:"post",as:"button",children:a?"Шығу":"Выйти"})]})]})})}),t.jsx("div",{className:"-me-2 flex items-center sm:hidden",children:t.jsx("button",{onClick:()=>s(d=>!d),className:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out",children:t.jsxs("svg",{className:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24",children:[t.jsx("path",{className:o?"hidden":"inline-flex",strokeLinecap:"round",strokeLinejoin:"round",strokeWidth:"2",d:"M4 6h16M4 12h16M4 18h16"}),t.jsx("path",{className:o?"inline-flex":"hidden",strokeLinecap:"round",strokeLinejoin:"round",strokeWidth:"2",d:"M6 18L18 6M6 6l12 12"})]})})})]})}),t.jsxs("div",{className:(o?"block":"hidden")+" sm:hidden",children:[t.jsx("div",{className:"pt-2 pb-3 space-y-1",children:t.jsx(E,{href:route("dashboard"),active:route().current("dashboard"),children:a?" Кесте":"Расписание"})}),t.jsxs("div",{className:"pt-4 pb-1 border-t border-gray-200 dark:border-gray-600",children:[t.jsxs("div",{className:"px-4",children:[t.jsx("div",{className:"font-medium text-base text-gray-800 dark:text-gray-200",children:e.name}),t.jsx("div",{className:"font-medium text-sm text-gray-500",children:e.email})]}),t.jsxs("div",{className:"mt-3 space-y-1",children:[t.jsx(E,{href:route("profile.edit"),children:"Profile"}),t.jsx(E,{method:"post",href:route("logout"),as:"button",children:"Log Out"})]})]})]})]}),r&&t.jsx("header",{className:"bg-white dark:bg-white shadow",children:t.jsx("div",{className:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8",children:r})}),t.jsx("main",{children:n})]})}export{ye as A,me as u};
