!function(){"use strict";var e,t={218:function(e,t,l){var o=window.wp.blocks,n=window.wp.element;const a={};a.video=(0,n.createElement)("svg",{width:"100pt",height:"100pt",version:"1.1",viewBox:"0 0 100 100",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"m33.625 32.367c-4.1875 0-7.5586 3.3711-7.5586 7.5586v20.152c0 4.1875 3.3711 7.5586 7.5586 7.5586h32.746c4.1875 0 7.5586-3.3711 7.5586-7.5586v-20.152c0-4.1875-3.3711-7.5586-7.5586-7.5586zm10.707 9.4453 15.113 8.1875-15.113 8.1875z"}));var r=a,s=window.wp.data,i=window.wp.i18n,c=window.wp.components,u=window.wp.blockEditor,d=window.wp.serverSideRender,m=l.n(d),b=(0,s.withSelect)(((e,t)=>{const{attributes:l}=t,{getEntityRecords:o}=e("core"),{taxTermsSelected:n,order:a,sortBy:r}=l,s=o("taxonomy","embed_cat",{per_page:-1,orderby:"name",order:"asc"});return{lists:s,taxTermsSelected:Array.isArray(s)&&1==s.length?s[0]:n}}))((function(e){const{lists:t,attributes:l,setAttributes:o,name:a}=e,{taxTermsSelected:s,sortBy:d,order:b,displayAs:p,columns:k,columnsTablet:y,columnsMobile:f,autoPlay:g,autoPlaySpeed:h,postsPerPage:v,showTitle:_,showDescription:w}=l;let C=[];if(t){if(C=t.map((e=>({value:e.id,label:e.name}))),!s){const e={value:null,label:"Select a Category"};C.unshift(e)}}else C=[{value:0,label:"Loading..."}];const E=(0,n.createElement)(n.Fragment,null,(0,n.createElement)(c.SelectControl,{label:(0,i.__)("Select Category","carkeek-blocks"),onChange:e=>o({taxTermsSelected:e}),options:C,value:s})),S=(0,n.createElement)(u.InspectorControls,null,(0,n.createElement)(c.PanelBody,{title:(0,i.__)("List Settings","carkeek-blocks")},E,(0,n.createElement)(c.SelectControl,{label:(0,i.__)("Sort Links By","carkeek-blocks"),onChange:e=>o({sortBy:e}),options:[{label:(0,i.__)("Title (alpha)"),value:"title"},{label:(0,i.__)("Menu Order"),value:"menu_order"}],value:d}),(0,n.createElement)(c.RadioControl,{label:(0,i.__)("Order"),selected:b,options:[{label:(0,i.__)("ASC"),value:"ASC"},{label:(0,i.__)("DESC"),value:"DESC"}],onChange:e=>o({order:e})})),(0,n.createElement)(c.PanelBody,{title:(0,i.__)("Layout","carkeek-blocks")},(0,n.createElement)(c.RadioControl,{label:(0,i.__)("Display As","carkeek-blocks"),selected:p,options:[{label:(0,i.__)("Grid"),value:"grid"},{label:(0,i.__)("Carousel"),value:"carousel"}],onChange:e=>o({displayAs:e})}),(0,n.createElement)(c.RangeControl,{label:(0,i.__)("Limit Results","carkeek-blocks"),help:(0,i.__)("Limit the number of results to show, select -1 to show all.","carkeek-blocks"),value:v,onChange:e=>o({postsPerPage:e}),min:-1,max:20}),(0,n.createElement)(c.RangeControl,{label:(0,i.__)("Columns","carkeek-blocks"),value:k,onChange:e=>o({columns:e}),min:1,max:6}),(0,n.createElement)(c.RangeControl,{label:(0,i.__)("Columns Mobile","carkeek-blocks"),value:f,onChange:e=>o({columnsMobile:e}),min:1,max:6}),(0,n.createElement)(c.RangeControl,{label:(0,i.__)("Columns Tablet","carkeek-blocks"),value:y,onChange:e=>o({columnsTablet:e}),min:1,max:6})),"carousel"===p&&(0,n.createElement)(c.PanelBody,{title:(0,i.__)("Carousel Settings","carkeek-blocks")},(0,n.createElement)(c.ToggleControl,{label:"Auto Play Carousel",checked:g,onChange:e=>o({autoPlay:e})}),g&&(0,n.createElement)(c.RangeControl,{label:(0,i.__)("Time on each Slide (in ms)","carkeek-blocks"),value:h,onChange:e=>o({autoPlaySpeed:e}),min:1e3,max:1e4})),(0,n.createElement)(c.PanelBody,{title:(0,i.__)("Item Layout","carkeek-blocks")},(0,n.createElement)(c.ToggleControl,{label:"Show Item Title",checked:_,onChange:e=>o({showTitle:e})}),(0,n.createElement)(c.ToggleControl,{label:"Show Item Description",checked:w,onChange:e=>o({showDescription:e})}))),x=(0,u.useBlockProps)();if(s)return l.context="edit",(0,n.createElement)("div",x,S,(0,n.createElement)(m(),{block:a,attributes:l}),(0,n.createElement)("div",{className:"block-preview--notes"},"List preview. To edit the content visit Youtube Embeds in the admin dashboard."));{const e=(0,i.__)("Select a Category from the Block Settings");return(0,n.createElement)("div",x,S,(0,n.createElement)(c.Placeholder,{icon:r.linkList,label:(0,i.__)("YouTube Embed List")},(0,n.createElement)(c.Spinner,null)," ",e))}})),p=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"carkeek-blocks/youtube-embed","version":"0.1.1","title":"Youtube Embeds","category":"widgets","icon":"smiley","description":"Display a List of Youtube Videos.","supports":{"html":false,"anchor":true,"align":["wide","full"]},"keywords":["youtube","carousel","videos"],"textdomain":"carkeek-blocks","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","render":"file:./render.php","viewScript":"file:./script.js","attributes":{"taxTermsSelected":{"type":"string","default":""},"taxQueryType":{"type":"string","default":"AND"},"displayAs":{"type":"string","default":"grid"},"sortBy":{"type":"string","default":"title"},"order":{"type":"string","default":"ASC"},"postsPerPage":{"type":"number","default":6},"columns":{"type":"number","default":3},"columnsMobile":{"type":"number","default":1},"columnsTablet":{"type":"number","default":3},"autoPlay":{"type":"boolean","default":true},"autoPlaySpeed":{"type":"number","default":3000},"context":{"type":"string","default":"view"},"showTitle":{"type":"boolean","default":true},"showDescription":{"type":"boolean","default":true},"align":{"type":"string","default":""}}}');(0,o.registerBlockType)(p,{icon:{src:r.video},edit:b})}},l={};function o(e){var n=l[e];if(void 0!==n)return n.exports;var a=l[e]={exports:{}};return t[e](a,a.exports,o),a.exports}o.m=t,e=[],o.O=function(t,l,n,a){if(!l){var r=1/0;for(u=0;u<e.length;u++){l=e[u][0],n=e[u][1],a=e[u][2];for(var s=!0,i=0;i<l.length;i++)(!1&a||r>=a)&&Object.keys(o.O).every((function(e){return o.O[e](l[i])}))?l.splice(i--,1):(s=!1,a<r&&(r=a));if(s){e.splice(u--,1);var c=n();void 0!==c&&(t=c)}}return t}a=a||0;for(var u=e.length;u>0&&e[u-1][2]>a;u--)e[u]=e[u-1];e[u]=[l,n,a]},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,{a:t}),t},o.d=function(e,t){for(var l in t)o.o(t,l)&&!o.o(e,l)&&Object.defineProperty(e,l,{enumerable:!0,get:t[l]})},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={169:0,447:0};o.O.j=function(t){return 0===e[t]};var t=function(t,l){var n,a,r=l[0],s=l[1],i=l[2],c=0;if(r.some((function(t){return 0!==e[t]}))){for(n in s)o.o(s,n)&&(o.m[n]=s[n]);if(i)var u=i(o)}for(t&&t(l);c<r.length;c++)a=r[c],o.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return o.O(u)},l=self.webpackChunkexample_dynamic=self.webpackChunkexample_dynamic||[];l.forEach(t.bind(null,0)),l.push=t.bind(null,l.push.bind(l))}();var n=o.O(void 0,[447],(function(){return o(218)}));n=o.O(n)}();