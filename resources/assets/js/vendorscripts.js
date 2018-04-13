/*!
 * laudatio
 *
 *
 * @author PHMU Webdesign
 * @version 0.1.0
 * Copyright 2018.  licensed.
 */
/*! jQuery v3.3.1 | (c) JS Foundation and other contributors | jquery.org/license */
!function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(e,t){"use strict";var n=[],r=e.document,i=Object.getPrototypeOf,o=n.slice,a=n.concat,s=n.push,u=n.indexOf,l={},c=l.toString,f=l.hasOwnProperty,p=f.toString,d=p.call(Object),h={},g=function e(t){return"function"==typeof t&&"number"!=typeof t.nodeType},y=function e(t){return null!=t&&t===t.window},v={type:!0,src:!0,noModule:!0};function m(e,t,n){var i,o=(t=t||r).createElement("script");if(o.text=e,n)for(i in v)n[i]&&(o[i]=n[i]);t.head.appendChild(o).parentNode.removeChild(o)}function x(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?l[c.call(e)]||"object":typeof e}var b="3.3.1",w=function(e,t){return new w.fn.init(e,t)},T=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;w.fn=w.prototype={jquery:"3.3.1",constructor:w,length:0,toArray:function(){return o.call(this)},get:function(e){return null==e?o.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=w.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return w.each(this,e)},map:function(e){return this.pushStack(w.map(this,function(t,n){return e.call(t,n,t)}))},slice:function(){return this.pushStack(o.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(n>=0&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:s,sort:n.sort,splice:n.splice},w.extend=w.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||g(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)n=a[t],a!==(r=e[t])&&(l&&r&&(w.isPlainObject(r)||(i=Array.isArray(r)))?(i?(i=!1,o=n&&Array.isArray(n)?n:[]):o=n&&w.isPlainObject(n)?n:{},a[t]=w.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},w.extend({expando:"jQuery"+("3.3.1"+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==c.call(e))&&(!(t=i(e))||"function"==typeof(n=f.call(t,"constructor")&&t.constructor)&&p.call(n)===d)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e){m(e)},each:function(e,t){var n,r=0;if(C(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},trim:function(e){return null==e?"":(e+"").replace(T,"")},makeArray:function(e,t){var n=t||[];return null!=e&&(C(Object(e))?w.merge(n,"string"==typeof e?[e]:e):s.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:u.call(t,e,n)},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r,i=[],o=0,a=e.length,s=!n;o<a;o++)(r=!t(e[o],o))!==s&&i.push(e[o]);return i},map:function(e,t,n){var r,i,o=0,s=[];if(C(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&s.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&s.push(i);return a.apply([],s)},guid:1,support:h}),"function"==typeof Symbol&&(w.fn[Symbol.iterator]=n[Symbol.iterator]),w.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){l["[object "+t+"]"]=t.toLowerCase()});function C(e){var t=!!e&&"length"in e&&e.length,n=x(e);return!g(e)&&!y(e)&&("array"===n||0===t||"number"==typeof t&&t>0&&t-1 in e)}var E=function(e){var t,n,r,i,o,a,s,u,l,c,f,p,d,h,g,y,v,m,x,b="sizzle"+1*new Date,w=e.document,T=0,C=0,E=ae(),k=ae(),S=ae(),D=function(e,t){return e===t&&(f=!0),0},N={}.hasOwnProperty,A=[],j=A.pop,q=A.push,L=A.push,H=A.slice,O=function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1},P="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\\x20\\t\\r\\n\\f]",R="(?:\\\\.|[\\w-]|[^\0-\\xa0])+",I="\\["+M+"*("+R+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+R+"))|)"+M+"*\\]",W=":("+R+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+I+")*)|.*)\\)|)",$=new RegExp(M+"+","g"),B=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),F=new RegExp("^"+M+"*,"+M+"*"),_=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),z=new RegExp("="+M+"*([^\\]'\"]*?)"+M+"*\\]","g"),X=new RegExp(W),U=new RegExp("^"+R+"$"),V={ID:new RegExp("^#("+R+")"),CLASS:new RegExp("^\\.("+R+")"),TAG:new RegExp("^("+R+"|[*])"),ATTR:new RegExp("^"+I),PSEUDO:new RegExp("^"+W),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+P+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},G=/^(?:input|select|textarea|button)$/i,Y=/^h\d$/i,Q=/^[^{]+\{\s*\[native \w/,J=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,K=/[+~]/,Z=new RegExp("\\\\([\\da-f]{1,6}"+M+"?|("+M+")|.)","ig"),ee=function(e,t,n){var r="0x"+t-65536;return r!==r||n?t:r<0?String.fromCharCode(r+65536):String.fromCharCode(r>>10|55296,1023&r|56320)},te=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,ne=function(e,t){return t?"\0"===e?"\ufffd":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},re=function(){p()},ie=me(function(e){return!0===e.disabled&&("form"in e||"label"in e)},{dir:"parentNode",next:"legend"});try{L.apply(A=H.call(w.childNodes),w.childNodes),A[w.childNodes.length].nodeType}catch(e){L={apply:A.length?function(e,t){q.apply(e,H.call(t))}:function(e,t){var n=e.length,r=0;while(e[n++]=t[r++]);e.length=n-1}}}function oe(e,t,r,i){var o,s,l,c,f,h,v,m=t&&t.ownerDocument,T=t?t.nodeType:9;if(r=r||[],"string"!=typeof e||!e||1!==T&&9!==T&&11!==T)return r;if(!i&&((t?t.ownerDocument||t:w)!==d&&p(t),t=t||d,g)){if(11!==T&&(f=J.exec(e)))if(o=f[1]){if(9===T){if(!(l=t.getElementById(o)))return r;if(l.id===o)return r.push(l),r}else if(m&&(l=m.getElementById(o))&&x(t,l)&&l.id===o)return r.push(l),r}else{if(f[2])return L.apply(r,t.getElementsByTagName(e)),r;if((o=f[3])&&n.getElementsByClassName&&t.getElementsByClassName)return L.apply(r,t.getElementsByClassName(o)),r}if(n.qsa&&!S[e+" "]&&(!y||!y.test(e))){if(1!==T)m=t,v=e;else if("object"!==t.nodeName.toLowerCase()){(c=t.getAttribute("id"))?c=c.replace(te,ne):t.setAttribute("id",c=b),s=(h=a(e)).length;while(s--)h[s]="#"+c+" "+ve(h[s]);v=h.join(","),m=K.test(e)&&ge(t.parentNode)||t}if(v)try{return L.apply(r,m.querySelectorAll(v)),r}catch(e){}finally{c===b&&t.removeAttribute("id")}}}return u(e.replace(B,"$1"),t,r,i)}function ae(){var e=[];function t(n,i){return e.push(n+" ")>r.cacheLength&&delete t[e.shift()],t[n+" "]=i}return t}function se(e){return e[b]=!0,e}function ue(e){var t=d.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function le(e,t){var n=e.split("|"),i=n.length;while(i--)r.attrHandle[n[i]]=t}function ce(e,t){var n=t&&e,r=n&&1===e.nodeType&&1===t.nodeType&&e.sourceIndex-t.sourceIndex;if(r)return r;if(n)while(n=n.nextSibling)if(n===t)return-1;return e?1:-1}function fe(e){return function(t){return"input"===t.nodeName.toLowerCase()&&t.type===e}}function pe(e){return function(t){var n=t.nodeName.toLowerCase();return("input"===n||"button"===n)&&t.type===e}}function de(e){return function(t){return"form"in t?t.parentNode&&!1===t.disabled?"label"in t?"label"in t.parentNode?t.parentNode.disabled===e:t.disabled===e:t.isDisabled===e||t.isDisabled!==!e&&ie(t)===e:t.disabled===e:"label"in t&&t.disabled===e}}function he(e){return se(function(t){return t=+t,se(function(n,r){var i,o=e([],n.length,t),a=o.length;while(a--)n[i=o[a]]&&(n[i]=!(r[i]=n[i]))})})}function ge(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}n=oe.support={},o=oe.isXML=function(e){var t=e&&(e.ownerDocument||e).documentElement;return!!t&&"HTML"!==t.nodeName},p=oe.setDocument=function(e){var t,i,a=e?e.ownerDocument||e:w;return a!==d&&9===a.nodeType&&a.documentElement?(d=a,h=d.documentElement,g=!o(d),w!==d&&(i=d.defaultView)&&i.top!==i&&(i.addEventListener?i.addEventListener("unload",re,!1):i.attachEvent&&i.attachEvent("onunload",re)),n.attributes=ue(function(e){return e.className="i",!e.getAttribute("className")}),n.getElementsByTagName=ue(function(e){return e.appendChild(d.createComment("")),!e.getElementsByTagName("*").length}),n.getElementsByClassName=Q.test(d.getElementsByClassName),n.getById=ue(function(e){return h.appendChild(e).id=b,!d.getElementsByName||!d.getElementsByName(b).length}),n.getById?(r.filter.ID=function(e){var t=e.replace(Z,ee);return function(e){return e.getAttribute("id")===t}},r.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&g){var n=t.getElementById(e);return n?[n]:[]}}):(r.filter.ID=function(e){var t=e.replace(Z,ee);return function(e){var n="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return n&&n.value===t}},r.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&g){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),r.find.TAG=n.getElementsByTagName?function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):n.qsa?t.querySelectorAll(e):void 0}:function(e,t){var n,r=[],i=0,o=t.getElementsByTagName(e);if("*"===e){while(n=o[i++])1===n.nodeType&&r.push(n);return r}return o},r.find.CLASS=n.getElementsByClassName&&function(e,t){if("undefined"!=typeof t.getElementsByClassName&&g)return t.getElementsByClassName(e)},v=[],y=[],(n.qsa=Q.test(d.querySelectorAll))&&(ue(function(e){h.appendChild(e).innerHTML="<a id='"+b+"'></a><select id='"+b+"-\r\\' msallowcapture=''><option selected=''></option></select>",e.querySelectorAll("[msallowcapture^='']").length&&y.push("[*^$]="+M+"*(?:''|\"\")"),e.querySelectorAll("[selected]").length||y.push("\\["+M+"*(?:value|"+P+")"),e.querySelectorAll("[id~="+b+"-]").length||y.push("~="),e.querySelectorAll(":checked").length||y.push(":checked"),e.querySelectorAll("a#"+b+"+*").length||y.push(".#.+[+~]")}),ue(function(e){e.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var t=d.createElement("input");t.setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),e.querySelectorAll("[name=d]").length&&y.push("name"+M+"*[*^$|!~]?="),2!==e.querySelectorAll(":enabled").length&&y.push(":enabled",":disabled"),h.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&y.push(":enabled",":disabled"),e.querySelectorAll("*,:x"),y.push(",.*:")})),(n.matchesSelector=Q.test(m=h.matches||h.webkitMatchesSelector||h.mozMatchesSelector||h.oMatchesSelector||h.msMatchesSelector))&&ue(function(e){n.disconnectedMatch=m.call(e,"*"),m.call(e,"[s!='']:x"),v.push("!=",W)}),y=y.length&&new RegExp(y.join("|")),v=v.length&&new RegExp(v.join("|")),t=Q.test(h.compareDocumentPosition),x=t||Q.test(h.contains)?function(e,t){var n=9===e.nodeType?e.documentElement:e,r=t&&t.parentNode;return e===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):e.compareDocumentPosition&&16&e.compareDocumentPosition(r)))}:function(e,t){if(t)while(t=t.parentNode)if(t===e)return!0;return!1},D=t?function(e,t){if(e===t)return f=!0,0;var r=!e.compareDocumentPosition-!t.compareDocumentPosition;return r||(1&(r=(e.ownerDocument||e)===(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!n.sortDetached&&t.compareDocumentPosition(e)===r?e===d||e.ownerDocument===w&&x(w,e)?-1:t===d||t.ownerDocument===w&&x(w,t)?1:c?O(c,e)-O(c,t):0:4&r?-1:1)}:function(e,t){if(e===t)return f=!0,0;var n,r=0,i=e.parentNode,o=t.parentNode,a=[e],s=[t];if(!i||!o)return e===d?-1:t===d?1:i?-1:o?1:c?O(c,e)-O(c,t):0;if(i===o)return ce(e,t);n=e;while(n=n.parentNode)a.unshift(n);n=t;while(n=n.parentNode)s.unshift(n);while(a[r]===s[r])r++;return r?ce(a[r],s[r]):a[r]===w?-1:s[r]===w?1:0},d):d},oe.matches=function(e,t){return oe(e,null,null,t)},oe.matchesSelector=function(e,t){if((e.ownerDocument||e)!==d&&p(e),t=t.replace(z,"='$1']"),n.matchesSelector&&g&&!S[t+" "]&&(!v||!v.test(t))&&(!y||!y.test(t)))try{var r=m.call(e,t);if(r||n.disconnectedMatch||e.document&&11!==e.document.nodeType)return r}catch(e){}return oe(t,d,null,[e]).length>0},oe.contains=function(e,t){return(e.ownerDocument||e)!==d&&p(e),x(e,t)},oe.attr=function(e,t){(e.ownerDocument||e)!==d&&p(e);var i=r.attrHandle[t.toLowerCase()],o=i&&N.call(r.attrHandle,t.toLowerCase())?i(e,t,!g):void 0;return void 0!==o?o:n.attributes||!g?e.getAttribute(t):(o=e.getAttributeNode(t))&&o.specified?o.value:null},oe.escape=function(e){return(e+"").replace(te,ne)},oe.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},oe.uniqueSort=function(e){var t,r=[],i=0,o=0;if(f=!n.detectDuplicates,c=!n.sortStable&&e.slice(0),e.sort(D),f){while(t=e[o++])t===e[o]&&(i=r.push(o));while(i--)e.splice(r[i],1)}return c=null,e},i=oe.getText=function(e){var t,n="",r=0,o=e.nodeType;if(o){if(1===o||9===o||11===o){if("string"==typeof e.textContent)return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=i(e)}else if(3===o||4===o)return e.nodeValue}else while(t=e[r++])n+=i(t);return n},(r=oe.selectors={cacheLength:50,createPseudo:se,match:V,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(Z,ee),e[3]=(e[3]||e[4]||e[5]||"").replace(Z,ee),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||oe.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&oe.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return V.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&X.test(n)&&(t=a(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(Z,ee).toLowerCase();return"*"===e?function(){return!0}:function(e){return e.nodeName&&e.nodeName.toLowerCase()===t}},CLASS:function(e){var t=E[e+" "];return t||(t=new RegExp("(^|"+M+")"+e+"("+M+"|$)"))&&E(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(e,t,n){return function(r){var i=oe.attr(r,e);return null==i?"!="===t:!t||(i+="","="===t?i===n:"!="===t?i!==n:"^="===t?n&&0===i.indexOf(n):"*="===t?n&&i.indexOf(n)>-1:"$="===t?n&&i.slice(-n.length)===n:"~="===t?(" "+i.replace($," ")+" ").indexOf(n)>-1:"|="===t&&(i===n||i.slice(0,n.length+1)===n+"-"))}},CHILD:function(e,t,n,r,i){var o="nth"!==e.slice(0,3),a="last"!==e.slice(-4),s="of-type"===t;return 1===r&&0===i?function(e){return!!e.parentNode}:function(t,n,u){var l,c,f,p,d,h,g=o!==a?"nextSibling":"previousSibling",y=t.parentNode,v=s&&t.nodeName.toLowerCase(),m=!u&&!s,x=!1;if(y){if(o){while(g){p=t;while(p=p[g])if(s?p.nodeName.toLowerCase()===v:1===p.nodeType)return!1;h=g="only"===e&&!h&&"nextSibling"}return!0}if(h=[a?y.firstChild:y.lastChild],a&&m){x=(d=(l=(c=(f=(p=y)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]||[])[0]===T&&l[1])&&l[2],p=d&&y.childNodes[d];while(p=++d&&p&&p[g]||(x=d=0)||h.pop())if(1===p.nodeType&&++x&&p===t){c[e]=[T,d,x];break}}else if(m&&(x=d=(l=(c=(f=(p=t)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]||[])[0]===T&&l[1]),!1===x)while(p=++d&&p&&p[g]||(x=d=0)||h.pop())if((s?p.nodeName.toLowerCase()===v:1===p.nodeType)&&++x&&(m&&((c=(f=p[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[e]=[T,x]),p===t))break;return(x-=i)===r||x%r==0&&x/r>=0}}},PSEUDO:function(e,t){var n,i=r.pseudos[e]||r.setFilters[e.toLowerCase()]||oe.error("unsupported pseudo: "+e);return i[b]?i(t):i.length>1?(n=[e,e,"",t],r.setFilters.hasOwnProperty(e.toLowerCase())?se(function(e,n){var r,o=i(e,t),a=o.length;while(a--)e[r=O(e,o[a])]=!(n[r]=o[a])}):function(e){return i(e,0,n)}):i}},pseudos:{not:se(function(e){var t=[],n=[],r=s(e.replace(B,"$1"));return r[b]?se(function(e,t,n,i){var o,a=r(e,null,i,[]),s=e.length;while(s--)(o=a[s])&&(e[s]=!(t[s]=o))}):function(e,i,o){return t[0]=e,r(t,null,o,n),t[0]=null,!n.pop()}}),has:se(function(e){return function(t){return oe(e,t).length>0}}),contains:se(function(e){return e=e.replace(Z,ee),function(t){return(t.textContent||t.innerText||i(t)).indexOf(e)>-1}}),lang:se(function(e){return U.test(e||"")||oe.error("unsupported lang: "+e),e=e.replace(Z,ee).toLowerCase(),function(t){var n;do{if(n=g?t.lang:t.getAttribute("xml:lang")||t.getAttribute("lang"))return(n=n.toLowerCase())===e||0===n.indexOf(e+"-")}while((t=t.parentNode)&&1===t.nodeType);return!1}}),target:function(t){var n=e.location&&e.location.hash;return n&&n.slice(1)===t.id},root:function(e){return e===h},focus:function(e){return e===d.activeElement&&(!d.hasFocus||d.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},enabled:de(!1),disabled:de(!0),checked:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&!!e.checked||"option"===t&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!r.pseudos.empty(e)},header:function(e){return Y.test(e.nodeName)},input:function(e){return G.test(e.nodeName)},button:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&"button"===e.type||"button"===t},text:function(e){var t;return"input"===e.nodeName.toLowerCase()&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:he(function(){return[0]}),last:he(function(e,t){return[t-1]}),eq:he(function(e,t,n){return[n<0?n+t:n]}),even:he(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:he(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:he(function(e,t,n){for(var r=n<0?n+t:n;--r>=0;)e.push(r);return e}),gt:he(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=r.pseudos.eq;for(t in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})r.pseudos[t]=fe(t);for(t in{submit:!0,reset:!0})r.pseudos[t]=pe(t);function ye(){}ye.prototype=r.filters=r.pseudos,r.setFilters=new ye,a=oe.tokenize=function(e,t){var n,i,o,a,s,u,l,c=k[e+" "];if(c)return t?0:c.slice(0);s=e,u=[],l=r.preFilter;while(s){n&&!(i=F.exec(s))||(i&&(s=s.slice(i[0].length)||s),u.push(o=[])),n=!1,(i=_.exec(s))&&(n=i.shift(),o.push({value:n,type:i[0].replace(B," ")}),s=s.slice(n.length));for(a in r.filter)!(i=V[a].exec(s))||l[a]&&!(i=l[a](i))||(n=i.shift(),o.push({value:n,type:a,matches:i}),s=s.slice(n.length));if(!n)break}return t?s.length:s?oe.error(e):k(e,u).slice(0)};function ve(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function me(e,t,n){var r=t.dir,i=t.next,o=i||r,a=n&&"parentNode"===o,s=C++;return t.first?function(t,n,i){while(t=t[r])if(1===t.nodeType||a)return e(t,n,i);return!1}:function(t,n,u){var l,c,f,p=[T,s];if(u){while(t=t[r])if((1===t.nodeType||a)&&e(t,n,u))return!0}else while(t=t[r])if(1===t.nodeType||a)if(f=t[b]||(t[b]={}),c=f[t.uniqueID]||(f[t.uniqueID]={}),i&&i===t.nodeName.toLowerCase())t=t[r]||t;else{if((l=c[o])&&l[0]===T&&l[1]===s)return p[2]=l[2];if(c[o]=p,p[2]=e(t,n,u))return!0}return!1}}function xe(e){return e.length>1?function(t,n,r){var i=e.length;while(i--)if(!e[i](t,n,r))return!1;return!0}:e[0]}function be(e,t,n){for(var r=0,i=t.length;r<i;r++)oe(e,t[r],n);return n}function we(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function Te(e,t,n,r,i,o){return r&&!r[b]&&(r=Te(r)),i&&!i[b]&&(i=Te(i,o)),se(function(o,a,s,u){var l,c,f,p=[],d=[],h=a.length,g=o||be(t||"*",s.nodeType?[s]:s,[]),y=!e||!o&&t?g:we(g,p,e,s,u),v=n?i||(o?e:h||r)?[]:a:y;if(n&&n(y,v,s,u),r){l=we(v,d),r(l,[],s,u),c=l.length;while(c--)(f=l[c])&&(v[d[c]]=!(y[d[c]]=f))}if(o){if(i||e){if(i){l=[],c=v.length;while(c--)(f=v[c])&&l.push(y[c]=f);i(null,v=[],l,u)}c=v.length;while(c--)(f=v[c])&&(l=i?O(o,f):p[c])>-1&&(o[l]=!(a[l]=f))}}else v=we(v===a?v.splice(h,v.length):v),i?i(null,a,v,u):L.apply(a,v)})}function Ce(e){for(var t,n,i,o=e.length,a=r.relative[e[0].type],s=a||r.relative[" "],u=a?1:0,c=me(function(e){return e===t},s,!0),f=me(function(e){return O(t,e)>-1},s,!0),p=[function(e,n,r){var i=!a&&(r||n!==l)||((t=n).nodeType?c(e,n,r):f(e,n,r));return t=null,i}];u<o;u++)if(n=r.relative[e[u].type])p=[me(xe(p),n)];else{if((n=r.filter[e[u].type].apply(null,e[u].matches))[b]){for(i=++u;i<o;i++)if(r.relative[e[i].type])break;return Te(u>1&&xe(p),u>1&&ve(e.slice(0,u-1).concat({value:" "===e[u-2].type?"*":""})).replace(B,"$1"),n,u<i&&Ce(e.slice(u,i)),i<o&&Ce(e=e.slice(i)),i<o&&ve(e))}p.push(n)}return xe(p)}function Ee(e,t){var n=t.length>0,i=e.length>0,o=function(o,a,s,u,c){var f,h,y,v=0,m="0",x=o&&[],b=[],w=l,C=o||i&&r.find.TAG("*",c),E=T+=null==w?1:Math.random()||.1,k=C.length;for(c&&(l=a===d||a||c);m!==k&&null!=(f=C[m]);m++){if(i&&f){h=0,a||f.ownerDocument===d||(p(f),s=!g);while(y=e[h++])if(y(f,a||d,s)){u.push(f);break}c&&(T=E)}n&&((f=!y&&f)&&v--,o&&x.push(f))}if(v+=m,n&&m!==v){h=0;while(y=t[h++])y(x,b,a,s);if(o){if(v>0)while(m--)x[m]||b[m]||(b[m]=j.call(u));b=we(b)}L.apply(u,b),c&&!o&&b.length>0&&v+t.length>1&&oe.uniqueSort(u)}return c&&(T=E,l=w),x};return n?se(o):o}return s=oe.compile=function(e,t){var n,r=[],i=[],o=S[e+" "];if(!o){t||(t=a(e)),n=t.length;while(n--)(o=Ce(t[n]))[b]?r.push(o):i.push(o);(o=S(e,Ee(i,r))).selector=e}return o},u=oe.select=function(e,t,n,i){var o,u,l,c,f,p="function"==typeof e&&e,d=!i&&a(e=p.selector||e);if(n=n||[],1===d.length){if((u=d[0]=d[0].slice(0)).length>2&&"ID"===(l=u[0]).type&&9===t.nodeType&&g&&r.relative[u[1].type]){if(!(t=(r.find.ID(l.matches[0].replace(Z,ee),t)||[])[0]))return n;p&&(t=t.parentNode),e=e.slice(u.shift().value.length)}o=V.needsContext.test(e)?0:u.length;while(o--){if(l=u[o],r.relative[c=l.type])break;if((f=r.find[c])&&(i=f(l.matches[0].replace(Z,ee),K.test(u[0].type)&&ge(t.parentNode)||t))){if(u.splice(o,1),!(e=i.length&&ve(u)))return L.apply(n,i),n;break}}}return(p||s(e,d))(i,t,!g,n,!t||K.test(e)&&ge(t.parentNode)||t),n},n.sortStable=b.split("").sort(D).join("")===b,n.detectDuplicates=!!f,p(),n.sortDetached=ue(function(e){return 1&e.compareDocumentPosition(d.createElement("fieldset"))}),ue(function(e){return e.innerHTML="<a href='#'></a>","#"===e.firstChild.getAttribute("href")})||le("type|href|height|width",function(e,t,n){if(!n)return e.getAttribute(t,"type"===t.toLowerCase()?1:2)}),n.attributes&&ue(function(e){return e.innerHTML="<input/>",e.firstChild.setAttribute("value",""),""===e.firstChild.getAttribute("value")})||le("value",function(e,t,n){if(!n&&"input"===e.nodeName.toLowerCase())return e.defaultValue}),ue(function(e){return null==e.getAttribute("disabled")})||le(P,function(e,t,n){var r;if(!n)return!0===e[t]?t.toLowerCase():(r=e.getAttributeNode(t))&&r.specified?r.value:null}),oe}(e);w.find=E,w.expr=E.selectors,w.expr[":"]=w.expr.pseudos,w.uniqueSort=w.unique=E.uniqueSort,w.text=E.getText,w.isXMLDoc=E.isXML,w.contains=E.contains,w.escapeSelector=E.escape;var k=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&w(e).is(n))break;r.push(e)}return r},S=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},D=w.expr.match.needsContext;function N(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}var A=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(e,t,n){return g(t)?w.grep(e,function(e,r){return!!t.call(e,r,e)!==n}):t.nodeType?w.grep(e,function(e){return e===t!==n}):"string"!=typeof t?w.grep(e,function(e){return u.call(t,e)>-1!==n}):w.filter(t,e,n)}w.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?w.find.matchesSelector(r,e)?[r]:[]:w.find.matches(e,w.grep(t,function(e){return 1===e.nodeType}))},w.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(w(e).filter(function(){for(t=0;t<r;t++)if(w.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)w.find(e,i[t],n);return r>1?w.uniqueSort(n):n},filter:function(e){return this.pushStack(j(this,e||[],!1))},not:function(e){return this.pushStack(j(this,e||[],!0))},is:function(e){return!!j(this,"string"==typeof e&&D.test(e)?w(e):e||[],!1).length}});var q,L=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(w.fn.init=function(e,t,n){var i,o;if(!e)return this;if(n=n||q,"string"==typeof e){if(!(i="<"===e[0]&&">"===e[e.length-1]&&e.length>=3?[null,e,null]:L.exec(e))||!i[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(i[1]){if(t=t instanceof w?t[0]:t,w.merge(this,w.parseHTML(i[1],t&&t.nodeType?t.ownerDocument||t:r,!0)),A.test(i[1])&&w.isPlainObject(t))for(i in t)g(this[i])?this[i](t[i]):this.attr(i,t[i]);return this}return(o=r.getElementById(i[2]))&&(this[0]=o,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):g(e)?void 0!==n.ready?n.ready(e):e(w):w.makeArray(e,this)}).prototype=w.fn,q=w(r);var H=/^(?:parents|prev(?:Until|All))/,O={children:!0,contents:!0,next:!0,prev:!0};w.fn.extend({has:function(e){var t=w(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(w.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&w(e);if(!D.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?a.index(n)>-1:1===n.nodeType&&w.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(o.length>1?w.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?u.call(w(e),this[0]):u.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(w.uniqueSort(w.merge(this.get(),w(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}});function P(e,t){while((e=e[t])&&1!==e.nodeType);return e}w.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return k(e,"parentNode")},parentsUntil:function(e,t,n){return k(e,"parentNode",n)},next:function(e){return P(e,"nextSibling")},prev:function(e){return P(e,"previousSibling")},nextAll:function(e){return k(e,"nextSibling")},prevAll:function(e){return k(e,"previousSibling")},nextUntil:function(e,t,n){return k(e,"nextSibling",n)},prevUntil:function(e,t,n){return k(e,"previousSibling",n)},siblings:function(e){return S((e.parentNode||{}).firstChild,e)},children:function(e){return S(e.firstChild)},contents:function(e){return N(e,"iframe")?e.contentDocument:(N(e,"template")&&(e=e.content||e),w.merge([],e.childNodes))}},function(e,t){w.fn[e]=function(n,r){var i=w.map(this,t,n);return"Until"!==e.slice(-5)&&(r=n),r&&"string"==typeof r&&(i=w.filter(r,i)),this.length>1&&(O[e]||w.uniqueSort(i),H.test(e)&&i.reverse()),this.pushStack(i)}});var M=/[^\x20\t\r\n\f]+/g;function R(e){var t={};return w.each(e.match(M)||[],function(e,n){t[n]=!0}),t}w.Callbacks=function(e){e="string"==typeof e?R(e):w.extend({},e);var t,n,r,i,o=[],a=[],s=-1,u=function(){for(i=i||e.once,r=t=!0;a.length;s=-1){n=a.shift();while(++s<o.length)!1===o[s].apply(n[0],n[1])&&e.stopOnFalse&&(s=o.length,n=!1)}e.memory||(n=!1),t=!1,i&&(o=n?[]:"")},l={add:function(){return o&&(n&&!t&&(s=o.length-1,a.push(n)),function t(n){w.each(n,function(n,r){g(r)?e.unique&&l.has(r)||o.push(r):r&&r.length&&"string"!==x(r)&&t(r)})}(arguments),n&&!t&&u()),this},remove:function(){return w.each(arguments,function(e,t){var n;while((n=w.inArray(t,o,n))>-1)o.splice(n,1),n<=s&&s--}),this},has:function(e){return e?w.inArray(e,o)>-1:o.length>0},empty:function(){return o&&(o=[]),this},disable:function(){return i=a=[],o=n="",this},disabled:function(){return!o},lock:function(){return i=a=[],n||t||(o=n=""),this},locked:function(){return!!i},fireWith:function(e,n){return i||(n=[e,(n=n||[]).slice?n.slice():n],a.push(n),t||u()),this},fire:function(){return l.fireWith(this,arguments),this},fired:function(){return!!r}};return l};function I(e){return e}function W(e){throw e}function $(e,t,n,r){var i;try{e&&g(i=e.promise)?i.call(e).done(t).fail(n):e&&g(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}w.extend({Deferred:function(t){var n=[["notify","progress",w.Callbacks("memory"),w.Callbacks("memory"),2],["resolve","done",w.Callbacks("once memory"),w.Callbacks("once memory"),0,"resolved"],["reject","fail",w.Callbacks("once memory"),w.Callbacks("once memory"),1,"rejected"]],r="pending",i={state:function(){return r},always:function(){return o.done(arguments).fail(arguments),this},"catch":function(e){return i.then(null,e)},pipe:function(){var e=arguments;return w.Deferred(function(t){w.each(n,function(n,r){var i=g(e[r[4]])&&e[r[4]];o[r[1]](function(){var e=i&&i.apply(this,arguments);e&&g(e.promise)?e.promise().progress(t.notify).done(t.resolve).fail(t.reject):t[r[0]+"With"](this,i?[e]:arguments)})}),e=null}).promise()},then:function(t,r,i){var o=0;function a(t,n,r,i){return function(){var s=this,u=arguments,l=function(){var e,l;if(!(t<o)){if((e=r.apply(s,u))===n.promise())throw new TypeError("Thenable self-resolution");l=e&&("object"==typeof e||"function"==typeof e)&&e.then,g(l)?i?l.call(e,a(o,n,I,i),a(o,n,W,i)):(o++,l.call(e,a(o,n,I,i),a(o,n,W,i),a(o,n,I,n.notifyWith))):(r!==I&&(s=void 0,u=[e]),(i||n.resolveWith)(s,u))}},c=i?l:function(){try{l()}catch(e){w.Deferred.exceptionHook&&w.Deferred.exceptionHook(e,c.stackTrace),t+1>=o&&(r!==W&&(s=void 0,u=[e]),n.rejectWith(s,u))}};t?c():(w.Deferred.getStackHook&&(c.stackTrace=w.Deferred.getStackHook()),e.setTimeout(c))}}return w.Deferred(function(e){n[0][3].add(a(0,e,g(i)?i:I,e.notifyWith)),n[1][3].add(a(0,e,g(t)?t:I)),n[2][3].add(a(0,e,g(r)?r:W))}).promise()},promise:function(e){return null!=e?w.extend(e,i):i}},o={};return w.each(n,function(e,t){var a=t[2],s=t[5];i[t[1]]=a.add,s&&a.add(function(){r=s},n[3-e][2].disable,n[3-e][3].disable,n[0][2].lock,n[0][3].lock),a.add(t[3].fire),o[t[0]]=function(){return o[t[0]+"With"](this===o?void 0:this,arguments),this},o[t[0]+"With"]=a.fireWith}),i.promise(o),t&&t.call(o,o),o},when:function(e){var t=arguments.length,n=t,r=Array(n),i=o.call(arguments),a=w.Deferred(),s=function(e){return function(n){r[e]=this,i[e]=arguments.length>1?o.call(arguments):n,--t||a.resolveWith(r,i)}};if(t<=1&&($(e,a.done(s(n)).resolve,a.reject,!t),"pending"===a.state()||g(i[n]&&i[n].then)))return a.then();while(n--)$(i[n],s(n),a.reject);return a.promise()}});var B=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;w.Deferred.exceptionHook=function(t,n){e.console&&e.console.warn&&t&&B.test(t.name)&&e.console.warn("jQuery.Deferred exception: "+t.message,t.stack,n)},w.readyException=function(t){e.setTimeout(function(){throw t})};var F=w.Deferred();w.fn.ready=function(e){return F.then(e)["catch"](function(e){w.readyException(e)}),this},w.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--w.readyWait:w.isReady)||(w.isReady=!0,!0!==e&&--w.readyWait>0||F.resolveWith(r,[w]))}}),w.ready.then=F.then;function _(){r.removeEventListener("DOMContentLoaded",_),e.removeEventListener("load",_),w.ready()}"complete"===r.readyState||"loading"!==r.readyState&&!r.documentElement.doScroll?e.setTimeout(w.ready):(r.addEventListener("DOMContentLoaded",_),e.addEventListener("load",_));var z=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===x(n)){i=!0;for(s in n)z(e,t,s,n[s],!0,o,a)}else if(void 0!==r&&(i=!0,g(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(w(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},X=/^-ms-/,U=/-([a-z])/g;function V(e,t){return t.toUpperCase()}function G(e){return e.replace(X,"ms-").replace(U,V)}var Y=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function Q(){this.expando=w.expando+Q.uid++}Q.uid=1,Q.prototype={cache:function(e){var t=e[this.expando];return t||(t={},Y(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[G(t)]=n;else for(r in t)i[G(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][G(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(G):(t=G(t))in r?[t]:t.match(M)||[]).length;while(n--)delete r[t[n]]}(void 0===t||w.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!w.isEmptyObject(t)}};var J=new Q,K=new Q,Z=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,ee=/[A-Z]/g;function te(e){return"true"===e||"false"!==e&&("null"===e?null:e===+e+""?+e:Z.test(e)?JSON.parse(e):e)}function ne(e,t,n){var r;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(ee,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n=te(n)}catch(e){}K.set(e,t,n)}else n=void 0;return n}w.extend({hasData:function(e){return K.hasData(e)||J.hasData(e)},data:function(e,t,n){return K.access(e,t,n)},removeData:function(e,t){K.remove(e,t)},_data:function(e,t,n){return J.access(e,t,n)},_removeData:function(e,t){J.remove(e,t)}}),w.fn.extend({data:function(e,t){var n,r,i,o=this[0],a=o&&o.attributes;if(void 0===e){if(this.length&&(i=K.get(o),1===o.nodeType&&!J.get(o,"hasDataAttrs"))){n=a.length;while(n--)a[n]&&0===(r=a[n].name).indexOf("data-")&&(r=G(r.slice(5)),ne(o,r,i[r]));J.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof e?this.each(function(){K.set(this,e)}):z(this,function(t){var n;if(o&&void 0===t){if(void 0!==(n=K.get(o,e)))return n;if(void 0!==(n=ne(o,e)))return n}else this.each(function(){K.set(this,e,t)})},null,t,arguments.length>1,null,!0)},removeData:function(e){return this.each(function(){K.remove(this,e)})}}),w.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=J.get(e,t),n&&(!r||Array.isArray(n)?r=J.access(e,t,w.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=w.queue(e,t),r=n.length,i=n.shift(),o=w._queueHooks(e,t),a=function(){w.dequeue(e,t)};"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,a,o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return J.get(e,n)||J.access(e,n,{empty:w.Callbacks("once memory").add(function(){J.remove(e,[t+"queue",n])})})}}),w.fn.extend({queue:function(e,t){var n=2;return"string"!=typeof e&&(t=e,e="fx",n--),arguments.length<n?w.queue(this[0],e):void 0===t?this:this.each(function(){var n=w.queue(this,e,t);w._queueHooks(this,e),"fx"===e&&"inprogress"!==n[0]&&w.dequeue(this,e)})},dequeue:function(e){return this.each(function(){w.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=w.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=J.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var re=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,ie=new RegExp("^(?:([+-])=|)("+re+")([a-z%]*)$","i"),oe=["Top","Right","Bottom","Left"],ae=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&w.contains(e.ownerDocument,e)&&"none"===w.css(e,"display")},se=function(e,t,n,r){var i,o,a={};for(o in t)a[o]=e.style[o],e.style[o]=t[o];i=n.apply(e,r||[]);for(o in t)e.style[o]=a[o];return i};function ue(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return w.css(e,t,"")},u=s(),l=n&&n[3]||(w.cssNumber[t]?"":"px"),c=(w.cssNumber[t]||"px"!==l&&+u)&&ie.exec(w.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)w.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,w.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var le={};function ce(e){var t,n=e.ownerDocument,r=e.nodeName,i=le[r];return i||(t=n.body.appendChild(n.createElement(r)),i=w.css(t,"display"),t.parentNode.removeChild(t),"none"===i&&(i="block"),le[r]=i,i)}function fe(e,t){for(var n,r,i=[],o=0,a=e.length;o<a;o++)(r=e[o]).style&&(n=r.style.display,t?("none"===n&&(i[o]=J.get(r,"display")||null,i[o]||(r.style.display="")),""===r.style.display&&ae(r)&&(i[o]=ce(r))):"none"!==n&&(i[o]="none",J.set(r,"display",n)));for(o=0;o<a;o++)null!=i[o]&&(e[o].style.display=i[o]);return e}w.fn.extend({show:function(){return fe(this,!0)},hide:function(){return fe(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ae(this)?w(this).show():w(this).hide()})}});var pe=/^(?:checkbox|radio)$/i,de=/<([a-z][^\/\0>\x20\t\r\n\f]+)/i,he=/^$|^module$|\/(?:java|ecma)script/i,ge={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ge.optgroup=ge.option,ge.tbody=ge.tfoot=ge.colgroup=ge.caption=ge.thead,ge.th=ge.td;function ye(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&N(e,t)?w.merge([e],n):n}function ve(e,t){for(var n=0,r=e.length;n<r;n++)J.set(e[n],"globalEval",!t||J.get(t[n],"globalEval"))}var me=/<|&#?\w+;/;function xe(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===x(o))w.merge(p,o.nodeType?[o]:o);else if(me.test(o)){a=a||f.appendChild(t.createElement("div")),s=(de.exec(o)||["",""])[1].toLowerCase(),u=ge[s]||ge._default,a.innerHTML=u[1]+w.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;w.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&w.inArray(o,r)>-1)i&&i.push(o);else if(l=w.contains(o.ownerDocument,o),a=ye(f.appendChild(o),"script"),l&&ve(a),n){c=0;while(o=a[c++])he.test(o.type||"")&&n.push(o)}return f}!function(){var e=r.createDocumentFragment().appendChild(r.createElement("div")),t=r.createElement("input");t.setAttribute("type","radio"),t.setAttribute("checked","checked"),t.setAttribute("name","t"),e.appendChild(t),h.checkClone=e.cloneNode(!0).cloneNode(!0).lastChild.checked,e.innerHTML="<textarea>x</textarea>",h.noCloneChecked=!!e.cloneNode(!0).lastChild.defaultValue}();var be=r.documentElement,we=/^key/,Te=/^(?:mouse|pointer|contextmenu|drag|drop)|click/,Ce=/^([^.]*)(?:\.(.+)|)/;function Ee(){return!0}function ke(){return!1}function Se(){try{return r.activeElement}catch(e){}}function De(e,t,n,r,i,o){var a,s;if("object"==typeof t){"string"!=typeof n&&(r=r||n,n=void 0);for(s in t)De(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=ke;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return w().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=w.guid++)),e.each(function(){w.event.add(this,t,i,r,n)})}w.event={global:{},add:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,y=J.get(e);if(y){n.handler&&(n=(o=n).handler,i=o.selector),i&&w.find.matchesSelector(be,i),n.guid||(n.guid=w.guid++),(u=y.events)||(u=y.events={}),(a=y.handle)||(a=y.handle=function(t){return"undefined"!=typeof w&&w.event.triggered!==t.type?w.event.dispatch.apply(e,arguments):void 0}),l=(t=(t||"").match(M)||[""]).length;while(l--)d=g=(s=Ce.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=w.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=w.event.special[d]||{},c=w.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&w.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(e,r,h,a)||e.addEventListener&&e.addEventListener(d,a)),f.add&&(f.add.call(e,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),w.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,y=J.hasData(e)&&J.get(e);if(y&&(u=y.events)){l=(t=(t||"").match(M)||[""]).length;while(l--)if(s=Ce.exec(t[l])||[],d=g=s[1],h=(s[2]||"").split(".").sort(),d){f=w.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,y.handle)||w.removeEvent(e,d,y.handle),delete u[d])}else for(d in u)w.event.remove(e,d+t[l],n,r,!0);w.isEmptyObject(u)&&J.remove(e,"handle events")}},dispatch:function(e){var t=w.event.fix(e),n,r,i,o,a,s,u=new Array(arguments.length),l=(J.get(this,"events")||{})[t.type]||[],c=w.event.special[t.type]||{};for(u[0]=t,n=1;n<arguments.length;n++)u[n]=arguments[n];if(t.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,t)){s=w.event.handlers.call(this,t,l),n=0;while((o=s[n++])&&!t.isPropagationStopped()){t.currentTarget=o.elem,r=0;while((a=o.handlers[r++])&&!t.isImmediatePropagationStopped())t.rnamespace&&!t.rnamespace.test(a.namespace)||(t.handleObj=a,t.data=a.data,void 0!==(i=((w.event.special[a.origType]||{}).handle||a.handler).apply(o.elem,u))&&!1===(t.result=i)&&(t.preventDefault(),t.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,t),t.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&e.button>=1))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?w(i,this).index(l)>-1:w.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(e,t){Object.defineProperty(w.Event.prototype,e,{enumerable:!0,configurable:!0,get:g(t)?function(){if(this.originalEvent)return t(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[e]},set:function(t){Object.defineProperty(this,e,{enumerable:!0,configurable:!0,writable:!0,value:t})}})},fix:function(e){return e[w.expando]?e:new w.Event(e)},special:{load:{noBubble:!0},focus:{trigger:function(){if(this!==Se()&&this.focus)return this.focus(),!1},delegateType:"focusin"},blur:{trigger:function(){if(this===Se()&&this.blur)return this.blur(),!1},delegateType:"focusout"},click:{trigger:function(){if("checkbox"===this.type&&this.click&&N(this,"input"))return this.click(),!1},_default:function(e){return N(e.target,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},w.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},w.Event=function(e,t){if(!(this instanceof w.Event))return new w.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?Ee:ke,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&w.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[w.expando]=!0},w.Event.prototype={constructor:w.Event,isDefaultPrevented:ke,isPropagationStopped:ke,isImmediatePropagationStopped:ke,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=Ee,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=Ee,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=Ee,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},w.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:function(e){var t=e.button;return null==e.which&&we.test(e.type)?null!=e.charCode?e.charCode:e.keyCode:!e.which&&void 0!==t&&Te.test(e.type)?1&t?1:2&t?3:4&t?2:0:e.which}},w.event.addProp),w.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,t){w.event.special[e]={delegateType:t,bindType:t,handle:function(e){var n,r=this,i=e.relatedTarget,o=e.handleObj;return i&&(i===r||w.contains(r,i))||(e.type=o.origType,n=o.handler.apply(this,arguments),e.type=t),n}}}),w.fn.extend({on:function(e,t,n,r){return De(this,e,t,n,r)},one:function(e,t,n,r){return De(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,w(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=ke),this.each(function(){w.event.remove(this,e,n,t)})}});var Ne=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,Ae=/<script|<style|<link/i,je=/checked\s*(?:[^=]|=\s*.checked.)/i,qe=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function Le(e,t){return N(e,"table")&&N(11!==t.nodeType?t:t.firstChild,"tr")?w(e).children("tbody")[0]||e:e}function He(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function Oe(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Pe(e,t){var n,r,i,o,a,s,u,l;if(1===t.nodeType){if(J.hasData(e)&&(o=J.access(e),a=J.set(t,o),l=o.events)){delete a.handle,a.events={};for(i in l)for(n=0,r=l[i].length;n<r;n++)w.event.add(t,i,l[i][n])}K.hasData(e)&&(s=K.access(e),u=w.extend({},s),K.set(t,u))}}function Me(e,t){var n=t.nodeName.toLowerCase();"input"===n&&pe.test(e.type)?t.checked=e.checked:"input"!==n&&"textarea"!==n||(t.defaultValue=e.defaultValue)}function Re(e,t,n,r){t=a.apply([],t);var i,o,s,u,l,c,f=0,p=e.length,d=p-1,y=t[0],v=g(y);if(v||p>1&&"string"==typeof y&&!h.checkClone&&je.test(y))return e.each(function(i){var o=e.eq(i);v&&(t[0]=y.call(this,i,o.html())),Re(o,t,n,r)});if(p&&(i=xe(t,e[0].ownerDocument,!1,e,r),o=i.firstChild,1===i.childNodes.length&&(i=o),o||r)){for(u=(s=w.map(ye(i,"script"),He)).length;f<p;f++)l=i,f!==d&&(l=w.clone(l,!0,!0),u&&w.merge(s,ye(l,"script"))),n.call(e[f],l,f);if(u)for(c=s[s.length-1].ownerDocument,w.map(s,Oe),f=0;f<u;f++)l=s[f],he.test(l.type||"")&&!J.access(l,"globalEval")&&w.contains(c,l)&&(l.src&&"module"!==(l.type||"").toLowerCase()?w._evalUrl&&w._evalUrl(l.src):m(l.textContent.replace(qe,""),c,l))}return e}function Ie(e,t,n){for(var r,i=t?w.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||w.cleanData(ye(r)),r.parentNode&&(n&&w.contains(r.ownerDocument,r)&&ve(ye(r,"script")),r.parentNode.removeChild(r));return e}w.extend({htmlPrefilter:function(e){return e.replace(Ne,"<$1></$2>")},clone:function(e,t,n){var r,i,o,a,s=e.cloneNode(!0),u=w.contains(e.ownerDocument,e);if(!(h.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||w.isXMLDoc(e)))for(a=ye(s),r=0,i=(o=ye(e)).length;r<i;r++)Me(o[r],a[r]);if(t)if(n)for(o=o||ye(e),a=a||ye(s),r=0,i=o.length;r<i;r++)Pe(o[r],a[r]);else Pe(e,s);return(a=ye(s,"script")).length>0&&ve(a,!u&&ye(e,"script")),s},cleanData:function(e){for(var t,n,r,i=w.event.special,o=0;void 0!==(n=e[o]);o++)if(Y(n)){if(t=n[J.expando]){if(t.events)for(r in t.events)i[r]?w.event.remove(n,r):w.removeEvent(n,r,t.handle);n[J.expando]=void 0}n[K.expando]&&(n[K.expando]=void 0)}}}),w.fn.extend({detach:function(e){return Ie(this,e,!0)},remove:function(e){return Ie(this,e)},text:function(e){return z(this,function(e){return void 0===e?w.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return Re(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||Le(this,e).appendChild(e)})},prepend:function(){return Re(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=Le(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return Re(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return Re(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(w.cleanData(ye(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return w.clone(this,e,t)})},html:function(e){return z(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!Ae.test(e)&&!ge[(de.exec(e)||["",""])[1].toLowerCase()]){e=w.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(w.cleanData(ye(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var e=[];return Re(this,arguments,function(t){var n=this.parentNode;w.inArray(this,e)<0&&(w.cleanData(ye(this)),n&&n.replaceChild(t,this))},e)}}),w.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,t){w.fn[e]=function(e){for(var n,r=[],i=w(e),o=i.length-1,a=0;a<=o;a++)n=a===o?this:this.clone(!0),w(i[a])[t](n),s.apply(r,n.get());return this.pushStack(r)}});var We=new RegExp("^("+re+")(?!px)[a-z%]+$","i"),$e=function(t){var n=t.ownerDocument.defaultView;return n&&n.opener||(n=e),n.getComputedStyle(t)},Be=new RegExp(oe.join("|"),"i");!function(){function t(){if(c){l.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",c.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",be.appendChild(l).appendChild(c);var t=e.getComputedStyle(c);i="1%"!==t.top,u=12===n(t.marginLeft),c.style.right="60%",s=36===n(t.right),o=36===n(t.width),c.style.position="absolute",a=36===c.offsetWidth||"absolute",be.removeChild(l),c=null}}function n(e){return Math.round(parseFloat(e))}var i,o,a,s,u,l=r.createElement("div"),c=r.createElement("div");c.style&&(c.style.backgroundClip="content-box",c.cloneNode(!0).style.backgroundClip="",h.clearCloneStyle="content-box"===c.style.backgroundClip,w.extend(h,{boxSizingReliable:function(){return t(),o},pixelBoxStyles:function(){return t(),s},pixelPosition:function(){return t(),i},reliableMarginLeft:function(){return t(),u},scrollboxSize:function(){return t(),a}}))}();function Fe(e,t,n){var r,i,o,a,s=e.style;return(n=n||$e(e))&&(""!==(a=n.getPropertyValue(t)||n[t])||w.contains(e.ownerDocument,e)||(a=w.style(e,t)),!h.pixelBoxStyles()&&We.test(a)&&Be.test(t)&&(r=s.width,i=s.minWidth,o=s.maxWidth,s.minWidth=s.maxWidth=s.width=a,a=n.width,s.width=r,s.minWidth=i,s.maxWidth=o)),void 0!==a?a+"":a}function _e(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}var ze=/^(none|table(?!-c[ea]).+)/,Xe=/^--/,Ue={position:"absolute",visibility:"hidden",display:"block"},Ve={letterSpacing:"0",fontWeight:"400"},Ge=["Webkit","Moz","ms"],Ye=r.createElement("div").style;function Qe(e){if(e in Ye)return e;var t=e[0].toUpperCase()+e.slice(1),n=Ge.length;while(n--)if((e=Ge[n]+t)in Ye)return e}function Je(e){var t=w.cssProps[e];return t||(t=w.cssProps[e]=Qe(e)||e),t}function Ke(e,t,n){var r=ie.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function Ze(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(u+=w.css(e,n+oe[a],!0,i)),r?("content"===n&&(u-=w.css(e,"padding"+oe[a],!0,i)),"margin"!==n&&(u-=w.css(e,"border"+oe[a]+"Width",!0,i))):(u+=w.css(e,"padding"+oe[a],!0,i),"padding"!==n?u+=w.css(e,"border"+oe[a]+"Width",!0,i):s+=w.css(e,"border"+oe[a]+"Width",!0,i));return!r&&o>=0&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))),u}function et(e,t,n){var r=$e(e),i=Fe(e,t,r),o="border-box"===w.css(e,"boxSizing",!1,r),a=o;if(We.test(i)){if(!n)return i;i="auto"}return a=a&&(h.boxSizingReliable()||i===e.style[t]),("auto"===i||!parseFloat(i)&&"inline"===w.css(e,"display",!1,r))&&(i=e["offset"+t[0].toUpperCase()+t.slice(1)],a=!0),(i=parseFloat(i)||0)+Ze(e,t,n||(o?"border":"content"),a,r,i)+"px"}w.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=Fe(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=G(t),u=Xe.test(t),l=e.style;if(u||(t=Je(s)),a=w.cssHooks[t]||w.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"==(o=typeof n)&&(i=ie.exec(n))&&i[1]&&(n=ue(e,t,i),o="number"),null!=n&&n===n&&("number"===o&&(n+=i&&i[3]||(w.cssNumber[s]?"":"px")),h.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=G(t);return Xe.test(t)||(t=Je(s)),(a=w.cssHooks[t]||w.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=Fe(e,t,r)),"normal"===i&&t in Ve&&(i=Ve[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),w.each(["height","width"],function(e,t){w.cssHooks[t]={get:function(e,n,r){if(n)return!ze.test(w.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?et(e,t,r):se(e,Ue,function(){return et(e,t,r)})},set:function(e,n,r){var i,o=$e(e),a="border-box"===w.css(e,"boxSizing",!1,o),s=r&&Ze(e,t,r,a,o);return a&&h.scrollboxSize()===o.position&&(s-=Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-parseFloat(o[t])-Ze(e,t,"border",!1,o)-.5)),s&&(i=ie.exec(n))&&"px"!==(i[3]||"px")&&(e.style[t]=n,n=w.css(e,t)),Ke(e,n,s)}}}),w.cssHooks.marginLeft=_e(h.reliableMarginLeft,function(e,t){if(t)return(parseFloat(Fe(e,"marginLeft"))||e.getBoundingClientRect().left-se(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),w.each({margin:"",padding:"",border:"Width"},function(e,t){w.cssHooks[e+t]={expand:function(n){for(var r=0,i={},o="string"==typeof n?n.split(" "):[n];r<4;r++)i[e+oe[r]+t]=o[r]||o[r-2]||o[0];return i}},"margin"!==e&&(w.cssHooks[e+t].set=Ke)}),w.fn.extend({css:function(e,t){return z(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=$e(e),i=t.length;a<i;a++)o[t[a]]=w.css(e,t[a],!1,r);return o}return void 0!==n?w.style(e,t,n):w.css(e,t)},e,t,arguments.length>1)}});function tt(e,t,n,r,i){return new tt.prototype.init(e,t,n,r,i)}w.Tween=tt,tt.prototype={constructor:tt,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||w.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(w.cssNumber[n]?"":"px")},cur:function(){var e=tt.propHooks[this.prop];return e&&e.get?e.get(this):tt.propHooks._default.get(this)},run:function(e){var t,n=tt.propHooks[this.prop];return this.options.duration?this.pos=t=w.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):tt.propHooks._default.set(this),this}},tt.prototype.init.prototype=tt.prototype,tt.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=w.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){w.fx.step[e.prop]?w.fx.step[e.prop](e):1!==e.elem.nodeType||null==e.elem.style[w.cssProps[e.prop]]&&!w.cssHooks[e.prop]?e.elem[e.prop]=e.now:w.style(e.elem,e.prop,e.now+e.unit)}}},tt.propHooks.scrollTop=tt.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},w.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},w.fx=tt.prototype.init,w.fx.step={};var nt,rt,it=/^(?:toggle|show|hide)$/,ot=/queueHooks$/;function at(){rt&&(!1===r.hidden&&e.requestAnimationFrame?e.requestAnimationFrame(at):e.setTimeout(at,w.fx.interval),w.fx.tick())}function st(){return e.setTimeout(function(){nt=void 0}),nt=Date.now()}function ut(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=oe[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function lt(e,t,n){for(var r,i=(pt.tweeners[t]||[]).concat(pt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function ct(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ae(e),y=J.get(e,"fxshow");n.queue||(null==(a=w._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,w.queue(e,"fx").length||a.empty.fire()})}));for(r in t)if(i=t[r],it.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!y||void 0===y[r])continue;g=!0}d[r]=y&&y[r]||w.style(e,r)}if((u=!w.isEmptyObject(t))||!w.isEmptyObject(d)){f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=y&&y.display)&&(l=J.get(e,"display")),"none"===(c=w.css(e,"display"))&&(l?c=l:(fe([e],!0),l=e.style.display||l,c=w.css(e,"display"),fe([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===w.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1;for(r in d)u||(y?"hidden"in y&&(g=y.hidden):y=J.access(e,"fxshow",{display:l}),o&&(y.hidden=!g),g&&fe([e],!0),p.done(function(){g||fe([e]),J.remove(e,"fxshow");for(r in d)w.style(e,r,d[r])})),u=lt(g?y[r]:0,r,p),r in y||(y[r]=u.start,g&&(u.end=u.start,u.start=0))}}function ft(e,t){var n,r,i,o,a;for(n in e)if(r=G(n),i=t[r],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=w.cssHooks[r])&&"expand"in a){o=a.expand(o),delete e[r];for(n in o)n in e||(e[n]=o[n],t[n]=i)}else t[r]=i}function pt(e,t,n){var r,i,o=0,a=pt.prefilters.length,s=w.Deferred().always(function(){delete u.elem}),u=function(){if(i)return!1;for(var t=nt||st(),n=Math.max(0,l.startTime+l.duration-t),r=1-(n/l.duration||0),o=0,a=l.tweens.length;o<a;o++)l.tweens[o].run(r);return s.notifyWith(e,[l,r,n]),r<1&&a?n:(a||s.notifyWith(e,[l,1,0]),s.resolveWith(e,[l]),!1)},l=s.promise({elem:e,props:w.extend({},t),opts:w.extend(!0,{specialEasing:{},easing:w.easing._default},n),originalProperties:t,originalOptions:n,startTime:nt||st(),duration:n.duration,tweens:[],createTween:function(t,n){var r=w.Tween(e,l.opts,t,n,l.opts.specialEasing[t]||l.opts.easing);return l.tweens.push(r),r},stop:function(t){var n=0,r=t?l.tweens.length:0;if(i)return this;for(i=!0;n<r;n++)l.tweens[n].run(1);return t?(s.notifyWith(e,[l,1,0]),s.resolveWith(e,[l,t])):s.rejectWith(e,[l,t]),this}}),c=l.props;for(ft(c,l.opts.specialEasing);o<a;o++)if(r=pt.prefilters[o].call(l,e,c,l.opts))return g(r.stop)&&(w._queueHooks(l.elem,l.opts.queue).stop=r.stop.bind(r)),r;return w.map(c,lt,l),g(l.opts.start)&&l.opts.start.call(e,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),w.fx.timer(w.extend(u,{elem:e,anim:l,queue:l.opts.queue})),l}w.Animation=w.extend(pt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return ue(n.elem,e,ie.exec(t),n),n}]},tweener:function(e,t){g(e)?(t=e,e=["*"]):e=e.match(M);for(var n,r=0,i=e.length;r<i;r++)n=e[r],pt.tweeners[n]=pt.tweeners[n]||[],pt.tweeners[n].unshift(t)},prefilters:[ct],prefilter:function(e,t){t?pt.prefilters.unshift(e):pt.prefilters.push(e)}}),w.speed=function(e,t,n){var r=e&&"object"==typeof e?w.extend({},e):{complete:n||!n&&t||g(e)&&e,duration:e,easing:n&&t||t&&!g(t)&&t};return w.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in w.fx.speeds?r.duration=w.fx.speeds[r.duration]:r.duration=w.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){g(r.old)&&r.old.call(this),r.queue&&w.dequeue(this,r.queue)},r},w.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ae).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(e,t,n,r){var i=w.isEmptyObject(e),o=w.speed(t,n,r),a=function(){var t=pt(this,w.extend({},e),o);(i||J.get(this,"finish"))&&t.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(e,t,n){var r=function(e){var t=e.stop;delete e.stop,t(n)};return"string"!=typeof e&&(n=t,t=e,e=void 0),t&&!1!==e&&this.queue(e||"fx",[]),this.each(function(){var t=!0,i=null!=e&&e+"queueHooks",o=w.timers,a=J.get(this);if(i)a[i]&&a[i].stop&&r(a[i]);else for(i in a)a[i]&&a[i].stop&&ot.test(i)&&r(a[i]);for(i=o.length;i--;)o[i].elem!==this||null!=e&&o[i].queue!==e||(o[i].anim.stop(n),t=!1,o.splice(i,1));!t&&n||w.dequeue(this,e)})},finish:function(e){return!1!==e&&(e=e||"fx"),this.each(function(){var t,n=J.get(this),r=n[e+"queue"],i=n[e+"queueHooks"],o=w.timers,a=r?r.length:0;for(n.finish=!0,w.queue(this,e,[]),i&&i.stop&&i.stop.call(this,!0),t=o.length;t--;)o[t].elem===this&&o[t].queue===e&&(o[t].anim.stop(!0),o.splice(t,1));for(t=0;t<a;t++)r[t]&&r[t].finish&&r[t].finish.call(this);delete n.finish})}}),w.each(["toggle","show","hide"],function(e,t){var n=w.fn[t];w.fn[t]=function(e,r,i){return null==e||"boolean"==typeof e?n.apply(this,arguments):this.animate(ut(t,!0),e,r,i)}}),w.each({slideDown:ut("show"),slideUp:ut("hide"),slideToggle:ut("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,t){w.fn[e]=function(e,n,r){return this.animate(t,e,n,r)}}),w.timers=[],w.fx.tick=function(){var e,t=0,n=w.timers;for(nt=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||w.fx.stop(),nt=void 0},w.fx.timer=function(e){w.timers.push(e),w.fx.start()},w.fx.interval=13,w.fx.start=function(){rt||(rt=!0,at())},w.fx.stop=function(){rt=null},w.fx.speeds={slow:600,fast:200,_default:400},w.fn.delay=function(t,n){return t=w.fx?w.fx.speeds[t]||t:t,n=n||"fx",this.queue(n,function(n,r){var i=e.setTimeout(n,t);r.stop=function(){e.clearTimeout(i)}})},function(){var e=r.createElement("input"),t=r.createElement("select").appendChild(r.createElement("option"));e.type="checkbox",h.checkOn=""!==e.value,h.optSelected=t.selected,(e=r.createElement("input")).value="t",e.type="radio",h.radioValue="t"===e.value}();var dt,ht=w.expr.attrHandle;w.fn.extend({attr:function(e,t){return z(this,w.attr,e,t,arguments.length>1)},removeAttr:function(e){return this.each(function(){w.removeAttr(this,e)})}}),w.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?w.prop(e,t,n):(1===o&&w.isXMLDoc(e)||(i=w.attrHooks[t.toLowerCase()]||(w.expr.match.bool.test(t)?dt:void 0)),void 0!==n?null===n?void w.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=w.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!h.radioValue&&"radio"===t&&N(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(M);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),dt={set:function(e,t,n){return!1===t?w.removeAttr(e,n):e.setAttribute(n,n),n}},w.each(w.expr.match.bool.source.match(/\w+/g),function(e,t){var n=ht[t]||w.find.attr;ht[t]=function(e,t,r){var i,o,a=t.toLowerCase();return r||(o=ht[a],ht[a]=i,i=null!=n(e,t,r)?a:null,ht[a]=o),i}});var gt=/^(?:input|select|textarea|button)$/i,yt=/^(?:a|area)$/i;w.fn.extend({prop:function(e,t){return z(this,w.prop,e,t,arguments.length>1)},removeProp:function(e){return this.each(function(){delete this[w.propFix[e]||e]})}}),w.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&w.isXMLDoc(e)||(t=w.propFix[t]||t,i=w.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=w.find.attr(e,"tabindex");return t?parseInt(t,10):gt.test(e.nodeName)||yt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),h.optSelected||(w.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),w.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){w.propFix[this.toLowerCase()]=this});function vt(e){return(e.match(M)||[]).join(" ")}function mt(e){return e.getAttribute&&e.getAttribute("class")||""}function xt(e){return Array.isArray(e)?e:"string"==typeof e?e.match(M)||[]:[]}w.fn.extend({addClass:function(e){var t,n,r,i,o,a,s,u=0;if(g(e))return this.each(function(t){w(this).addClass(e.call(this,t,mt(this)))});if((t=xt(e)).length)while(n=this[u++])if(i=mt(n),r=1===n.nodeType&&" "+vt(i)+" "){a=0;while(o=t[a++])r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(s=vt(r))&&n.setAttribute("class",s)}return this},removeClass:function(e){var t,n,r,i,o,a,s,u=0;if(g(e))return this.each(function(t){w(this).removeClass(e.call(this,t,mt(this)))});if(!arguments.length)return this.attr("class","");if((t=xt(e)).length)while(n=this[u++])if(i=mt(n),r=1===n.nodeType&&" "+vt(i)+" "){a=0;while(o=t[a++])while(r.indexOf(" "+o+" ")>-1)r=r.replace(" "+o+" "," ");i!==(s=vt(r))&&n.setAttribute("class",s)}return this},toggleClass:function(e,t){var n=typeof e,r="string"===n||Array.isArray(e);return"boolean"==typeof t&&r?t?this.addClass(e):this.removeClass(e):g(e)?this.each(function(n){w(this).toggleClass(e.call(this,n,mt(this),t),t)}):this.each(function(){var t,i,o,a;if(r){i=0,o=w(this),a=xt(e);while(t=a[i++])o.hasClass(t)?o.removeClass(t):o.addClass(t)}else void 0!==e&&"boolean"!==n||((t=mt(this))&&J.set(this,"__className__",t),this.setAttribute&&this.setAttribute("class",t||!1===e?"":J.get(this,"__className__")||""))})},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&(" "+vt(mt(n))+" ").indexOf(t)>-1)return!0;return!1}});var bt=/\r/g;w.fn.extend({val:function(e){var t,n,r,i=this[0];{if(arguments.length)return r=g(e),this.each(function(n){var i;1===this.nodeType&&(null==(i=r?e.call(this,n,w(this).val()):e)?i="":"number"==typeof i?i+="":Array.isArray(i)&&(i=w.map(i,function(e){return null==e?"":e+""})),(t=w.valHooks[this.type]||w.valHooks[this.nodeName.toLowerCase()])&&"set"in t&&void 0!==t.set(this,i,"value")||(this.value=i))});if(i)return(t=w.valHooks[i.type]||w.valHooks[i.nodeName.toLowerCase()])&&"get"in t&&void 0!==(n=t.get(i,"value"))?n:"string"==typeof(n=i.value)?n.replace(bt,""):null==n?"":n}}}),w.extend({valHooks:{option:{get:function(e){var t=w.find.attr(e,"value");return null!=t?t:vt(w.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!N(n.parentNode,"optgroup"))){if(t=w(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=w.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=w.inArray(w.valHooks.option.get(r),o)>-1)&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),w.each(["radio","checkbox"],function(){w.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=w.inArray(w(e).val(),t)>-1}},h.checkOn||(w.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})}),h.focusin="onfocusin"in e;var wt=/^(?:focusinfocus|focusoutblur)$/,Tt=function(e){e.stopPropagation()};w.extend(w.event,{trigger:function(t,n,i,o){var a,s,u,l,c,p,d,h,v=[i||r],m=f.call(t,"type")?t.type:t,x=f.call(t,"namespace")?t.namespace.split("."):[];if(s=h=u=i=i||r,3!==i.nodeType&&8!==i.nodeType&&!wt.test(m+w.event.triggered)&&(m.indexOf(".")>-1&&(m=(x=m.split(".")).shift(),x.sort()),c=m.indexOf(":")<0&&"on"+m,t=t[w.expando]?t:new w.Event(m,"object"==typeof t&&t),t.isTrigger=o?2:3,t.namespace=x.join("."),t.rnamespace=t.namespace?new RegExp("(^|\\.)"+x.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,t.result=void 0,t.target||(t.target=i),n=null==n?[t]:w.makeArray(n,[t]),d=w.event.special[m]||{},o||!d.trigger||!1!==d.trigger.apply(i,n))){if(!o&&!d.noBubble&&!y(i)){for(l=d.delegateType||m,wt.test(l+m)||(s=s.parentNode);s;s=s.parentNode)v.push(s),u=s;u===(i.ownerDocument||r)&&v.push(u.defaultView||u.parentWindow||e)}a=0;while((s=v[a++])&&!t.isPropagationStopped())h=s,t.type=a>1?l:d.bindType||m,(p=(J.get(s,"events")||{})[t.type]&&J.get(s,"handle"))&&p.apply(s,n),(p=c&&s[c])&&p.apply&&Y(s)&&(t.result=p.apply(s,n),!1===t.result&&t.preventDefault());return t.type=m,o||t.isDefaultPrevented()||d._default&&!1!==d._default.apply(v.pop(),n)||!Y(i)||c&&g(i[m])&&!y(i)&&((u=i[c])&&(i[c]=null),w.event.triggered=m,t.isPropagationStopped()&&h.addEventListener(m,Tt),i[m](),t.isPropagationStopped()&&h.removeEventListener(m,Tt),w.event.triggered=void 0,u&&(i[c]=u)),t.result}},simulate:function(e,t,n){var r=w.extend(new w.Event,n,{type:e,isSimulated:!0});w.event.trigger(r,null,t)}}),w.fn.extend({trigger:function(e,t){return this.each(function(){w.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return w.event.trigger(e,t,n,!0)}}),h.focusin||w.each({focus:"focusin",blur:"focusout"},function(e,t){var n=function(e){w.event.simulate(t,e.target,w.event.fix(e))};w.event.special[t]={setup:function(){var r=this.ownerDocument||this,i=J.access(r,t);i||r.addEventListener(e,n,!0),J.access(r,t,(i||0)+1)},teardown:function(){var r=this.ownerDocument||this,i=J.access(r,t)-1;i?J.access(r,t,i):(r.removeEventListener(e,n,!0),J.remove(r,t))}}});var Ct=e.location,Et=Date.now(),kt=/\?/;w.parseXML=function(t){var n;if(!t||"string"!=typeof t)return null;try{n=(new e.DOMParser).parseFromString(t,"text/xml")}catch(e){n=void 0}return n&&!n.getElementsByTagName("parsererror").length||w.error("Invalid XML: "+t),n};var St=/\[\]$/,Dt=/\r?\n/g,Nt=/^(?:submit|button|image|reset|file)$/i,At=/^(?:input|select|textarea|keygen)/i;function jt(e,t,n,r){var i;if(Array.isArray(t))w.each(t,function(t,i){n||St.test(e)?r(e,i):jt(e+"["+("object"==typeof i&&null!=i?t:"")+"]",i,n,r)});else if(n||"object"!==x(t))r(e,t);else for(i in t)jt(e+"["+i+"]",t[i],n,r)}w.param=function(e,t){var n,r=[],i=function(e,t){var n=g(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(Array.isArray(e)||e.jquery&&!w.isPlainObject(e))w.each(e,function(){i(this.name,this.value)});else for(n in e)jt(n,e[n],t,i);return r.join("&")},w.fn.extend({serialize:function(){return w.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=w.prop(this,"elements");return e?w.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!w(this).is(":disabled")&&At.test(this.nodeName)&&!Nt.test(e)&&(this.checked||!pe.test(e))}).map(function(e,t){var n=w(this).val();return null==n?null:Array.isArray(n)?w.map(n,function(e){return{name:t.name,value:e.replace(Dt,"\r\n")}}):{name:t.name,value:n.replace(Dt,"\r\n")}}).get()}});var qt=/%20/g,Lt=/#.*$/,Ht=/([?&])_=[^&]*/,Ot=/^(.*?):[ \t]*([^\r\n]*)$/gm,Pt=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,Mt=/^(?:GET|HEAD)$/,Rt=/^\/\//,It={},Wt={},$t="*/".concat("*"),Bt=r.createElement("a");Bt.href=Ct.href;function Ft(e){return function(t,n){"string"!=typeof t&&(n=t,t="*");var r,i=0,o=t.toLowerCase().match(M)||[];if(g(n))while(r=o[i++])"+"===r[0]?(r=r.slice(1)||"*",(e[r]=e[r]||[]).unshift(n)):(e[r]=e[r]||[]).push(n)}}function _t(e,t,n,r){var i={},o=e===Wt;function a(s){var u;return i[s]=!0,w.each(e[s]||[],function(e,s){var l=s(t,n,r);return"string"!=typeof l||o||i[l]?o?!(u=l):void 0:(t.dataTypes.unshift(l),a(l),!1)}),u}return a(t.dataTypes[0])||!i["*"]&&a("*")}function zt(e,t){var n,r,i=w.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&w.extend(!0,e,r),e}function Xt(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}function Ut(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}w.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:Ct.href,type:"GET",isLocal:Pt.test(Ct.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":$t,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":w.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?zt(zt(e,w.ajaxSettings),t):zt(w.ajaxSettings,e)},ajaxPrefilter:Ft(It),ajaxTransport:Ft(Wt),ajax:function(t,n){"object"==typeof t&&(n=t,t=void 0),n=n||{};var i,o,a,s,u,l,c,f,p,d,h=w.ajaxSetup({},n),g=h.context||h,y=h.context&&(g.nodeType||g.jquery)?w(g):w.event,v=w.Deferred(),m=w.Callbacks("once memory"),x=h.statusCode||{},b={},T={},C="canceled",E={readyState:0,getResponseHeader:function(e){var t;if(c){if(!s){s={};while(t=Ot.exec(a))s[t[1].toLowerCase()]=t[2]}t=s[e.toLowerCase()]}return null==t?null:t},getAllResponseHeaders:function(){return c?a:null},setRequestHeader:function(e,t){return null==c&&(e=T[e.toLowerCase()]=T[e.toLowerCase()]||e,b[e]=t),this},overrideMimeType:function(e){return null==c&&(h.mimeType=e),this},statusCode:function(e){var t;if(e)if(c)E.always(e[E.status]);else for(t in e)x[t]=[x[t],e[t]];return this},abort:function(e){var t=e||C;return i&&i.abort(t),k(0,t),this}};if(v.promise(E),h.url=((t||h.url||Ct.href)+"").replace(Rt,Ct.protocol+"//"),h.type=n.method||n.type||h.method||h.type,h.dataTypes=(h.dataType||"*").toLowerCase().match(M)||[""],null==h.crossDomain){l=r.createElement("a");try{l.href=h.url,l.href=l.href,h.crossDomain=Bt.protocol+"//"+Bt.host!=l.protocol+"//"+l.host}catch(e){h.crossDomain=!0}}if(h.data&&h.processData&&"string"!=typeof h.data&&(h.data=w.param(h.data,h.traditional)),_t(It,h,n,E),c)return E;(f=w.event&&h.global)&&0==w.active++&&w.event.trigger("ajaxStart"),h.type=h.type.toUpperCase(),h.hasContent=!Mt.test(h.type),o=h.url.replace(Lt,""),h.hasContent?h.data&&h.processData&&0===(h.contentType||"").indexOf("application/x-www-form-urlencoded")&&(h.data=h.data.replace(qt,"+")):(d=h.url.slice(o.length),h.data&&(h.processData||"string"==typeof h.data)&&(o+=(kt.test(o)?"&":"?")+h.data,delete h.data),!1===h.cache&&(o=o.replace(Ht,"$1"),d=(kt.test(o)?"&":"?")+"_="+Et+++d),h.url=o+d),h.ifModified&&(w.lastModified[o]&&E.setRequestHeader("If-Modified-Since",w.lastModified[o]),w.etag[o]&&E.setRequestHeader("If-None-Match",w.etag[o])),(h.data&&h.hasContent&&!1!==h.contentType||n.contentType)&&E.setRequestHeader("Content-Type",h.contentType),E.setRequestHeader("Accept",h.dataTypes[0]&&h.accepts[h.dataTypes[0]]?h.accepts[h.dataTypes[0]]+("*"!==h.dataTypes[0]?", "+$t+"; q=0.01":""):h.accepts["*"]);for(p in h.headers)E.setRequestHeader(p,h.headers[p]);if(h.beforeSend&&(!1===h.beforeSend.call(g,E,h)||c))return E.abort();if(C="abort",m.add(h.complete),E.done(h.success),E.fail(h.error),i=_t(Wt,h,n,E)){if(E.readyState=1,f&&y.trigger("ajaxSend",[E,h]),c)return E;h.async&&h.timeout>0&&(u=e.setTimeout(function(){E.abort("timeout")},h.timeout));try{c=!1,i.send(b,k)}catch(e){if(c)throw e;k(-1,e)}}else k(-1,"No Transport");function k(t,n,r,s){var l,p,d,b,T,C=n;c||(c=!0,u&&e.clearTimeout(u),i=void 0,a=s||"",E.readyState=t>0?4:0,l=t>=200&&t<300||304===t,r&&(b=Xt(h,E,r)),b=Ut(h,b,E,l),l?(h.ifModified&&((T=E.getResponseHeader("Last-Modified"))&&(w.lastModified[o]=T),(T=E.getResponseHeader("etag"))&&(w.etag[o]=T)),204===t||"HEAD"===h.type?C="nocontent":304===t?C="notmodified":(C=b.state,p=b.data,l=!(d=b.error))):(d=C,!t&&C||(C="error",t<0&&(t=0))),E.status=t,E.statusText=(n||C)+"",l?v.resolveWith(g,[p,C,E]):v.rejectWith(g,[E,C,d]),E.statusCode(x),x=void 0,f&&y.trigger(l?"ajaxSuccess":"ajaxError",[E,h,l?p:d]),m.fireWith(g,[E,C]),f&&(y.trigger("ajaxComplete",[E,h]),--w.active||w.event.trigger("ajaxStop")))}return E},getJSON:function(e,t,n){return w.get(e,t,n,"json")},getScript:function(e,t){return w.get(e,void 0,t,"script")}}),w.each(["get","post"],function(e,t){w[t]=function(e,n,r,i){return g(n)&&(i=i||r,r=n,n=void 0),w.ajax(w.extend({url:e,type:t,dataType:i,data:n,success:r},w.isPlainObject(e)&&e))}}),w._evalUrl=function(e){return w.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,"throws":!0})},w.fn.extend({wrapAll:function(e){var t;return this[0]&&(g(e)&&(e=e.call(this[0])),t=w(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(e){return g(e)?this.each(function(t){w(this).wrapInner(e.call(this,t))}):this.each(function(){var t=w(this),n=t.contents();n.length?n.wrapAll(e):t.append(e)})},wrap:function(e){var t=g(e);return this.each(function(n){w(this).wrapAll(t?e.call(this,n):e)})},unwrap:function(e){return this.parent(e).not("body").each(function(){w(this).replaceWith(this.childNodes)}),this}}),w.expr.pseudos.hidden=function(e){return!w.expr.pseudos.visible(e)},w.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},w.ajaxSettings.xhr=function(){try{return new e.XMLHttpRequest}catch(e){}};var Vt={0:200,1223:204},Gt=w.ajaxSettings.xhr();h.cors=!!Gt&&"withCredentials"in Gt,h.ajax=Gt=!!Gt,w.ajaxTransport(function(t){var n,r;if(h.cors||Gt&&!t.crossDomain)return{send:function(i,o){var a,s=t.xhr();if(s.open(t.type,t.url,t.async,t.username,t.password),t.xhrFields)for(a in t.xhrFields)s[a]=t.xhrFields[a];t.mimeType&&s.overrideMimeType&&s.overrideMimeType(t.mimeType),t.crossDomain||i["X-Requested-With"]||(i["X-Requested-With"]="XMLHttpRequest");for(a in i)s.setRequestHeader(a,i[a]);n=function(e){return function(){n&&(n=r=s.onload=s.onerror=s.onabort=s.ontimeout=s.onreadystatechange=null,"abort"===e?s.abort():"error"===e?"number"!=typeof s.status?o(0,"error"):o(s.status,s.statusText):o(Vt[s.status]||s.status,s.statusText,"text"!==(s.responseType||"text")||"string"!=typeof s.responseText?{binary:s.response}:{text:s.responseText},s.getAllResponseHeaders()))}},s.onload=n(),r=s.onerror=s.ontimeout=n("error"),void 0!==s.onabort?s.onabort=r:s.onreadystatechange=function(){4===s.readyState&&e.setTimeout(function(){n&&r()})},n=n("abort");try{s.send(t.hasContent&&t.data||null)}catch(e){if(n)throw e}},abort:function(){n&&n()}}}),w.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),w.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return w.globalEval(e),e}}}),w.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),w.ajaxTransport("script",function(e){if(e.crossDomain){var t,n;return{send:function(i,o){t=w("<script>").prop({charset:e.scriptCharset,src:e.url}).on("load error",n=function(e){t.remove(),n=null,e&&o("error"===e.type?404:200,e.type)}),r.head.appendChild(t[0])},abort:function(){n&&n()}}}});var Yt=[],Qt=/(=)\?(?=&|$)|\?\?/;w.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=Yt.pop()||w.expando+"_"+Et++;return this[e]=!0,e}}),w.ajaxPrefilter("json jsonp",function(t,n,r){var i,o,a,s=!1!==t.jsonp&&(Qt.test(t.url)?"url":"string"==typeof t.data&&0===(t.contentType||"").indexOf("application/x-www-form-urlencoded")&&Qt.test(t.data)&&"data");if(s||"jsonp"===t.dataTypes[0])return i=t.jsonpCallback=g(t.jsonpCallback)?t.jsonpCallback():t.jsonpCallback,s?t[s]=t[s].replace(Qt,"$1"+i):!1!==t.jsonp&&(t.url+=(kt.test(t.url)?"&":"?")+t.jsonp+"="+i),t.converters["script json"]=function(){return a||w.error(i+" was not called"),a[0]},t.dataTypes[0]="json",o=e[i],e[i]=function(){a=arguments},r.always(function(){void 0===o?w(e).removeProp(i):e[i]=o,t[i]&&(t.jsonpCallback=n.jsonpCallback,Yt.push(i)),a&&g(o)&&o(a[0]),a=o=void 0}),"script"}),h.createHTMLDocument=function(){var e=r.implementation.createHTMLDocument("").body;return e.innerHTML="<form></form><form></form>",2===e.childNodes.length}(),w.parseHTML=function(e,t,n){if("string"!=typeof e)return[];"boolean"==typeof t&&(n=t,t=!1);var i,o,a;return t||(h.createHTMLDocument?((i=(t=r.implementation.createHTMLDocument("")).createElement("base")).href=r.location.href,t.head.appendChild(i)):t=r),o=A.exec(e),a=!n&&[],o?[t.createElement(o[1])]:(o=xe([e],t,a),a&&a.length&&w(a).remove(),w.merge([],o.childNodes))},w.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return s>-1&&(r=vt(e.slice(s)),e=e.slice(0,s)),g(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),a.length>0&&w.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?w("<div>").append(w.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},w.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){w.fn[t]=function(e){return this.on(t,e)}}),w.expr.pseudos.animated=function(e){return w.grep(w.timers,function(t){return e===t.elem}).length},w.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l,c=w.css(e,"position"),f=w(e),p={};"static"===c&&(e.style.position="relative"),s=f.offset(),o=w.css(e,"top"),u=w.css(e,"left"),(l=("absolute"===c||"fixed"===c)&&(o+u).indexOf("auto")>-1)?(a=(r=f.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),g(t)&&(t=t.call(e,n,w.extend({},s))),null!=t.top&&(p.top=t.top-s.top+a),null!=t.left&&(p.left=t.left-s.left+i),"using"in t?t.using.call(e,p):f.css(p)}},w.fn.extend({offset:function(e){if(arguments.length)return void 0===e?this:this.each(function(t){w.offset.setOffset(this,e,t)});var t,n,r=this[0];if(r)return r.getClientRects().length?(t=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:t.top+n.pageYOffset,left:t.left+n.pageXOffset}):{top:0,left:0}},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===w.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===w.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=w(e).offset()).top+=w.css(e,"borderTopWidth",!0),i.left+=w.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-w.css(r,"marginTop",!0),left:t.left-i.left-w.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===w.css(e,"position"))e=e.offsetParent;return e||be})}}),w.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(e,t){var n="pageYOffset"===t;w.fn[e]=function(r){return z(this,function(e,r,i){var o;if(y(e)?o=e:9===e.nodeType&&(o=e.defaultView),void 0===i)return o?o[t]:e[r];o?o.scrollTo(n?o.pageXOffset:i,n?i:o.pageYOffset):e[r]=i},e,r,arguments.length)}}),w.each(["top","left"],function(e,t){w.cssHooks[t]=_e(h.pixelPosition,function(e,n){if(n)return n=Fe(e,t),We.test(n)?w(e).position()[t]+"px":n})}),w.each({Height:"height",Width:"width"},function(e,t){w.each({padding:"inner"+e,content:t,"":"outer"+e},function(n,r){w.fn[r]=function(i,o){var a=arguments.length&&(n||"boolean"!=typeof i),s=n||(!0===i||!0===o?"margin":"border");return z(this,function(t,n,i){var o;return y(t)?0===r.indexOf("outer")?t["inner"+e]:t.document.documentElement["client"+e]:9===t.nodeType?(o=t.documentElement,Math.max(t.body["scroll"+e],o["scroll"+e],t.body["offset"+e],o["offset"+e],o["client"+e])):void 0===i?w.css(t,n,s):w.style(t,n,i,s)},t,a?i:void 0,a)}})}),w.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,t){w.fn[t]=function(e,n){return arguments.length>0?this.on(t,null,e,n):this.trigger(t)}}),w.fn.extend({hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),w.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)}}),w.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),g(e))return r=o.call(arguments,2),i=function(){return e.apply(t||this,r.concat(o.call(arguments)))},i.guid=e.guid=e.guid||w.guid++,i},w.holdReady=function(e){e?w.readyWait++:w.ready(!0)},w.isArray=Array.isArray,w.parseJSON=JSON.parse,w.nodeName=N,w.isFunction=g,w.isWindow=y,w.camelCase=G,w.type=x,w.now=Date.now,w.isNumeric=function(e){var t=w.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},"function"==typeof define&&define.amd&&define("jquery",[],function(){return w});var Jt=e.jQuery,Kt=e.$;return w.noConflict=function(t){return e.$===w&&(e.$=Kt),t&&e.jQuery===w&&(e.jQuery=Jt),w},t||(e.jQuery=e.$=w),w});

/*
 Copyright (C) Federico Zivolo 2017
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */(function(e,t){'object'==typeof exports&&'undefined'!=typeof module?module.exports=t():'function'==typeof define&&define.amd?define(t):e.Popper=t()})(this,function(){'use strict';function e(e){return e&&'[object Function]'==={}.toString.call(e)}function t(e,t){if(1!==e.nodeType)return[];var o=getComputedStyle(e,null);return t?o[t]:o}function o(e){return'HTML'===e.nodeName?e:e.parentNode||e.host}function n(e){if(!e)return document.body;switch(e.nodeName){case'HTML':case'BODY':return e.ownerDocument.body;case'#document':return e.body;}var i=t(e),r=i.overflow,p=i.overflowX,s=i.overflowY;return /(auto|scroll)/.test(r+s+p)?e:n(o(e))}function r(e){var o=e&&e.offsetParent,i=o&&o.nodeName;return i&&'BODY'!==i&&'HTML'!==i?-1!==['TD','TABLE'].indexOf(o.nodeName)&&'static'===t(o,'position')?r(o):o:e?e.ownerDocument.documentElement:document.documentElement}function p(e){var t=e.nodeName;return'BODY'!==t&&('HTML'===t||r(e.firstElementChild)===e)}function s(e){return null===e.parentNode?e:s(e.parentNode)}function d(e,t){if(!e||!e.nodeType||!t||!t.nodeType)return document.documentElement;var o=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,i=o?e:t,n=o?t:e,a=document.createRange();a.setStart(i,0),a.setEnd(n,0);var l=a.commonAncestorContainer;if(e!==l&&t!==l||i.contains(n))return p(l)?l:r(l);var f=s(e);return f.host?d(f.host,t):d(e,s(t).host)}function a(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:'top',o='top'===t?'scrollTop':'scrollLeft',i=e.nodeName;if('BODY'===i||'HTML'===i){var n=e.ownerDocument.documentElement,r=e.ownerDocument.scrollingElement||n;return r[o]}return e[o]}function l(e,t){var o=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=a(t,'top'),n=a(t,'left'),r=o?-1:1;return e.top+=i*r,e.bottom+=i*r,e.left+=n*r,e.right+=n*r,e}function f(e,t){var o='x'===t?'Left':'Top',i='Left'==o?'Right':'Bottom';return parseFloat(e['border'+o+'Width'],10)+parseFloat(e['border'+i+'Width'],10)}function m(e,t,o,i){return J(t['offset'+e],t['scroll'+e],o['client'+e],o['offset'+e],o['scroll'+e],ie()?o['offset'+e]+i['margin'+('Height'===e?'Top':'Left')]+i['margin'+('Height'===e?'Bottom':'Right')]:0)}function h(){var e=document.body,t=document.documentElement,o=ie()&&getComputedStyle(t);return{height:m('Height',e,t,o),width:m('Width',e,t,o)}}function c(e){return se({},e,{right:e.left+e.width,bottom:e.top+e.height})}function g(e){var o={};if(ie())try{o=e.getBoundingClientRect();var i=a(e,'top'),n=a(e,'left');o.top+=i,o.left+=n,o.bottom+=i,o.right+=n}catch(e){}else o=e.getBoundingClientRect();var r={left:o.left,top:o.top,width:o.right-o.left,height:o.bottom-o.top},p='HTML'===e.nodeName?h():{},s=p.width||e.clientWidth||r.right-r.left,d=p.height||e.clientHeight||r.bottom-r.top,l=e.offsetWidth-s,m=e.offsetHeight-d;if(l||m){var g=t(e);l-=f(g,'x'),m-=f(g,'y'),r.width-=l,r.height-=m}return c(r)}function u(e,o){var i=ie(),r='HTML'===o.nodeName,p=g(e),s=g(o),d=n(e),a=t(o),f=parseFloat(a.borderTopWidth,10),m=parseFloat(a.borderLeftWidth,10),h=c({top:p.top-s.top-f,left:p.left-s.left-m,width:p.width,height:p.height});if(h.marginTop=0,h.marginLeft=0,!i&&r){var u=parseFloat(a.marginTop,10),b=parseFloat(a.marginLeft,10);h.top-=f-u,h.bottom-=f-u,h.left-=m-b,h.right-=m-b,h.marginTop=u,h.marginLeft=b}return(i?o.contains(d):o===d&&'BODY'!==d.nodeName)&&(h=l(h,o)),h}function b(e){var t=e.ownerDocument.documentElement,o=u(e,t),i=J(t.clientWidth,window.innerWidth||0),n=J(t.clientHeight,window.innerHeight||0),r=a(t),p=a(t,'left'),s={top:r-o.top+o.marginTop,left:p-o.left+o.marginLeft,width:i,height:n};return c(s)}function w(e){var i=e.nodeName;return'BODY'===i||'HTML'===i?!1:'fixed'===t(e,'position')||w(o(e))}function y(e,t,i,r){var p={top:0,left:0},s=d(e,t);if('viewport'===r)p=b(s);else{var a;'scrollParent'===r?(a=n(o(t)),'BODY'===a.nodeName&&(a=e.ownerDocument.documentElement)):'window'===r?a=e.ownerDocument.documentElement:a=r;var l=u(a,s);if('HTML'===a.nodeName&&!w(s)){var f=h(),m=f.height,c=f.width;p.top+=l.top-l.marginTop,p.bottom=m+l.top,p.left+=l.left-l.marginLeft,p.right=c+l.left}else p=l}return p.left+=i,p.top+=i,p.right-=i,p.bottom-=i,p}function E(e){var t=e.width,o=e.height;return t*o}function v(e,t,o,i,n){var r=5<arguments.length&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf('auto'))return e;var p=y(o,i,r,n),s={top:{width:p.width,height:t.top-p.top},right:{width:p.right-t.right,height:p.height},bottom:{width:p.width,height:p.bottom-t.bottom},left:{width:t.left-p.left,height:p.height}},d=Object.keys(s).map(function(e){return se({key:e},s[e],{area:E(s[e])})}).sort(function(e,t){return t.area-e.area}),a=d.filter(function(e){var t=e.width,i=e.height;return t>=o.clientWidth&&i>=o.clientHeight}),l=0<a.length?a[0].key:d[0].key,f=e.split('-')[1];return l+(f?'-'+f:'')}function O(e,t,o){var i=d(t,o);return u(o,i)}function L(e){var t=getComputedStyle(e),o=parseFloat(t.marginTop)+parseFloat(t.marginBottom),i=parseFloat(t.marginLeft)+parseFloat(t.marginRight),n={width:e.offsetWidth+i,height:e.offsetHeight+o};return n}function x(e){var t={left:'right',right:'left',bottom:'top',top:'bottom'};return e.replace(/left|right|bottom|top/g,function(e){return t[e]})}function S(e,t,o){o=o.split('-')[0];var i=L(e),n={width:i.width,height:i.height},r=-1!==['right','left'].indexOf(o),p=r?'top':'left',s=r?'left':'top',d=r?'height':'width',a=r?'width':'height';return n[p]=t[p]+t[d]/2-i[d]/2,n[s]=o===s?t[s]-i[a]:t[x(s)],n}function T(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function D(e,t,o){if(Array.prototype.findIndex)return e.findIndex(function(e){return e[t]===o});var i=T(e,function(e){return e[t]===o});return e.indexOf(i)}function C(t,o,i){var n=void 0===i?t:t.slice(0,D(t,'name',i));return n.forEach(function(t){t['function']&&console.warn('`modifier.function` is deprecated, use `modifier.fn`!');var i=t['function']||t.fn;t.enabled&&e(i)&&(o.offsets.popper=c(o.offsets.popper),o.offsets.reference=c(o.offsets.reference),o=i(o,t))}),o}function N(){if(!this.state.isDestroyed){var e={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};e.offsets.reference=O(this.state,this.popper,this.reference),e.placement=v(this.options.placement,e.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),e.originalPlacement=e.placement,e.offsets.popper=S(this.popper,e.offsets.reference,e.placement),e.offsets.popper.position='absolute',e=C(this.modifiers,e),this.state.isCreated?this.options.onUpdate(e):(this.state.isCreated=!0,this.options.onCreate(e))}}function k(e,t){return e.some(function(e){var o=e.name,i=e.enabled;return i&&o===t})}function W(e){for(var t=[!1,'ms','Webkit','Moz','O'],o=e.charAt(0).toUpperCase()+e.slice(1),n=0;n<t.length-1;n++){var i=t[n],r=i?''+i+o:e;if('undefined'!=typeof document.body.style[r])return r}return null}function P(){return this.state.isDestroyed=!0,k(this.modifiers,'applyStyle')&&(this.popper.removeAttribute('x-placement'),this.popper.style.left='',this.popper.style.position='',this.popper.style.top='',this.popper.style[W('transform')]=''),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}function B(e){var t=e.ownerDocument;return t?t.defaultView:window}function H(e,t,o,i){var r='BODY'===e.nodeName,p=r?e.ownerDocument.defaultView:e;p.addEventListener(t,o,{passive:!0}),r||H(n(p.parentNode),t,o,i),i.push(p)}function A(e,t,o,i){o.updateBound=i,B(e).addEventListener('resize',o.updateBound,{passive:!0});var r=n(e);return H(r,'scroll',o.updateBound,o.scrollParents),o.scrollElement=r,o.eventsEnabled=!0,o}function I(){this.state.eventsEnabled||(this.state=A(this.reference,this.options,this.state,this.scheduleUpdate))}function M(e,t){return B(e).removeEventListener('resize',t.updateBound),t.scrollParents.forEach(function(e){e.removeEventListener('scroll',t.updateBound)}),t.updateBound=null,t.scrollParents=[],t.scrollElement=null,t.eventsEnabled=!1,t}function R(){this.state.eventsEnabled&&(cancelAnimationFrame(this.scheduleUpdate),this.state=M(this.reference,this.state))}function U(e){return''!==e&&!isNaN(parseFloat(e))&&isFinite(e)}function Y(e,t){Object.keys(t).forEach(function(o){var i='';-1!==['width','height','top','right','bottom','left'].indexOf(o)&&U(t[o])&&(i='px'),e.style[o]=t[o]+i})}function j(e,t){Object.keys(t).forEach(function(o){var i=t[o];!1===i?e.removeAttribute(o):e.setAttribute(o,t[o])})}function F(e,t,o){var i=T(e,function(e){var o=e.name;return o===t}),n=!!i&&e.some(function(e){return e.name===o&&e.enabled&&e.order<i.order});if(!n){var r='`'+t+'`';console.warn('`'+o+'`'+' modifier is required by '+r+' modifier in order to work, be sure to include it before '+r+'!')}return n}function K(e){return'end'===e?'start':'start'===e?'end':e}function q(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1],o=ae.indexOf(e),i=ae.slice(o+1).concat(ae.slice(0,o));return t?i.reverse():i}function V(e,t,o,i){var n=e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),r=+n[1],p=n[2];if(!r)return e;if(0===p.indexOf('%')){var s;switch(p){case'%p':s=o;break;case'%':case'%r':default:s=i;}var d=c(s);return d[t]/100*r}if('vh'===p||'vw'===p){var a;return a='vh'===p?J(document.documentElement.clientHeight,window.innerHeight||0):J(document.documentElement.clientWidth,window.innerWidth||0),a/100*r}return r}function z(e,t,o,i){var n=[0,0],r=-1!==['right','left'].indexOf(i),p=e.split(/(\+|\-)/).map(function(e){return e.trim()}),s=p.indexOf(T(p,function(e){return-1!==e.search(/,|\s/)}));p[s]&&-1===p[s].indexOf(',')&&console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');var d=/\s*,\s*|\s+/,a=-1===s?[p]:[p.slice(0,s).concat([p[s].split(d)[0]]),[p[s].split(d)[1]].concat(p.slice(s+1))];return a=a.map(function(e,i){var n=(1===i?!r:r)?'height':'width',p=!1;return e.reduce(function(e,t){return''===e[e.length-1]&&-1!==['+','-'].indexOf(t)?(e[e.length-1]=t,p=!0,e):p?(e[e.length-1]+=t,p=!1,e):e.concat(t)},[]).map(function(e){return V(e,n,t,o)})}),a.forEach(function(e,t){e.forEach(function(o,i){U(o)&&(n[t]+=o*('-'===e[i-1]?-1:1))})}),n}function G(e,t){var o,i=t.offset,n=e.placement,r=e.offsets,p=r.popper,s=r.reference,d=n.split('-')[0];return o=U(+i)?[+i,0]:z(i,p,s,d),'left'===d?(p.top+=o[0],p.left-=o[1]):'right'===d?(p.top+=o[0],p.left+=o[1]):'top'===d?(p.left+=o[0],p.top-=o[1]):'bottom'===d&&(p.left+=o[0],p.top+=o[1]),e.popper=p,e}for(var _=Math.min,X=Math.floor,J=Math.max,Q='undefined'!=typeof window&&'undefined'!=typeof document,Z=['Edge','Trident','Firefox'],$=0,ee=0;ee<Z.length;ee+=1)if(Q&&0<=navigator.userAgent.indexOf(Z[ee])){$=1;break}var i,te=Q&&window.Promise,oe=te?function(e){var t=!1;return function(){t||(t=!0,window.Promise.resolve().then(function(){t=!1,e()}))}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout(function(){t=!1,e()},$))}},ie=function(){return void 0==i&&(i=-1!==navigator.appVersion.indexOf('MSIE 10')),i},ne=function(e,t){if(!(e instanceof t))throw new TypeError('Cannot call a class as a function')},re=function(){function e(e,t){for(var o,n=0;n<t.length;n++)o=t[n],o.enumerable=o.enumerable||!1,o.configurable=!0,'value'in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}return function(t,o,i){return o&&e(t.prototype,o),i&&e(t,i),t}}(),pe=function(e,t,o){return t in e?Object.defineProperty(e,t,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[t]=o,e},se=Object.assign||function(e){for(var t,o=1;o<arguments.length;o++)for(var i in t=arguments[o],t)Object.prototype.hasOwnProperty.call(t,i)&&(e[i]=t[i]);return e},de=['auto-start','auto','auto-end','top-start','top','top-end','right-start','right','right-end','bottom-end','bottom','bottom-start','left-end','left','left-start'],ae=de.slice(3),le={FLIP:'flip',CLOCKWISE:'clockwise',COUNTERCLOCKWISE:'counterclockwise'},fe=function(){function t(o,i){var n=this,r=2<arguments.length&&void 0!==arguments[2]?arguments[2]:{};ne(this,t),this.scheduleUpdate=function(){return requestAnimationFrame(n.update)},this.update=oe(this.update.bind(this)),this.options=se({},t.Defaults,r),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=o&&o.jquery?o[0]:o,this.popper=i&&i.jquery?i[0]:i,this.options.modifiers={},Object.keys(se({},t.Defaults.modifiers,r.modifiers)).forEach(function(e){n.options.modifiers[e]=se({},t.Defaults.modifiers[e]||{},r.modifiers?r.modifiers[e]:{})}),this.modifiers=Object.keys(this.options.modifiers).map(function(e){return se({name:e},n.options.modifiers[e])}).sort(function(e,t){return e.order-t.order}),this.modifiers.forEach(function(t){t.enabled&&e(t.onLoad)&&t.onLoad(n.reference,n.popper,n.options,t,n.state)}),this.update();var p=this.options.eventsEnabled;p&&this.enableEventListeners(),this.state.eventsEnabled=p}return re(t,[{key:'update',value:function(){return N.call(this)}},{key:'destroy',value:function(){return P.call(this)}},{key:'enableEventListeners',value:function(){return I.call(this)}},{key:'disableEventListeners',value:function(){return R.call(this)}}]),t}();return fe.Utils=('undefined'==typeof window?global:window).PopperUtils,fe.placements=de,fe.Defaults={placement:'bottom',eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(e){var t=e.placement,o=t.split('-')[0],i=t.split('-')[1];if(i){var n=e.offsets,r=n.reference,p=n.popper,s=-1!==['bottom','top'].indexOf(o),d=s?'left':'top',a=s?'width':'height',l={start:pe({},d,r[d]),end:pe({},d,r[d]+r[a]-p[a])};e.offsets.popper=se({},p,l[i])}return e}},offset:{order:200,enabled:!0,fn:G,offset:0},preventOverflow:{order:300,enabled:!0,fn:function(e,t){var o=t.boundariesElement||r(e.instance.popper);e.instance.reference===o&&(o=r(o));var i=y(e.instance.popper,e.instance.reference,t.padding,o);t.boundaries=i;var n=t.priority,p=e.offsets.popper,s={primary:function(e){var o=p[e];return p[e]<i[e]&&!t.escapeWithReference&&(o=J(p[e],i[e])),pe({},e,o)},secondary:function(e){var o='right'===e?'left':'top',n=p[o];return p[e]>i[e]&&!t.escapeWithReference&&(n=_(p[o],i[e]-('right'===e?p.width:p.height))),pe({},o,n)}};return n.forEach(function(e){var t=-1===['left','top'].indexOf(e)?'secondary':'primary';p=se({},p,s[t](e))}),e.offsets.popper=p,e},priority:['left','right','top','bottom'],padding:5,boundariesElement:'scrollParent'},keepTogether:{order:400,enabled:!0,fn:function(e){var t=e.offsets,o=t.popper,i=t.reference,n=e.placement.split('-')[0],r=X,p=-1!==['top','bottom'].indexOf(n),s=p?'right':'bottom',d=p?'left':'top',a=p?'width':'height';return o[s]<r(i[d])&&(e.offsets.popper[d]=r(i[d])-o[a]),o[d]>r(i[s])&&(e.offsets.popper[d]=r(i[s])),e}},arrow:{order:500,enabled:!0,fn:function(e,o){var i;if(!F(e.instance.modifiers,'arrow','keepTogether'))return e;var n=o.element;if('string'==typeof n){if(n=e.instance.popper.querySelector(n),!n)return e;}else if(!e.instance.popper.contains(n))return console.warn('WARNING: `arrow.element` must be child of its popper element!'),e;var r=e.placement.split('-')[0],p=e.offsets,s=p.popper,d=p.reference,a=-1!==['left','right'].indexOf(r),l=a?'height':'width',f=a?'Top':'Left',m=f.toLowerCase(),h=a?'left':'top',g=a?'bottom':'right',u=L(n)[l];d[g]-u<s[m]&&(e.offsets.popper[m]-=s[m]-(d[g]-u)),d[m]+u>s[g]&&(e.offsets.popper[m]+=d[m]+u-s[g]),e.offsets.popper=c(e.offsets.popper);var b=d[m]+d[l]/2-u/2,w=t(e.instance.popper),y=parseFloat(w['margin'+f],10),E=parseFloat(w['border'+f+'Width'],10),v=b-e.offsets.popper[m]-y-E;return v=J(_(s[l]-u,v),0),e.arrowElement=n,e.offsets.arrow=(i={},pe(i,m,Math.round(v)),pe(i,h,''),i),e},element:'[x-arrow]'},flip:{order:600,enabled:!0,fn:function(e,t){if(k(e.instance.modifiers,'inner'))return e;if(e.flipped&&e.placement===e.originalPlacement)return e;var o=y(e.instance.popper,e.instance.reference,t.padding,t.boundariesElement),i=e.placement.split('-')[0],n=x(i),r=e.placement.split('-')[1]||'',p=[];switch(t.behavior){case le.FLIP:p=[i,n];break;case le.CLOCKWISE:p=q(i);break;case le.COUNTERCLOCKWISE:p=q(i,!0);break;default:p=t.behavior;}return p.forEach(function(s,d){if(i!==s||p.length===d+1)return e;i=e.placement.split('-')[0],n=x(i);var a=e.offsets.popper,l=e.offsets.reference,f=X,m='left'===i&&f(a.right)>f(l.left)||'right'===i&&f(a.left)<f(l.right)||'top'===i&&f(a.bottom)>f(l.top)||'bottom'===i&&f(a.top)<f(l.bottom),h=f(a.left)<f(o.left),c=f(a.right)>f(o.right),g=f(a.top)<f(o.top),u=f(a.bottom)>f(o.bottom),b='left'===i&&h||'right'===i&&c||'top'===i&&g||'bottom'===i&&u,w=-1!==['top','bottom'].indexOf(i),y=!!t.flipVariations&&(w&&'start'===r&&h||w&&'end'===r&&c||!w&&'start'===r&&g||!w&&'end'===r&&u);(m||b||y)&&(e.flipped=!0,(m||b)&&(i=p[d+1]),y&&(r=K(r)),e.placement=i+(r?'-'+r:''),e.offsets.popper=se({},e.offsets.popper,S(e.instance.popper,e.offsets.reference,e.placement)),e=C(e.instance.modifiers,e,'flip'))}),e},behavior:'flip',padding:5,boundariesElement:'viewport'},inner:{order:700,enabled:!1,fn:function(e){var t=e.placement,o=t.split('-')[0],i=e.offsets,n=i.popper,r=i.reference,p=-1!==['left','right'].indexOf(o),s=-1===['top','left'].indexOf(o);return n[p?'left':'top']=r[o]-(s?n[p?'width':'height']:0),e.placement=x(t),e.offsets.popper=c(n),e}},hide:{order:800,enabled:!0,fn:function(e){if(!F(e.instance.modifiers,'hide','preventOverflow'))return e;var t=e.offsets.reference,o=T(e.instance.modifiers,function(e){return'preventOverflow'===e.name}).boundaries;if(t.bottom<o.top||t.left>o.right||t.top>o.bottom||t.right<o.left){if(!0===e.hide)return e;e.hide=!0,e.attributes['x-out-of-boundaries']=''}else{if(!1===e.hide)return e;e.hide=!1,e.attributes['x-out-of-boundaries']=!1}return e}},computeStyle:{order:850,enabled:!0,fn:function(e,t){var o=t.x,i=t.y,n=e.offsets.popper,p=T(e.instance.modifiers,function(e){return'applyStyle'===e.name}).gpuAcceleration;void 0!==p&&console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');var s,d,a=void 0===p?t.gpuAcceleration:p,l=r(e.instance.popper),f=g(l),m={position:n.position},h={left:X(n.left),top:X(n.top),bottom:X(n.bottom),right:X(n.right)},c='bottom'===o?'top':'bottom',u='right'===i?'left':'right',b=W('transform');if(d='bottom'==c?-f.height+h.bottom:h.top,s='right'==u?-f.width+h.right:h.left,a&&b)m[b]='translate3d('+s+'px, '+d+'px, 0)',m[c]=0,m[u]=0,m.willChange='transform';else{var w='bottom'==c?-1:1,y='right'==u?-1:1;m[c]=d*w,m[u]=s*y,m.willChange=c+', '+u}var E={"x-placement":e.placement};return e.attributes=se({},E,e.attributes),e.styles=se({},m,e.styles),e.arrowStyles=se({},e.offsets.arrow,e.arrowStyles),e},gpuAcceleration:!0,x:'bottom',y:'right'},applyStyle:{order:900,enabled:!0,fn:function(e){return Y(e.instance.popper,e.styles),j(e.instance.popper,e.attributes),e.arrowElement&&Object.keys(e.arrowStyles).length&&Y(e.arrowElement,e.arrowStyles),e},onLoad:function(e,t,o,i,n){var r=O(n,t,e),p=v(o.placement,r,t,e,o.modifiers.flip.boundariesElement,o.modifiers.flip.padding);return t.setAttribute('x-placement',p),Y(t,{position:'absolute'}),o},gpuAcceleration:void 0}}},fe});
//# sourceMappingURL=popper.js.map

/*!
 * Bootstrap v4.0.0 (https://getbootstrap.com)
 * Copyright 2011-2018 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(exports,require("jquery"),require("popper.js")):"function"==typeof define&&define.amd?define(["exports","jquery","popper.js"],e):e(t.bootstrap={},t.jQuery,t.Popper)}(this,function(t,e,n){"use strict";function i(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}function s(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t}function r(){return(r=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var i in n)Object.prototype.hasOwnProperty.call(n,i)&&(t[i]=n[i])}return t}).apply(this,arguments)}e=e&&e.hasOwnProperty("default")?e.default:e,n=n&&n.hasOwnProperty("default")?n.default:n;var o,a,l,h,c,u,f,d,_,g,p,m,v,E,T,y,C,I,A,b,D,S,w,N,O,k,P=function(t){var e=!1;function n(e){var n=this,s=!1;return t(this).one(i.TRANSITION_END,function(){s=!0}),setTimeout(function(){s||i.triggerTransitionEnd(n)},e),this}var i={TRANSITION_END:"bsTransitionEnd",getUID:function(t){do{t+=~~(1e6*Math.random())}while(document.getElementById(t));return t},getSelectorFromElement:function(e){var n,i=e.getAttribute("data-target");i&&"#"!==i||(i=e.getAttribute("href")||""),"#"===i.charAt(0)&&(n=i,i=n="function"==typeof t.escapeSelector?t.escapeSelector(n).substr(1):n.replace(/(:|\.|\[|\]|,|=|@)/g,"\\$1"));try{return t(document).find(i).length>0?i:null}catch(t){return null}},reflow:function(t){return t.offsetHeight},triggerTransitionEnd:function(n){t(n).trigger(e.end)},supportsTransitionEnd:function(){return Boolean(e)},isElement:function(t){return(t[0]||t).nodeType},typeCheckConfig:function(t,e,n){for(var s in n)if(Object.prototype.hasOwnProperty.call(n,s)){var r=n[s],o=e[s],a=o&&i.isElement(o)?"element":(l=o,{}.toString.call(l).match(/\s([a-zA-Z]+)/)[1].toLowerCase());if(!new RegExp(r).test(a))throw new Error(t.toUpperCase()+': Option "'+s+'" provided type "'+a+'" but expected type "'+r+'".')}var l}};return e=("undefined"==typeof window||!window.QUnit)&&{end:"transitionend"},t.fn.emulateTransitionEnd=n,i.supportsTransitionEnd()&&(t.event.special[i.TRANSITION_END]={bindType:e.end,delegateType:e.end,handle:function(e){if(t(e.target).is(this))return e.handleObj.handler.apply(this,arguments)}}),i}(e),L=(a="alert",h="."+(l="bs.alert"),c=(o=e).fn[a],u={CLOSE:"close"+h,CLOSED:"closed"+h,CLICK_DATA_API:"click"+h+".data-api"},f="alert",d="fade",_="show",g=function(){function t(t){this._element=t}var e=t.prototype;return e.close=function(t){t=t||this._element;var e=this._getRootElement(t);this._triggerCloseEvent(e).isDefaultPrevented()||this._removeElement(e)},e.dispose=function(){o.removeData(this._element,l),this._element=null},e._getRootElement=function(t){var e=P.getSelectorFromElement(t),n=!1;return e&&(n=o(e)[0]),n||(n=o(t).closest("."+f)[0]),n},e._triggerCloseEvent=function(t){var e=o.Event(u.CLOSE);return o(t).trigger(e),e},e._removeElement=function(t){var e=this;o(t).removeClass(_),P.supportsTransitionEnd()&&o(t).hasClass(d)?o(t).one(P.TRANSITION_END,function(n){return e._destroyElement(t,n)}).emulateTransitionEnd(150):this._destroyElement(t)},e._destroyElement=function(t){o(t).detach().trigger(u.CLOSED).remove()},t._jQueryInterface=function(e){return this.each(function(){var n=o(this),i=n.data(l);i||(i=new t(this),n.data(l,i)),"close"===e&&i[e](this)})},t._handleDismiss=function(t){return function(e){e&&e.preventDefault(),t.close(this)}},s(t,null,[{key:"VERSION",get:function(){return"4.0.0"}}]),t}(),o(document).on(u.CLICK_DATA_API,'[data-dismiss="alert"]',g._handleDismiss(new g)),o.fn[a]=g._jQueryInterface,o.fn[a].Constructor=g,o.fn[a].noConflict=function(){return o.fn[a]=c,g._jQueryInterface},g),R=(m="button",E="."+(v="bs.button"),T=".data-api",y=(p=e).fn[m],C="active",I="btn",A="focus",b='[data-toggle^="button"]',D='[data-toggle="buttons"]',S="input",w=".active",N=".btn",O={CLICK_DATA_API:"click"+E+T,FOCUS_BLUR_DATA_API:"focus"+E+T+" blur"+E+T},k=function(){function t(t){this._element=t}var e=t.prototype;return e.toggle=function(){var t=!0,e=!0,n=p(this._element).closest(D)[0];if(n){var i=p(this._element).find(S)[0];if(i){if("radio"===i.type)if(i.checked&&p(this._element).hasClass(C))t=!1;else{var s=p(n).find(w)[0];s&&p(s).removeClass(C)}if(t){if(i.hasAttribute("disabled")||n.hasAttribute("disabled")||i.classList.contains("disabled")||n.classList.contains("disabled"))return;i.checked=!p(this._element).hasClass(C),p(i).trigger("change")}i.focus(),e=!1}}e&&this._element.setAttribute("aria-pressed",!p(this._element).hasClass(C)),t&&p(this._element).toggleClass(C)},e.dispose=function(){p.removeData(this._element,v),this._element=null},t._jQueryInterface=function(e){return this.each(function(){var n=p(this).data(v);n||(n=new t(this),p(this).data(v,n)),"toggle"===e&&n[e]()})},s(t,null,[{key:"VERSION",get:function(){return"4.0.0"}}]),t}(),p(document).on(O.CLICK_DATA_API,b,function(t){t.preventDefault();var e=t.target;p(e).hasClass(I)||(e=p(e).closest(N)),k._jQueryInterface.call(p(e),"toggle")}).on(O.FOCUS_BLUR_DATA_API,b,function(t){var e=p(t.target).closest(N)[0];p(e).toggleClass(A,/^focus(in)?$/.test(t.type))}),p.fn[m]=k._jQueryInterface,p.fn[m].Constructor=k,p.fn[m].noConflict=function(){return p.fn[m]=y,k._jQueryInterface},k),j=function(t){var e="carousel",n="bs.carousel",i="."+n,o=t.fn[e],a={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0},l={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean"},h="next",c="prev",u="left",f="right",d={SLIDE:"slide"+i,SLID:"slid"+i,KEYDOWN:"keydown"+i,MOUSEENTER:"mouseenter"+i,MOUSELEAVE:"mouseleave"+i,TOUCHEND:"touchend"+i,LOAD_DATA_API:"load"+i+".data-api",CLICK_DATA_API:"click"+i+".data-api"},_="carousel",g="active",p="slide",m="carousel-item-right",v="carousel-item-left",E="carousel-item-next",T="carousel-item-prev",y={ACTIVE:".active",ACTIVE_ITEM:".active.carousel-item",ITEM:".carousel-item",NEXT_PREV:".carousel-item-next, .carousel-item-prev",INDICATORS:".carousel-indicators",DATA_SLIDE:"[data-slide], [data-slide-to]",DATA_RIDE:'[data-ride="carousel"]'},C=function(){function o(e,n){this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this.touchTimeout=null,this._config=this._getConfig(n),this._element=t(e)[0],this._indicatorsElement=t(this._element).find(y.INDICATORS)[0],this._addEventListeners()}var C=o.prototype;return C.next=function(){this._isSliding||this._slide(h)},C.nextWhenVisible=function(){!document.hidden&&t(this._element).is(":visible")&&"hidden"!==t(this._element).css("visibility")&&this.next()},C.prev=function(){this._isSliding||this._slide(c)},C.pause=function(e){e||(this._isPaused=!0),t(this._element).find(y.NEXT_PREV)[0]&&P.supportsTransitionEnd()&&(P.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null},C.cycle=function(t){t||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval((document.visibilityState?this.nextWhenVisible:this.next).bind(this),this._config.interval))},C.to=function(e){var n=this;this._activeElement=t(this._element).find(y.ACTIVE_ITEM)[0];var i=this._getItemIndex(this._activeElement);if(!(e>this._items.length-1||e<0))if(this._isSliding)t(this._element).one(d.SLID,function(){return n.to(e)});else{if(i===e)return this.pause(),void this.cycle();var s=e>i?h:c;this._slide(s,this._items[e])}},C.dispose=function(){t(this._element).off(i),t.removeData(this._element,n),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null},C._getConfig=function(t){return t=r({},a,t),P.typeCheckConfig(e,t,l),t},C._addEventListeners=function(){var e=this;this._config.keyboard&&t(this._element).on(d.KEYDOWN,function(t){return e._keydown(t)}),"hover"===this._config.pause&&(t(this._element).on(d.MOUSEENTER,function(t){return e.pause(t)}).on(d.MOUSELEAVE,function(t){return e.cycle(t)}),"ontouchstart"in document.documentElement&&t(this._element).on(d.TOUCHEND,function(){e.pause(),e.touchTimeout&&clearTimeout(e.touchTimeout),e.touchTimeout=setTimeout(function(t){return e.cycle(t)},500+e._config.interval)}))},C._keydown=function(t){if(!/input|textarea/i.test(t.target.tagName))switch(t.which){case 37:t.preventDefault(),this.prev();break;case 39:t.preventDefault(),this.next()}},C._getItemIndex=function(e){return this._items=t.makeArray(t(e).parent().find(y.ITEM)),this._items.indexOf(e)},C._getItemByDirection=function(t,e){var n=t===h,i=t===c,s=this._getItemIndex(e),r=this._items.length-1;if((i&&0===s||n&&s===r)&&!this._config.wrap)return e;var o=(s+(t===c?-1:1))%this._items.length;return-1===o?this._items[this._items.length-1]:this._items[o]},C._triggerSlideEvent=function(e,n){var i=this._getItemIndex(e),s=this._getItemIndex(t(this._element).find(y.ACTIVE_ITEM)[0]),r=t.Event(d.SLIDE,{relatedTarget:e,direction:n,from:s,to:i});return t(this._element).trigger(r),r},C._setActiveIndicatorElement=function(e){if(this._indicatorsElement){t(this._indicatorsElement).find(y.ACTIVE).removeClass(g);var n=this._indicatorsElement.children[this._getItemIndex(e)];n&&t(n).addClass(g)}},C._slide=function(e,n){var i,s,r,o=this,a=t(this._element).find(y.ACTIVE_ITEM)[0],l=this._getItemIndex(a),c=n||a&&this._getItemByDirection(e,a),_=this._getItemIndex(c),C=Boolean(this._interval);if(e===h?(i=v,s=E,r=u):(i=m,s=T,r=f),c&&t(c).hasClass(g))this._isSliding=!1;else if(!this._triggerSlideEvent(c,r).isDefaultPrevented()&&a&&c){this._isSliding=!0,C&&this.pause(),this._setActiveIndicatorElement(c);var I=t.Event(d.SLID,{relatedTarget:c,direction:r,from:l,to:_});P.supportsTransitionEnd()&&t(this._element).hasClass(p)?(t(c).addClass(s),P.reflow(c),t(a).addClass(i),t(c).addClass(i),t(a).one(P.TRANSITION_END,function(){t(c).removeClass(i+" "+s).addClass(g),t(a).removeClass(g+" "+s+" "+i),o._isSliding=!1,setTimeout(function(){return t(o._element).trigger(I)},0)}).emulateTransitionEnd(600)):(t(a).removeClass(g),t(c).addClass(g),this._isSliding=!1,t(this._element).trigger(I)),C&&this.cycle()}},o._jQueryInterface=function(e){return this.each(function(){var i=t(this).data(n),s=r({},a,t(this).data());"object"==typeof e&&(s=r({},s,e));var l="string"==typeof e?e:s.slide;if(i||(i=new o(this,s),t(this).data(n,i)),"number"==typeof e)i.to(e);else if("string"==typeof l){if("undefined"==typeof i[l])throw new TypeError('No method named "'+l+'"');i[l]()}else s.interval&&(i.pause(),i.cycle())})},o._dataApiClickHandler=function(e){var i=P.getSelectorFromElement(this);if(i){var s=t(i)[0];if(s&&t(s).hasClass(_)){var a=r({},t(s).data(),t(this).data()),l=this.getAttribute("data-slide-to");l&&(a.interval=!1),o._jQueryInterface.call(t(s),a),l&&t(s).data(n).to(l),e.preventDefault()}}},s(o,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return a}}]),o}();return t(document).on(d.CLICK_DATA_API,y.DATA_SLIDE,C._dataApiClickHandler),t(window).on(d.LOAD_DATA_API,function(){t(y.DATA_RIDE).each(function(){var e=t(this);C._jQueryInterface.call(e,e.data())})}),t.fn[e]=C._jQueryInterface,t.fn[e].Constructor=C,t.fn[e].noConflict=function(){return t.fn[e]=o,C._jQueryInterface},C}(e),H=function(t){var e="collapse",n="bs.collapse",i="."+n,o=t.fn[e],a={toggle:!0,parent:""},l={toggle:"boolean",parent:"(string|element)"},h={SHOW:"show"+i,SHOWN:"shown"+i,HIDE:"hide"+i,HIDDEN:"hidden"+i,CLICK_DATA_API:"click"+i+".data-api"},c="show",u="collapse",f="collapsing",d="collapsed",_="width",g="height",p={ACTIVES:".show, .collapsing",DATA_TOGGLE:'[data-toggle="collapse"]'},m=function(){function i(e,n){this._isTransitioning=!1,this._element=e,this._config=this._getConfig(n),this._triggerArray=t.makeArray(t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]'));for(var i=t(p.DATA_TOGGLE),s=0;s<i.length;s++){var r=i[s],o=P.getSelectorFromElement(r);null!==o&&t(o).filter(e).length>0&&(this._selector=o,this._triggerArray.push(r))}this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}var o=i.prototype;return o.toggle=function(){t(this._element).hasClass(c)?this.hide():this.show()},o.show=function(){var e,s,r=this;if(!this._isTransitioning&&!t(this._element).hasClass(c)&&(this._parent&&0===(e=t.makeArray(t(this._parent).find(p.ACTIVES).filter('[data-parent="'+this._config.parent+'"]'))).length&&(e=null),!(e&&(s=t(e).not(this._selector).data(n))&&s._isTransitioning))){var o=t.Event(h.SHOW);if(t(this._element).trigger(o),!o.isDefaultPrevented()){e&&(i._jQueryInterface.call(t(e).not(this._selector),"hide"),s||t(e).data(n,null));var a=this._getDimension();t(this._element).removeClass(u).addClass(f),this._element.style[a]=0,this._triggerArray.length>0&&t(this._triggerArray).removeClass(d).attr("aria-expanded",!0),this.setTransitioning(!0);var l=function(){t(r._element).removeClass(f).addClass(u).addClass(c),r._element.style[a]="",r.setTransitioning(!1),t(r._element).trigger(h.SHOWN)};if(P.supportsTransitionEnd()){var _="scroll"+(a[0].toUpperCase()+a.slice(1));t(this._element).one(P.TRANSITION_END,l).emulateTransitionEnd(600),this._element.style[a]=this._element[_]+"px"}else l()}}},o.hide=function(){var e=this;if(!this._isTransitioning&&t(this._element).hasClass(c)){var n=t.Event(h.HIDE);if(t(this._element).trigger(n),!n.isDefaultPrevented()){var i=this._getDimension();if(this._element.style[i]=this._element.getBoundingClientRect()[i]+"px",P.reflow(this._element),t(this._element).addClass(f).removeClass(u).removeClass(c),this._triggerArray.length>0)for(var s=0;s<this._triggerArray.length;s++){var r=this._triggerArray[s],o=P.getSelectorFromElement(r);if(null!==o)t(o).hasClass(c)||t(r).addClass(d).attr("aria-expanded",!1)}this.setTransitioning(!0);var a=function(){e.setTransitioning(!1),t(e._element).removeClass(f).addClass(u).trigger(h.HIDDEN)};this._element.style[i]="",P.supportsTransitionEnd()?t(this._element).one(P.TRANSITION_END,a).emulateTransitionEnd(600):a()}}},o.setTransitioning=function(t){this._isTransitioning=t},o.dispose=function(){t.removeData(this._element,n),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null},o._getConfig=function(t){return(t=r({},a,t)).toggle=Boolean(t.toggle),P.typeCheckConfig(e,t,l),t},o._getDimension=function(){return t(this._element).hasClass(_)?_:g},o._getParent=function(){var e=this,n=null;P.isElement(this._config.parent)?(n=this._config.parent,"undefined"!=typeof this._config.parent.jquery&&(n=this._config.parent[0])):n=t(this._config.parent)[0];var s='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]';return t(n).find(s).each(function(t,n){e._addAriaAndCollapsedClass(i._getTargetFromElement(n),[n])}),n},o._addAriaAndCollapsedClass=function(e,n){if(e){var i=t(e).hasClass(c);n.length>0&&t(n).toggleClass(d,!i).attr("aria-expanded",i)}},i._getTargetFromElement=function(e){var n=P.getSelectorFromElement(e);return n?t(n)[0]:null},i._jQueryInterface=function(e){return this.each(function(){var s=t(this),o=s.data(n),l=r({},a,s.data(),"object"==typeof e&&e);if(!o&&l.toggle&&/show|hide/.test(e)&&(l.toggle=!1),o||(o=new i(this,l),s.data(n,o)),"string"==typeof e){if("undefined"==typeof o[e])throw new TypeError('No method named "'+e+'"');o[e]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return a}}]),i}();return t(document).on(h.CLICK_DATA_API,p.DATA_TOGGLE,function(e){"A"===e.currentTarget.tagName&&e.preventDefault();var i=t(this),s=P.getSelectorFromElement(this);t(s).each(function(){var e=t(this),s=e.data(n)?"toggle":i.data();m._jQueryInterface.call(e,s)})}),t.fn[e]=m._jQueryInterface,t.fn[e].Constructor=m,t.fn[e].noConflict=function(){return t.fn[e]=o,m._jQueryInterface},m}(e),W=function(t){var e="dropdown",i="bs.dropdown",o="."+i,a=".data-api",l=t.fn[e],h=new RegExp("38|40|27"),c={HIDE:"hide"+o,HIDDEN:"hidden"+o,SHOW:"show"+o,SHOWN:"shown"+o,CLICK:"click"+o,CLICK_DATA_API:"click"+o+a,KEYDOWN_DATA_API:"keydown"+o+a,KEYUP_DATA_API:"keyup"+o+a},u="disabled",f="show",d="dropup",_="dropright",g="dropleft",p="dropdown-menu-right",m="dropdown-menu-left",v="position-static",E='[data-toggle="dropdown"]',T=".dropdown form",y=".dropdown-menu",C=".navbar-nav",I=".dropdown-menu .dropdown-item:not(.disabled)",A="top-start",b="top-end",D="bottom-start",S="bottom-end",w="right-start",N="left-start",O={offset:0,flip:!0,boundary:"scrollParent"},k={offset:"(number|string|function)",flip:"boolean",boundary:"(string|element)"},L=function(){function a(t,e){this._element=t,this._popper=null,this._config=this._getConfig(e),this._menu=this._getMenuElement(),this._inNavbar=this._detectNavbar(),this._addEventListeners()}var l=a.prototype;return l.toggle=function(){if(!this._element.disabled&&!t(this._element).hasClass(u)){var e=a._getParentFromElement(this._element),i=t(this._menu).hasClass(f);if(a._clearMenus(),!i){var s={relatedTarget:this._element},r=t.Event(c.SHOW,s);if(t(e).trigger(r),!r.isDefaultPrevented()){if(!this._inNavbar){if("undefined"==typeof n)throw new TypeError("Bootstrap dropdown require Popper.js (https://popper.js.org)");var o=this._element;t(e).hasClass(d)&&(t(this._menu).hasClass(m)||t(this._menu).hasClass(p))&&(o=e),"scrollParent"!==this._config.boundary&&t(e).addClass(v),this._popper=new n(o,this._menu,this._getPopperConfig())}"ontouchstart"in document.documentElement&&0===t(e).closest(C).length&&t("body").children().on("mouseover",null,t.noop),this._element.focus(),this._element.setAttribute("aria-expanded",!0),t(this._menu).toggleClass(f),t(e).toggleClass(f).trigger(t.Event(c.SHOWN,s))}}}},l.dispose=function(){t.removeData(this._element,i),t(this._element).off(o),this._element=null,this._menu=null,null!==this._popper&&(this._popper.destroy(),this._popper=null)},l.update=function(){this._inNavbar=this._detectNavbar(),null!==this._popper&&this._popper.scheduleUpdate()},l._addEventListeners=function(){var e=this;t(this._element).on(c.CLICK,function(t){t.preventDefault(),t.stopPropagation(),e.toggle()})},l._getConfig=function(n){return n=r({},this.constructor.Default,t(this._element).data(),n),P.typeCheckConfig(e,n,this.constructor.DefaultType),n},l._getMenuElement=function(){if(!this._menu){var e=a._getParentFromElement(this._element);this._menu=t(e).find(y)[0]}return this._menu},l._getPlacement=function(){var e=t(this._element).parent(),n=D;return e.hasClass(d)?(n=A,t(this._menu).hasClass(p)&&(n=b)):e.hasClass(_)?n=w:e.hasClass(g)?n=N:t(this._menu).hasClass(p)&&(n=S),n},l._detectNavbar=function(){return t(this._element).closest(".navbar").length>0},l._getPopperConfig=function(){var t=this,e={};return"function"==typeof this._config.offset?e.fn=function(e){return e.offsets=r({},e.offsets,t._config.offset(e.offsets)||{}),e}:e.offset=this._config.offset,{placement:this._getPlacement(),modifiers:{offset:e,flip:{enabled:this._config.flip},preventOverflow:{boundariesElement:this._config.boundary}}}},a._jQueryInterface=function(e){return this.each(function(){var n=t(this).data(i);if(n||(n=new a(this,"object"==typeof e?e:null),t(this).data(i,n)),"string"==typeof e){if("undefined"==typeof n[e])throw new TypeError('No method named "'+e+'"');n[e]()}})},a._clearMenus=function(e){if(!e||3!==e.which&&("keyup"!==e.type||9===e.which))for(var n=t.makeArray(t(E)),s=0;s<n.length;s++){var r=a._getParentFromElement(n[s]),o=t(n[s]).data(i),l={relatedTarget:n[s]};if(o){var h=o._menu;if(t(r).hasClass(f)&&!(e&&("click"===e.type&&/input|textarea/i.test(e.target.tagName)||"keyup"===e.type&&9===e.which)&&t.contains(r,e.target))){var u=t.Event(c.HIDE,l);t(r).trigger(u),u.isDefaultPrevented()||("ontouchstart"in document.documentElement&&t("body").children().off("mouseover",null,t.noop),n[s].setAttribute("aria-expanded","false"),t(h).removeClass(f),t(r).removeClass(f).trigger(t.Event(c.HIDDEN,l)))}}}},a._getParentFromElement=function(e){var n,i=P.getSelectorFromElement(e);return i&&(n=t(i)[0]),n||e.parentNode},a._dataApiKeydownHandler=function(e){if((/input|textarea/i.test(e.target.tagName)?!(32===e.which||27!==e.which&&(40!==e.which&&38!==e.which||t(e.target).closest(y).length)):h.test(e.which))&&(e.preventDefault(),e.stopPropagation(),!this.disabled&&!t(this).hasClass(u))){var n=a._getParentFromElement(this),i=t(n).hasClass(f);if((i||27===e.which&&32===e.which)&&(!i||27!==e.which&&32!==e.which)){var s=t(n).find(I).get();if(0!==s.length){var r=s.indexOf(e.target);38===e.which&&r>0&&r--,40===e.which&&r<s.length-1&&r++,r<0&&(r=0),s[r].focus()}}else{if(27===e.which){var o=t(n).find(E)[0];t(o).trigger("focus")}t(this).trigger("click")}}},s(a,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return O}},{key:"DefaultType",get:function(){return k}}]),a}();return t(document).on(c.KEYDOWN_DATA_API,E,L._dataApiKeydownHandler).on(c.KEYDOWN_DATA_API,y,L._dataApiKeydownHandler).on(c.CLICK_DATA_API+" "+c.KEYUP_DATA_API,L._clearMenus).on(c.CLICK_DATA_API,E,function(e){e.preventDefault(),e.stopPropagation(),L._jQueryInterface.call(t(this),"toggle")}).on(c.CLICK_DATA_API,T,function(t){t.stopPropagation()}),t.fn[e]=L._jQueryInterface,t.fn[e].Constructor=L,t.fn[e].noConflict=function(){return t.fn[e]=l,L._jQueryInterface},L}(e),M=function(t){var e="modal",n="bs.modal",i="."+n,o=t.fn.modal,a={backdrop:!0,keyboard:!0,focus:!0,show:!0},l={backdrop:"(boolean|string)",keyboard:"boolean",focus:"boolean",show:"boolean"},h={HIDE:"hide"+i,HIDDEN:"hidden"+i,SHOW:"show"+i,SHOWN:"shown"+i,FOCUSIN:"focusin"+i,RESIZE:"resize"+i,CLICK_DISMISS:"click.dismiss"+i,KEYDOWN_DISMISS:"keydown.dismiss"+i,MOUSEUP_DISMISS:"mouseup.dismiss"+i,MOUSEDOWN_DISMISS:"mousedown.dismiss"+i,CLICK_DATA_API:"click"+i+".data-api"},c="modal-scrollbar-measure",u="modal-backdrop",f="modal-open",d="fade",_="show",g={DIALOG:".modal-dialog",DATA_TOGGLE:'[data-toggle="modal"]',DATA_DISMISS:'[data-dismiss="modal"]',FIXED_CONTENT:".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",STICKY_CONTENT:".sticky-top",NAVBAR_TOGGLER:".navbar-toggler"},p=function(){function o(e,n){this._config=this._getConfig(n),this._element=e,this._dialog=t(e).find(g.DIALOG)[0],this._backdrop=null,this._isShown=!1,this._isBodyOverflowing=!1,this._ignoreBackdropClick=!1,this._originalBodyPadding=0,this._scrollbarWidth=0}var p=o.prototype;return p.toggle=function(t){return this._isShown?this.hide():this.show(t)},p.show=function(e){var n=this;if(!this._isTransitioning&&!this._isShown){P.supportsTransitionEnd()&&t(this._element).hasClass(d)&&(this._isTransitioning=!0);var i=t.Event(h.SHOW,{relatedTarget:e});t(this._element).trigger(i),this._isShown||i.isDefaultPrevented()||(this._isShown=!0,this._checkScrollbar(),this._setScrollbar(),this._adjustDialog(),t(document.body).addClass(f),this._setEscapeEvent(),this._setResizeEvent(),t(this._element).on(h.CLICK_DISMISS,g.DATA_DISMISS,function(t){return n.hide(t)}),t(this._dialog).on(h.MOUSEDOWN_DISMISS,function(){t(n._element).one(h.MOUSEUP_DISMISS,function(e){t(e.target).is(n._element)&&(n._ignoreBackdropClick=!0)})}),this._showBackdrop(function(){return n._showElement(e)}))}},p.hide=function(e){var n=this;if(e&&e.preventDefault(),!this._isTransitioning&&this._isShown){var i=t.Event(h.HIDE);if(t(this._element).trigger(i),this._isShown&&!i.isDefaultPrevented()){this._isShown=!1;var s=P.supportsTransitionEnd()&&t(this._element).hasClass(d);s&&(this._isTransitioning=!0),this._setEscapeEvent(),this._setResizeEvent(),t(document).off(h.FOCUSIN),t(this._element).removeClass(_),t(this._element).off(h.CLICK_DISMISS),t(this._dialog).off(h.MOUSEDOWN_DISMISS),s?t(this._element).one(P.TRANSITION_END,function(t){return n._hideModal(t)}).emulateTransitionEnd(300):this._hideModal()}}},p.dispose=function(){t.removeData(this._element,n),t(window,document,this._element,this._backdrop).off(i),this._config=null,this._element=null,this._dialog=null,this._backdrop=null,this._isShown=null,this._isBodyOverflowing=null,this._ignoreBackdropClick=null,this._scrollbarWidth=null},p.handleUpdate=function(){this._adjustDialog()},p._getConfig=function(t){return t=r({},a,t),P.typeCheckConfig(e,t,l),t},p._showElement=function(e){var n=this,i=P.supportsTransitionEnd()&&t(this._element).hasClass(d);this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE||document.body.appendChild(this._element),this._element.style.display="block",this._element.removeAttribute("aria-hidden"),this._element.scrollTop=0,i&&P.reflow(this._element),t(this._element).addClass(_),this._config.focus&&this._enforceFocus();var s=t.Event(h.SHOWN,{relatedTarget:e}),r=function(){n._config.focus&&n._element.focus(),n._isTransitioning=!1,t(n._element).trigger(s)};i?t(this._dialog).one(P.TRANSITION_END,r).emulateTransitionEnd(300):r()},p._enforceFocus=function(){var e=this;t(document).off(h.FOCUSIN).on(h.FOCUSIN,function(n){document!==n.target&&e._element!==n.target&&0===t(e._element).has(n.target).length&&e._element.focus()})},p._setEscapeEvent=function(){var e=this;this._isShown&&this._config.keyboard?t(this._element).on(h.KEYDOWN_DISMISS,function(t){27===t.which&&(t.preventDefault(),e.hide())}):this._isShown||t(this._element).off(h.KEYDOWN_DISMISS)},p._setResizeEvent=function(){var e=this;this._isShown?t(window).on(h.RESIZE,function(t){return e.handleUpdate(t)}):t(window).off(h.RESIZE)},p._hideModal=function(){var e=this;this._element.style.display="none",this._element.setAttribute("aria-hidden",!0),this._isTransitioning=!1,this._showBackdrop(function(){t(document.body).removeClass(f),e._resetAdjustments(),e._resetScrollbar(),t(e._element).trigger(h.HIDDEN)})},p._removeBackdrop=function(){this._backdrop&&(t(this._backdrop).remove(),this._backdrop=null)},p._showBackdrop=function(e){var n=this,i=t(this._element).hasClass(d)?d:"";if(this._isShown&&this._config.backdrop){var s=P.supportsTransitionEnd()&&i;if(this._backdrop=document.createElement("div"),this._backdrop.className=u,i&&t(this._backdrop).addClass(i),t(this._backdrop).appendTo(document.body),t(this._element).on(h.CLICK_DISMISS,function(t){n._ignoreBackdropClick?n._ignoreBackdropClick=!1:t.target===t.currentTarget&&("static"===n._config.backdrop?n._element.focus():n.hide())}),s&&P.reflow(this._backdrop),t(this._backdrop).addClass(_),!e)return;if(!s)return void e();t(this._backdrop).one(P.TRANSITION_END,e).emulateTransitionEnd(150)}else if(!this._isShown&&this._backdrop){t(this._backdrop).removeClass(_);var r=function(){n._removeBackdrop(),e&&e()};P.supportsTransitionEnd()&&t(this._element).hasClass(d)?t(this._backdrop).one(P.TRANSITION_END,r).emulateTransitionEnd(150):r()}else e&&e()},p._adjustDialog=function(){var t=this._element.scrollHeight>document.documentElement.clientHeight;!this._isBodyOverflowing&&t&&(this._element.style.paddingLeft=this._scrollbarWidth+"px"),this._isBodyOverflowing&&!t&&(this._element.style.paddingRight=this._scrollbarWidth+"px")},p._resetAdjustments=function(){this._element.style.paddingLeft="",this._element.style.paddingRight=""},p._checkScrollbar=function(){var t=document.body.getBoundingClientRect();this._isBodyOverflowing=t.left+t.right<window.innerWidth,this._scrollbarWidth=this._getScrollbarWidth()},p._setScrollbar=function(){var e=this;if(this._isBodyOverflowing){t(g.FIXED_CONTENT).each(function(n,i){var s=t(i)[0].style.paddingRight,r=t(i).css("padding-right");t(i).data("padding-right",s).css("padding-right",parseFloat(r)+e._scrollbarWidth+"px")}),t(g.STICKY_CONTENT).each(function(n,i){var s=t(i)[0].style.marginRight,r=t(i).css("margin-right");t(i).data("margin-right",s).css("margin-right",parseFloat(r)-e._scrollbarWidth+"px")}),t(g.NAVBAR_TOGGLER).each(function(n,i){var s=t(i)[0].style.marginRight,r=t(i).css("margin-right");t(i).data("margin-right",s).css("margin-right",parseFloat(r)+e._scrollbarWidth+"px")});var n=document.body.style.paddingRight,i=t("body").css("padding-right");t("body").data("padding-right",n).css("padding-right",parseFloat(i)+this._scrollbarWidth+"px")}},p._resetScrollbar=function(){t(g.FIXED_CONTENT).each(function(e,n){var i=t(n).data("padding-right");"undefined"!=typeof i&&t(n).css("padding-right",i).removeData("padding-right")}),t(g.STICKY_CONTENT+", "+g.NAVBAR_TOGGLER).each(function(e,n){var i=t(n).data("margin-right");"undefined"!=typeof i&&t(n).css("margin-right",i).removeData("margin-right")});var e=t("body").data("padding-right");"undefined"!=typeof e&&t("body").css("padding-right",e).removeData("padding-right")},p._getScrollbarWidth=function(){var t=document.createElement("div");t.className=c,document.body.appendChild(t);var e=t.getBoundingClientRect().width-t.clientWidth;return document.body.removeChild(t),e},o._jQueryInterface=function(e,i){return this.each(function(){var s=t(this).data(n),a=r({},o.Default,t(this).data(),"object"==typeof e&&e);if(s||(s=new o(this,a),t(this).data(n,s)),"string"==typeof e){if("undefined"==typeof s[e])throw new TypeError('No method named "'+e+'"');s[e](i)}else a.show&&s.show(i)})},s(o,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return a}}]),o}();return t(document).on(h.CLICK_DATA_API,g.DATA_TOGGLE,function(e){var i,s=this,o=P.getSelectorFromElement(this);o&&(i=t(o)[0]);var a=t(i).data(n)?"toggle":r({},t(i).data(),t(this).data());"A"!==this.tagName&&"AREA"!==this.tagName||e.preventDefault();var l=t(i).one(h.SHOW,function(e){e.isDefaultPrevented()||l.one(h.HIDDEN,function(){t(s).is(":visible")&&s.focus()})});p._jQueryInterface.call(t(i),a,this)}),t.fn.modal=p._jQueryInterface,t.fn.modal.Constructor=p,t.fn.modal.noConflict=function(){return t.fn.modal=o,p._jQueryInterface},p}(e),U=function(t){var e="tooltip",i="bs.tooltip",o="."+i,a=t.fn[e],l=new RegExp("(^|\\s)bs-tooltip\\S+","g"),h={animation:"boolean",template:"string",title:"(string|element|function)",trigger:"string",delay:"(number|object)",html:"boolean",selector:"(string|boolean)",placement:"(string|function)",offset:"(number|string)",container:"(string|element|boolean)",fallbackPlacement:"(string|array)",boundary:"(string|element)"},c={AUTO:"auto",TOP:"top",RIGHT:"right",BOTTOM:"bottom",LEFT:"left"},u={animation:!0,template:'<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,selector:!1,placement:"top",offset:0,container:!1,fallbackPlacement:"flip",boundary:"scrollParent"},f="show",d="out",_={HIDE:"hide"+o,HIDDEN:"hidden"+o,SHOW:"show"+o,SHOWN:"shown"+o,INSERTED:"inserted"+o,CLICK:"click"+o,FOCUSIN:"focusin"+o,FOCUSOUT:"focusout"+o,MOUSEENTER:"mouseenter"+o,MOUSELEAVE:"mouseleave"+o},g="fade",p="show",m=".tooltip-inner",v=".arrow",E="hover",T="focus",y="click",C="manual",I=function(){function a(t,e){if("undefined"==typeof n)throw new TypeError("Bootstrap tooltips require Popper.js (https://popper.js.org)");this._isEnabled=!0,this._timeout=0,this._hoverState="",this._activeTrigger={},this._popper=null,this.element=t,this.config=this._getConfig(e),this.tip=null,this._setListeners()}var I=a.prototype;return I.enable=function(){this._isEnabled=!0},I.disable=function(){this._isEnabled=!1},I.toggleEnabled=function(){this._isEnabled=!this._isEnabled},I.toggle=function(e){if(this._isEnabled)if(e){var n=this.constructor.DATA_KEY,i=t(e.currentTarget).data(n);i||(i=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(n,i)),i._activeTrigger.click=!i._activeTrigger.click,i._isWithActiveTrigger()?i._enter(null,i):i._leave(null,i)}else{if(t(this.getTipElement()).hasClass(p))return void this._leave(null,this);this._enter(null,this)}},I.dispose=function(){clearTimeout(this._timeout),t.removeData(this.element,this.constructor.DATA_KEY),t(this.element).off(this.constructor.EVENT_KEY),t(this.element).closest(".modal").off("hide.bs.modal"),this.tip&&t(this.tip).remove(),this._isEnabled=null,this._timeout=null,this._hoverState=null,this._activeTrigger=null,null!==this._popper&&this._popper.destroy(),this._popper=null,this.element=null,this.config=null,this.tip=null},I.show=function(){var e=this;if("none"===t(this.element).css("display"))throw new Error("Please use show on visible elements");var i=t.Event(this.constructor.Event.SHOW);if(this.isWithContent()&&this._isEnabled){t(this.element).trigger(i);var s=t.contains(this.element.ownerDocument.documentElement,this.element);if(i.isDefaultPrevented()||!s)return;var r=this.getTipElement(),o=P.getUID(this.constructor.NAME);r.setAttribute("id",o),this.element.setAttribute("aria-describedby",o),this.setContent(),this.config.animation&&t(r).addClass(g);var l="function"==typeof this.config.placement?this.config.placement.call(this,r,this.element):this.config.placement,h=this._getAttachment(l);this.addAttachmentClass(h);var c=!1===this.config.container?document.body:t(this.config.container);t(r).data(this.constructor.DATA_KEY,this),t.contains(this.element.ownerDocument.documentElement,this.tip)||t(r).appendTo(c),t(this.element).trigger(this.constructor.Event.INSERTED),this._popper=new n(this.element,r,{placement:h,modifiers:{offset:{offset:this.config.offset},flip:{behavior:this.config.fallbackPlacement},arrow:{element:v},preventOverflow:{boundariesElement:this.config.boundary}},onCreate:function(t){t.originalPlacement!==t.placement&&e._handlePopperPlacementChange(t)},onUpdate:function(t){e._handlePopperPlacementChange(t)}}),t(r).addClass(p),"ontouchstart"in document.documentElement&&t("body").children().on("mouseover",null,t.noop);var u=function(){e.config.animation&&e._fixTransition();var n=e._hoverState;e._hoverState=null,t(e.element).trigger(e.constructor.Event.SHOWN),n===d&&e._leave(null,e)};P.supportsTransitionEnd()&&t(this.tip).hasClass(g)?t(this.tip).one(P.TRANSITION_END,u).emulateTransitionEnd(a._TRANSITION_DURATION):u()}},I.hide=function(e){var n=this,i=this.getTipElement(),s=t.Event(this.constructor.Event.HIDE),r=function(){n._hoverState!==f&&i.parentNode&&i.parentNode.removeChild(i),n._cleanTipClass(),n.element.removeAttribute("aria-describedby"),t(n.element).trigger(n.constructor.Event.HIDDEN),null!==n._popper&&n._popper.destroy(),e&&e()};t(this.element).trigger(s),s.isDefaultPrevented()||(t(i).removeClass(p),"ontouchstart"in document.documentElement&&t("body").children().off("mouseover",null,t.noop),this._activeTrigger[y]=!1,this._activeTrigger[T]=!1,this._activeTrigger[E]=!1,P.supportsTransitionEnd()&&t(this.tip).hasClass(g)?t(i).one(P.TRANSITION_END,r).emulateTransitionEnd(150):r(),this._hoverState="")},I.update=function(){null!==this._popper&&this._popper.scheduleUpdate()},I.isWithContent=function(){return Boolean(this.getTitle())},I.addAttachmentClass=function(e){t(this.getTipElement()).addClass("bs-tooltip-"+e)},I.getTipElement=function(){return this.tip=this.tip||t(this.config.template)[0],this.tip},I.setContent=function(){var e=t(this.getTipElement());this.setElementContent(e.find(m),this.getTitle()),e.removeClass(g+" "+p)},I.setElementContent=function(e,n){var i=this.config.html;"object"==typeof n&&(n.nodeType||n.jquery)?i?t(n).parent().is(e)||e.empty().append(n):e.text(t(n).text()):e[i?"html":"text"](n)},I.getTitle=function(){var t=this.element.getAttribute("data-original-title");return t||(t="function"==typeof this.config.title?this.config.title.call(this.element):this.config.title),t},I._getAttachment=function(t){return c[t.toUpperCase()]},I._setListeners=function(){var e=this;this.config.trigger.split(" ").forEach(function(n){if("click"===n)t(e.element).on(e.constructor.Event.CLICK,e.config.selector,function(t){return e.toggle(t)});else if(n!==C){var i=n===E?e.constructor.Event.MOUSEENTER:e.constructor.Event.FOCUSIN,s=n===E?e.constructor.Event.MOUSELEAVE:e.constructor.Event.FOCUSOUT;t(e.element).on(i,e.config.selector,function(t){return e._enter(t)}).on(s,e.config.selector,function(t){return e._leave(t)})}t(e.element).closest(".modal").on("hide.bs.modal",function(){return e.hide()})}),this.config.selector?this.config=r({},this.config,{trigger:"manual",selector:""}):this._fixTitle()},I._fixTitle=function(){var t=typeof this.element.getAttribute("data-original-title");(this.element.getAttribute("title")||"string"!==t)&&(this.element.setAttribute("data-original-title",this.element.getAttribute("title")||""),this.element.setAttribute("title",""))},I._enter=function(e,n){var i=this.constructor.DATA_KEY;(n=n||t(e.currentTarget).data(i))||(n=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(i,n)),e&&(n._activeTrigger["focusin"===e.type?T:E]=!0),t(n.getTipElement()).hasClass(p)||n._hoverState===f?n._hoverState=f:(clearTimeout(n._timeout),n._hoverState=f,n.config.delay&&n.config.delay.show?n._timeout=setTimeout(function(){n._hoverState===f&&n.show()},n.config.delay.show):n.show())},I._leave=function(e,n){var i=this.constructor.DATA_KEY;(n=n||t(e.currentTarget).data(i))||(n=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(i,n)),e&&(n._activeTrigger["focusout"===e.type?T:E]=!1),n._isWithActiveTrigger()||(clearTimeout(n._timeout),n._hoverState=d,n.config.delay&&n.config.delay.hide?n._timeout=setTimeout(function(){n._hoverState===d&&n.hide()},n.config.delay.hide):n.hide())},I._isWithActiveTrigger=function(){for(var t in this._activeTrigger)if(this._activeTrigger[t])return!0;return!1},I._getConfig=function(n){return"number"==typeof(n=r({},this.constructor.Default,t(this.element).data(),n)).delay&&(n.delay={show:n.delay,hide:n.delay}),"number"==typeof n.title&&(n.title=n.title.toString()),"number"==typeof n.content&&(n.content=n.content.toString()),P.typeCheckConfig(e,n,this.constructor.DefaultType),n},I._getDelegateConfig=function(){var t={};if(this.config)for(var e in this.config)this.constructor.Default[e]!==this.config[e]&&(t[e]=this.config[e]);return t},I._cleanTipClass=function(){var e=t(this.getTipElement()),n=e.attr("class").match(l);null!==n&&n.length>0&&e.removeClass(n.join(""))},I._handlePopperPlacementChange=function(t){this._cleanTipClass(),this.addAttachmentClass(this._getAttachment(t.placement))},I._fixTransition=function(){var e=this.getTipElement(),n=this.config.animation;null===e.getAttribute("x-placement")&&(t(e).removeClass(g),this.config.animation=!1,this.hide(),this.show(),this.config.animation=n)},a._jQueryInterface=function(e){return this.each(function(){var n=t(this).data(i),s="object"==typeof e&&e;if((n||!/dispose|hide/.test(e))&&(n||(n=new a(this,s),t(this).data(i,n)),"string"==typeof e)){if("undefined"==typeof n[e])throw new TypeError('No method named "'+e+'"');n[e]()}})},s(a,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return u}},{key:"NAME",get:function(){return e}},{key:"DATA_KEY",get:function(){return i}},{key:"Event",get:function(){return _}},{key:"EVENT_KEY",get:function(){return o}},{key:"DefaultType",get:function(){return h}}]),a}();return t.fn[e]=I._jQueryInterface,t.fn[e].Constructor=I,t.fn[e].noConflict=function(){return t.fn[e]=a,I._jQueryInterface},I}(e),x=function(t){var e="popover",n="bs.popover",i="."+n,o=t.fn[e],a=new RegExp("(^|\\s)bs-popover\\S+","g"),l=r({},U.Default,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'}),h=r({},U.DefaultType,{content:"(string|element|function)"}),c="fade",u="show",f=".popover-header",d=".popover-body",_={HIDE:"hide"+i,HIDDEN:"hidden"+i,SHOW:"show"+i,SHOWN:"shown"+i,INSERTED:"inserted"+i,CLICK:"click"+i,FOCUSIN:"focusin"+i,FOCUSOUT:"focusout"+i,MOUSEENTER:"mouseenter"+i,MOUSELEAVE:"mouseleave"+i},g=function(r){var o,g;function p(){return r.apply(this,arguments)||this}g=r,(o=p).prototype=Object.create(g.prototype),o.prototype.constructor=o,o.__proto__=g;var m=p.prototype;return m.isWithContent=function(){return this.getTitle()||this._getContent()},m.addAttachmentClass=function(e){t(this.getTipElement()).addClass("bs-popover-"+e)},m.getTipElement=function(){return this.tip=this.tip||t(this.config.template)[0],this.tip},m.setContent=function(){var e=t(this.getTipElement());this.setElementContent(e.find(f),this.getTitle());var n=this._getContent();"function"==typeof n&&(n=n.call(this.element)),this.setElementContent(e.find(d),n),e.removeClass(c+" "+u)},m._getContent=function(){return this.element.getAttribute("data-content")||this.config.content},m._cleanTipClass=function(){var e=t(this.getTipElement()),n=e.attr("class").match(a);null!==n&&n.length>0&&e.removeClass(n.join(""))},p._jQueryInterface=function(e){return this.each(function(){var i=t(this).data(n),s="object"==typeof e?e:null;if((i||!/destroy|hide/.test(e))&&(i||(i=new p(this,s),t(this).data(n,i)),"string"==typeof e)){if("undefined"==typeof i[e])throw new TypeError('No method named "'+e+'"');i[e]()}})},s(p,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return l}},{key:"NAME",get:function(){return e}},{key:"DATA_KEY",get:function(){return n}},{key:"Event",get:function(){return _}},{key:"EVENT_KEY",get:function(){return i}},{key:"DefaultType",get:function(){return h}}]),p}(U);return t.fn[e]=g._jQueryInterface,t.fn[e].Constructor=g,t.fn[e].noConflict=function(){return t.fn[e]=o,g._jQueryInterface},g}(e),K=function(t){var e="scrollspy",n="bs.scrollspy",i="."+n,o=t.fn[e],a={offset:10,method:"auto",target:""},l={offset:"number",method:"string",target:"(string|element)"},h={ACTIVATE:"activate"+i,SCROLL:"scroll"+i,LOAD_DATA_API:"load"+i+".data-api"},c="dropdown-item",u="active",f={DATA_SPY:'[data-spy="scroll"]',ACTIVE:".active",NAV_LIST_GROUP:".nav, .list-group",NAV_LINKS:".nav-link",NAV_ITEMS:".nav-item",LIST_ITEMS:".list-group-item",DROPDOWN:".dropdown",DROPDOWN_ITEMS:".dropdown-item",DROPDOWN_TOGGLE:".dropdown-toggle"},d="offset",_="position",g=function(){function o(e,n){var i=this;this._element=e,this._scrollElement="BODY"===e.tagName?window:e,this._config=this._getConfig(n),this._selector=this._config.target+" "+f.NAV_LINKS+","+this._config.target+" "+f.LIST_ITEMS+","+this._config.target+" "+f.DROPDOWN_ITEMS,this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,t(this._scrollElement).on(h.SCROLL,function(t){return i._process(t)}),this.refresh(),this._process()}var g=o.prototype;return g.refresh=function(){var e=this,n=this._scrollElement===this._scrollElement.window?d:_,i="auto"===this._config.method?n:this._config.method,s=i===_?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight(),t.makeArray(t(this._selector)).map(function(e){var n,r=P.getSelectorFromElement(e);if(r&&(n=t(r)[0]),n){var o=n.getBoundingClientRect();if(o.width||o.height)return[t(n)[i]().top+s,r]}return null}).filter(function(t){return t}).sort(function(t,e){return t[0]-e[0]}).forEach(function(t){e._offsets.push(t[0]),e._targets.push(t[1])})},g.dispose=function(){t.removeData(this._element,n),t(this._scrollElement).off(i),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null},g._getConfig=function(n){if("string"!=typeof(n=r({},a,n)).target){var i=t(n.target).attr("id");i||(i=P.getUID(e),t(n.target).attr("id",i)),n.target="#"+i}return P.typeCheckConfig(e,n,l),n},g._getScrollTop=function(){return this._scrollElement===window?this._scrollElement.pageYOffset:this._scrollElement.scrollTop},g._getScrollHeight=function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)},g._getOffsetHeight=function(){return this._scrollElement===window?window.innerHeight:this._scrollElement.getBoundingClientRect().height},g._process=function(){var t=this._getScrollTop()+this._config.offset,e=this._getScrollHeight(),n=this._config.offset+e-this._getOffsetHeight();if(this._scrollHeight!==e&&this.refresh(),t>=n){var i=this._targets[this._targets.length-1];this._activeTarget!==i&&this._activate(i)}else{if(this._activeTarget&&t<this._offsets[0]&&this._offsets[0]>0)return this._activeTarget=null,void this._clear();for(var s=this._offsets.length;s--;){this._activeTarget!==this._targets[s]&&t>=this._offsets[s]&&("undefined"==typeof this._offsets[s+1]||t<this._offsets[s+1])&&this._activate(this._targets[s])}}},g._activate=function(e){this._activeTarget=e,this._clear();var n=this._selector.split(",");n=n.map(function(t){return t+'[data-target="'+e+'"],'+t+'[href="'+e+'"]'});var i=t(n.join(","));i.hasClass(c)?(i.closest(f.DROPDOWN).find(f.DROPDOWN_TOGGLE).addClass(u),i.addClass(u)):(i.addClass(u),i.parents(f.NAV_LIST_GROUP).prev(f.NAV_LINKS+", "+f.LIST_ITEMS).addClass(u),i.parents(f.NAV_LIST_GROUP).prev(f.NAV_ITEMS).children(f.NAV_LINKS).addClass(u)),t(this._scrollElement).trigger(h.ACTIVATE,{relatedTarget:e})},g._clear=function(){t(this._selector).filter(f.ACTIVE).removeClass(u)},o._jQueryInterface=function(e){return this.each(function(){var i=t(this).data(n);if(i||(i=new o(this,"object"==typeof e&&e),t(this).data(n,i)),"string"==typeof e){if("undefined"==typeof i[e])throw new TypeError('No method named "'+e+'"');i[e]()}})},s(o,null,[{key:"VERSION",get:function(){return"4.0.0"}},{key:"Default",get:function(){return a}}]),o}();return t(window).on(h.LOAD_DATA_API,function(){for(var e=t.makeArray(t(f.DATA_SPY)),n=e.length;n--;){var i=t(e[n]);g._jQueryInterface.call(i,i.data())}}),t.fn[e]=g._jQueryInterface,t.fn[e].Constructor=g,t.fn[e].noConflict=function(){return t.fn[e]=o,g._jQueryInterface},g}(e),V=function(t){var e="bs.tab",n="."+e,i=t.fn.tab,r={HIDE:"hide"+n,HIDDEN:"hidden"+n,SHOW:"show"+n,SHOWN:"shown"+n,CLICK_DATA_API:"click.bs.tab.data-api"},o="dropdown-menu",a="active",l="disabled",h="fade",c="show",u=".dropdown",f=".nav, .list-group",d=".active",_="> li > .active",g='[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',p=".dropdown-toggle",m="> .dropdown-menu .active",v=function(){function n(t){this._element=t}var i=n.prototype;return i.show=function(){var e=this;if(!(this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE&&t(this._element).hasClass(a)||t(this._element).hasClass(l))){var n,i,s=t(this._element).closest(f)[0],o=P.getSelectorFromElement(this._element);if(s){var h="UL"===s.nodeName?_:d;i=(i=t.makeArray(t(s).find(h)))[i.length-1]}var c=t.Event(r.HIDE,{relatedTarget:this._element}),u=t.Event(r.SHOW,{relatedTarget:i});if(i&&t(i).trigger(c),t(this._element).trigger(u),!u.isDefaultPrevented()&&!c.isDefaultPrevented()){o&&(n=t(o)[0]),this._activate(this._element,s);var g=function(){var n=t.Event(r.HIDDEN,{relatedTarget:e._element}),s=t.Event(r.SHOWN,{relatedTarget:i});t(i).trigger(n),t(e._element).trigger(s)};n?this._activate(n,n.parentNode,g):g()}}},i.dispose=function(){t.removeData(this._element,e),this._element=null},i._activate=function(e,n,i){var s=this,r=("UL"===n.nodeName?t(n).find(_):t(n).children(d))[0],o=i&&P.supportsTransitionEnd()&&r&&t(r).hasClass(h),a=function(){return s._transitionComplete(e,r,i)};r&&o?t(r).one(P.TRANSITION_END,a).emulateTransitionEnd(150):a()},i._transitionComplete=function(e,n,i){if(n){t(n).removeClass(c+" "+a);var s=t(n.parentNode).find(m)[0];s&&t(s).removeClass(a),"tab"===n.getAttribute("role")&&n.setAttribute("aria-selected",!1)}if(t(e).addClass(a),"tab"===e.getAttribute("role")&&e.setAttribute("aria-selected",!0),P.reflow(e),t(e).addClass(c),e.parentNode&&t(e.parentNode).hasClass(o)){var r=t(e).closest(u)[0];r&&t(r).find(p).addClass(a),e.setAttribute("aria-expanded",!0)}i&&i()},n._jQueryInterface=function(i){return this.each(function(){var s=t(this),r=s.data(e);if(r||(r=new n(this),s.data(e,r)),"string"==typeof i){if("undefined"==typeof r[i])throw new TypeError('No method named "'+i+'"');r[i]()}})},s(n,null,[{key:"VERSION",get:function(){return"4.0.0"}}]),n}();return t(document).on(r.CLICK_DATA_API,g,function(e){e.preventDefault(),v._jQueryInterface.call(t(this),"show")}),t.fn.tab=v._jQueryInterface,t.fn.tab.Constructor=v,t.fn.tab.noConflict=function(){return t.fn.tab=i,v._jQueryInterface},v}(e);!function(t){if("undefined"==typeof t)throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1===e[0]&&9===e[1]&&e[2]<1||e[0]>=4)throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}(e),t.Util=P,t.Alert=L,t.Button=R,t.Carousel=j,t.Collapse=H,t.Dropdown=W,t.Modal=M,t.Popover=x,t.Scrollspy=K,t.Tab=V,t.Tooltip=U,Object.defineProperty(t,"__esModule",{value:!0})});
//# sourceMappingURL=bootstrap.min.js.map
"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*
 *
 * More info at [www.dropzonejs.com](http://www.dropzonejs.com)
 *
 * Copyright (c) 2012, Matias Meno
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

// The Emitter class provides the ability to call `.on()` on Dropzone to listen
// to events.
// It is strongly based on component's emitter class, and I removed the
// functionality because of the dependency hell with different frameworks.
var Emitter = function () {
    function Emitter() {
        _classCallCheck(this, Emitter);
    }

    _createClass(Emitter, [{
        key: "on",

        // Add an event listener for given event
        value: function on(event, fn) {
            this._callbacks = this._callbacks || {};
            // Create namespace for this event
            if (!this._callbacks[event]) {
                this._callbacks[event] = [];
            }
            this._callbacks[event].push(fn);
            return this;
        }
    }, {
        key: "emit",
        value: function emit(event) {
            this._callbacks = this._callbacks || {};
            var callbacks = this._callbacks[event];

            if (callbacks) {
                for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                    args[_key - 1] = arguments[_key];
                }

                for (var _iterator = callbacks, _isArray = true, _i = 0, _iterator = _isArray ? _iterator : _iterator[Symbol.iterator]();;) {
                    var _ref;

                    if (_isArray) {
                        if (_i >= _iterator.length) break;
                        _ref = _iterator[_i++];
                    } else {
                        _i = _iterator.next();
                        if (_i.done) break;
                        _ref = _i.value;
                    }

                    var callback = _ref;

                    callback.apply(this, args);
                }
            }

            return this;
        }

        // Remove event listener for given event. If fn is not provided, all event
        // listeners for that event will be removed. If neither is provided, all
        // event listeners will be removed.

    }, {
        key: "off",
        value: function off(event, fn) {
            if (!this._callbacks || arguments.length === 0) {
                this._callbacks = {};
                return this;
            }

            // specific event
            var callbacks = this._callbacks[event];
            if (!callbacks) {
                return this;
            }

            // remove all handlers
            if (arguments.length === 1) {
                delete this._callbacks[event];
                return this;
            }

            // remove specific handler
            for (var i = 0; i < callbacks.length; i++) {
                var callback = callbacks[i];
                if (callback === fn) {
                    callbacks.splice(i, 1);
                    break;
                }
            }

            return this;
        }
    }]);

    return Emitter;
}();

var Dropzone = function (_Emitter) {
    _inherits(Dropzone, _Emitter);

    _createClass(Dropzone, null, [{
        key: "initClass",
        value: function initClass() {

            // Exposing the emitter class, mainly for tests
            this.prototype.Emitter = Emitter;

            /*
             This is a list of all available events you can register on a dropzone object.
             You can register an event handler like this:
             dropzone.on("dragEnter", function() { });
             */
            this.prototype.events = ["drop", "dragstart", "dragend", "dragenter", "dragover", "dragleave", "addedfile", "addedfiles", "removedfile", "thumbnail", "error", "errormultiple", "processing", "processingmultiple", "uploadprogress", "totaluploadprogress", "sending", "sendingmultiple", "success", "successmultiple", "canceled", "canceledmultiple", "complete", "completemultiple", "reset", "maxfilesexceeded", "maxfilesreached", "queuecomplete"];

            this.prototype.defaultOptions = {
                /**
                 * Has to be specified on elements other than form (or when the form
                 * doesn't have an `action` attribute). You can also
                 * provide a function that will be called with `files` and
                 * must return the url (since `v3.12.0`)
                 */
                url: null,

                /**
                 * Can be changed to `"put"` if necessary. You can also provide a function
                 * that will be called with `files` and must return the method (since `v3.12.0`).
                 */
                method: "post",

                /**
                 * Will be set on the XHRequest.
                 */
                withCredentials: false,

                /**
                 * The timeout for the XHR requests in milliseconds (since `v4.4.0`).
                 */
                timeout: 30000,

                /**
                 * How many file uploads to process in parallel (See the
                 * Enqueuing file uploads* documentation section for more info)
                 */
                parallelUploads: 2,

                /**
                 * Whether to send multiple files in one request. If
                 * this it set to true, then the fallback file input element will
                 * have the `multiple` attribute as well. This option will
                 * also trigger additional events (like `processingmultiple`). See the events
                 * documentation section for more information.
                 */
                uploadMultiple: false,

                /**
                 * Whether you want files to be uploaded in chunks to your server. This can't be
                 * used in combination with `uploadMultiple`.
                 *
                 * See [chunksUploaded](#config-chunksUploaded) for the callback to finalise an upload.
                 */
                chunking: false,

                /**
                 * If `chunking` is enabled, this defines whether **every** file should be chunked,
                 * even if the file size is below chunkSize. This means, that the additional chunk
                 * form data will be submitted and the `chunksUploaded` callback will be invoked.
                 */
                forceChunking: false,

                /**
                 * If `chunking` is `true`, then this defines the chunk size in bytes.
                 */
                chunkSize: 2000000,

                /**
                 * If `true`, the individual chunks of a file are being uploaded simultaneously.
                 */
                parallelChunkUploads: false,

                /**
                 * Whether a chunk should be retried if it fails.
                 */
                retryChunks: false,

                /**
                 * If `retryChunks` is true, how many times should it be retried.
                 */
                retryChunksLimit: 3,

                /**
                 * If not `null` defines how many files this Dropzone handles. If it exceeds,
                 * the event `maxfilesexceeded` will be called. The dropzone element gets the
                 * class `dz-max-files-reached` accordingly so you can provide visual feedback.
                 */
                maxFilesize: 256,

                /**
                 * The name of the file param that gets transferred.
                 * **NOTE**: If you have the option  `uploadMultiple` set to `true`, then
                 * Dropzone will append `[]` to the name.
                 */
                paramName: "file",

                /**
                 * Whether thumbnails for images should be generated
                 */
                createImageThumbnails: true,

                /**
                 * In MB. When the filename exceeds this limit, the thumbnail will not be generated.
                 */
                maxThumbnailFilesize: 10,

                /**
                 * If `null`, the ratio of the image will be used to calculate it.
                 */
                thumbnailWidth: 120,

                /**
                 * The same as `thumbnailWidth`. If both are null, images will not be resized.
                 */
                thumbnailHeight: 120,

                /**
                 * How the images should be scaled down in case both, `thumbnailWidth` and `thumbnailHeight` are provided.
                 * Can be either `contain` or `crop`.
                 */
                thumbnailMethod: 'crop',

                /**
                 * If set, images will be resized to these dimensions before being **uploaded**.
                 * If only one, `resizeWidth` **or** `resizeHeight` is provided, the original aspect
                 * ratio of the file will be preserved.
                 *
                 * The `options.transformFile` function uses these options, so if the `transformFile` function
                 * is overridden, these options don't do anything.
                 */
                resizeWidth: null,

                /**
                 * See `resizeWidth`.
                 */
                resizeHeight: null,

                /**
                 * The mime type of the resized image (before it gets uploaded to the server).
                 * If `null` the original mime type will be used. To force jpeg, for example, use `image/jpeg`.
                 * See `resizeWidth` for more information.
                 */
                resizeMimeType: null,

                /**
                 * The quality of the resized images. See `resizeWidth`.
                 */
                resizeQuality: 0.8,

                /**
                 * How the images should be scaled down in case both, `resizeWidth` and `resizeHeight` are provided.
                 * Can be either `contain` or `crop`.
                 */
                resizeMethod: 'contain',

                /**
                 * The base that is used to calculate the filesize. You can change this to
                 * 1024 if you would rather display kibibytes, mebibytes, etc...
                 * 1024 is technically incorrect, because `1024 bytes` are `1 kibibyte` not `1 kilobyte`.
                 * You can change this to `1024` if you don't care about validity.
                 */
                filesizeBase: 1000,

                /**
                 * Can be used to limit the maximum number of files that will be handled by this Dropzone
                 */
                maxFiles: null,

                /**
                 * An optional object to send additional headers to the server. Eg:
                 * `{ "My-Awesome-Header": "header value" }`
                 */
                headers: null,

                /**
                 * If `true`, the dropzone element itself will be clickable, if `false`
                 * nothing will be clickable.
                 *
                 * You can also pass an HTML element, a CSS selector (for multiple elements)
                 * or an array of those. In that case, all of those elements will trigger an
                 * upload when clicked.
                 */
                clickable: true,

                /**
                 * Whether hidden files in directories should be ignored.
                 */
                ignoreHiddenFiles: true,

                /**
                 * The default implementation of `accept` checks the file's mime type or
                 * extension against this list. This is a comma separated list of mime
                 * types or file extensions.
                 *
                 * Eg.: `image/*,application/pdf,.psd`
                 *
                 * If the Dropzone is `clickable` this option will also be used as
                 * [`accept`](https://developer.mozilla.org/en-US/docs/HTML/Element/input#attr-accept)
                 * parameter on the hidden file input as well.
                 */
                acceptedFiles: null,

                /**
                 * **Deprecated!**
                 * Use acceptedFiles instead.
                 */
                acceptedMimeTypes: null,

                /**
                 * If false, files will be added to the queue but the queue will not be
                 * processed automatically.
                 * This can be useful if you need some additional user input before sending
                 * files (or if you want want all files sent at once).
                 * If you're ready to send the file simply call `myDropzone.processQueue()`.
                 *
                 * See the [enqueuing file uploads](#enqueuing-file-uploads) documentation
                 * section for more information.
                 */
                autoProcessQueue: true,

                /**
                 * If false, files added to the dropzone will not be queued by default.
                 * You'll have to call `enqueueFile(file)` manually.
                 */
                autoQueue: true,

                /**
                 * If `true`, this will add a link to every file preview to remove or cancel (if
                 * already uploading) the file. The `dictCancelUpload`, `dictCancelUploadConfirmation`
                 * and `dictRemoveFile` options are used for the wording.
                 */
                addRemoveLinks: false,

                /**
                 * Defines where to display the file previews – if `null` the
                 * Dropzone element itself is used. Can be a plain `HTMLElement` or a CSS
                 * selector. The element should have the `dropzone-previews` class so
                 * the previews are displayed properly.
                 */
                previewsContainer: null,

                /**
                 * This is the element the hidden input field (which is used when clicking on the
                 * dropzone to trigger file selection) will be appended to. This might
                 * be important in case you use frameworks to switch the content of your page.
                 */
                hiddenInputContainer: "body",

                /**
                 * If null, no capture type will be specified
                 * If camera, mobile devices will skip the file selection and choose camera
                 * If microphone, mobile devices will skip the file selection and choose the microphone
                 * If camcorder, mobile devices will skip the file selection and choose the camera in video mode
                 * On apple devices multiple must be set to false.  AcceptedFiles may need to
                 * be set to an appropriate mime type (e.g. "image/*", "audio/*", or "video/*").
                 */
                capture: null,

                /**
                 * **Deprecated**. Use `renameFile` instead.
                 */
                renameFilename: null,

                /**
                 * A function that is invoked before the file is uploaded to the server and renames the file.
                 * This function gets the `File` as argument and can use the `file.name`. The actual name of the
                 * file that gets used during the upload can be accessed through `file.upload.filename`.
                 */
                renameFile: null,

                /**
                 * If `true` the fallback will be forced. This is very useful to test your server
                 * implementations first and make sure that everything works as
                 * expected without dropzone if you experience problems, and to test
                 * how your fallbacks will look.
                 */
                forceFallback: false,

                /**
                 * The text used before any files are dropped.
                 */
                dictDefaultMessage: "Drop files here to upload",

                /**
                 * The text that replaces the default message text it the browser is not supported.
                 */
                dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",

                /**
                 * The text that will be added before the fallback form.
                 * If you provide a  fallback element yourself, or if this option is `null` this will
                 * be ignored.
                 */
                dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",

                /**
                 * If the filesize is too big.
                 * `{{filesize}}` and `{{maxFilesize}}` will be replaced with the respective configuration values.
                 */
                dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",

                /**
                 * If the file doesn't match the file type.
                 */
                dictInvalidFileType: "You can't upload files of this type.",

                /**
                 * If the server response was invalid.
                 * `{{statusCode}}` will be replaced with the servers status code.
                 */
                dictResponseError: "Server responded with {{statusCode}} code.",

                /**
                 * If `addRemoveLinks` is true, the text to be used for the cancel upload link.
                 */
                dictCancelUpload: "Cancel upload",

                /**
                 * The text that is displayed if an upload was manually canceled
                 */
                dictUploadCanceled: "Upload canceled.",

                /**
                 * If `addRemoveLinks` is true, the text to be used for confirmation when cancelling upload.
                 */
                dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",

                /**
                 * If `addRemoveLinks` is true, the text to be used to remove a file.
                 */
                dictRemoveFile: "Remove file",

                /**
                 * If this is not null, then the user will be prompted before removing a file.
                 */
                dictRemoveFileConfirmation: null,

                /**
                 * Displayed if `maxFiles` is st and exceeded.
                 * The string `{{maxFiles}}` will be replaced by the configuration value.
                 */
                dictMaxFilesExceeded: "You can not upload any more files.",

                /**
                 * Allows you to translate the different units. Starting with `tb` for terabytes and going down to
                 * `b` for bytes.
                 */
                dictFileSizeUnits: { tb: "TB", gb: "GB", mb: "MB", kb: "KB", b: "b" },
                /**
                 * Called when dropzone initialized
                 * You can add event listeners here
                 */
                init: function init() {},


                /**
                 * Can be an **object** of additional parameters to transfer to the server, **or** a `Function`
                 * that gets invoked with the `files`, `xhr` and, if it's a chunked upload, `chunk` arguments. In case
                 * of a function, this needs to return a map.
                 *
                 * The default implementation does nothing for normal uploads, but adds relevant information for
                 * chunked uploads.
                 *
                 * This is the same as adding hidden input fields in the form element.
                 */
                params: function params(files, xhr, chunk) {
                    if (chunk) {
                        return {
                            dzuuid: chunk.file.upload.uuid,
                            dzchunkindex: chunk.index,
                            dztotalfilesize: chunk.file.size,
                            dzchunksize: this.options.chunkSize,
                            dztotalchunkcount: chunk.file.upload.totalChunkCount,
                            dzchunkbyteoffset: chunk.index * this.options.chunkSize
                        };
                    }
                },


                /**
                 * A function that gets a [file](https://developer.mozilla.org/en-US/docs/DOM/File)
                 * and a `done` function as parameters.
                 *
                 * If the done function is invoked without arguments, the file is "accepted" and will
                 * be processed. If you pass an error message, the file is rejected, and the error
                 * message will be displayed.
                 * This function will not be called if the file is too big or doesn't match the mime types.
                 */
                accept: function accept(file, done) {
                    return done();
                },


                /**
                 * The callback that will be invoked when all chunks have been uploaded for a file.
                 * It gets the file for which the chunks have been uploaded as the first parameter,
                 * and the `done` function as second. `done()` needs to be invoked when everything
                 * needed to finish the upload process is done.
                 */
                chunksUploaded: function chunksUploaded(file, done) {
                    done();
                },

                /**
                 * Gets called when the browser is not supported.
                 * The default implementation shows the fallback input field and adds
                 * a text.
                 */
                fallback: function fallback() {
                    // This code should pass in IE7... :(
                    var messageElement = void 0;
                    this.element.className = this.element.className + " dz-browser-not-supported";

                    for (var _iterator2 = this.element.getElementsByTagName("div"), _isArray2 = true, _i2 = 0, _iterator2 = _isArray2 ? _iterator2 : _iterator2[Symbol.iterator]();;) {
                        var _ref2;

                        if (_isArray2) {
                            if (_i2 >= _iterator2.length) break;
                            _ref2 = _iterator2[_i2++];
                        } else {
                            _i2 = _iterator2.next();
                            if (_i2.done) break;
                            _ref2 = _i2.value;
                        }

                        var child = _ref2;

                        if (/(^| )dz-message($| )/.test(child.className)) {
                            messageElement = child;
                            child.className = "dz-message"; // Removes the 'dz-default' class
                            break;
                        }
                    }
                    if (!messageElement) {
                        messageElement = Dropzone.createElement("<div class=\"dz-message\"><span></span></div>");
                        this.element.appendChild(messageElement);
                    }

                    var span = messageElement.getElementsByTagName("span")[0];
                    if (span) {
                        if (span.textContent != null) {
                            span.textContent = this.options.dictFallbackMessage;
                        } else if (span.innerText != null) {
                            span.innerText = this.options.dictFallbackMessage;
                        }
                    }

                    return this.element.appendChild(this.getFallbackForm());
                },


                /**
                 * Gets called to calculate the thumbnail dimensions.
                 *
                 * It gets `file`, `width` and `height` (both may be `null`) as parameters and must return an object containing:
                 *
                 *  - `srcWidth` & `srcHeight` (required)
                 *  - `trgWidth` & `trgHeight` (required)
                 *  - `srcX` & `srcY` (optional, default `0`)
                 *  - `trgX` & `trgY` (optional, default `0`)
                 *
                 * Those values are going to be used by `ctx.drawImage()`.
                 */
                resize: function resize(file, width, height, resizeMethod) {
                    var info = {
                        srcX: 0,
                        srcY: 0,
                        srcWidth: file.width,
                        srcHeight: file.height
                    };

                    var srcRatio = file.width / file.height;

                    // Automatically calculate dimensions if not specified
                    if (width == null && height == null) {
                        width = info.srcWidth;
                        height = info.srcHeight;
                    } else if (width == null) {
                        width = height * srcRatio;
                    } else if (height == null) {
                        height = width / srcRatio;
                    }

                    // Make sure images aren't upscaled
                    width = Math.min(width, info.srcWidth);
                    height = Math.min(height, info.srcHeight);

                    var trgRatio = width / height;

                    if (info.srcWidth > width || info.srcHeight > height) {
                        // Image is bigger and needs rescaling
                        if (resizeMethod === 'crop') {
                            if (srcRatio > trgRatio) {
                                info.srcHeight = file.height;
                                info.srcWidth = info.srcHeight * trgRatio;
                            } else {
                                info.srcWidth = file.width;
                                info.srcHeight = info.srcWidth / trgRatio;
                            }
                        } else if (resizeMethod === 'contain') {
                            // Method 'contain'
                            if (srcRatio > trgRatio) {
                                height = width / srcRatio;
                            } else {
                                width = height * srcRatio;
                            }
                        } else {
                            throw new Error("Unknown resizeMethod '" + resizeMethod + "'");
                        }
                    }

                    info.srcX = (file.width - info.srcWidth) / 2;
                    info.srcY = (file.height - info.srcHeight) / 2;

                    info.trgWidth = width;
                    info.trgHeight = height;

                    return info;
                },


                /**
                 * Can be used to transform the file (for example, resize an image if necessary).
                 *
                 * The default implementation uses `resizeWidth` and `resizeHeight` (if provided) and resizes
                 * images according to those dimensions.
                 *
                 * Gets the `file` as the first parameter, and a `done()` function as the second, that needs
                 * to be invoked with the file when the transformation is done.
                 */
                transformFile: function transformFile(file, done) {
                    if ((this.options.resizeWidth || this.options.resizeHeight) && file.type.match(/image.*/)) {
                        return this.resizeImage(file, this.options.resizeWidth, this.options.resizeHeight, this.options.resizeMethod, done);
                    } else {
                        return done(file);
                    }
                },


                /**
                 * A string that contains the template used for each dropped
                 * file. Change it to fulfill your needs but make sure to properly
                 * provide all elements.
                 *
                 * If you want to use an actual HTML element instead of providing a String
                 * as a config option, you could create a div with the id `tpl`,
                 * put the template inside it and provide the element like this:
                 *
                 *     document
                 *       .querySelector('#tpl')
                 *       .innerHTML
                 *
                 */
                previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>",

                // END OPTIONS
                // (Required by the dropzone documentation parser)


                /*
                 Those functions register themselves to the events on init and handle all
                 the user interface specific stuff. Overwriting them won't break the upload
                 but can break the way it's displayed.
                 You can overwrite them if you don't like the default behavior. If you just
                 want to add an additional event handler, register it on the dropzone object
                 and don't overwrite those options.
                 */

                // Those are self explanatory and simply concern the DragnDrop.
                drop: function drop(e) {
                    return this.element.classList.remove("dz-drag-hover");
                },
                dragstart: function dragstart(e) {},
                dragend: function dragend(e) {
                    return this.element.classList.remove("dz-drag-hover");
                },
                dragenter: function dragenter(e) {
                    return this.element.classList.add("dz-drag-hover");
                },
                dragover: function dragover(e) {
                    return this.element.classList.add("dz-drag-hover");
                },
                dragleave: function dragleave(e) {
                    return this.element.classList.remove("dz-drag-hover");
                },
                paste: function paste(e) {},


                // Called whenever there are no files left in the dropzone anymore, and the
                // dropzone should be displayed as if in the initial state.
                reset: function reset() {
                    return this.element.classList.remove("dz-started");
                },


                // Called when a file is added to the queue
                // Receives `file`
                addedfile: function addedfile(file) {
                    var _this2 = this;

                    if (this.element === this.previewsContainer) {
                        this.element.classList.add("dz-started");
                    }

                    if (this.previewsContainer) {
                        file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
                        file.previewTemplate = file.previewElement; // Backwards compatibility

                        this.previewsContainer.appendChild(file.previewElement);
                        for (var _iterator3 = file.previewElement.querySelectorAll("[data-dz-name]"), _isArray3 = true, _i3 = 0, _iterator3 = _isArray3 ? _iterator3 : _iterator3[Symbol.iterator]();;) {
                            var _ref3;

                            if (_isArray3) {
                                if (_i3 >= _iterator3.length) break;
                                _ref3 = _iterator3[_i3++];
                            } else {
                                _i3 = _iterator3.next();
                                if (_i3.done) break;
                                _ref3 = _i3.value;
                            }

                            var node = _ref3;

                            node.textContent = file.name;
                        }
                        for (var _iterator4 = file.previewElement.querySelectorAll("[data-dz-size]"), _isArray4 = true, _i4 = 0, _iterator4 = _isArray4 ? _iterator4 : _iterator4[Symbol.iterator]();;) {
                            if (_isArray4) {
                                if (_i4 >= _iterator4.length) break;
                                node = _iterator4[_i4++];
                            } else {
                                _i4 = _iterator4.next();
                                if (_i4.done) break;
                                node = _i4.value;
                            }

                            node.innerHTML = this.filesize(file.size);
                        }

                        if (this.options.addRemoveLinks) {
                            file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\" data-dz-remove>" + this.options.dictRemoveFile + "</a>");
                            file.previewElement.appendChild(file._removeLink);
                        }

                        var removeFileEvent = function removeFileEvent(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (file.status === Dropzone.UPLOADING) {
                                return Dropzone.confirm(_this2.options.dictCancelUploadConfirmation, function () {
                                    return _this2.removeFile(file);
                                });
                            } else {
                                if (_this2.options.dictRemoveFileConfirmation) {
                                    return Dropzone.confirm(_this2.options.dictRemoveFileConfirmation, function () {
                                        return _this2.removeFile(file);
                                    });
                                } else {
                                    return _this2.removeFile(file);
                                }
                            }
                        };

                        for (var _iterator5 = file.previewElement.querySelectorAll("[data-dz-remove]"), _isArray5 = true, _i5 = 0, _iterator5 = _isArray5 ? _iterator5 : _iterator5[Symbol.iterator]();;) {
                            var _ref4;

                            if (_isArray5) {
                                if (_i5 >= _iterator5.length) break;
                                _ref4 = _iterator5[_i5++];
                            } else {
                                _i5 = _iterator5.next();
                                if (_i5.done) break;
                                _ref4 = _i5.value;
                            }

                            var removeLink = _ref4;

                            removeLink.addEventListener("click", removeFileEvent);
                        }
                    }
                },


                // Called whenever a file is removed.
                removedfile: function removedfile(file) {
                    if (file.previewElement != null && file.previewElement.parentNode != null) {
                        file.previewElement.parentNode.removeChild(file.previewElement);
                    }
                    return this._updateMaxFilesReachedClass();
                },


                // Called when a thumbnail has been generated
                // Receives `file` and `dataUrl`
                thumbnail: function thumbnail(file, dataUrl) {
                    if (file.previewElement) {
                        file.previewElement.classList.remove("dz-file-preview");
                        for (var _iterator6 = file.previewElement.querySelectorAll("[data-dz-thumbnail]"), _isArray6 = true, _i6 = 0, _iterator6 = _isArray6 ? _iterator6 : _iterator6[Symbol.iterator]();;) {
                            var _ref5;

                            if (_isArray6) {
                                if (_i6 >= _iterator6.length) break;
                                _ref5 = _iterator6[_i6++];
                            } else {
                                _i6 = _iterator6.next();
                                if (_i6.done) break;
                                _ref5 = _i6.value;
                            }

                            var thumbnailElement = _ref5;

                            thumbnailElement.alt = file.name;
                            thumbnailElement.src = dataUrl;
                        }

                        return setTimeout(function () {
                            return file.previewElement.classList.add("dz-image-preview");
                        }, 1);
                    }
                },


                // Called whenever an error occurs
                // Receives `file` and `message`
                error: function error(file, message) {
                    if (file.previewElement) {
                        file.previewElement.classList.add("dz-error");
                        if (typeof message !== "String" && message.error) {
                            message = message.error;
                        }
                        for (var _iterator7 = file.previewElement.querySelectorAll("[data-dz-errormessage]"), _isArray7 = true, _i7 = 0, _iterator7 = _isArray7 ? _iterator7 : _iterator7[Symbol.iterator]();;) {
                            var _ref6;

                            if (_isArray7) {
                                if (_i7 >= _iterator7.length) break;
                                _ref6 = _iterator7[_i7++];
                            } else {
                                _i7 = _iterator7.next();
                                if (_i7.done) break;
                                _ref6 = _i7.value;
                            }

                            var node = _ref6;

                            node.textContent = message;
                        }
                    }
                },
                errormultiple: function errormultiple() {},


                // Called when a file gets processed. Since there is a cue, not all added
                // files are processed immediately.
                // Receives `file`
                processing: function processing(file) {
                    if (file.previewElement) {
                        file.previewElement.classList.add("dz-processing");
                        if (file._removeLink) {
                            return file._removeLink.textContent = this.options.dictCancelUpload;
                        }
                    }
                },
                processingmultiple: function processingmultiple() {},


                // Called whenever the upload progress gets updated.
                // Receives `file`, `progress` (percentage 0-100) and `bytesSent`.
                // To get the total number of bytes of the file, use `file.size`
                uploadprogress: function uploadprogress(file, progress, bytesSent) {
                    if (file.previewElement) {
                        for (var _iterator8 = file.previewElement.querySelectorAll("[data-dz-uploadprogress]"), _isArray8 = true, _i8 = 0, _iterator8 = _isArray8 ? _iterator8 : _iterator8[Symbol.iterator]();;) {
                            var _ref7;

                            if (_isArray8) {
                                if (_i8 >= _iterator8.length) break;
                                _ref7 = _iterator8[_i8++];
                            } else {
                                _i8 = _iterator8.next();
                                if (_i8.done) break;
                                _ref7 = _i8.value;
                            }

                            var node = _ref7;

                            node.nodeName === 'PROGRESS' ? node.value = progress : node.style.width = progress + "%";
                        }
                    }
                },


                // Called whenever the total upload progress gets updated.
                // Called with totalUploadProgress (0-100), totalBytes and totalBytesSent
                totaluploadprogress: function totaluploadprogress() {},


                // Called just before the file is sent. Gets the `xhr` object as second
                // parameter, so you can modify it (for example to add a CSRF token) and a
                // `formData` object to add additional information.
                sending: function sending() {},
                sendingmultiple: function sendingmultiple() {},


                // When the complete upload is finished and successful
                // Receives `file`
                success: function success(file) {
                    if (file.previewElement) {
                        return file.previewElement.classList.add("dz-success");
                    }
                },
                successmultiple: function successmultiple() {},


                // When the upload is canceled.
                canceled: function canceled(file) {
                    return this.emit("error", file, this.options.dictUploadCanceled);
                },
                canceledmultiple: function canceledmultiple() {},


                // When the upload is finished, either with success or an error.
                // Receives `file`
                complete: function complete(file) {
                    if (file._removeLink) {
                        file._removeLink.textContent = this.options.dictRemoveFile;
                    }
                    if (file.previewElement) {
                        return file.previewElement.classList.add("dz-complete");
                    }
                },
                completemultiple: function completemultiple() {},
                maxfilesexceeded: function maxfilesexceeded() {},
                maxfilesreached: function maxfilesreached() {},
                queuecomplete: function queuecomplete() {},
                addedfiles: function addedfiles() {}
            };

            this.prototype._thumbnailQueue = [];
            this.prototype._processingThumbnail = false;
        }

        // global utility

    }, {
        key: "extend",
        value: function extend(target) {
            for (var _len2 = arguments.length, objects = Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
                objects[_key2 - 1] = arguments[_key2];
            }

            for (var _iterator9 = objects, _isArray9 = true, _i9 = 0, _iterator9 = _isArray9 ? _iterator9 : _iterator9[Symbol.iterator]();;) {
                var _ref8;

                if (_isArray9) {
                    if (_i9 >= _iterator9.length) break;
                    _ref8 = _iterator9[_i9++];
                } else {
                    _i9 = _iterator9.next();
                    if (_i9.done) break;
                    _ref8 = _i9.value;
                }

                var object = _ref8;

                for (var key in object) {
                    var val = object[key];
                    target[key] = val;
                }
            }
            return target;
        }
    }]);

    function Dropzone(el, options) {
        _classCallCheck(this, Dropzone);

        var _this = _possibleConstructorReturn(this, (Dropzone.__proto__ || Object.getPrototypeOf(Dropzone)).call(this));

        var fallback = void 0,
            left = void 0;
        _this.element = el;
        // For backwards compatibility since the version was in the prototype previously
        _this.version = Dropzone.version;

        _this.defaultOptions.previewTemplate = _this.defaultOptions.previewTemplate.replace(/\n*/g, "");

        _this.clickableElements = [];
        _this.listeners = [];
        _this.files = []; // All files

        if (typeof _this.element === "string") {
            _this.element = document.querySelector(_this.element);
        }

        // Not checking if instance of HTMLElement or Element since IE9 is extremely weird.
        if (!_this.element || _this.element.nodeType == null) {
            throw new Error("Invalid dropzone element.");
        }

        if (_this.element.dropzone) {
            throw new Error("Dropzone already attached.");
        }

        // Now add this dropzone to the instances.
        Dropzone.instances.push(_this);

        // Put the dropzone inside the element itself.
        _this.element.dropzone = _this;

        var elementOptions = (left = Dropzone.optionsForElement(_this.element)) != null ? left : {};

        _this.options = Dropzone.extend({}, _this.defaultOptions, elementOptions, options != null ? options : {});

        // If the browser failed, just call the fallback and leave
        if (_this.options.forceFallback || !Dropzone.isBrowserSupported()) {
            var _ret;

            return _ret = _this.options.fallback.call(_this), _possibleConstructorReturn(_this, _ret);
        }

        // @options.url = @element.getAttribute "action" unless @options.url?
        if (_this.options.url == null) {
            _this.options.url = _this.element.getAttribute("action");
        }

        if (!_this.options.url) {
            throw new Error("No URL provided.");
        }

        if (_this.options.acceptedFiles && _this.options.acceptedMimeTypes) {
            throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
        }

        if (_this.options.uploadMultiple && _this.options.chunking) {
            throw new Error('You cannot set both: uploadMultiple and chunking.');
        }

        // Backwards compatibility
        if (_this.options.acceptedMimeTypes) {
            _this.options.acceptedFiles = _this.options.acceptedMimeTypes;
            delete _this.options.acceptedMimeTypes;
        }

        // Backwards compatibility
        if (_this.options.renameFilename != null) {
            _this.options.renameFile = function (file) {
                return _this.options.renameFilename.call(_this, file.name, file);
            };
        }

        _this.options.method = _this.options.method.toUpperCase();

        if ((fallback = _this.getExistingFallback()) && fallback.parentNode) {
            // Remove the fallback
            fallback.parentNode.removeChild(fallback);
        }

        // Display previews in the previewsContainer element or the Dropzone element unless explicitly set to false
        if (_this.options.previewsContainer !== false) {
            if (_this.options.previewsContainer) {
                _this.previewsContainer = Dropzone.getElement(_this.options.previewsContainer, "previewsContainer");
            } else {
                _this.previewsContainer = _this.element;
            }
        }

        if (_this.options.clickable) {
            if (_this.options.clickable === true) {
                _this.clickableElements = [_this.element];
            } else {
                _this.clickableElements = Dropzone.getElements(_this.options.clickable, "clickable");
            }
        }

        _this.init();
        return _this;
    }

    // Returns all files that have been accepted


    _createClass(Dropzone, [{
        key: "getAcceptedFiles",
        value: function getAcceptedFiles() {
            return this.files.filter(function (file) {
                return file.accepted;
            }).map(function (file) {
                return file;
            });
        }

        // Returns all files that have been rejected
        // Not sure when that's going to be useful, but added for completeness.

    }, {
        key: "getRejectedFiles",
        value: function getRejectedFiles() {
            return this.files.filter(function (file) {
                return !file.accepted;
            }).map(function (file) {
                return file;
            });
        }
    }, {
        key: "getFilesWithStatus",
        value: function getFilesWithStatus(status) {
            return this.files.filter(function (file) {
                return file.status === status;
            }).map(function (file) {
                return file;
            });
        }

        // Returns all files that are in the queue

    }, {
        key: "getQueuedFiles",
        value: function getQueuedFiles() {
            return this.getFilesWithStatus(Dropzone.QUEUED);
        }
    }, {
        key: "getUploadingFiles",
        value: function getUploadingFiles() {
            return this.getFilesWithStatus(Dropzone.UPLOADING);
        }
    }, {
        key: "getAddedFiles",
        value: function getAddedFiles() {
            return this.getFilesWithStatus(Dropzone.ADDED);
        }

        // Files that are either queued or uploading

    }, {
        key: "getActiveFiles",
        value: function getActiveFiles() {
            return this.files.filter(function (file) {
                return file.status === Dropzone.UPLOADING || file.status === Dropzone.QUEUED;
            }).map(function (file) {
                return file;
            });
        }

        // The function that gets called when Dropzone is initialized. You
        // can (and should) setup event listeners inside this function.

    }, {
        key: "init",
        value: function init() {
            var _this3 = this;

            // In case it isn't set already
            if (this.element.tagName === "form") {
                this.element.setAttribute("enctype", "multipart/form-data");
            }

            if (this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message")) {
                this.element.appendChild(Dropzone.createElement("<div class=\"dz-default dz-message\"><span>" + this.options.dictDefaultMessage + "</span></div>"));
            }

            if (this.clickableElements.length) {
                var setupHiddenFileInput = function setupHiddenFileInput() {
                    if (_this3.hiddenFileInput) {
                        _this3.hiddenFileInput.parentNode.removeChild(_this3.hiddenFileInput);
                    }
                    _this3.hiddenFileInput = document.createElement("input");
                    _this3.hiddenFileInput.setAttribute("type", "file");
                    if (_this3.options.maxFiles === null || _this3.options.maxFiles > 1) {
                        _this3.hiddenFileInput.setAttribute("multiple", "multiple");
                    }
                    _this3.hiddenFileInput.className = "dz-hidden-input";

                    if (_this3.options.acceptedFiles !== null) {
                        _this3.hiddenFileInput.setAttribute("accept", _this3.options.acceptedFiles);
                    }
                    if (_this3.options.capture !== null) {
                        _this3.hiddenFileInput.setAttribute("capture", _this3.options.capture);
                    }

                    // Not setting `display="none"` because some browsers don't accept clicks
                    // on elements that aren't displayed.
                    _this3.hiddenFileInput.style.visibility = "hidden";
                    _this3.hiddenFileInput.style.position = "absolute";
                    _this3.hiddenFileInput.style.top = "0";
                    _this3.hiddenFileInput.style.left = "0";
                    _this3.hiddenFileInput.style.height = "0";
                    _this3.hiddenFileInput.style.width = "0";
                    document.querySelector(_this3.options.hiddenInputContainer).appendChild(_this3.hiddenFileInput);
                    return _this3.hiddenFileInput.addEventListener("change", function () {
                        var files = _this3.hiddenFileInput.files;

                        if (files.length) {
                            for (var _iterator10 = files, _isArray10 = true, _i10 = 0, _iterator10 = _isArray10 ? _iterator10 : _iterator10[Symbol.iterator]();;) {
                                var _ref9;

                                if (_isArray10) {
                                    if (_i10 >= _iterator10.length) break;
                                    _ref9 = _iterator10[_i10++];
                                } else {
                                    _i10 = _iterator10.next();
                                    if (_i10.done) break;
                                    _ref9 = _i10.value;
                                }

                                var file = _ref9;

                                _this3.addFile(file);
                            }
                        }
                        _this3.emit("addedfiles", files);
                        return setupHiddenFileInput();
                    });
                };
                setupHiddenFileInput();
            }

            this.URL = window.URL !== null ? window.URL : window.webkitURL;

            // Setup all event listeners on the Dropzone object itself.
            // They're not in @setupEventListeners() because they shouldn't be removed
            // again when the dropzone gets disabled.
            for (var _iterator11 = this.events, _isArray11 = true, _i11 = 0, _iterator11 = _isArray11 ? _iterator11 : _iterator11[Symbol.iterator]();;) {
                var _ref10;

                if (_isArray11) {
                    if (_i11 >= _iterator11.length) break;
                    _ref10 = _iterator11[_i11++];
                } else {
                    _i11 = _iterator11.next();
                    if (_i11.done) break;
                    _ref10 = _i11.value;
                }

                var eventName = _ref10;

                this.on(eventName, this.options[eventName]);
            }

            this.on("uploadprogress", function () {
                return _this3.updateTotalUploadProgress();
            });

            this.on("removedfile", function () {
                return _this3.updateTotalUploadProgress();
            });

            this.on("canceled", function (file) {
                return _this3.emit("complete", file);
            });

            // Emit a `queuecomplete` event if all files finished uploading.
            this.on("complete", function (file) {
                if (_this3.getAddedFiles().length === 0 && _this3.getUploadingFiles().length === 0 && _this3.getQueuedFiles().length === 0) {
                    // This needs to be deferred so that `queuecomplete` really triggers after `complete`
                    return setTimeout(function () {
                        return _this3.emit("queuecomplete");
                    }, 0);
                }
            });

            var noPropagation = function noPropagation(e) {
                e.stopPropagation();
                if (e.preventDefault) {
                    return e.preventDefault();
                } else {
                    return e.returnValue = false;
                }
            };

            // Create the listeners
            this.listeners = [{
                element: this.element,
                events: {
                    "dragstart": function dragstart(e) {
                        return _this3.emit("dragstart", e);
                    },
                    "dragenter": function dragenter(e) {
                        noPropagation(e);
                        return _this3.emit("dragenter", e);
                    },
                    "dragover": function dragover(e) {
                        // Makes it possible to drag files from chrome's download bar
                        // http://stackoverflow.com/questions/19526430/drag-and-drop-file-uploads-from-chrome-downloads-bar
                        // Try is required to prevent bug in Internet Explorer 11 (SCRIPT65535 exception)
                        var efct = void 0;
                        try {
                            efct = e.dataTransfer.effectAllowed;
                        } catch (error) {}
                        e.dataTransfer.dropEffect = 'move' === efct || 'linkMove' === efct ? 'move' : 'copy';

                        noPropagation(e);
                        return _this3.emit("dragover", e);
                    },
                    "dragleave": function dragleave(e) {
                        return _this3.emit("dragleave", e);
                    },
                    "drop": function drop(e) {
                        noPropagation(e);
                        return _this3.drop(e);
                    },
                    "dragend": function dragend(e) {
                        return _this3.emit("dragend", e);
                    }

                    // This is disabled right now, because the browsers don't implement it properly.
                    // "paste": (e) =>
                    //   noPropagation e
                    //   @paste e
                } }];

            this.clickableElements.forEach(function (clickableElement) {
                return _this3.listeners.push({
                    element: clickableElement,
                    events: {
                        "click": function click(evt) {
                            // Only the actual dropzone or the message element should trigger file selection
                            if (clickableElement !== _this3.element || evt.target === _this3.element || Dropzone.elementInside(evt.target, _this3.element.querySelector(".dz-message"))) {
                                _this3.hiddenFileInput.click(); // Forward the click
                            }
                            return true;
                        }
                    }
                });
            });

            this.enable();

            return this.options.init.call(this);
        }

        // Not fully tested yet

    }, {
        key: "destroy",
        value: function destroy() {
            this.disable();
            this.removeAllFiles(true);
            if (this.hiddenFileInput != null ? this.hiddenFileInput.parentNode : undefined) {
                this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
                this.hiddenFileInput = null;
            }
            delete this.element.dropzone;
            return Dropzone.instances.splice(Dropzone.instances.indexOf(this), 1);
        }
    }, {
        key: "updateTotalUploadProgress",
        value: function updateTotalUploadProgress() {
            var totalUploadProgress = void 0;
            var totalBytesSent = 0;
            var totalBytes = 0;

            var activeFiles = this.getActiveFiles();

            if (activeFiles.length) {
                for (var _iterator12 = this.getActiveFiles(), _isArray12 = true, _i12 = 0, _iterator12 = _isArray12 ? _iterator12 : _iterator12[Symbol.iterator]();;) {
                    var _ref11;

                    if (_isArray12) {
                        if (_i12 >= _iterator12.length) break;
                        _ref11 = _iterator12[_i12++];
                    } else {
                        _i12 = _iterator12.next();
                        if (_i12.done) break;
                        _ref11 = _i12.value;
                    }

                    var file = _ref11;

                    totalBytesSent += file.upload.bytesSent;
                    totalBytes += file.upload.total;
                }
                totalUploadProgress = 100 * totalBytesSent / totalBytes;
            } else {
                totalUploadProgress = 100;
            }

            return this.emit("totaluploadprogress", totalUploadProgress, totalBytes, totalBytesSent);
        }

        // @options.paramName can be a function taking one parameter rather than a string.
        // A parameter name for a file is obtained simply by calling this with an index number.

    }, {
        key: "_getParamName",
        value: function _getParamName(n) {
            if (typeof this.options.paramName === "function") {
                return this.options.paramName(n);
            } else {
                return "" + this.options.paramName + (this.options.uploadMultiple ? "[" + n + "]" : "");
            }
        }

        // If @options.renameFile is a function,
        // the function will be used to rename the file.name before appending it to the formData

    }, {
        key: "_renameFile",
        value: function _renameFile(file) {
            if (typeof this.options.renameFile !== "function") {
                return file.name;
            }
            return this.options.renameFile(file);
        }

        // Returns a form that can be used as fallback if the browser does not support DragnDrop
        //
        // If the dropzone is already a form, only the input field and button are returned. Otherwise a complete form element is provided.
        // This code has to pass in IE7 :(

    }, {
        key: "getFallbackForm",
        value: function getFallbackForm() {
            var existingFallback = void 0,
                form = void 0;
            if (existingFallback = this.getExistingFallback()) {
                return existingFallback;
            }

            var fieldsString = "<div class=\"dz-fallback\">";
            if (this.options.dictFallbackText) {
                fieldsString += "<p>" + this.options.dictFallbackText + "</p>";
            }
            fieldsString += "<input type=\"file\" name=\"" + this._getParamName(0) + "\" " + (this.options.uploadMultiple ? 'multiple="multiple"' : undefined) + " /><input type=\"submit\" value=\"Upload!\"></div>";

            var fields = Dropzone.createElement(fieldsString);
            if (this.element.tagName !== "FORM") {
                form = Dropzone.createElement("<form action=\"" + this.options.url + "\" enctype=\"multipart/form-data\" method=\"" + this.options.method + "\"></form>");
                form.appendChild(fields);
            } else {
                // Make sure that the enctype and method attributes are set properly
                this.element.setAttribute("enctype", "multipart/form-data");
                this.element.setAttribute("method", this.options.method);
            }
            return form != null ? form : fields;
        }

        // Returns the fallback elements if they exist already
        //
        // This code has to pass in IE7 :(

    }, {
        key: "getExistingFallback",
        value: function getExistingFallback() {
            var getFallback = function getFallback(elements) {
                for (var _iterator13 = elements, _isArray13 = true, _i13 = 0, _iterator13 = _isArray13 ? _iterator13 : _iterator13[Symbol.iterator]();;) {
                    var _ref12;

                    if (_isArray13) {
                        if (_i13 >= _iterator13.length) break;
                        _ref12 = _iterator13[_i13++];
                    } else {
                        _i13 = _iterator13.next();
                        if (_i13.done) break;
                        _ref12 = _i13.value;
                    }

                    var el = _ref12;

                    if (/(^| )fallback($| )/.test(el.className)) {
                        return el;
                    }
                }
            };

            var _arr = ["div", "form"];
            for (var _i14 = 0; _i14 < _arr.length; _i14++) {
                var tagName = _arr[_i14];
                var fallback;
                if (fallback = getFallback(this.element.getElementsByTagName(tagName))) {
                    return fallback;
                }
            }
        }

        // Activates all listeners stored in @listeners

    }, {
        key: "setupEventListeners",
        value: function setupEventListeners() {
            return this.listeners.map(function (elementListeners) {
                return function () {
                    var result = [];
                    for (var event in elementListeners.events) {
                        var listener = elementListeners.events[event];
                        result.push(elementListeners.element.addEventListener(event, listener, false));
                    }
                    return result;
                }();
            });
        }

        // Deactivates all listeners stored in @listeners

    }, {
        key: "removeEventListeners",
        value: function removeEventListeners() {
            return this.listeners.map(function (elementListeners) {
                return function () {
                    var result = [];
                    for (var event in elementListeners.events) {
                        var listener = elementListeners.events[event];
                        result.push(elementListeners.element.removeEventListener(event, listener, false));
                    }
                    return result;
                }();
            });
        }

        // Removes all event listeners and cancels all files in the queue or being processed.

    }, {
        key: "disable",
        value: function disable() {
            var _this4 = this;

            this.clickableElements.forEach(function (element) {
                return element.classList.remove("dz-clickable");
            });
            this.removeEventListeners();
            this.disabled = true;

            return this.files.map(function (file) {
                return _this4.cancelUpload(file);
            });
        }
    }, {
        key: "enable",
        value: function enable() {
            delete this.disabled;
            this.clickableElements.forEach(function (element) {
                return element.classList.add("dz-clickable");
            });
            return this.setupEventListeners();
        }

        // Returns a nicely formatted filesize

    }, {
        key: "filesize",
        value: function filesize(size) {
            var selectedSize = 0;
            var selectedUnit = "b";

            if (size > 0) {
                var units = ['tb', 'gb', 'mb', 'kb', 'b'];

                for (var i = 0; i < units.length; i++) {
                    var unit = units[i];
                    var cutoff = Math.pow(this.options.filesizeBase, 4 - i) / 10;

                    if (size >= cutoff) {
                        selectedSize = size / Math.pow(this.options.filesizeBase, 4 - i);
                        selectedUnit = unit;
                        break;
                    }
                }

                selectedSize = Math.round(10 * selectedSize) / 10; // Cutting of digits
            }

            return "<strong>" + selectedSize + "</strong> " + this.options.dictFileSizeUnits[selectedUnit];
        }

        // Adds or removes the `dz-max-files-reached` class from the form.

    }, {
        key: "_updateMaxFilesReachedClass",
        value: function _updateMaxFilesReachedClass() {
            if (this.options.maxFiles != null && this.getAcceptedFiles().length >= this.options.maxFiles) {
                if (this.getAcceptedFiles().length === this.options.maxFiles) {
                    this.emit('maxfilesreached', this.files);
                }
                return this.element.classList.add("dz-max-files-reached");
            } else {
                return this.element.classList.remove("dz-max-files-reached");
            }
        }
    }, {
        key: "drop",
        value: function drop(e) {
            if (!e.dataTransfer) {
                return;
            }
            this.emit("drop", e);

            var files = e.dataTransfer.files;

            this.emit("addedfiles", files);

            // Even if it's a folder, files.length will contain the folders.
            if (files.length) {
                var items = e.dataTransfer.items;

                if (items && items.length && items[0].webkitGetAsEntry != null) {
                    // The browser supports dropping of folders, so handle items instead of files
                    this._addFilesFromItems(items);
                } else {
                    this.handleFiles(files);
                }
            }
        }
    }, {
        key: "paste",
        value: function paste(e) {
            if (__guard__(e != null ? e.clipboardData : undefined, function (x) {
                    return x.items;
                }) == null) {
                return;
            }

            this.emit("paste", e);
            var items = e.clipboardData.items;


            if (items.length) {
                return this._addFilesFromItems(items);
            }
        }
    }, {
        key: "handleFiles",
        value: function handleFiles(files) {
            for (var _iterator14 = files, _isArray14 = true, _i15 = 0, _iterator14 = _isArray14 ? _iterator14 : _iterator14[Symbol.iterator]();;) {
                var _ref13;

                if (_isArray14) {
                    if (_i15 >= _iterator14.length) break;
                    _ref13 = _iterator14[_i15++];
                } else {
                    _i15 = _iterator14.next();
                    if (_i15.done) break;
                    _ref13 = _i15.value;
                }

                var file = _ref13;

                this.addFile(file);
            }
        }

        // When a folder is dropped (or files are pasted), items must be handled
        // instead of files.

    }, {
        key: "_addFilesFromItems",
        value: function _addFilesFromItems(items) {
            var _this5 = this;

            return function () {
                var result = [];
                for (var _iterator15 = items, _isArray15 = true, _i16 = 0, _iterator15 = _isArray15 ? _iterator15 : _iterator15[Symbol.iterator]();;) {
                    var _ref14;

                    if (_isArray15) {
                        if (_i16 >= _iterator15.length) break;
                        _ref14 = _iterator15[_i16++];
                    } else {
                        _i16 = _iterator15.next();
                        if (_i16.done) break;
                        _ref14 = _i16.value;
                    }

                    var item = _ref14;

                    var entry;
                    if (item.webkitGetAsEntry != null && (entry = item.webkitGetAsEntry())) {
                        if (entry.isFile) {
                            result.push(_this5.addFile(item.getAsFile()));
                        } else if (entry.isDirectory) {
                            // Append all files from that directory to files
                            result.push(_this5._addFilesFromDirectory(entry, entry.name));
                        } else {
                            result.push(undefined);
                        }
                    } else if (item.getAsFile != null) {
                        if (item.kind == null || item.kind === "file") {
                            result.push(_this5.addFile(item.getAsFile()));
                        } else {
                            result.push(undefined);
                        }
                    } else {
                        result.push(undefined);
                    }
                }
                return result;
            }();
        }

        // Goes through the directory, and adds each file it finds recursively

    }, {
        key: "_addFilesFromDirectory",
        value: function _addFilesFromDirectory(directory, path) {
            var _this6 = this;

            var dirReader = directory.createReader();

            var errorHandler = function errorHandler(error) {
                return __guardMethod__(console, 'log', function (o) {
                    return o.log(error);
                });
            };

            var readEntries = function readEntries() {
                return dirReader.readEntries(function (entries) {
                    if (entries.length > 0) {
                        for (var _iterator16 = entries, _isArray16 = true, _i17 = 0, _iterator16 = _isArray16 ? _iterator16 : _iterator16[Symbol.iterator]();;) {
                            var _ref15;

                            if (_isArray16) {
                                if (_i17 >= _iterator16.length) break;
                                _ref15 = _iterator16[_i17++];
                            } else {
                                _i17 = _iterator16.next();
                                if (_i17.done) break;
                                _ref15 = _i17.value;
                            }

                            var entry = _ref15;

                            if (entry.isFile) {
                                entry.file(function (file) {
                                    if (_this6.options.ignoreHiddenFiles && file.name.substring(0, 1) === '.') {
                                        return;
                                    }
                                    file.fullPath = path + "/" + file.name;
                                    return _this6.addFile(file);
                                });
                            } else if (entry.isDirectory) {
                                _this6._addFilesFromDirectory(entry, path + "/" + entry.name);
                            }
                        }

                        // Recursively call readEntries() again, since browser only handle
                        // the first 100 entries.
                        // See: https://developer.mozilla.org/en-US/docs/Web/API/DirectoryReader#readEntries
                        readEntries();
                    }
                    return null;
                }, errorHandler);
            };

            return readEntries();
        }

        // If `done()` is called without argument the file is accepted
        // If you call it with an error message, the file is rejected
        // (This allows for asynchronous validation)
        //
        // This function checks the filesize, and if the file.type passes the
        // `acceptedFiles` check.

    }, {
        key: "accept",
        value: function accept(file, done) {
            if (file.size > this.options.maxFilesize * 1024 * 1024) {
                return done(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(file.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize));
            } else if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
                return done(this.options.dictInvalidFileType);
            } else if (this.options.maxFiles != null && this.getAcceptedFiles().length >= this.options.maxFiles) {
                done(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles));
                return this.emit("maxfilesexceeded", file);
            } else {
                return this.options.accept.call(this, file, done);
            }
        }
    }, {
        key: "addFile",
        value: function addFile(file) {
            var _this7 = this;

            file.upload = {
                uuid: Dropzone.uuidv4(),
                progress: 0,
                // Setting the total upload size to file.size for the beginning
                // It's actual different than the size to be transmitted.
                total: file.size,
                bytesSent: 0,
                filename: this._renameFile(file),
                chunked: this.options.chunking && (this.options.forceChunking || file.size > this.options.chunkSize),
                totalChunkCount: Math.ceil(file.size / this.options.chunkSize)
            };
            this.files.push(file);

            file.status = Dropzone.ADDED;

            this.emit("addedfile", file);

            this._enqueueThumbnail(file);

            return this.accept(file, function (error) {
                if (error) {
                    file.accepted = false;
                    _this7._errorProcessing([file], error); // Will set the file.status
                } else {
                    file.accepted = true;
                    if (_this7.options.autoQueue) {
                        _this7.enqueueFile(file);
                    } // Will set .accepted = true
                }
                return _this7._updateMaxFilesReachedClass();
            });
        }

        // Wrapper for enqueueFile

    }, {
        key: "enqueueFiles",
        value: function enqueueFiles(files) {
            for (var _iterator17 = files, _isArray17 = true, _i18 = 0, _iterator17 = _isArray17 ? _iterator17 : _iterator17[Symbol.iterator]();;) {
                var _ref16;

                if (_isArray17) {
                    if (_i18 >= _iterator17.length) break;
                    _ref16 = _iterator17[_i18++];
                } else {
                    _i18 = _iterator17.next();
                    if (_i18.done) break;
                    _ref16 = _i18.value;
                }

                var file = _ref16;

                this.enqueueFile(file);
            }
            return null;
        }
    }, {
        key: "enqueueFile",
        value: function enqueueFile(file) {
            var _this8 = this;

            if (file.status === Dropzone.ADDED && file.accepted === true) {
                file.status = Dropzone.QUEUED;
                if (this.options.autoProcessQueue) {
                    return setTimeout(function () {
                        return _this8.processQueue();
                    }, 0); // Deferring the call
                }
            } else {
                throw new Error("This file can't be queued because it has already been processed or was rejected.");
            }
        }
    }, {
        key: "_enqueueThumbnail",
        value: function _enqueueThumbnail(file) {
            var _this9 = this;

            if (this.options.createImageThumbnails && file.type.match(/image.*/) && file.size <= this.options.maxThumbnailFilesize * 1024 * 1024) {
                this._thumbnailQueue.push(file);
                return setTimeout(function () {
                    return _this9._processThumbnailQueue();
                }, 0); // Deferring the call
            }
        }
    }, {
        key: "_processThumbnailQueue",
        value: function _processThumbnailQueue() {
            var _this10 = this;

            if (this._processingThumbnail || this._thumbnailQueue.length === 0) {
                return;
            }

            this._processingThumbnail = true;
            var file = this._thumbnailQueue.shift();
            return this.createThumbnail(file, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.thumbnailMethod, true, function (dataUrl) {
                _this10.emit("thumbnail", file, dataUrl);
                _this10._processingThumbnail = false;
                return _this10._processThumbnailQueue();
            });
        }

        // Can be called by the user to remove a file

    }, {
        key: "removeFile",
        value: function removeFile(file) {
            if (file.status === Dropzone.UPLOADING) {
                this.cancelUpload(file);
            }
            this.files = without(this.files, file);

            this.emit("removedfile", file);
            if (this.files.length === 0) {
                return this.emit("reset");
            }
        }

        // Removes all files that aren't currently processed from the list

    }, {
        key: "removeAllFiles",
        value: function removeAllFiles(cancelIfNecessary) {
            // Create a copy of files since removeFile() changes the @files array.
            if (cancelIfNecessary == null) {
                cancelIfNecessary = false;
            }
            for (var _iterator18 = this.files.slice(), _isArray18 = true, _i19 = 0, _iterator18 = _isArray18 ? _iterator18 : _iterator18[Symbol.iterator]();;) {
                var _ref17;

                if (_isArray18) {
                    if (_i19 >= _iterator18.length) break;
                    _ref17 = _iterator18[_i19++];
                } else {
                    _i19 = _iterator18.next();
                    if (_i19.done) break;
                    _ref17 = _i19.value;
                }

                var file = _ref17;

                if (file.status !== Dropzone.UPLOADING || cancelIfNecessary) {
                    this.removeFile(file);
                }
            }
            return null;
        }

        // Resizes an image before it gets sent to the server. This function is the default behavior of
        // `options.transformFile` if `resizeWidth` or `resizeHeight` are set. The callback is invoked with
        // the resized blob.

    }, {
        key: "resizeImage",
        value: function resizeImage(file, width, height, resizeMethod, callback) {
            var _this11 = this;

            return this.createThumbnail(file, width, height, resizeMethod, false, function (dataUrl, canvas) {
                if (canvas == null) {
                    // The image has not been resized
                    return callback(file);
                } else {
                    var resizeMimeType = _this11.options.resizeMimeType;

                    if (resizeMimeType == null) {
                        resizeMimeType = file.type;
                    }
                    var resizedDataURL = canvas.toDataURL(resizeMimeType, _this11.options.resizeQuality);
                    if (resizeMimeType === 'image/jpeg' || resizeMimeType === 'image/jpg') {
                        // Now add the original EXIF information
                        resizedDataURL = ExifRestore.restore(file.dataURL, resizedDataURL);
                    }
                    return callback(Dropzone.dataURItoBlob(resizedDataURL));
                }
            });
        }
    }, {
        key: "createThumbnail",
        value: function createThumbnail(file, width, height, resizeMethod, fixOrientation, callback) {
            var _this12 = this;

            var fileReader = new FileReader();

            fileReader.onload = function () {

                file.dataURL = fileReader.result;

                // Don't bother creating a thumbnail for SVG images since they're vector
                if (file.type === "image/svg+xml") {
                    if (callback != null) {
                        callback(fileReader.result);
                    }
                    return;
                }

                return _this12.createThumbnailFromUrl(file, width, height, resizeMethod, fixOrientation, callback);
            };

            return fileReader.readAsDataURL(file);
        }
    }, {
        key: "createThumbnailFromUrl",
        value: function createThumbnailFromUrl(file, width, height, resizeMethod, fixOrientation, callback, crossOrigin) {
            var _this13 = this;

            // Not using `new Image` here because of a bug in latest Chrome versions.
            // See https://github.com/enyo/dropzone/pull/226
            var img = document.createElement("img");

            if (crossOrigin) {
                img.crossOrigin = crossOrigin;
            }

            img.onload = function () {
                var loadExif = function loadExif(callback) {
                    return callback(1);
                };
                if (typeof EXIF !== 'undefined' && EXIF !== null && fixOrientation) {
                    loadExif = function loadExif(callback) {
                        return EXIF.getData(img, function () {
                            return callback(EXIF.getTag(this, 'Orientation'));
                        });
                    };
                }

                return loadExif(function (orientation) {
                    file.width = img.width;
                    file.height = img.height;

                    var resizeInfo = _this13.options.resize.call(_this13, file, width, height, resizeMethod);

                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");

                    canvas.width = resizeInfo.trgWidth;
                    canvas.height = resizeInfo.trgHeight;

                    if (orientation > 4) {
                        canvas.width = resizeInfo.trgHeight;
                        canvas.height = resizeInfo.trgWidth;
                    }

                    switch (orientation) {
                        case 2:
                            // horizontal flip
                            ctx.translate(canvas.width, 0);
                            ctx.scale(-1, 1);
                            break;
                        case 3:
                            // 180° rotate left
                            ctx.translate(canvas.width, canvas.height);
                            ctx.rotate(Math.PI);
                            break;
                        case 4:
                            // vertical flip
                            ctx.translate(0, canvas.height);
                            ctx.scale(1, -1);
                            break;
                        case 5:
                            // vertical flip + 90 rotate right
                            ctx.rotate(0.5 * Math.PI);
                            ctx.scale(1, -1);
                            break;
                        case 6:
                            // 90° rotate right
                            ctx.rotate(0.5 * Math.PI);
                            ctx.translate(0, -canvas.height);
                            break;
                        case 7:
                            // horizontal flip + 90 rotate right
                            ctx.rotate(0.5 * Math.PI);
                            ctx.translate(canvas.width, -canvas.height);
                            ctx.scale(-1, 1);
                            break;
                        case 8:
                            // 90° rotate left
                            ctx.rotate(-0.5 * Math.PI);
                            ctx.translate(-canvas.width, 0);
                            break;
                    }

                    // This is a bugfix for iOS' scaling bug.
                    drawImageIOSFix(ctx, img, resizeInfo.srcX != null ? resizeInfo.srcX : 0, resizeInfo.srcY != null ? resizeInfo.srcY : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, resizeInfo.trgX != null ? resizeInfo.trgX : 0, resizeInfo.trgY != null ? resizeInfo.trgY : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);

                    var thumbnail = canvas.toDataURL("image/png");

                    if (callback != null) {
                        return callback(thumbnail, canvas);
                    }
                });
            };

            if (callback != null) {
                img.onerror = callback;
            }

            return img.src = file.dataURL;
        }

        // Goes through the queue and processes files if there aren't too many already.

    }, {
        key: "processQueue",
        value: function processQueue() {
            var parallelUploads = this.options.parallelUploads;

            var processingLength = this.getUploadingFiles().length;
            var i = processingLength;

            // There are already at least as many files uploading than should be
            if (processingLength >= parallelUploads) {
                return;
            }

            var queuedFiles = this.getQueuedFiles();

            if (!(queuedFiles.length > 0)) {
                return;
            }

            if (this.options.uploadMultiple) {
                // The files should be uploaded in one request
                return this.processFiles(queuedFiles.slice(0, parallelUploads - processingLength));
            } else {
                while (i < parallelUploads) {
                    if (!queuedFiles.length) {
                        return;
                    } // Nothing left to process
                    this.processFile(queuedFiles.shift());
                    i++;
                }
            }
        }

        // Wrapper for `processFiles`

    }, {
        key: "processFile",
        value: function processFile(file) {
            return this.processFiles([file]);
        }

        // Loads the file, then calls finishedLoading()

    }, {
        key: "processFiles",
        value: function processFiles(files) {
            for (var _iterator19 = files, _isArray19 = true, _i20 = 0, _iterator19 = _isArray19 ? _iterator19 : _iterator19[Symbol.iterator]();;) {
                var _ref18;

                if (_isArray19) {
                    if (_i20 >= _iterator19.length) break;
                    _ref18 = _iterator19[_i20++];
                } else {
                    _i20 = _iterator19.next();
                    if (_i20.done) break;
                    _ref18 = _i20.value;
                }

                var file = _ref18;

                file.processing = true; // Backwards compatibility
                file.status = Dropzone.UPLOADING;

                this.emit("processing", file);
            }

            if (this.options.uploadMultiple) {
                this.emit("processingmultiple", files);
            }

            return this.uploadFiles(files);
        }
    }, {
        key: "_getFilesWithXhr",
        value: function _getFilesWithXhr(xhr) {
            var files = void 0;
            return files = this.files.filter(function (file) {
                return file.xhr === xhr;
            }).map(function (file) {
                return file;
            });
        }

        // Cancels the file upload and sets the status to CANCELED
        // **if** the file is actually being uploaded.
        // If it's still in the queue, the file is being removed from it and the status
        // set to CANCELED.

    }, {
        key: "cancelUpload",
        value: function cancelUpload(file) {
            if (file.status === Dropzone.UPLOADING) {
                var groupedFiles = this._getFilesWithXhr(file.xhr);
                for (var _iterator20 = groupedFiles, _isArray20 = true, _i21 = 0, _iterator20 = _isArray20 ? _iterator20 : _iterator20[Symbol.iterator]();;) {
                    var _ref19;

                    if (_isArray20) {
                        if (_i21 >= _iterator20.length) break;
                        _ref19 = _iterator20[_i21++];
                    } else {
                        _i21 = _iterator20.next();
                        if (_i21.done) break;
                        _ref19 = _i21.value;
                    }

                    var groupedFile = _ref19;

                    groupedFile.status = Dropzone.CANCELED;
                }
                if (typeof file.xhr !== 'undefined') {
                    file.xhr.abort();
                }
                for (var _iterator21 = groupedFiles, _isArray21 = true, _i22 = 0, _iterator21 = _isArray21 ? _iterator21 : _iterator21[Symbol.iterator]();;) {
                    var _ref20;

                    if (_isArray21) {
                        if (_i22 >= _iterator21.length) break;
                        _ref20 = _iterator21[_i22++];
                    } else {
                        _i22 = _iterator21.next();
                        if (_i22.done) break;
                        _ref20 = _i22.value;
                    }

                    var _groupedFile = _ref20;

                    this.emit("canceled", _groupedFile);
                }
                if (this.options.uploadMultiple) {
                    this.emit("canceledmultiple", groupedFiles);
                }
            } else if (file.status === Dropzone.ADDED || file.status === Dropzone.QUEUED) {
                file.status = Dropzone.CANCELED;
                this.emit("canceled", file);
                if (this.options.uploadMultiple) {
                    this.emit("canceledmultiple", [file]);
                }
            }

            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        }
    }, {
        key: "resolveOption",
        value: function resolveOption(option) {
            if (typeof option === 'function') {
                for (var _len3 = arguments.length, args = Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
                    args[_key3 - 1] = arguments[_key3];
                }

                return option.apply(this, args);
            }
            return option;
        }
    }, {
        key: "uploadFile",
        value: function uploadFile(file) {
            return this.uploadFiles([file]);
        }
    }, {
        key: "uploadFiles",
        value: function uploadFiles(files) {
            var _this14 = this;

            this._transformFiles(files, function (transformedFiles) {
                if (files[0].upload.chunked) {
                    // This file should be sent in chunks!

                    // If the chunking option is set, we **know** that there can only be **one** file, since
                    // uploadMultiple is not allowed with this option.
                    var file = files[0];
                    var transformedFile = transformedFiles[0];
                    var startedChunkCount = 0;

                    file.upload.chunks = [];

                    var handleNextChunk = function handleNextChunk() {
                        var chunkIndex = 0;

                        // Find the next item in file.upload.chunks that is not defined yet.
                        while (file.upload.chunks[chunkIndex] !== undefined) {
                            chunkIndex++;
                        }

                        // This means, that all chunks have already been started.
                        if (chunkIndex >= file.upload.totalChunkCount) return;

                        startedChunkCount++;

                        var start = chunkIndex * _this14.options.chunkSize;
                        var end = Math.min(start + _this14.options.chunkSize, file.size);

                        var dataBlock = {
                            name: _this14._getParamName(0),
                            data: transformedFile.webkitSlice ? transformedFile.webkitSlice(start, end) : transformedFile.slice(start, end),
                            filename: file.upload.filename,
                            chunkIndex: chunkIndex
                        };

                        file.upload.chunks[chunkIndex] = {
                            file: file,
                            index: chunkIndex,
                            dataBlock: dataBlock, // In case we want to retry.
                            status: Dropzone.UPLOADING,
                            progress: 0,
                            retries: 0 // The number of times this block has been retried.
                        };

                        _this14._uploadData(files, [dataBlock]);
                    };

                    file.upload.finishedChunkUpload = function (chunk) {
                        var allFinished = true;
                        chunk.status = Dropzone.SUCCESS;

                        // Clear the data from the chunk
                        chunk.dataBlock = null;

                        for (var i = 0; i < file.upload.totalChunkCount; i++) {
                            if (file.upload.chunks[i] === undefined) {
                                return handleNextChunk();
                            }
                            if (file.upload.chunks[i].status !== Dropzone.SUCCESS) {
                                allFinished = false;
                            }
                        }

                        if (allFinished) {
                            _this14.options.chunksUploaded(file, function () {
                                _this14._finished(files, '', null);
                            });
                        }
                    };

                    if (_this14.options.parallelChunkUploads) {
                        for (var i = 0; i < file.upload.totalChunkCount; i++) {
                            handleNextChunk();
                        }
                    } else {
                        handleNextChunk();
                    }
                } else {
                    var dataBlocks = [];
                    for (var _i23 = 0; _i23 < files.length; _i23++) {
                        dataBlocks[_i23] = {
                            name: _this14._getParamName(_i23),
                            data: transformedFiles[_i23],
                            filename: files[_i23].upload.filename
                        };
                    }
                    _this14._uploadData(files, dataBlocks);
                }
            });
        }

        /// Returns the right chunk for given file and xhr

    }, {
        key: "_getChunk",
        value: function _getChunk(file, xhr) {
            for (var i = 0; i < file.upload.totalChunkCount; i++) {
                if (file.upload.chunks[i] !== undefined && file.upload.chunks[i].xhr === xhr) {
                    return file.upload.chunks[i];
                }
            }
        }

        // This function actually uploads the file(s) to the server.
        // If dataBlocks contains the actual data to upload (meaning, that this could either be transformed
        // files, or individual chunks for chunked upload).

    }, {
        key: "_uploadData",
        value: function _uploadData(files, dataBlocks) {
            var _this15 = this;

            var xhr = new XMLHttpRequest();

            // Put the xhr object in the file objects to be able to reference it later.
            for (var _iterator22 = files, _isArray22 = true, _i24 = 0, _iterator22 = _isArray22 ? _iterator22 : _iterator22[Symbol.iterator]();;) {
                var _ref21;

                if (_isArray22) {
                    if (_i24 >= _iterator22.length) break;
                    _ref21 = _iterator22[_i24++];
                } else {
                    _i24 = _iterator22.next();
                    if (_i24.done) break;
                    _ref21 = _i24.value;
                }

                var file = _ref21;

                file.xhr = xhr;
            }
            if (files[0].upload.chunked) {
                // Put the xhr object in the right chunk object, so it can be associated later, and found with _getChunk
                files[0].upload.chunks[dataBlocks[0].chunkIndex].xhr = xhr;
            }

            var method = this.resolveOption(this.options.method, files);
            var url = this.resolveOption(this.options.url, files);
            xhr.open(method, url, true);

            // Setting the timeout after open because of IE11 issue: https://gitlab.com/meno/dropzone/issues/8
            xhr.timeout = this.resolveOption(this.options.timeout, files);

            // Has to be after `.open()`. See https://github.com/enyo/dropzone/issues/179
            xhr.withCredentials = !!this.options.withCredentials;

            xhr.onload = function (e) {
                _this15._finishedUploading(files, xhr, e);
            };

            xhr.onerror = function () {
                _this15._handleUploadError(files, xhr);
            };

            // Some browsers do not have the .upload property
            var progressObj = xhr.upload != null ? xhr.upload : xhr;
            progressObj.onprogress = function (e) {
                return _this15._updateFilesUploadProgress(files, xhr, e);
            };

            var headers = {
                "Accept": "application/json",
                "Cache-Control": "no-cache",
                "X-Requested-With": "XMLHttpRequest"
            };

            if (this.options.headers) {
                Dropzone.extend(headers, this.options.headers);
            }

            for (var headerName in headers) {
                var headerValue = headers[headerName];
                if (headerValue) {
                    xhr.setRequestHeader(headerName, headerValue);
                }
            }

            var formData = new FormData();

            // Adding all @options parameters
            if (this.options.params) {
                var additionalParams = this.options.params;
                if (typeof additionalParams === 'function') {
                    additionalParams = additionalParams.call(this, files, xhr, files[0].upload.chunked ? this._getChunk(files[0], xhr) : null);
                }

                for (var key in additionalParams) {
                    var value = additionalParams[key];
                    formData.append(key, value);
                }
            }

            // Let the user add additional data if necessary
            for (var _iterator23 = files, _isArray23 = true, _i25 = 0, _iterator23 = _isArray23 ? _iterator23 : _iterator23[Symbol.iterator]();;) {
                var _ref22;

                if (_isArray23) {
                    if (_i25 >= _iterator23.length) break;
                    _ref22 = _iterator23[_i25++];
                } else {
                    _i25 = _iterator23.next();
                    if (_i25.done) break;
                    _ref22 = _i25.value;
                }

                var _file = _ref22;

                this.emit("sending", _file, xhr, formData);
            }
            if (this.options.uploadMultiple) {
                this.emit("sendingmultiple", files, xhr, formData);
            }

            this._addFormElementData(formData);

            // Finally add the files
            // Has to be last because some servers (eg: S3) expect the file to be the last parameter
            for (var i = 0; i < dataBlocks.length; i++) {
                var dataBlock = dataBlocks[i];
                formData.append(dataBlock.name, dataBlock.data, dataBlock.filename);
            }

            this.submitRequest(xhr, formData, files);
        }

        // Transforms all files with this.options.transformFile and invokes done with the transformed files when done.

    }, {
        key: "_transformFiles",
        value: function _transformFiles(files, done) {
            var _this16 = this;

            var transformedFiles = [];
            // Clumsy way of handling asynchronous calls, until I get to add a proper Future library.
            var doneCounter = 0;

            var _loop = function _loop(i) {
                _this16.options.transformFile.call(_this16, files[i], function (transformedFile) {
                    transformedFiles[i] = transformedFile;
                    if (++doneCounter === files.length) {
                        done(transformedFiles);
                    }
                });
            };

            for (var i = 0; i < files.length; i++) {
                _loop(i);
            }
        }

        // Takes care of adding other input elements of the form to the AJAX request

    }, {
        key: "_addFormElementData",
        value: function _addFormElementData(formData) {
            // Take care of other input elements
            if (this.element.tagName === "FORM") {
                for (var _iterator24 = this.element.querySelectorAll("input, textarea, select, button"), _isArray24 = true, _i26 = 0, _iterator24 = _isArray24 ? _iterator24 : _iterator24[Symbol.iterator]();;) {
                    var _ref23;

                    if (_isArray24) {
                        if (_i26 >= _iterator24.length) break;
                        _ref23 = _iterator24[_i26++];
                    } else {
                        _i26 = _iterator24.next();
                        if (_i26.done) break;
                        _ref23 = _i26.value;
                    }

                    var input = _ref23;

                    var inputName = input.getAttribute("name");
                    var inputType = input.getAttribute("type");
                    if (inputType) inputType = inputType.toLowerCase();

                    // If the input doesn't have a name, we can't use it.
                    if (typeof inputName === 'undefined' || inputName === null) continue;

                    if (input.tagName === "SELECT" && input.hasAttribute("multiple")) {
                        // Possibly multiple values
                        for (var _iterator25 = input.options, _isArray25 = true, _i27 = 0, _iterator25 = _isArray25 ? _iterator25 : _iterator25[Symbol.iterator]();;) {
                            var _ref24;

                            if (_isArray25) {
                                if (_i27 >= _iterator25.length) break;
                                _ref24 = _iterator25[_i27++];
                            } else {
                                _i27 = _iterator25.next();
                                if (_i27.done) break;
                                _ref24 = _i27.value;
                            }

                            var option = _ref24;

                            if (option.selected) {
                                formData.append(inputName, option.value);
                            }
                        }
                    } else if (!inputType || inputType !== "checkbox" && inputType !== "radio" || input.checked) {
                        formData.append(inputName, input.value);
                    }
                }
            }
        }

        // Invoked when there is new progress information about given files.
        // If e is not provided, it is assumed that the upload is finished.

    }, {
        key: "_updateFilesUploadProgress",
        value: function _updateFilesUploadProgress(files, xhr, e) {
            var progress = void 0;
            if (typeof e !== 'undefined') {
                progress = 100 * e.loaded / e.total;

                if (files[0].upload.chunked) {
                    var file = files[0];
                    // Since this is a chunked upload, we need to update the appropriate chunk progress.
                    var chunk = this._getChunk(file, xhr);
                    chunk.progress = progress;
                    chunk.total = e.total;
                    chunk.bytesSent = e.loaded;
                    var fileProgress = 0,
                        fileTotal = void 0,
                        fileBytesSent = void 0;
                    file.upload.progress = 0;
                    file.upload.total = 0;
                    file.upload.bytesSent = 0;
                    for (var i = 0; i < file.upload.totalChunkCount; i++) {
                        if (file.upload.chunks[i] !== undefined && file.upload.chunks[i].progress !== undefined) {
                            file.upload.progress += file.upload.chunks[i].progress;
                            file.upload.total += file.upload.chunks[i].total;
                            file.upload.bytesSent += file.upload.chunks[i].bytesSent;
                        }
                    }
                    file.upload.progress = file.upload.progress / file.upload.totalChunkCount;
                } else {
                    for (var _iterator26 = files, _isArray26 = true, _i28 = 0, _iterator26 = _isArray26 ? _iterator26 : _iterator26[Symbol.iterator]();;) {
                        var _ref25;

                        if (_isArray26) {
                            if (_i28 >= _iterator26.length) break;
                            _ref25 = _iterator26[_i28++];
                        } else {
                            _i28 = _iterator26.next();
                            if (_i28.done) break;
                            _ref25 = _i28.value;
                        }

                        var _file2 = _ref25;

                        _file2.upload.progress = progress;
                        _file2.upload.total = e.total;
                        _file2.upload.bytesSent = e.loaded;
                    }
                }
                for (var _iterator27 = files, _isArray27 = true, _i29 = 0, _iterator27 = _isArray27 ? _iterator27 : _iterator27[Symbol.iterator]();;) {
                    var _ref26;

                    if (_isArray27) {
                        if (_i29 >= _iterator27.length) break;
                        _ref26 = _iterator27[_i29++];
                    } else {
                        _i29 = _iterator27.next();
                        if (_i29.done) break;
                        _ref26 = _i29.value;
                    }

                    var _file3 = _ref26;

                    this.emit("uploadprogress", _file3, _file3.upload.progress, _file3.upload.bytesSent);
                }
            } else {
                // Called when the file finished uploading

                var allFilesFinished = true;

                progress = 100;

                for (var _iterator28 = files, _isArray28 = true, _i30 = 0, _iterator28 = _isArray28 ? _iterator28 : _iterator28[Symbol.iterator]();;) {
                    var _ref27;

                    if (_isArray28) {
                        if (_i30 >= _iterator28.length) break;
                        _ref27 = _iterator28[_i30++];
                    } else {
                        _i30 = _iterator28.next();
                        if (_i30.done) break;
                        _ref27 = _i30.value;
                    }

                    var _file4 = _ref27;

                    if (_file4.upload.progress !== 100 || _file4.upload.bytesSent !== _file4.upload.total) {
                        allFilesFinished = false;
                    }
                    _file4.upload.progress = progress;
                    _file4.upload.bytesSent = _file4.upload.total;
                }

                // Nothing to do, all files already at 100%
                if (allFilesFinished) {
                    return;
                }

                for (var _iterator29 = files, _isArray29 = true, _i31 = 0, _iterator29 = _isArray29 ? _iterator29 : _iterator29[Symbol.iterator]();;) {
                    var _ref28;

                    if (_isArray29) {
                        if (_i31 >= _iterator29.length) break;
                        _ref28 = _iterator29[_i31++];
                    } else {
                        _i31 = _iterator29.next();
                        if (_i31.done) break;
                        _ref28 = _i31.value;
                    }

                    var _file5 = _ref28;

                    this.emit("uploadprogress", _file5, progress, _file5.upload.bytesSent);
                }
            }
        }
    }, {
        key: "_finishedUploading",
        value: function _finishedUploading(files, xhr, e) {
            var response = void 0;

            if (files[0].status === Dropzone.CANCELED) {
                return;
            }

            if (xhr.readyState !== 4) {
                return;
            }

            if (xhr.responseType !== 'arraybuffer' && xhr.responseType !== 'blob') {
                response = xhr.responseText;

                if (xhr.getResponseHeader("content-type") && ~xhr.getResponseHeader("content-type").indexOf("application/json")) {
                    try {
                        response = JSON.parse(response);
                    } catch (error) {
                        e = error;
                        response = "Invalid JSON response from server.";
                    }
                }
            }

            this._updateFilesUploadProgress(files);

            if (!(200 <= xhr.status && xhr.status < 300)) {
                this._handleUploadError(files, xhr, response);
            } else {
                if (files[0].upload.chunked) {
                    files[0].upload.finishedChunkUpload(this._getChunk(files[0], xhr));
                } else {
                    this._finished(files, response, e);
                }
            }
        }
    }, {
        key: "_handleUploadError",
        value: function _handleUploadError(files, xhr, response) {
            if (files[0].status === Dropzone.CANCELED) {
                return;
            }

            if (files[0].upload.chunked && this.options.retryChunks) {
                var chunk = this._getChunk(files[0], xhr);
                if (chunk.retries++ < this.options.retryChunksLimit) {
                    this._uploadData(files, [chunk.dataBlock]);
                    return;
                } else {
                    console.warn('Retried this chunk too often. Giving up.');
                }
            }

            for (var _iterator30 = files, _isArray30 = true, _i32 = 0, _iterator30 = _isArray30 ? _iterator30 : _iterator30[Symbol.iterator]();;) {
                var _ref29;

                if (_isArray30) {
                    if (_i32 >= _iterator30.length) break;
                    _ref29 = _iterator30[_i32++];
                } else {
                    _i32 = _iterator30.next();
                    if (_i32.done) break;
                    _ref29 = _i32.value;
                }

                var file = _ref29;

                this._errorProcessing(files, response || this.options.dictResponseError.replace("{{statusCode}}", xhr.status), xhr);
            }
        }
    }, {
        key: "submitRequest",
        value: function submitRequest(xhr, formData, files) {
            xhr.send(formData);
        }

        // Called internally when processing is finished.
        // Individual callbacks have to be called in the appropriate sections.

    }, {
        key: "_finished",
        value: function _finished(files, responseText, e) {
            for (var _iterator31 = files, _isArray31 = true, _i33 = 0, _iterator31 = _isArray31 ? _iterator31 : _iterator31[Symbol.iterator]();;) {
                var _ref30;

                if (_isArray31) {
                    if (_i33 >= _iterator31.length) break;
                    _ref30 = _iterator31[_i33++];
                } else {
                    _i33 = _iterator31.next();
                    if (_i33.done) break;
                    _ref30 = _i33.value;
                }

                var file = _ref30;

                file.status = Dropzone.SUCCESS;
                this.emit("success", file, responseText, e);
                this.emit("complete", file);
            }
            if (this.options.uploadMultiple) {
                this.emit("successmultiple", files, responseText, e);
                this.emit("completemultiple", files);
            }

            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        }

        // Called internally when processing is finished.
        // Individual callbacks have to be called in the appropriate sections.

    }, {
        key: "_errorProcessing",
        value: function _errorProcessing(files, message, xhr) {
            for (var _iterator32 = files, _isArray32 = true, _i34 = 0, _iterator32 = _isArray32 ? _iterator32 : _iterator32[Symbol.iterator]();;) {
                var _ref31;

                if (_isArray32) {
                    if (_i34 >= _iterator32.length) break;
                    _ref31 = _iterator32[_i34++];
                } else {
                    _i34 = _iterator32.next();
                    if (_i34.done) break;
                    _ref31 = _i34.value;
                }

                var file = _ref31;

                file.status = Dropzone.ERROR;
                this.emit("error", file, message, xhr);
                this.emit("complete", file);
            }
            if (this.options.uploadMultiple) {
                this.emit("errormultiple", files, message, xhr);
                this.emit("completemultiple", files);
            }

            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        }
    }], [{
        key: "uuidv4",
        value: function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = Math.random() * 16 | 0,
                    v = c === 'x' ? r : r & 0x3 | 0x8;
                return v.toString(16);
            });
        }
    }]);

    return Dropzone;
}(Emitter);

Dropzone.initClass();

Dropzone.version = "5.3.1";

// This is a map of options for your different dropzones. Add configurations
// to this object for your different dropzone elemens.
//
// Example:
//
//     Dropzone.options.myDropzoneElementId = { maxFilesize: 1 };
//
// To disable autoDiscover for a specific element, you can set `false` as an option:
//
//     Dropzone.options.myDisabledElementId = false;
//
// And in html:
//
//     <form action="/upload" id="my-dropzone-element-id" class="dropzone"></form>
Dropzone.options = {};

// Returns the options for an element or undefined if none available.
Dropzone.optionsForElement = function (element) {
    // Get the `Dropzone.options.elementId` for this element if it exists
    if (element.getAttribute("id")) {
        return Dropzone.options[camelize(element.getAttribute("id"))];
    } else {
        return undefined;
    }
};

// Holds a list of all dropzone instances
Dropzone.instances = [];

// Returns the dropzone for given element if any
Dropzone.forElement = function (element) {
    if (typeof element === "string") {
        element = document.querySelector(element);
    }
    if ((element != null ? element.dropzone : undefined) == null) {
        throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
    }
    return element.dropzone;
};

// Set to false if you don't want Dropzone to automatically find and attach to .dropzone elements.
Dropzone.autoDiscover = true;

// Looks for all .dropzone elements and creates a dropzone for them
Dropzone.discover = function () {
    var dropzones = void 0;
    if (document.querySelectorAll) {
        dropzones = document.querySelectorAll(".dropzone");
    } else {
        dropzones = [];
        // IE :(
        var checkElements = function checkElements(elements) {
            return function () {
                var result = [];
                for (var _iterator33 = elements, _isArray33 = true, _i35 = 0, _iterator33 = _isArray33 ? _iterator33 : _iterator33[Symbol.iterator]();;) {
                    var _ref32;

                    if (_isArray33) {
                        if (_i35 >= _iterator33.length) break;
                        _ref32 = _iterator33[_i35++];
                    } else {
                        _i35 = _iterator33.next();
                        if (_i35.done) break;
                        _ref32 = _i35.value;
                    }

                    var el = _ref32;

                    if (/(^| )dropzone($| )/.test(el.className)) {
                        result.push(dropzones.push(el));
                    } else {
                        result.push(undefined);
                    }
                }
                return result;
            }();
        };
        checkElements(document.getElementsByTagName("div"));
        checkElements(document.getElementsByTagName("form"));
    }

    return function () {
        var result = [];
        for (var _iterator34 = dropzones, _isArray34 = true, _i36 = 0, _iterator34 = _isArray34 ? _iterator34 : _iterator34[Symbol.iterator]();;) {
            var _ref33;

            if (_isArray34) {
                if (_i36 >= _iterator34.length) break;
                _ref33 = _iterator34[_i36++];
            } else {
                _i36 = _iterator34.next();
                if (_i36.done) break;
                _ref33 = _i36.value;
            }

            var dropzone = _ref33;

            // Create a dropzone unless auto discover has been disabled for specific element
            if (Dropzone.optionsForElement(dropzone) !== false) {
                result.push(new Dropzone(dropzone));
            } else {
                result.push(undefined);
            }
        }
        return result;
    }();
};

// Since the whole Drag'n'Drop API is pretty new, some browsers implement it,
// but not correctly.
// So I created a blacklist of userAgents. Yes, yes. Browser sniffing, I know.
// But what to do when browsers *theoretically* support an API, but crash
// when using it.
//
// This is a list of regular expressions tested against navigator.userAgent
//
// ** It should only be used on browser that *do* support the API, but
// incorrectly **
//
Dropzone.blacklistedBrowsers = [
// The mac os and windows phone version of opera 12 seems to have a problem with the File drag'n'drop API.
    /opera.*(Macintosh|Windows Phone).*version\/12/i];

// Checks if the browser is supported
Dropzone.isBrowserSupported = function () {
    var capableBrowser = true;

    if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector) {
        if (!("classList" in document.createElement("a"))) {
            capableBrowser = false;
        } else {
            // The browser supports the API, but may be blacklisted.
            for (var _iterator35 = Dropzone.blacklistedBrowsers, _isArray35 = true, _i37 = 0, _iterator35 = _isArray35 ? _iterator35 : _iterator35[Symbol.iterator]();;) {
                var _ref34;

                if (_isArray35) {
                    if (_i37 >= _iterator35.length) break;
                    _ref34 = _iterator35[_i37++];
                } else {
                    _i37 = _iterator35.next();
                    if (_i37.done) break;
                    _ref34 = _i37.value;
                }

                var regex = _ref34;

                if (regex.test(navigator.userAgent)) {
                    capableBrowser = false;
                    continue;
                }
            }
        }
    } else {
        capableBrowser = false;
    }

    return capableBrowser;
};

Dropzone.dataURItoBlob = function (dataURI) {
    // convert base64 to raw binary data held in a string
    // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    var byteString = atob(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to an ArrayBuffer
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0, end = byteString.length, asc = 0 <= end; asc ? i <= end : i >= end; asc ? i++ : i--) {
        ia[i] = byteString.charCodeAt(i);
    }

    // write the ArrayBuffer to a blob
    return new Blob([ab], { type: mimeString });
};

// Returns an array without the rejected item
var without = function without(list, rejectedItem) {
    return list.filter(function (item) {
        return item !== rejectedItem;
    }).map(function (item) {
        return item;
    });
};

// abc-def_ghi -> abcDefGhi
var camelize = function camelize(str) {
    return str.replace(/[\-_](\w)/g, function (match) {
        return match.charAt(1).toUpperCase();
    });
};

// Creates an element from string
Dropzone.createElement = function (string) {
    var div = document.createElement("div");
    div.innerHTML = string;
    return div.childNodes[0];
};

// Tests if given element is inside (or simply is) the container
Dropzone.elementInside = function (element, container) {
    if (element === container) {
        return true;
    } // Coffeescript doesn't support do/while loops
    while (element = element.parentNode) {
        if (element === container) {
            return true;
        }
    }
    return false;
};

Dropzone.getElement = function (el, name) {
    var element = void 0;
    if (typeof el === "string") {
        element = document.querySelector(el);
    } else if (el.nodeType != null) {
        element = el;
    }
    if (element == null) {
        throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector or a plain HTML element.");
    }
    return element;
};

Dropzone.getElements = function (els, name) {
    var el = void 0,
        elements = void 0;
    if (els instanceof Array) {
        elements = [];
        try {
            for (var _iterator36 = els, _isArray36 = true, _i38 = 0, _iterator36 = _isArray36 ? _iterator36 : _iterator36[Symbol.iterator]();;) {
                if (_isArray36) {
                    if (_i38 >= _iterator36.length) break;
                    el = _iterator36[_i38++];
                } else {
                    _i38 = _iterator36.next();
                    if (_i38.done) break;
                    el = _i38.value;
                }

                elements.push(this.getElement(el, name));
            }
        } catch (e) {
            elements = null;
        }
    } else if (typeof els === "string") {
        elements = [];
        for (var _iterator37 = document.querySelectorAll(els), _isArray37 = true, _i39 = 0, _iterator37 = _isArray37 ? _iterator37 : _iterator37[Symbol.iterator]();;) {
            if (_isArray37) {
                if (_i39 >= _iterator37.length) break;
                el = _iterator37[_i39++];
            } else {
                _i39 = _iterator37.next();
                if (_i39.done) break;
                el = _i39.value;
            }

            elements.push(el);
        }
    } else if (els.nodeType != null) {
        elements = [els];
    }

    if (elements == null || !elements.length) {
        throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector, a plain HTML element or a list of those.");
    }

    return elements;
};

// Asks the user the question and calls accepted or rejected accordingly
//
// The default implementation just uses `window.confirm` and then calls the
// appropriate callback.
Dropzone.confirm = function (question, accepted, rejected) {
    if (window.confirm(question)) {
        return accepted();
    } else if (rejected != null) {
        return rejected();
    }
};

// Validates the mime type like this:
//
// https://developer.mozilla.org/en-US/docs/HTML/Element/input#attr-accept
Dropzone.isValidFile = function (file, acceptedFiles) {
    if (!acceptedFiles) {
        return true;
    } // If there are no accepted mime types, it's OK
    acceptedFiles = acceptedFiles.split(",");

    var mimeType = file.type;
    var baseMimeType = mimeType.replace(/\/.*$/, "");

    for (var _iterator38 = acceptedFiles, _isArray38 = true, _i40 = 0, _iterator38 = _isArray38 ? _iterator38 : _iterator38[Symbol.iterator]();;) {
        var _ref35;

        if (_isArray38) {
            if (_i40 >= _iterator38.length) break;
            _ref35 = _iterator38[_i40++];
        } else {
            _i40 = _iterator38.next();
            if (_i40.done) break;
            _ref35 = _i40.value;
        }

        var validType = _ref35;

        validType = validType.trim();
        if (validType.charAt(0) === ".") {
            if (file.name.toLowerCase().indexOf(validType.toLowerCase(), file.name.length - validType.length) !== -1) {
                return true;
            }
        } else if (/\/\*$/.test(validType)) {
            // This is something like a image/* mime type
            if (baseMimeType === validType.replace(/\/.*$/, "")) {
                return true;
            }
        } else {
            if (mimeType === validType) {
                return true;
            }
        }
    }

    return false;
};

// Augment jQuery
if (typeof jQuery !== 'undefined' && jQuery !== null) {
    jQuery.fn.dropzone = function (options) {
        return this.each(function () {
            return new Dropzone(this, options);
        });
    };
}

if (typeof module !== 'undefined' && module !== null) {
    module.exports = Dropzone;
} else {
    window.Dropzone = Dropzone;
}

// Dropzone file status codes
Dropzone.ADDED = "added";

Dropzone.QUEUED = "queued";
// For backwards compatibility. Now, if a file is accepted, it's either queued
// or uploading.
Dropzone.ACCEPTED = Dropzone.QUEUED;

Dropzone.UPLOADING = "uploading";
Dropzone.PROCESSING = Dropzone.UPLOADING; // alias

Dropzone.CANCELED = "canceled";
Dropzone.ERROR = "error";
Dropzone.SUCCESS = "success";

/*

 Bugfix for iOS 6 and 7
 Source: http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
 based on the work of https://github.com/stomita/ios-imagefile-megapixel

 */

// Detecting vertical squash in loaded image.
// Fixes a bug which squash image vertically while drawing into canvas for some images.
// This is a bug in iOS6 devices. This function from https://github.com/stomita/ios-imagefile-megapixel
var detectVerticalSquash = function detectVerticalSquash(img) {
    var iw = img.naturalWidth;
    var ih = img.naturalHeight;
    var canvas = document.createElement("canvas");
    canvas.width = 1;
    canvas.height = ih;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    var _ctx$getImageData = ctx.getImageData(1, 0, 1, ih),
        data = _ctx$getImageData.data;

    // search image edge pixel position in case it is squashed vertically.


    var sy = 0;
    var ey = ih;
    var py = ih;
    while (py > sy) {
        var alpha = data[(py - 1) * 4 + 3];

        if (alpha === 0) {
            ey = py;
        } else {
            sy = py;
        }

        py = ey + sy >> 1;
    }
    var ratio = py / ih;

    if (ratio === 0) {
        return 1;
    } else {
        return ratio;
    }
};

// A replacement for context.drawImage
// (args are for source and destination).
var drawImageIOSFix = function drawImageIOSFix(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    var vertSquashRatio = detectVerticalSquash(img);
    return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
};

// Based on MinifyJpeg
// Source: http://www.perry.cz/files/ExifRestorer.js
// http://elicon.blog57.fc2.com/blog-entry-206.html

var ExifRestore = function () {
    function ExifRestore() {
        _classCallCheck(this, ExifRestore);
    }

    _createClass(ExifRestore, null, [{
        key: "initClass",
        value: function initClass() {
            this.KEY_STR = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
        }
    }, {
        key: "encode64",
        value: function encode64(input) {
            var output = '';
            var chr1 = undefined;
            var chr2 = undefined;
            var chr3 = '';
            var enc1 = undefined;
            var enc2 = undefined;
            var enc3 = undefined;
            var enc4 = '';
            var i = 0;
            while (true) {
                chr1 = input[i++];
                chr2 = input[i++];
                chr3 = input[i++];
                enc1 = chr1 >> 2;
                enc2 = (chr1 & 3) << 4 | chr2 >> 4;
                enc3 = (chr2 & 15) << 2 | chr3 >> 6;
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output + this.KEY_STR.charAt(enc1) + this.KEY_STR.charAt(enc2) + this.KEY_STR.charAt(enc3) + this.KEY_STR.charAt(enc4);
                chr1 = chr2 = chr3 = '';
                enc1 = enc2 = enc3 = enc4 = '';
                if (!(i < input.length)) {
                    break;
                }
            }
            return output;
        }
    }, {
        key: "restore",
        value: function restore(origFileBase64, resizedFileBase64) {
            if (!origFileBase64.match('data:image/jpeg;base64,')) {
                return resizedFileBase64;
            }
            var rawImage = this.decode64(origFileBase64.replace('data:image/jpeg;base64,', ''));
            var segments = this.slice2Segments(rawImage);
            var image = this.exifManipulation(resizedFileBase64, segments);
            return "data:image/jpeg;base64," + this.encode64(image);
        }
    }, {
        key: "exifManipulation",
        value: function exifManipulation(resizedFileBase64, segments) {
            var exifArray = this.getExifArray(segments);
            var newImageArray = this.insertExif(resizedFileBase64, exifArray);
            var aBuffer = new Uint8Array(newImageArray);
            return aBuffer;
        }
    }, {
        key: "getExifArray",
        value: function getExifArray(segments) {
            var seg = undefined;
            var x = 0;
            while (x < segments.length) {
                seg = segments[x];
                if (seg[0] === 255 & seg[1] === 225) {
                    return seg;
                }
                x++;
            }
            return [];
        }
    }, {
        key: "insertExif",
        value: function insertExif(resizedFileBase64, exifArray) {
            var imageData = resizedFileBase64.replace('data:image/jpeg;base64,', '');
            var buf = this.decode64(imageData);
            var separatePoint = buf.indexOf(255, 3);
            var mae = buf.slice(0, separatePoint);
            var ato = buf.slice(separatePoint);
            var array = mae;
            array = array.concat(exifArray);
            array = array.concat(ato);
            return array;
        }
    }, {
        key: "slice2Segments",
        value: function slice2Segments(rawImageArray) {
            var head = 0;
            var segments = [];
            while (true) {
                var length;
                if (rawImageArray[head] === 255 & rawImageArray[head + 1] === 218) {
                    break;
                }
                if (rawImageArray[head] === 255 & rawImageArray[head + 1] === 216) {
                    head += 2;
                } else {
                    length = rawImageArray[head + 2] * 256 + rawImageArray[head + 3];
                    var endPoint = head + length + 2;
                    var seg = rawImageArray.slice(head, endPoint);
                    segments.push(seg);
                    head = endPoint;
                }
                if (head > rawImageArray.length) {
                    break;
                }
            }
            return segments;
        }
    }, {
        key: "decode64",
        value: function decode64(input) {
            var output = '';
            var chr1 = undefined;
            var chr2 = undefined;
            var chr3 = '';
            var enc1 = undefined;
            var enc2 = undefined;
            var enc3 = undefined;
            var enc4 = '';
            var i = 0;
            var buf = [];
            // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
            var base64test = /[^A-Za-z0-9\+\/\=]/g;
            if (base64test.exec(input)) {
                console.warn('There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, \'+\', \'/\',and \'=\'\nExpect errors in decoding.');
            }
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, '');
            while (true) {
                enc1 = this.KEY_STR.indexOf(input.charAt(i++));
                enc2 = this.KEY_STR.indexOf(input.charAt(i++));
                enc3 = this.KEY_STR.indexOf(input.charAt(i++));
                enc4 = this.KEY_STR.indexOf(input.charAt(i++));
                chr1 = enc1 << 2 | enc2 >> 4;
                chr2 = (enc2 & 15) << 4 | enc3 >> 2;
                chr3 = (enc3 & 3) << 6 | enc4;
                buf.push(chr1);
                if (enc3 !== 64) {
                    buf.push(chr2);
                }
                if (enc4 !== 64) {
                    buf.push(chr3);
                }
                chr1 = chr2 = chr3 = '';
                enc1 = enc2 = enc3 = enc4 = '';
                if (!(i < input.length)) {
                    break;
                }
            }
            return buf;
        }
    }]);

    return ExifRestore;
}();

ExifRestore.initClass();

/*
 * contentloaded.js
 *
 * Author: Diego Perini (diego.perini at gmail.com)
 * Summary: cross-browser wrapper for DOMContentLoaded
 * Updated: 20101020
 * License: MIT
 * Version: 1.2
 *
 * URL:
 * http://javascript.nwbox.com/ContentLoaded/
 * http://javascript.nwbox.com/ContentLoaded/MIT-LICENSE
 */

// @win window reference
// @fn function reference
var contentLoaded = function contentLoaded(win, fn) {
    var done = false;
    var top = true;
    var doc = win.document;
    var root = doc.documentElement;
    var add = doc.addEventListener ? "addEventListener" : "attachEvent";
    var rem = doc.addEventListener ? "removeEventListener" : "detachEvent";
    var pre = doc.addEventListener ? "" : "on";
    var init = function init(e) {
        if (e.type === "readystatechange" && doc.readyState !== "complete") {
            return;
        }
        (e.type === "load" ? win : doc)[rem](pre + e.type, init, false);
        if (!done && (done = true)) {
            return fn.call(win, e.type || e);
        }
    };

    var poll = function poll() {
        try {
            root.doScroll("left");
        } catch (e) {
            setTimeout(poll, 50);
            return;
        }
        return init("poll");
    };

    if (doc.readyState !== "complete") {
        if (doc.createEventObject && root.doScroll) {
            try {
                top = !win.frameElement;
            } catch (error) {}
            if (top) {
                poll();
            }
        }
        doc[add](pre + "DOMContentLoaded", init, false);
        doc[add](pre + "readystatechange", init, false);
        return win[add](pre + "load", init, false);
    }
};

// As a single function to be able to write tests.
Dropzone._autoDiscoverFunction = function () {
    if (Dropzone.autoDiscover) {
        return Dropzone.discover();
    }
};
contentLoaded(window, Dropzone._autoDiscoverFunction);

function __guard__(value, transform) {
    return typeof value !== 'undefined' && value !== null ? transform(value) : undefined;
}
function __guardMethod__(obj, methodName, transform) {
    if (typeof obj !== 'undefined' && obj !== null && typeof obj[methodName] === 'function') {
        return transform(obj, methodName);
    } else {
        return undefined;
    }
}

/**
 *  Ajax Autocomplete for jQuery, version 1.4.7
 *  (c) 2017 Tomas Kirda
 *
 *  Ajax Autocomplete for jQuery is freely distributable under the terms of an MIT-style license.
 *  For details, see the web site: https://github.com/devbridge/jQuery-Autocomplete
 */
!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports&&"function"==typeof require?require("jquery"):jQuery)}(function(a){"use strict";function b(c,d){var e=this;e.element=c,e.el=a(c),e.suggestions=[],e.badQueries=[],e.selectedIndex=-1,e.currentValue=e.element.value,e.timeoutId=null,e.cachedResponse={},e.onChangeTimeout=null,e.onChange=null,e.isLocal=!1,e.suggestionsContainer=null,e.noSuggestionsContainer=null,e.options=a.extend({},b.defaults,d),e.classes={selected:"autocomplete-selected",suggestion:"autocomplete-suggestion"},e.hint=null,e.hintValue="",e.selection=null,e.initialize(),e.setOptions(d)}function c(a,b,c){return a.value.toLowerCase().indexOf(c)!==-1}function d(b){return"string"==typeof b?a.parseJSON(b):b}function e(a,b){if(!b)return a.value;var c="("+g.escapeRegExChars(b)+")";return a.value.replace(new RegExp(c,"gi"),"<strong>$1</strong>").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/&lt;(\/?strong)&gt;/g,"<$1>")}function f(a,b){return'<div class="autocomplete-group">'+b+"</div>"}var g=function(){return{escapeRegExChars:function(a){return a.replace(/[|\\{}()[\]^$+*?.]/g,"\\$&")},createNode:function(a){var b=document.createElement("div");return b.className=a,b.style.position="absolute",b.style.display="none",b}}}(),h={ESC:27,TAB:9,RETURN:13,LEFT:37,UP:38,RIGHT:39,DOWN:40},i=a.noop;b.utils=g,a.Autocomplete=b,b.defaults={ajaxSettings:{},autoSelectFirst:!1,appendTo:"body",serviceUrl:null,lookup:null,onSelect:null,width:"auto",minChars:1,maxHeight:300,deferRequestBy:0,params:{},formatResult:e,formatGroup:f,delimiter:null,zIndex:9999,type:"GET",noCache:!1,onSearchStart:i,onSearchComplete:i,onSearchError:i,preserveInput:!1,containerClass:"autocomplete-suggestions",tabDisabled:!1,dataType:"text",currentRequest:null,triggerSelectOnValidInput:!0,preventBadQueries:!0,lookupFilter:c,paramName:"query",transformResult:d,showNoSuggestionNotice:!1,noSuggestionNotice:"No results",orientation:"bottom",forceFixPosition:!1},b.prototype={initialize:function(){var c,d=this,e="."+d.classes.suggestion,f=d.classes.selected,g=d.options;d.element.setAttribute("autocomplete","off"),d.noSuggestionsContainer=a('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0),d.suggestionsContainer=b.utils.createNode(g.containerClass),c=a(d.suggestionsContainer),c.appendTo(g.appendTo||"body"),"auto"!==g.width&&c.css("width",g.width),c.on("mouseover.autocomplete",e,function(){d.activate(a(this).data("index"))}),c.on("mouseout.autocomplete",function(){d.selectedIndex=-1,c.children("."+f).removeClass(f)}),c.on("click.autocomplete",e,function(){d.select(a(this).data("index"))}),c.on("click.autocomplete",function(){clearTimeout(d.blurTimeoutId)}),d.fixPositionCapture=function(){d.visible&&d.fixPosition()},a(window).on("resize.autocomplete",d.fixPositionCapture),d.el.on("keydown.autocomplete",function(a){d.onKeyPress(a)}),d.el.on("keyup.autocomplete",function(a){d.onKeyUp(a)}),d.el.on("blur.autocomplete",function(){d.onBlur()}),d.el.on("focus.autocomplete",function(){d.onFocus()}),d.el.on("change.autocomplete",function(a){d.onKeyUp(a)}),d.el.on("input.autocomplete",function(a){d.onKeyUp(a)})},onFocus:function(){var a=this;a.fixPosition(),a.el.val().length>=a.options.minChars&&a.onValueChange()},onBlur:function(){var a=this;a.blurTimeoutId=setTimeout(function(){a.hide()},200)},abortAjax:function(){var a=this;a.currentRequest&&(a.currentRequest.abort(),a.currentRequest=null)},setOptions:function(b){var c=this,d=a.extend({},c.options,b);c.isLocal=Array.isArray(d.lookup),c.isLocal&&(d.lookup=c.verifySuggestionsFormat(d.lookup)),d.orientation=c.validateOrientation(d.orientation,"bottom"),a(c.suggestionsContainer).css({"max-height":d.maxHeight+"px",width:d.width+"px","z-index":d.zIndex}),this.options=d},clearCache:function(){this.cachedResponse={},this.badQueries=[]},clear:function(){this.clearCache(),this.currentValue="",this.suggestions=[]},disable:function(){var a=this;a.disabled=!0,clearTimeout(a.onChangeTimeout),a.abortAjax()},enable:function(){this.disabled=!1},fixPosition:function(){var b=this,c=a(b.suggestionsContainer),d=c.parent().get(0);if(d===document.body||b.options.forceFixPosition){var e=b.options.orientation,f=c.outerHeight(),g=b.el.outerHeight(),h=b.el.offset(),i={top:h.top,left:h.left};if("auto"===e){var j=a(window).height(),k=a(window).scrollTop(),l=-k+h.top-f,m=k+j-(h.top+g+f);e=Math.max(l,m)===l?"top":"bottom"}if("top"===e?i.top+=-f:i.top+=g,d!==document.body){var n,o=c.css("opacity");b.visible||c.css("opacity",0).show(),n=c.offsetParent().offset(),i.top-=n.top,i.top+=d.scrollTop,i.left-=n.left,b.visible||c.css("opacity",o).hide()}"auto"===b.options.width&&(i.width=b.el.outerWidth()+"px"),c.css(i)}},isCursorAtEnd:function(){var a,b=this,c=b.el.val().length,d=b.element.selectionStart;return"number"==typeof d?d===c:!document.selection||(a=document.selection.createRange(),a.moveStart("character",-c),c===a.text.length)},onKeyPress:function(a){var b=this;if(!b.disabled&&!b.visible&&a.which===h.DOWN&&b.currentValue)return void b.suggest();if(!b.disabled&&b.visible){switch(a.which){case h.ESC:b.el.val(b.currentValue),b.hide();break;case h.RIGHT:if(b.hint&&b.options.onHint&&b.isCursorAtEnd()){b.selectHint();break}return;case h.TAB:if(b.hint&&b.options.onHint)return void b.selectHint();if(b.selectedIndex===-1)return void b.hide();if(b.select(b.selectedIndex),b.options.tabDisabled===!1)return;break;case h.RETURN:if(b.selectedIndex===-1)return void b.hide();b.select(b.selectedIndex);break;case h.UP:b.moveUp();break;case h.DOWN:b.moveDown();break;default:return}a.stopImmediatePropagation(),a.preventDefault()}},onKeyUp:function(a){var b=this;if(!b.disabled){switch(a.which){case h.UP:case h.DOWN:return}clearTimeout(b.onChangeTimeout),b.currentValue!==b.el.val()&&(b.findBestHint(),b.options.deferRequestBy>0?b.onChangeTimeout=setTimeout(function(){b.onValueChange()},b.options.deferRequestBy):b.onValueChange())}},onValueChange:function(){if(this.ignoreValueChange)return void(this.ignoreValueChange=!1);var b=this,c=b.options,d=b.el.val(),e=b.getQuery(d);return b.selection&&b.currentValue!==e&&(b.selection=null,(c.onInvalidateSelection||a.noop).call(b.element)),clearTimeout(b.onChangeTimeout),b.currentValue=d,b.selectedIndex=-1,c.triggerSelectOnValidInput&&b.isExactMatch(e)?void b.select(0):void(e.length<c.minChars?b.hide():b.getSuggestions(e))},isExactMatch:function(a){var b=this.suggestions;return 1===b.length&&b[0].value.toLowerCase()===a.toLowerCase()},getQuery:function(b){var c,d=this.options.delimiter;return d?(c=b.split(d),a.trim(c[c.length-1])):b},getSuggestionsLocal:function(b){var c,d=this,e=d.options,f=b.toLowerCase(),g=e.lookupFilter,h=parseInt(e.lookupLimit,10);return c={suggestions:a.grep(e.lookup,function(a){return g(a,b,f)})},h&&c.suggestions.length>h&&(c.suggestions=c.suggestions.slice(0,h)),c},getSuggestions:function(b){var c,d,e,f,g=this,h=g.options,i=h.serviceUrl;if(h.params[h.paramName]=b,h.onSearchStart.call(g.element,h.params)!==!1){if(d=h.ignoreParams?null:h.params,a.isFunction(h.lookup))return void h.lookup(b,function(a){g.suggestions=a.suggestions,g.suggest(),h.onSearchComplete.call(g.element,b,a.suggestions)});g.isLocal?c=g.getSuggestionsLocal(b):(a.isFunction(i)&&(i=i.call(g.element,b)),e=i+"?"+a.param(d||{}),c=g.cachedResponse[e]),c&&Array.isArray(c.suggestions)?(g.suggestions=c.suggestions,g.suggest(),h.onSearchComplete.call(g.element,b,c.suggestions)):g.isBadQuery(b)?h.onSearchComplete.call(g.element,b,[]):(g.abortAjax(),f={url:i,data:d,type:h.type,dataType:h.dataType},a.extend(f,h.ajaxSettings),g.currentRequest=a.ajax(f).done(function(a){var c;g.currentRequest=null,c=h.transformResult(a,b),g.processResponse(c,b,e),h.onSearchComplete.call(g.element,b,c.suggestions)}).fail(function(a,c,d){h.onSearchError.call(g.element,b,a,c,d)}))}},isBadQuery:function(a){if(!this.options.preventBadQueries)return!1;for(var b=this.badQueries,c=b.length;c--;)if(0===a.indexOf(b[c]))return!0;return!1},hide:function(){var b=this,c=a(b.suggestionsContainer);a.isFunction(b.options.onHide)&&b.visible&&b.options.onHide.call(b.element,c),b.visible=!1,b.selectedIndex=-1,clearTimeout(b.onChangeTimeout),a(b.suggestionsContainer).hide(),b.signalHint(null)},suggest:function(){if(!this.suggestions.length)return void(this.options.showNoSuggestionNotice?this.noSuggestions():this.hide());var b,c=this,d=c.options,e=d.groupBy,f=d.formatResult,g=c.getQuery(c.currentValue),h=c.classes.suggestion,i=c.classes.selected,j=a(c.suggestionsContainer),k=a(c.noSuggestionsContainer),l=d.beforeRender,m="",n=function(a,c){var f=a.data[e];return b===f?"":(b=f,d.formatGroup(a,b))};return d.triggerSelectOnValidInput&&c.isExactMatch(g)?void c.select(0):(a.each(c.suggestions,function(a,b){e&&(m+=n(b,g,a)),m+='<div class="'+h+'" data-index="'+a+'">'+f(b,g,a)+"</div>"}),this.adjustContainerWidth(),k.detach(),j.html(m),a.isFunction(l)&&l.call(c.element,j,c.suggestions),c.fixPosition(),j.show(),d.autoSelectFirst&&(c.selectedIndex=0,j.scrollTop(0),j.children("."+h).first().addClass(i)),c.visible=!0,void c.findBestHint())},noSuggestions:function(){var b=this,c=b.options.beforeRender,d=a(b.suggestionsContainer),e=a(b.noSuggestionsContainer);this.adjustContainerWidth(),e.detach(),d.empty(),d.append(e),a.isFunction(c)&&c.call(b.element,d,b.suggestions),b.fixPosition(),d.show(),b.visible=!0},adjustContainerWidth:function(){var b,c=this,d=c.options,e=a(c.suggestionsContainer);"auto"===d.width?(b=c.el.outerWidth(),e.css("width",b>0?b:300)):"flex"===d.width&&e.css("width","")},findBestHint:function(){var b=this,c=b.el.val().toLowerCase(),d=null;c&&(a.each(b.suggestions,function(a,b){var e=0===b.value.toLowerCase().indexOf(c);return e&&(d=b),!e}),b.signalHint(d))},signalHint:function(b){var c="",d=this;b&&(c=d.currentValue+b.value.substr(d.currentValue.length)),d.hintValue!==c&&(d.hintValue=c,d.hint=b,(this.options.onHint||a.noop)(c))},verifySuggestionsFormat:function(b){return b.length&&"string"==typeof b[0]?a.map(b,function(a){return{value:a,data:null}}):b},validateOrientation:function(b,c){return b=a.trim(b||"").toLowerCase(),a.inArray(b,["auto","bottom","top"])===-1&&(b=c),b},processResponse:function(a,b,c){var d=this,e=d.options;a.suggestions=d.verifySuggestionsFormat(a.suggestions),e.noCache||(d.cachedResponse[c]=a,e.preventBadQueries&&!a.suggestions.length&&d.badQueries.push(b)),b===d.getQuery(d.currentValue)&&(d.suggestions=a.suggestions,d.suggest())},activate:function(b){var c,d=this,e=d.classes.selected,f=a(d.suggestionsContainer),g=f.find("."+d.classes.suggestion);return f.find("."+e).removeClass(e),d.selectedIndex=b,d.selectedIndex!==-1&&g.length>d.selectedIndex?(c=g.get(d.selectedIndex),a(c).addClass(e),c):null},selectHint:function(){var b=this,c=a.inArray(b.hint,b.suggestions);b.select(c)},select:function(a){var b=this;b.hide(),b.onSelect(a)},moveUp:function(){var b=this;if(b.selectedIndex!==-1)return 0===b.selectedIndex?(a(b.suggestionsContainer).children("."+b.classes.suggestion).first().removeClass(b.classes.selected),b.selectedIndex=-1,b.ignoreValueChange=!1,b.el.val(b.currentValue),void b.findBestHint()):void b.adjustScroll(b.selectedIndex-1)},moveDown:function(){var a=this;a.selectedIndex!==a.suggestions.length-1&&a.adjustScroll(a.selectedIndex+1)},adjustScroll:function(b){var c=this,d=c.activate(b);if(d){var e,f,g,h=a(d).outerHeight();e=d.offsetTop,f=a(c.suggestionsContainer).scrollTop(),g=f+c.options.maxHeight-h,e<f?a(c.suggestionsContainer).scrollTop(e):e>g&&a(c.suggestionsContainer).scrollTop(e-c.options.maxHeight+h),c.options.preserveInput||(c.ignoreValueChange=!0,c.el.val(c.getValue(c.suggestions[b].value))),c.signalHint(null)}},onSelect:function(b){var c=this,d=c.options.onSelect,e=c.suggestions[b];c.currentValue=c.getValue(e.value),c.currentValue===c.el.val()||c.options.preserveInput||c.el.val(c.currentValue),c.signalHint(null),c.suggestions=[],c.selection=e,a.isFunction(d)&&d.call(c.element,e)},getValue:function(a){var b,c,d=this,e=d.options.delimiter;return e?(b=d.currentValue,c=b.split(e),1===c.length?a:b.substr(0,b.length-c[c.length-1].length)+a):a},dispose:function(){var b=this;b.el.off(".autocomplete").removeData("autocomplete"),a(window).off("resize.autocomplete",b.fixPositionCapture),a(b.suggestionsContainer).remove()}},a.fn.devbridgeAutocomplete=function(c,d){var e="autocomplete";return arguments.length?this.each(function(){var f=a(this),g=f.data(e);"string"==typeof c?g&&"function"==typeof g[c]&&g[c](d):(g&&g.dispose&&g.dispose(),g=new b(this,c),f.data(e,g))}):this.first().data(e)},a.fn.autocomplete||(a.fn.autocomplete=a.fn.devbridgeAutocomplete)});
/**
 * jQuery Flexdatalist.
 * Autocomplete input fields, with support for datalists.
 *
 * Version:
 * 2.2.4
 *
 * Depends:
 * jquery.js > 1.8.3
 *
 * Demo and Documentation:
 * http://projects.sergiodinislopes.pt/flexdatalist/
 *
 * Github:
 * https://github.com/sergiodlopes/jquery-flexdatalist/
 *
 */

jQuery.fn.flexdatalist = function (_option, _value) {
    'use strict';

    var destroy = function ($flex, clear) {
        $flex.each(function () {
            var $this = $(this),
                data = $this.data(),
                options = data.flexdatalist,
                $aliascontainer = data.aliascontainer;

            if ($aliascontainer) {
                $this.removeClass('flexdatalist-set')
                    .attr({'style': null, 'tabindex': null})
                    .val((options && options.originalValue && !clear ? options.originalValue : ''))
                    .removeData('flexdatalist')
                    .removeData('aliascontainer')
                    .off();
                $aliascontainer.remove();
            }
        });
    }

    // Callable stuff
    if (typeof _option === 'string' && _option !== 'reset') {
        if (typeof this[0].fvalue !== 'undefined') {
            var target = this[0];
            if (_option === 'destroy') {
                destroy(this, _value);
                // Get/Set value
            } else if (_option === 'value') {
                if (typeof _value === 'undefined') {
                    return target.fvalue.get();
                }
                target.fvalue.set(_value);
                // Add value
            } else if (_option === 'add') {
                if (typeof _value === 'undefined') {
                    return target.debug('Missing value to add!');
                }
                target.fvalue.add(_value);
                // Toggle value
            } else if (_option === 'toggle') {
                if (typeof _value === 'undefined') {
                    return target.debug('Missing value to toggle!');
                }
                target.fvalue.toggle(_value);
                // Remove value
            } else if (_option === 'remove') {
                if (typeof _value === 'undefined') {
                    return target.debug('Missing value to remove!');
                }
                target.fvalue.remove(_value);
                // Disabled/enabled
            } else if (_option === 'disabled') {
                if (typeof _value === 'undefined') {
                    return target.fdisabled();
                }
                target.fdisabled(_value);
                // Option(s)
            } else if (typeof _option === 'string') {
                if (typeof _value === 'undefined') {
                    return target.options.get(_option);
                }
                target.options.set(_option, _value);
            }
            return this;
        }
        _option = {_option: _value};
    }

    // Destroy if already set
    if (this.length > 0 && typeof this[0].fvalue !== 'undefined') {
        destroy(this);
    }

    var _options = $.extend({
        url: null,
        data: [],
        params: {},
        relatives: null,
        chainedRelatives: false,
        cache: true,
        cacheLifetime: 60,
        minLength: 2,
        groupBy: false,
        selectionRequired: false,
        focusFirstResult: false,
        textProperty: null,
        valueProperty: null,
        visibleProperties: [],
        iconProperty: 'thumb',
        searchIn: ['label'],
        searchContain: false,
        searchEqual: false,
        searchByWord: false,
        searchDisabled: false,
        searchDelay: 300,
        normalizeString: null,
        multiple: null,
        disabled: null,
        maxShownResults: 100,
        removeOnBackspace: true,
        noResultsText: 'No results found for "{keyword}"',
        toggleSelected: false,
        allowDuplicateValues: false,
        redoSearchOnFocus: true,
        requestType: 'get',
        requestContentType: 'x-www-form-urlencoded',
        resultsProperty: 'results',
        keywordParamName: 'keyword',
        limitOfValues: 0,
        valuesSeparator: ',',
        debug: true
    }, _option);

    return this.each(function (id) {
        var $this = $(this),
            _this = this,
            _searchTimeout = null,
            _selectedValues = [],
            fid = 'flex' + id,
            $alias = null,
            $multiple = null;

        /**
         * Initialization
         */
        this.init = function () {
            var options = this.options.init();
            this.set.up();

            $alias
            // Focusin
                .on('focusin', function (event) {
                    _this.action.redoSearchFocus(event);
                    _this.action.showAllResults(event);
                    if ($multiple) {
                        $multiple.addClass('focus');
                    }
                })
                // Keydown
                .on('input keydown', function (event) {
                    if (_this.keyNum(event) === 9) {
                        _this.results.remove();
                    }
                    _this.action.keypressValue(event, 188);
                    _this.action.backSpaceKeyRemove(event);
                })
                // Keyup
                .on('input keyup', function (event) {
                    _this.action.keypressValue(event, 13);
                    _this.action.keypressSearch(event);
                    _this.action.copyValue(event);
                    _this.action.backSpaceKeyRemove(event);
                    _this.action.showAllResults(event);
                    _this.action.clearValue(event);
                    _this.action.removeResults(event);
                    _this.action.inputWidth(event);
                })
                // Focusout
                .on('focusout', function (event) {
                    if ($multiple) {
                        $multiple.removeClass('focus');
                    }
                    _this.action.clearText(event);
                    _this.action.clearValue(event);
                });

            window.onresize = function (event) {
                _this.position();
            };

            // Run garbage collector
            this.cache.gc();

            if (options.selectionRequired) {
                _this.fvalue.clear(true, true);
            }
            this.fvalue._load(options.originalValue, function (values, matches) {
                _this.fdisabled(options.disabled);
                $this.trigger('init:flexdatalist', [options]);
            }, true);
        }

        /**
         * Handle user actions.
         */
        this.action = {
            /**
             * Add value on comma or enter keypress.
             */
            keypressValue: function (event, keyCode) {
                var key = _this.keyNum(event),
                    val = $alias[0].value,
                    options = _this.options.get();
                if (val.length > 0
                    && key === keyCode
                    && !options.selectionRequired
                    && options.multiple) {
                    var val = $alias[0].value;
                    event.preventDefault();
                    _this.fvalue.extract(val);
                    _this.results.remove();
                }
            },
            /**
             * Check if keypress is valid.
             */
            keypressSearch: function (event) {
                var key = _this.keyNum(event),
                    keyword = $alias.val(),
                    length = keyword.length,
                    options = _this.options.get();

                clearTimeout(_searchTimeout);
                if (!key || (key !== 13 && (key < 37 || key > 40))) {
                    _searchTimeout = setTimeout(function () {
                        if ((options.minLength === 0 && length > 0) || (options.minLength > 0 && length >= options.minLength)) {
                            _this.data.load(function (data) {
                                _this.search.get(keyword, data, function (matches) {
                                    _this.results.show(matches);
                                });
                            });
                        }
                    }, options.searchDelay);
                }
            },
            /**
             * Redo search if input get's back on focus and no value selected.
             */
            redoSearchFocus: function (event) {
                var val = _this.fvalue.get(),
                    options = _this.options.get(),
                    alias = $alias.val();
                if (options.redoSearchOnFocus && ((alias.length > 0 && options.multiple) || (alias.length > 0 && val.length === 0))) {
                    this.keypressSearch(event);
                }
            },
            /**
             * Copy value from alias to target input.
             */
            copyValue: function (event) {
                if (_this.keyNum(event) !== 13) {
                    var keyword = $alias.val(),
                        val = _this.fvalue.get(true),
                        options = _this.options.get();
                    if (!options.multiple && !options.selectionRequired && keyword.length !== val.length) {
                        _this.fvalue.extract(keyword);
                    }
                }
            },
            /**
             * Remove value on backspace key (multiple input only).
             */
            backSpaceKeyRemove: function (event) {
                var options = _this.options.get();
                if (options.removeOnBackspace && options.multiple) {
                    var val = $alias.val(),
                        $remove = $alias.data('_remove');
                    if (_this.keyNum(event) === 8) {
                        if (val.length === 0) {
                            if ($remove) {
                                _this.fvalue.remove($remove);
                                $alias.data('_remove', null);
                            } else {
                                console.log('remove!');
                                $alias.data('_remove', $alias.parents('li:eq(0)').prev());
                            }
                        } else {
                            $alias.data('_remove', null);
                        }
                    }
                }
            },
            /**
             * Show all results if minLength option is 0.
             */
            showAllResults: function (event) {
                var val = $alias.val();
                val = $.trim(val);
                if (val === '' && _this.options.get('minLength') === 0) {
                    _this.data.load(function (data) {
                        _this.results.show(data);
                    });
                }
            },
            /**
             * Calculate input width by number of characters.
             */
            inputWidth: function (event) {
                var options = _this.options.get();
                if (options.multiple) {
                    var keyword = $alias.val(),
                        fontSize = parseInt($alias.css('fontSize').replace('px', '')),
                        minWidth = 40,
                        maxWidth = $this.innerWidth(),
                        width = ((keyword.length + 1) * fontSize);

                    if (width >= minWidth && width <= maxWidth) {
                        $alias[0].style.width = width + 'px';
                    }
                }
            },
            /**
             * Clear text/alias input when criteria is met.
             */
            clearText: function (event) {
                var val = _this.fvalue.get(),
                    options = _this.options.get();

                if (!options.multiple && options.selectionRequired && val.length === 0) {
                    $alias[0].value = '';
                }
            },
            /**
             * Clear value when criteria is met.
             */
            clearValue: function (event) {
                var val = _this.fvalue.get(),
                    keyword = $alias.val(),
                    options = _this.options.get();

                if (!options.multiple && options.selectionRequired && keyword.length <= options.minLength) {
                    _this.fvalue.clear();
                }
            },
            /**
             * Remove results when criteria is met.
             */
            removeResults: function (event) {
                var val = _this.fvalue.get(),
                    keyword = $alias.val(),
                    options = _this.options.get();
                if (options.minLength > 0 && keyword.length < options.minLength) {
                    _this.results.remove();
                }
            }
        }

        /**
         * Setup flex.
         */
        this.set = {
            /**
             * Prepare input replacement.
             */
            up: function () {
                $alias = this.alias();
                if (_this.options.get('multiple')) {
                    $multiple = this.multipleInput($alias);
                } else {
                    $alias.insertAfter($this);
                }
                // Respect autofocus attribute
                if ($this.attr('autofocus')) {
                    $alias.focus();
                }

                $this.data('aliascontainer', ($multiple ? $multiple : $alias)).addClass('flexdatalist flexdatalist-set').css({
                    'position': 'absolute',
                    'top': -14000,
                    'left': -14000
                }).attr('tabindex', -1);

                // update input label with alias id
                var inputId = $this.attr('id'),
                    aliasId = $alias.attr('id');
                $('label[for="' + inputId + '"]').attr('for', aliasId);

                this.chained();
            },
            /**
             * Single value input.
             */
            alias: function () {
                var aliasid = ($this.attr('id') ? $this.attr('id') + '-flexdatalist' : fid);
                var $alias = $('<input type="text">')
                    .attr({
                        'class': $this.attr('class'),
                        'name': ($this.attr('name') ? 'flexdatalist-' + $this.attr('name') : null),
                        'id': aliasid,
                        'placeholder': $this.attr('placeholder')
                    })
                    .addClass('flexdatalist-alias ' + aliasid)
                    .removeClass('flexdatalist')
                    .attr('autocomplete', 'off');
                return $alias;
            },
            /**
             * Multiple values input/list
             */
            multipleInput: function ($alias) {
                $multiple = $('<ul tabindex="1">')
                    .addClass('flexdatalist-multiple ' + fid)
                    .css({
                        'border-color': $this.css('border-left-color'),
                        'border-width': $this.css('border-left-width'),
                        'border-style': $this.css('border-left-style'),
                        'border-radius': $this.css('border-top-left-radius'),
                        'background-color': $this.css('background-color')
                    })
                    .insertAfter($this).click(function () {
                        $(this).find('input').focus();
                    });
                $('<li class="input-container">')
                    .addClass('flexdatalist-multiple-value')
                    .append($alias)
                    .appendTo($multiple);

                return $multiple;
            },
            /**
             * Chained inputs handling.
             */
            chained: function () {
                var options = _this.options.get();
                if (options.relatives && options.chainedRelatives) {
                    var toggle = function (init) {
                        options.relatives.each(function () {
                            var emptyRelative = _this.isEmpty($(this).val()),
                                empty = _this.isEmpty(_this.value);
                            // If disabling, clear all values
                            if (emptyRelative || !empty) {
                                _this.fvalue.clear();
                            }
                            _this.fdisabled(emptyRelative);
                        });
                    };
                    options.relatives.on('change', function () {
                        toggle();
                    });
                    toggle(true);
                }
            }
        }

        /**
         * Process input value(s) (where the magic happens).
         */
        this.fvalue = {
            /**
             * Get value(s).
             */
            get: function (asString) {
                var val = _this.value,
                    options = _this.options.get();
                if ((options.multiple || this.isJSON()) && !asString) {
                    return this.toObj(val);
                }
                return val;
            },
            /**
             * Set value.
             * Parse value if necessary.
             */
            set: function (val, append) {
                if (!_this.fdisabled()) {
                    if (!append) {
                        this.clear(true);
                    }
                    this._load(val);
                }
                return $this;
            },
            /**
             * Add value.
             */
            add: function (val) {
                if (_this.options.get('multiple')) {
                    this.set(val, true);
                }
                return this;
            },
            /**
             * Toggle value.
             */
            toggle: function (val) {
                if (!_this.fdisabled()) {
                    this.multiple.toggle(val);
                }
                return this;
            },
            /**
             * Remove value.
             */
            remove: function (val) {
                if (!_this.fdisabled()) {
                    val = this.toObj(val);
                    $this.trigger('before:flexdatalist.remove', [val]);
                    var result = [];
                    if ($.isArray(val)) {
                        $.each(val, function (i, value) {
                            var removed = _this.fvalue.multiple.remove(value);
                            if (removed) {
                                result.push(removed);
                            }
                        });
                    } else {
                        var _result = this.multiple.remove(val);
                        if (_result) {
                            result.push(_result);
                        }
                    }
                    $this
                        .trigger('after:flexdatalist.remove', [val, result])
                        .trigger('change:flexdatalist', [result, _this.options.get()])
                        .trigger('change');
                }
                return this;
            },
            /**
             * Load (remote?) value(s).
             */
            _load: function (values, callback, init) {
                var options = _this.options.get(),
                    valueProp = options.valueProperty,
                    _values = this.toStr(values),
                    _val = this.get(true);

                callback = (callback ? callback : $.noop);

                // If nothing changes, return
                if (_values.length == 0 && _val.length == 0) {
                    callback(values);
                    return;
                }

                values = this.toObj(values);

                if (!_this.isEmpty(values) && !_this.isEmpty(valueProp) && valueProp !== '*') {
                    if (!_this.isObject(valueProp)) {
                        valueProp = valueProp.split(',');
                    }
                    // Load data
                    _this.data.load(function (data) {
                        if (!_this.isObject(values)) {
                            values = values.split(',');
                        } else if (!$.isArray(values)) {
                            values = [values];
                        }
                        var found = [];
                        for (var idxv = 0; idxv < values.length; idxv++) {
                            var value = values[idxv];
                            for (var i = 0; i < data.length; i++) {
                                var item = data[i];
                                for (var idx = 0; idx < valueProp.length; idx++) {
                                    var prop = valueProp[idx],
                                        value = _this.isDefined(value, prop) ? value[prop] : value;
                                    if (_this.isDefined(item, prop) && value === item[prop]) {
                                        found.push(item);
                                    }
                                }
                            }
                        }
                        if (found.length > 0) {
                            _this.fvalue.extract(found, true);
                        }
                        callback(values);
                    }, values);
                    return;
                }
                callback(values);
                _this.fvalue.extract(values, init);
            },
            /**
             * Extract value and text.
             */
            extract: function (values, init) {
                var options = _this.options.get(),
                    result = [];

                if (!init) {
                    $this.trigger('before:flexdatalist.value', [values, options]);
                }

                if ($.isArray(values)) {
                    $.each(values, function (i, value) {
                        result.push(_this.fvalue._extract(value));
                    });
                } else {
                    result = _this.fvalue._extract(values);
                }

                if (!init) {
                    $this
                        .trigger('after:flexdatalist.value', [result, options])
                        .trigger('change:flexdatalist', [result, options])
                        .trigger('change');
                }
            },
            /**
             * @inherited.
             */
            _extract: function (val) {
                var txt = this.text(val),
                    value = this.value(val),
                    current = _this.value,
                    options = _this.options.get();

                if (options.multiple) {
                    // For allowDuplicateValues
                    if (!_this.isEmpty(value)) {
                        if (_this.isDup(value)) {
                            return;
                        }

                        _selectedValues.push(value);
                        this.multiple.add(value, txt);
                    }
                } else {
                    this.single(value, txt);
                }
                return {value: value, text: txt};
            },
            /**
             * Default input value.
             */
            single: function (val, txt) {
                if (txt && txt !== $alias.val()) {
                    $alias[0].value = txt;
                }
                _this.value = val;
            },
            /**
             * Input with multiple values.
             */
            multiple: {
                /**
                 * Add value and item on list.
                 */
                add: function (val, txt) {
                    var _multiple = this,
                        $li = this.li(val, txt),
                        options = _this.options.get();

                    // Toggle
                    $li.click(function () {
                        _multiple.toggle($(this));
                        // Remove
                    }).find('.fdl-remove').click(function () {
                        _this.fvalue.remove($(this).parent());
                    });

                    this.push(val);
                    $alias[0].value = '';
                    this.checkLimit();
                },
                /**
                 * Push value to input.
                 */
                push: function (val, index) {
                    var current = _this.fvalue.get();
                    val = _this.fvalue.toObj(val);
                    current.push(val);
                    val = _this.fvalue.toStr(current);
                    _this.value = val;
                },
                /**
                 * Toggle value.
                 */
                toggle: function (val) {
                    var options = _this.options.get();
                    if (!options.toggleSelected) {
                        return;
                    }
                    var $li = this.findLi(val);
                    if ($li) {
                        var index = $li.index(),
                            data = $li.data(),
                            action = $li.hasClass('disabled') ? 'enable' : 'disable',
                            current = _this.fvalue.get(),
                            args = [{value: data.value, text: data.text, action: action}, options];

                        $this.trigger('before:flexdatalist.toggle', args);

                        if (action === 'enable') {
                            var value = $li.data('value');
                            current.splice(index, 0, value);
                            $li.removeClass('disabled');
                        } else {
                            current.splice(index, 1);
                            $li.addClass('disabled');
                        }

                        current = _this.fvalue.toStr(current);
                        _this.value = current;

                        $this
                            .trigger('after:flexdatalist.toggle', args)
                            .trigger('change:flexdatalist', args)
                            .trigger('change');
                    }
                },
                /**
                 * Remove value from input.
                 */
                remove: function (val) {
                    var $li = this.findLi(val);
                    if ($li) {
                        var values = _this.fvalue.get(),
                            index = $li.index(),
                            data = $li.data(),
                            options = _this.options.get(),
                            arg = {value: data.value, text: data.text};

                        values.splice(index, 1);
                        values = _this.fvalue.toStr(values);
                        _this.value = values;
                        $li.remove();
                        _this.fvalue.multiple.checkLimit();

                        // For allowDuplicateValues
                        _selectedValues.splice(index, 1);

                        return arg;
                    }
                },
                /**
                 * Remove all.
                 */
                removeAll: function () {
                    var values = _this.fvalue.get(),
                        options = _this.options.get();
                    $this.trigger('before:flexdatalist.remove.all', [values, options]);
                    $multiple.find('li:not(.input-container)').remove();
                    _this.value = '';
                    _selectedValues = [];
                    $this.trigger('after:flexdatalist.remove.all', [values, options]);
                },
                /**
                 * Create new item and return it.
                 */
                li: function (val, txt) {
                    var $inputContainer = $multiple.find('li.input-container')
                    return $('<li>')
                        .addClass('value' + (_this.options.get('toggleSelected') ? ' toggle' : ''))
                        .append('<span class="text">' + txt + '</span>')
                        .append('<span class="fdl-remove">&times;</span>')
                        .data({
                            'text': txt,
                            'value': _this.fvalue.toObj(val)
                        })
                        .insertBefore($inputContainer);
                },
                /**
                 * Create new item and return it.
                 */
                checkLimit: function () {
                    var limit = _this.options.get('limitOfValues');
                    if (limit > 0) {
                        var $input = $multiple.find('li.input-container'),
                            count = _selectedValues.length;
                        (limit == count ? $input.hide() : $input.show());
                    }
                },
                /**
                 * Get li item from value.
                 */
                findLi: function ($li) {
                    if (!($li instanceof jQuery)) {
                        var val = $li;
                        $li = null;
                        $multiple.find('li:not(.input-container)').each(function () {
                            var $_li = $(this);
                            if ($_li.data('value') === val) {
                                $li = $_li;
                                return false;
                            }
                        });
                    } else if ($li.length === 0) {
                        $li = null;
                    }
                    return $li;
                },
                /**
                 * Get li item from value.
                 */
                isEmpty: function () {
                    return this.get().length > 0;
                }
            },
            /**
             * Get value that will be set on input field.
             */
            value: function (item) {
                var value = item,
                    options = _this.options.get(),
                    valueProperty = options.valueProperty;

                if (_this.isObject(item)) {
                    if (this.isJSON() || this.isMixed()) {
                        delete item.name_highlight;
                        if ($.isArray(valueProperty)) {
                            var _value = {};
                            for (var i = 0; i < valueProperty.length; i++) {
                                if (_this.isDefined(item, valueProperty[i])) {
                                    _value[valueProperty[i]] = item[valueProperty[i]];
                                }
                            }
                            value = this.toStr(_value);
                        } else {
                            value = this.toStr(item);
                        }
                    } else if (_this.isDefined(item, valueProperty)) {
                        value = item[valueProperty];
                    } else if (_this.isDefined(item, options.searchIn[0])) {
                        value = item[options.searchIn[0]];
                    } else {
                        value = null;
                    }

                }
                return value;
            },
            /**
             * Get text that will be shown to user on the alias input field.
             */
            text: function (item) {
                var text = item,
                    options = _this.options.get();
                if (_this.isObject(item)) {
                    text = item[options.searchIn[0]];
                    if (_this.isDefined(item, options.textProperty)) {
                        text = item[options.textProperty];
                    } else {
                        text = this.placeholders.replace(item, options.textProperty, text);
                    }
                }
                return $('<div>').html(text).text();
            },
            /**
             * Text placeholders processing.
             */
            placeholders: {
                replace: function (item, pattern, fallback) {
                    if (_this.isObject(item) && typeof pattern === 'string') {
                        var properties = this.parse(pattern);
                        if (!_this.isEmpty(item) && properties) {
                            $.each(properties, function (string, property) {
                                if (_this.isDefined(item, property)) {
                                    pattern = pattern.replace(string, item[property]);
                                }
                            });
                            return pattern;
                        }
                    }
                    return fallback;
                },
                parse: function (pattern) {
                    var matches = pattern.match(/\{.+?\}/g);
                    if (matches) {
                        var properties = {};
                        matches.map(function (string) {
                            properties[string] = string.slice(1, -1);
                        });
                        return properties;
                    }
                    return false;
                }
            },
            /**
             * Clear input value(s).
             */
            clear: function (alias, init) {
                var current = _this.value,
                    options = _this.options.get();

                if (options.multiple) {
                    this.multiple.removeAll();
                }
                _this.value = '';
                if (current !== '' && !init) {
                    $this.trigger('change:flexdatalist', [{value: '', text: ''}, options]).trigger('change');
                }
                if (alias) {
                    $alias[0].value = '';
                }
                _selectedValues = [];
                return this;
            },
            /**
             * Value to object.
             */
            toObj: function (val) {
                if (typeof val !== 'object') {
                    var options = _this.options.get();
                    if (_this.isEmpty(val) || !_this.isDefined(val)) {
                        val = options.multiple ? [] : (this.isJSON() ? {} : '');
                    } else if (this.isCSV()) {
                        val = val.toString().split(options.valuesSeparator);
                        val = $.map(val, function (v) {
                            return $.trim(v);
                        });
                    } else if ((this.isMixed() || this.isJSON()) && this.isJSON(val)) {
                        val = JSON.parse(val);
                    } else if (typeof val === 'number') {
                        val = val.toString();
                    }
                }
                return val;
            },
            /**
             * Is value expected to be JSON (either object or string).
             */
            toStr: function (val) {
                if (typeof val !== 'string') {
                    if (_this.isEmpty(val) || !_this.isDefined(val)) {
                        val = '';
                    } else if (typeof val === 'number') {
                        val = val.toString();
                    } else if (this.isCSV()) {
                        val = val.join(_this.options.get('valuesSeparator'));
                    } else if (this.isJSON() || this.isMixed()) {
                        val = JSON.stringify(val);
                    }
                }
                return $.trim(val);
            },
            /**
             * If argument is passed, will check if is a valid JSON object/string.
             * otherwise will check if JSON is the value expected for input
             */
            isJSON: function (str) {
                if (typeof str !== 'undefined') {
                    if (_this.isObject(str)) {
                        str = JSON.stringify(str);
                    } else if (typeof str !== 'string') {
                        return false;
                    }
                    return (str.indexOf('{') === 0 || str.indexOf('[{') === 0);
                }
                var options = _this.options.get(),
                    prop = options.valueProperty;
                return (_this.isObject(prop) || prop === '*');
            },
            /**
             * Is value expected to be JSON (either object or string).
             */
            isMixed: function () {
                var options = _this.options.get();
                return !options.selectionRequired && options.valueProperty === '*';
            },
            /**
             * Is value expected to be CSV?
             */
            isCSV: function () {
                return (!this.isJSON() && _this.options.get('multiple'));
            }
        }

        /**
         * Data.
         */
        this.data = {
            /**
             * Load data from all sources.
             */
            load: function (callback, load) {
                var __this = this,
                    data = [];
                $this.trigger('before:flexdatalist.data');
                // Remote data
                this.url(function (remote) {
                    data = data.concat(remote);
                    // Static data
                    __this.static(function (_static) {
                        data = data.concat(_static);
                        // Datalist
                        __this.datalist(function (list) {
                            data = data.concat(list);

                            $this.trigger('after:flexdatalist.data', [data]);
                            callback(data);
                        });
                    });
                }, load);
            },
            /**
             * Get static data.
             */
            static: function (callback) {
                var __this = this,
                    options = _this.options.get();
                // Remote source
                if (typeof options.data === 'string') {
                    var url = options.data,
                        cache = _this.cache.read(url, true);
                    if (cache) {
                        callback(cache);
                        return;
                    }
                    this.remote({
                        url: url,
                        success: function (data) {
                            options.data = data;
                            callback(data);
                            _this.cache.write(url, data, options.cacheLifetime, true);
                        }
                    });
                } else {
                    if (typeof options.data !== 'object') {
                        options.data = [];
                    }
                    callback(options.data);
                }
            },
            /**
             * Get datalist values.
             */
            datalist: function (callback) {
                var list = $this.attr('list'),
                    datalist = [];
                if (!_this.isEmpty(list)) {
                    $('#' + list).find('option').each(function () {
                        var $option = $(this),
                            val = $option.val(),
                            label = $option.text();
                        datalist.push({
                            label: (label.length > 0 ? label : val),
                            value: val
                        });
                    });
                }
                callback(datalist);
            },
            /**
             * Get remote data.
             */
            url: function (callback, load) {
                var __this = this,
                    keyword = $alias.val(),
                    options = _this.options.get(),
                    keywordParamName = options.keywordParamName,
                    value = _this.fvalue.get(),
                    relatives = this.relativesData();

                if (_this.isEmpty(options.url)) {
                    return callback([]);
                }

                var _opts = {};
                if (options.requestType === 'post') {
                    $.each(options, function (option, value) {
                        if (option.indexOf('_') == 0 || option == 'data') {
                            return;
                        }
                        _opts[option] = value;
                    });
                    delete _opts.relatives;
                }

                // Cache
                var cacheKey = _this.cache.keyGen({
                        relative: relatives,
                        load: load,
                        keyword: keyword,
                        contain: options.searchContain
                    }, options.url),
                    cache = _this.cache.read(cacheKey, true);
                if (cache) {
                    callback(cache);
                    return;
                }

                var data = $.extend(
                    relatives,
                    options.params,
                    {
                        load: load,
                        contain: options.searchContain,
                        selected: value,
                        original: options.originalValue,
                        options: _opts
                    }
                );
                data[keywordParamName] = keyword;

                this.remote({
                    url: options.url,
                    data: data,
                    success: function (_data) {
                        var _keyword = $alias.val();
                        // Is this really needed?
                        if (_keyword.length >= keyword.length) {
                            callback(_data);
                        }
                        _this.cache.write(cacheKey, _data, options.cacheLifetime, true);
                    }
                });
            },
            /**
             * AJAX request.
             */
            remote: function (settings) {
                var __this = this,
                    options = _this.options.get();
                // Prevent get data when pressing backspace button
                if ($this.hasClass('flexdatalist-loading')) {
                    return;
                }
                $this.addClass('flexdatalist-loading');
                if (options.requestContentType === 'json') {
                    settings.data = JSON.stringify(settings.data);
                }
                $.ajax($.extend(
                    {
                        type: options.requestType,
                        dataType: 'json',
                        contentType: 'application/' + options.requestContentType + '; charset=UTF-8',
                        complete: function () {
                            $this.removeClass('flexdatalist-loading');
                        }
                    }, settings, {
                        success: function (data) {
                            data = __this.extractRemoteData(data);
                            settings.success(data);
                        }
                    }
                ));
            },
            /**
             * Extract remote data from server response.
             */
            extractRemoteData: function (data) {
                var options = _this.options.get(),
                    _data = _this.isDefined(data, options.resultsProperty) ? data[options.resultsProperty] : data;

                if (typeof _data === 'string' && _data.indexOf('[{') === 0) {
                    _data = JSON.parse(_data);
                }
                if (_data && _data.options) {
                    _this.options.set($.extend({}, options, _data.options));
                }
                if (_this.isObject(_data)) {
                    return _data;
                }
                return [];
            },
            /**
             * Extract remote data from server response.
             */
            relativesData: function () {
                var relatives = _this.options.get('relatives'),
                    data = {};
                if (relatives) {
                    data['relatives'] = {};
                    relatives.each(function () {
                        var $_input = $(this),
                            name = $_input.attr('name')
                                .split('][').join('-')
                                .split(']').join('-')
                                .split('[').join('-')
                                .replace(/^\|+|\-+$/g, '');
                        data['relatives'][name] = $_input.val();
                    });
                }
                return data;
            }
        }

        /**
         * Search.
         */
        this.search = {
            /**
             * Search for keywords in data and return matches to given callback.
             */
            get: function (keywords, data, callback) {
                var __this = this,
                    options = _this.options.get();

                if (!options.searchDisabled) {
                    var matches = _this.cache.read(keywords);
                    if (!matches) {
                        $this.trigger('before:flexdatalist.search', [keywords, data]);
                        if (!_this.isEmpty(keywords)) {
                            matches = [];
                            var words = __this.split(keywords);
                            for (var index = 0; index < data.length; index++) {
                                var item = data[index];
                                if (_this.isDup(item)) {
                                    continue;
                                }
                                item = __this.matches(item, words);
                                if (item) {
                                    matches.push(item);
                                }
                            }
                        }
                        _this.cache.write(keywords, matches, 2);
                        $this.trigger('after:flexdatalist.search', [keywords, data, matches]);
                    }
                } else {
                    matches = data;
                }
                callback(matches);
            },
            /**
             * Match against searchable properties.
             */
            matches: function (item, keywords) {
                var hasMatches = false,
                    _item = $.extend({}, item),
                    found = [],
                    options = _this.options.get(),
                    searchIn = options.searchIn;

                if (keywords.length > 0) {
                    for (var index = 0; index < searchIn.length; index++) {
                        var searchProperty = searchIn[index];
                        if (!_this.isDefined(item, searchProperty) || !item[searchProperty]) {
                            continue;
                        }
                        var text = item[searchProperty].toString(),
                            highlight = text,
                            strings = this.split(text);
                        for (var kwindex = 0; kwindex < keywords.length; kwindex++) {
                            var keyword = keywords[kwindex];
                            if (this.find(keyword, strings)) {
                                found.push(keyword);
                                highlight = this.highlight(keyword, highlight);
                            }
                        }
                        if (highlight !== text) {
                            _item[searchProperty + '_highlight'] = this.highlight(highlight);
                        }
                    }
                }
                if (found.length === 0 || (options.searchByWord && found.length < (keywords.length - 1))) {
                    return false;
                }
                return _item;
            },
            /**
             * Wrap found keyword with span.highlight.
             */
            highlight: function (keyword, text) {
                if (text) {
                    return text.replace(
                        new RegExp(keyword, (_this.options.get('searchContain') ? "ig" : "i")),
                        '|:|$&|::|'
                    );
                }
                keyword = keyword.split('|:|').join('<span class="highlight">');
                return keyword.split('|::|').join('</span>');
            },
            /**
             * Search for keyword(s) in string.
             */
            find: function (keyword, splitted) {
                var options = _this.options.get();
                for (var index = 0; index < splitted.length; index++) {
                    var text = splitted[index];
                    text = this.normalizeString(text),
                        keyword = this.normalizeString(keyword);
                    if (options.searchEqual) {
                        return text == keyword;
                    }
                    if ((options.searchContain ? (text.indexOf(keyword) >= 0) : (text.indexOf(keyword) === 0))) {
                        return true;
                    }
                }
                return false;
            },
            /**
             * Split string by words if needed.
             */
            split: function (keywords) {
                if (typeof keywords === 'string') {
                    keywords = [$.trim(keywords)];
                }
                if (_this.options.get('searchByWord')) {
                    for (var index = 0; index < keywords.length; index++) {
                        var keyword = $.trim(keywords[index]);
                        if (keyword.indexOf(' ') > 0) {
                            var words = keyword.split(' ');
                            $.merge(keywords, words);
                        }
                    }
                }
                return keywords;
            },
            /**
             * Normalize string to a consistent one to perform the search/match.
             */
            normalizeString: function (string) {
                if (typeof string === 'string') {
                    var normalizeString = _this.options.get('normalizeString');
                    if (typeof normalizeString === 'function') {
                        string = normalizeString(string);
                    }
                    return string.toUpperCase();
                }
                return string;
            }
        }

        /**
         * Handle results.
         */
        this.results = {
            /**
             * Save key = value data in local storage (if supported)
             *
             * @param string key Data key string
             */
            show: function (results) {
                var __this = this,
                    options = _this.options.get();

                this.remove(true);

                if (!results) {
                    return;
                } else if(results.length === 0) {
                    this.empty(options.noResultsText);
                    return;
                }

                var $ul = this.container();
                if (!options.groupBy) {
                    this.items(results, $ul);
                } else {
                    results = this.group(results);
                    Object.keys(results).forEach(function (groupName, index) {
                        var items = results[groupName],
                            property = options.groupBy,
                            groupText = _this.results.highlight(items[0], property, groupName);

                        var $li = $('<li>')
                            .addClass('group')
                            .append($('<span>')
                                .addClass('group-name')
                                .html(groupText)
                            )
                            .append($('<span>')
                                .addClass('group-item-count')
                                .text(' ' + items.length)
                            )
                            .appendTo($ul);

                        __this.items(items, $ul);
                    });
                }

                var $li = $ul.find('li:not(.group)');
                $li.on('click', function (event) {
                    var item = $(this).data('item');
                    if (item) {
                        _this.fvalue.extract(item);
                        __this.remove();
                        $this.trigger('select:flexdatalist', [item, options]);
                    }
                }).hover(function () {
                    $li.removeClass('active');
                    $(this).addClass('active').trigger('active:flexdatalist.results', [$(this).data('item')]);
                }, function () {
                    $(this).removeClass('active');
                });

                if (options.focusFirstResult) {
                    $li.filter(':first').addClass('active');
                }
            },
            /**
             * Remove results container.
             */
            empty: function (text) {
                if (_this.isEmpty(text)) {
                    return;
                }
                var $container = this.container(),
                    keyword = $alias.val();

                text = text.split('{keyword}').join(keyword);
                $('<li>')
                    .addClass('item no-results')
                    .append(text)
                    .appendTo($container)
            },
            /**
             * Items iteration.
             */
            items: function (items, $resultsContainer) {
                var max = _this.options.get('maxShownResults');
                $this.trigger('show:flexdatalist.results', [items]);
                for (var index = 0; index < items.length; index++) {
                    if (max > 0 && max === index) {
                        break;
                    }
                    this.item(items[index]).appendTo($resultsContainer);
                }
                $this.trigger('shown:flexdatalist.results', [items]);
            },
            /**
             * Result item creation.
             */
            item: function (item) {
                var $li = $('<li>').data('item', item).addClass('item'),
                    options = _this.options.get(),
                    visibleProperties = options.visibleProperties;

                for (var index = 0; index < visibleProperties.length; index++) {
                    var visibleProperty = visibleProperties[index];

                    if (visibleProperty.indexOf('{') > -1) {
                        var str = _this.fvalue.placeholders.replace(item, visibleProperty),
                            parsed = _this.fvalue.placeholders.parse(visibleProperty);
                        $item = $('<span>')
                            .addClass('item item-' + Object.values(parsed).join('-'))
                            .html(str + ' ').appendTo($li);
                    } else {
                        if (options.groupBy && options.groupBy === visibleProperty || !_this.isDefined(item, visibleProperty)) {
                            continue;
                        }
                        var $item = {};
                        if (visibleProperty === options.iconProperty) {
                            // Icon
                            $item = $('<img>')
                                .addClass('item item-' + visibleProperty)
                                .attr('src', item[visibleProperty]);
                        } else {
                            var propertyText = _this.results.highlight(item, visibleProperty);
                            // Other text properties
                            $item = $('<span>')
                                .addClass('item item-' + visibleProperty)
                                .html(propertyText + ' ');
                        }
                    }

                    $item.appendTo($li);
                }
                return $li;
            },
            /**
             * Results container
             */
            container: function () {
                var $target = $this;
                if ($multiple) {
                    $target = $multiple;
                }
                var $container = $('ul.flexdatalist-results');
                if ($container.length === 0) {
                    $container = $('<ul>')
                        .addClass('flexdatalist-results ')
                        .appendTo('body')
                        .attr('id', $alias.attr('id') + '-results')
                        .css({
                            'border-color': $target.css("border-left-color"),
                            'border-width': '1px',
                            'border-bottom-left-radius': $target.css("border-bottom-left-radius"),
                            'border-bottom-right-radius': $target.css("border-bottom-right-radius")
                        }).data({
                            target: ($multiple ? $multiple : $alias),
                            input: $this
                        });
                    _this.position($alias);
                }
                return $container;
            },
            /**
             * Results container
             */
            group: function (results) {
                var data = [],
                    groupProperty = _this.options.get('groupBy');
                for (var index = 0; index < results.length; index++) {
                    var _data = results[index];
                    if (_this.isDefined(_data, groupProperty)) {
                        var propertyValue = _data[groupProperty];
                        if (!_this.isDefined(data, propertyValue)) {
                            data[propertyValue] = [];
                        }
                        data[propertyValue].push(_data);
                    }
                }
                return data;
            },
            /**
             * Check if highlighted property value exists,
             * if true, return it, if not, fallback to given string
             */
            highlight: function (item, property, fallback) {
                if (_this.isDefined(item, property + '_highlight')) {
                    return item[property + '_highlight'];
                }
                return (_this.isDefined(item, property) ? item[property] : fallback);
            },
            /**
             * Remove results
             */
            remove: function (itemsOnly) {
                var selector = 'ul.flexdatalist-results';
                if (itemsOnly) {
                    selector = 'ul.flexdatalist-results li';
                }
                $this.trigger('remove:flexdatalist.results');
                $(selector).remove();
                $this.trigger('removed:flexdatalist.results');
            }
        }

        /**
         * Interface for localStorage.
         */
        this.cache = {
            /**
             * Save key = value data in local storage (if supported)
             *
             * @param string key Data key string
             * @param mixed value Value to be saved
             * @param int lifetime In Seconds
             * @return mixed
             */
            write: function (key, value, lifetime, global) {
                if (_this.cache.isSupported()) {
                    key = this.keyGen(key, undefined, global);
                    var object = {
                        value: value,
                        // Get current UNIX timestamp
                        timestamp: _this.unixtime(),
                        lifetime: (lifetime ? lifetime : false)
                    };
                    localStorage.setItem(key, JSON.stringify(object));
                }
            },
            /**
             * Read data associated with given key
             *
             * @param string key Data key string
             * @return mixed
             */
            read: function (key, global) {
                if (_this.cache.isSupported()) {
                    key = this.keyGen(key, undefined, global);
                    var data = localStorage.getItem(key);
                    if (data) {
                        var object = JSON.parse(data);
                        if (!this.expired(object)) {
                            return object.value;
                        }
                        localStorage.removeItem(key);
                    }
                }
                return null;
            },
            /**
             * Remove data associated with given key.
             *
             * @param string key Data key string
             */
            delete: function (key, global) {
                if (_this.cache.isSupported()) {
                    key = this.keyGen(key, undefined, global);
                    localStorage.removeItem(key);
                }
            },
            /**
             * Clear all data.
             */
            clear: function () {
                if (_this.cache.isSupported()) {
                    for (var key in localStorage){
                        if (key.indexOf(fid) > -1 || key.indexOf('global') > -1) {
                            localStorage.removeItem(key);
                        }
                    }
                    localStorage.clear();
                }
            },
            /**
             * Run cache garbage collector to prevent using all localStorage's
             * available space.
             */
            gc: function () {
                if (_this.cache.isSupported()) {
                    for (var key in localStorage){
                        if (key.indexOf(fid) > -1 || key.indexOf('global') > -1) {
                            var data = localStorage.getItem(key);
                            data = JSON.parse(data);
                            if (this.expired(data)) {
                                localStorage.removeItem(key);
                            }
                        }
                    }
                }
            },
            /**
             * Check if browser supports localtorage.
             *
             * @return boolean True if supports, false otherwise
             */
            isSupported: function () {
                if (_this.options.get('cache')) {
                    try {
                        return 'localStorage' in window && window['localStorage'] !== null;
                    } catch (e) {
                        return false;
                    }
                }
                return false;
            },
            /**
             * Check if cache data as expired.
             *
             * @param object object Data to check
             * @return boolean True if expired, false otherwise
             */
            expired: function (object) {
                if (object.lifetime) {
                    var diff = (_this.unixtime() - object.timestamp);
                    return object.lifetime <= diff;
                }
                return false;
            },
            /**
             * Generate cache key from object or string.
             *
             * @return string Cache key
             */
            keyGen: function (str, seed, global) {
                if (typeof str === 'object') {
                    str = JSON.stringify(str);
                }
                var i, l,
                    hval = (seed === undefined) ? 0x811c9dc5 : seed;

                for (i = 0, l = str.length; i < l; i++) {
                    hval ^= str.charCodeAt(i);
                    hval += (hval << 1) + (hval << 4) + (hval << 7) + (hval << 8) + (hval << 24);
                }
                return (global ? 'global' : fid) + ("0000000" + (hval >>> 0).toString(16)).substr(-8);
            }
        }

        /**
         * Options handler.
         */
        this.options = {
            init: function () {
                var options = $.extend({},
                    _options,
                    $this.data(),
                    {
                        multiple: (_options.multiple === null ? $this.is('[multiple]') : _options.multiple),
                        disabled: (_options.disabled === null ? $this.is('[disabled]') : _options.disabled),
                        originalValue: _this.value
                    }
                );
                this.set(options);
                return options;
            },
            get: function (option) {
                var options = $this.data('flexdatalist');
                if (!option) {
                    return options ? options : {};
                }
                return _this.isDefined(options, option) ? options[option] : null;
            },
            set: function (option, value) {
                var options = this.get();
                if (_this.isDefined(options, option) && _this.isDefined(value)) {
                    options[option] = value;
                } else if (_this.isObject(option)) {
                    options = this._normalize(option);
                }
                $this.data('flexdatalist', options);
                return $this;
            },
            _normalize: function (options) {
                options.searchIn = _this.csvToArray(options.searchIn);
                options.relatives = options.relatives && $(options.relatives).length > 0 ? $(options.relatives) : null;
                options.textProperty = options.textProperty === null ? options.searchIn[0] : options.textProperty;
                options.visibleProperties = _this.csvToArray(options.visibleProperties, options.searchIn);
                if (options.valueProperty === '*' && options.multiple && !options.selectionRequired) {
                    throw new Error('Selection must be required for multiple, JSON fields!');
                }
                return options;
            }
        }

        /**
         * Position results below parent element.
         */
        this.position = function () {
            var $results = $('ul.flexdatalist-results'),
                $target = $results.data('target');
            if ($results.length > 0) {
                // Set some required CSS properties
                $results.css({
                    'width': $target.outerWidth() + 'px',
                    'top': (($target.offset().top + $target.outerHeight())) + 'px',
                    'left': $target.offset().left + 'px'
                });
            }
        }

        /**
         * Handle disabled state.
         */
        this.fdisabled = function (disabled) {
            if (this.isDefined(disabled)) {
                $this.prop('disabled', disabled);
                $alias.prop('disabled', disabled);
                if ($multiple) {
                    $multiple.css('background-color', $this.css('background-color'));
                    var $btns = $multiple.find('li .fdl-remove'),
                        $input = $multiple.find('li.input-container');
                    if (disabled) {
                        $multiple.addClass('disabled');
                        if ($btns.length > 0) {
                            $input.hide();
                        }
                        $btns.hide();
                    } else {
                        $multiple.removeClass('disabled');
                        $input.show();
                        $btns.show();
                    }
                }
                this.options.set('disabled', disabled);
            }
            return this.options.get('disabled');
        }

        /**
         * Check for dup values.
         */
        this.isDup = function (val) {
            if (!this.options.get('allowDuplicateValues')) {
                return _selectedValues.length > 0 && _selectedValues.indexOf(this.fvalue.value(val)) > -1;
            }
            return false;
        }

        /**
         * Get key code from event.
         */
        this.keyNum = function (event) {
            return event.which || event.keyCode;
        }

        /**
         * Is variable empty.
         */
        this.isEmpty = function (value) {
            if (!_this.isDefined(value)) {
                return true;
            } else if (value === null) {
                return true;
            } else if (value === true) {
                return false;
            } else if (this.length(value) === 0) {
                return true;
            } else if ($.trim(value) === '') {
                return true;
            }
            return false;
        }

        /**
         * Is variable an object.
         */
        this.isObject = function (value) {
            return (value && typeof value === 'object');
        }

        /**
         * Get length of variable.
         */
        this.length = function (value) {
            if (this.isObject(value)) {
                return Object.keys(value).length;
            } else if (typeof value === 'number' || typeof value.length === 'number') {
                return value.toString().length;
            }
            return 0;
        }

        /**
         * Check if variable (and optionally property) is defined.
         */
        this.isDefined = function (variable, property) {
            var _variable = (typeof variable !== 'undefined');
            if (_variable && typeof property !== 'undefined') {
                return (typeof variable[property] !== 'undefined');
            }
            return _variable;
        }

        /**
         * Get unixtime stamp.
         *
         * @return boolean True if supports, false otherwise
         */
        this.unixtime = function (time) {
            var date = new Date();
            if (time) {
                date = new Date(time);
            }
            return Math.round(date.getTime() / 1000);
        }

        /**
         * To array.
         */
        this.csvToArray = function (value, _default) {
            if (value.length === 0) {
                return _default;
            }
            return typeof value === 'string' ? value.split(_this.options.get('valuesSeparator')) : value;
        }

        /**
         * Plugin warnings for debug.
         */
        this.debug = function (msg, data) {
            var options = _this.options.get();
            if (!options.debug) {
                return;
            }
            if (!data) {
                data = {};
            }
            msg = 'Flexdatalist: ' + msg;
            console.warn(msg);
            console.log($.extend({
                inputName: $this.attr('name'),
                options: options
            }, data));
            console.log('--- /flexdatalist ---');
        }

        // Go!
        this.init();
    });
}

jQuery(function ($) {
    var $document = $(document);
    // Handle results selection list keyboard shortcuts and events.
    if (!$document.data('flexdatalist')) {
        // Remove results on outside click
        $(document).mouseup(function (event) {
            var $container = $('.flexdatalist-results'),
                $target = $container.data('target');
            if ((!$target || !$target.is(':focus')) && !$container.is(event.target) && $container.has(event.target).length === 0) {
                $container.remove();
            }
            // Keyboard navigation
        }).keydown(function (event) {
            var $ul = $('.flexdatalist-results'),
                $li = $ul.find('li'),
                $active = $li.filter('.active'),
                index = $active.index(),
                length = $li.length,
                keynum = event.which || event.keyCode;

            if (length === 0) {
                return;
            }

            // on escape key, remove results
            if (keynum === 27) {
                $ul.remove();
                return;
            }

            // Enter/tab key
            if (keynum === 13) {
                event.preventDefault();
                $active.click();
                // Up/Down key
            } else if (keynum === 40 || keynum === 38) {
                event.preventDefault();
                // Down key
                if (keynum === 40) {
                    if (index < length && $active.nextAll('.item').first().length > 0) {
                        $active = $active.removeClass('active').nextAll('.item').first().addClass('active');
                    } else {
                        $active = $li.removeClass('active').filter('.item:first').addClass('active');
                    }
                    // Up key
                } else if (keynum === 38) {
                    if (index > 0 && $active.prevAll('.item').first().length > 0) {
                        $active = $active.removeClass('active').prevAll('.item').first().addClass('active');
                    } else {
                        $active = $li.removeClass('active').filter('.item:last').addClass('active');
                    }
                }

                $active.trigger('active:flexdatalist.results', [$active.data('item')]);

                // Scroll to
                var position = ($active.prev().length === 0 ? $active : $active.prev()).position().top;
                $ul.animate({
                    scrollTop: position + $ul.scrollTop()
                }, 100);
            }
        }).data('flexdatalist', true);
    }

    jQuery('input.flexdatalist:not(.flexdatalist-set):not(.autodiscover-disabled)').flexdatalist();
});

(function ($) {
    var jVal = $.fn.val;
    $.fn.val = function (value) {
        var isFlex = this.length > 0 && typeof this[0].fvalue !== 'undefined';
        if (typeof value === 'undefined') {
            return isFlex ? this[0].fvalue.get(true) : jVal.call(this);
        }
        return isFlex ? this[0].fvalue.set(value) : jVal.call(this, value);
    };
})(jQuery);
/*
 * jquery-match-height 0.7.2 by @liabru
 * http://brm.io/jquery-match-height/
 * License MIT
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):"undefined"!=typeof module&&module.exports?module.exports=t(require("jquery")):t(jQuery)}(function(t){var e=-1,o=-1,n=function(t){return parseFloat(t)||0},a=function(e){var o=1,a=t(e),i=null,r=[];return a.each(function(){var e=t(this),a=e.offset().top-n(e.css("margin-top")),s=r.length>0?r[r.length-1]:null;null===s?r.push(e):Math.floor(Math.abs(i-a))<=o?r[r.length-1]=s.add(e):r.push(e),i=a}),r},i=function(e){var o={
    byRow:!0,property:"height",target:null,remove:!1};return"object"==typeof e?t.extend(o,e):("boolean"==typeof e?o.byRow=e:"remove"===e&&(o.remove=!0),o)},r=t.fn.matchHeight=function(e){var o=i(e);if(o.remove){var n=this;return this.css(o.property,""),t.each(r._groups,function(t,e){e.elements=e.elements.not(n)}),this}return this.length<=1&&!o.target?this:(r._groups.push({elements:this,options:o}),r._apply(this,o),this)};r.version="0.7.2",r._groups=[],r._throttle=80,r._maintainScroll=!1,r._beforeUpdate=null,
    r._afterUpdate=null,r._rows=a,r._parse=n,r._parseOptions=i,r._apply=function(e,o){var s=i(o),h=t(e),l=[h],c=t(window).scrollTop(),p=t("html").outerHeight(!0),u=h.parents().filter(":hidden");return u.each(function(){var e=t(this);e.data("style-cache",e.attr("style"))}),u.css("display","block"),s.byRow&&!s.target&&(h.each(function(){var e=t(this),o=e.css("display");"inline-block"!==o&&"flex"!==o&&"inline-flex"!==o&&(o="block"),e.data("style-cache",e.attr("style")),e.css({display:o,"padding-top":"0",
    "padding-bottom":"0","margin-top":"0","margin-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px",overflow:"hidden"})}),l=a(h),h.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||"")})),t.each(l,function(e,o){var a=t(o),i=0;if(s.target)i=s.target.outerHeight(!1);else{if(s.byRow&&a.length<=1)return void a.css(s.property,"");a.each(function(){var e=t(this),o=e.attr("style"),n=e.css("display");"inline-block"!==n&&"flex"!==n&&"inline-flex"!==n&&(n="block");var a={
    display:n};a[s.property]="",e.css(a),e.outerHeight(!1)>i&&(i=e.outerHeight(!1)),o?e.attr("style",o):e.css("display","")})}a.each(function(){var e=t(this),o=0;s.target&&e.is(s.target)||("border-box"!==e.css("box-sizing")&&(o+=n(e.css("border-top-width"))+n(e.css("border-bottom-width")),o+=n(e.css("padding-top"))+n(e.css("padding-bottom"))),e.css(s.property,i-o+"px"))})}),u.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||null)}),r._maintainScroll&&t(window).scrollTop(c/p*t("html").outerHeight(!0)),
    this},r._applyDataApi=function(){var e={};t("[data-match-height], [data-mh]").each(function(){var o=t(this),n=o.attr("data-mh")||o.attr("data-match-height");n in e?e[n]=e[n].add(o):e[n]=o}),t.each(e,function(){this.matchHeight(!0)})};var s=function(e){r._beforeUpdate&&r._beforeUpdate(e,r._groups),t.each(r._groups,function(){r._apply(this.elements,this.options)}),r._afterUpdate&&r._afterUpdate(e,r._groups)};r._update=function(n,a){if(a&&"resize"===a.type){var i=t(window).width();if(i===e)return;e=i;
}n?o===-1&&(o=setTimeout(function(){s(a),o=-1},r._throttle)):s(a)},t(r._applyDataApi);var h=t.fn.on?"on":"bind";t(window)[h]("load",function(t){r._update(!1,t)}),t(window)[h]("resize orientationchange",function(t){r._update(!0,t)})});
/*! nouislider - 11.0.3 - 2018-01-21 14:04:07 */

!function(a){"function"==typeof define&&define.amd?define([],a):"object"==typeof exports?module.exports=a():window.noUiSlider=a()}(function(){"use strict";function a(a){return"object"==typeof a&&"function"==typeof a.to&&"function"==typeof a.from}function b(a){a.parentElement.removeChild(a)}function c(a){a.preventDefault()}function d(a){return a.filter(function(a){return!this[a]&&(this[a]=!0)},{})}function e(a,b){return Math.round(a/b)*b}function f(a,b){var c=a.getBoundingClientRect(),d=a.ownerDocument,e=d.documentElement,f=o(d);return/webkit.*Chrome.*Mobile/i.test(navigator.userAgent)&&(f.x=0),b?c.top+f.y-e.clientTop:c.left+f.x-e.clientLeft}function g(a){return"number"==typeof a&&!isNaN(a)&&isFinite(a)}function h(a,b,c){c>0&&(l(a,b),setTimeout(function(){m(a,b)},c))}function i(a){return Math.max(Math.min(a,100),0)}function j(a){return Array.isArray(a)?a:[a]}function k(a){a=String(a);var b=a.split(".");return b.length>1?b[1].length:0}function l(a,b){a.classList?a.classList.add(b):a.className+=" "+b}function m(a,b){a.classList?a.classList.remove(b):a.className=a.className.replace(new RegExp("(^|\\b)"+b.split(" ").join("|")+"(\\b|$)","gi")," ")}function n(a,b){return a.classList?a.classList.contains(b):new RegExp("\\b"+b+"\\b").test(a.className)}function o(a){var b=void 0!==window.pageXOffset,c="CSS1Compat"===(a.compatMode||"");return{x:b?window.pageXOffset:c?a.documentElement.scrollLeft:a.body.scrollLeft,y:b?window.pageYOffset:c?a.documentElement.scrollTop:a.body.scrollTop}}function p(){return window.navigator.pointerEnabled?{start:"pointerdown",move:"pointermove",end:"pointerup"}:window.navigator.msPointerEnabled?{start:"MSPointerDown",move:"MSPointerMove",end:"MSPointerUp"}:{start:"mousedown touchstart",move:"mousemove touchmove",end:"mouseup touchend"}}function q(){var a=!1;try{var b=Object.defineProperty({},"passive",{get:function(){a=!0}});window.addEventListener("test",null,b)}catch(a){}return a}function r(){return window.CSS&&CSS.supports&&CSS.supports("touch-action","none")}function s(a,b){return 100/(b-a)}function t(a,b){return 100*b/(a[1]-a[0])}function u(a,b){return t(a,a[0]<0?b+Math.abs(a[0]):b-a[0])}function v(a,b){return b*(a[1]-a[0])/100+a[0]}function w(a,b){for(var c=1;a>=b[c];)c+=1;return c}function x(a,b,c){if(c>=a.slice(-1)[0])return 100;var d=w(c,a),e=a[d-1],f=a[d],g=b[d-1],h=b[d];return g+u([e,f],c)/s(g,h)}function y(a,b,c){if(c>=100)return a.slice(-1)[0];var d=w(c,b),e=a[d-1],f=a[d],g=b[d-1];return v([e,f],(c-g)*s(g,b[d]))}function z(a,b,c,d){if(100===d)return d;var f=w(d,a),g=a[f-1],h=a[f];return c?d-g>(h-g)/2?h:g:b[f-1]?a[f-1]+e(d-a[f-1],b[f-1]):d}function A(a,b,c){var d;if("number"==typeof b&&(b=[b]),!Array.isArray(b))throw new Error("noUiSlider ("+Z+"): 'range' contains invalid value.");if(d="min"===a?0:"max"===a?100:parseFloat(a),!g(d)||!g(b[0]))throw new Error("noUiSlider ("+Z+"): 'range' value isn't numeric.");c.xPct.push(d),c.xVal.push(b[0]),d?c.xSteps.push(!isNaN(b[1])&&b[1]):isNaN(b[1])||(c.xSteps[0]=b[1]),c.xHighestCompleteStep.push(0)}function B(a,b,c){if(!b)return!0;c.xSteps[a]=t([c.xVal[a],c.xVal[a+1]],b)/s(c.xPct[a],c.xPct[a+1]);var d=(c.xVal[a+1]-c.xVal[a])/c.xNumSteps[a],e=Math.ceil(Number(d.toFixed(3))-1),f=c.xVal[a]+c.xNumSteps[a]*e;c.xHighestCompleteStep[a]=f}function C(a,b,c){this.xPct=[],this.xVal=[],this.xSteps=[c||!1],this.xNumSteps=[!1],this.xHighestCompleteStep=[],this.snap=b;var d,e=[];for(d in a)a.hasOwnProperty(d)&&e.push([a[d],d]);for(e.length&&"object"==typeof e[0][0]?e.sort(function(a,b){return a[0][0]-b[0][0]}):e.sort(function(a,b){return a[0]-b[0]}),d=0;d<e.length;d++)A(e[d][1],e[d][0],this);for(this.xNumSteps=this.xSteps.slice(0),d=0;d<this.xNumSteps.length;d++)B(d,this.xNumSteps[d],this)}function D(b){if(a(b))return!0;throw new Error("noUiSlider ("+Z+"): 'format' requires 'to' and 'from' methods.")}function E(a,b){if(!g(b))throw new Error("noUiSlider ("+Z+"): 'step' is not numeric.");a.singleStep=b}function F(a,b){if("object"!=typeof b||Array.isArray(b))throw new Error("noUiSlider ("+Z+"): 'range' is not an object.");if(void 0===b.min||void 0===b.max)throw new Error("noUiSlider ("+Z+"): Missing 'min' or 'max' in 'range'.");if(b.min===b.max)throw new Error("noUiSlider ("+Z+"): 'range' 'min' and 'max' cannot be equal.");a.spectrum=new C(b,a.snap,a.singleStep)}function G(a,b){if(b=j(b),!Array.isArray(b)||!b.length)throw new Error("noUiSlider ("+Z+"): 'start' option is incorrect.");a.handles=b.length,a.start=b}function H(a,b){if(a.snap=b,"boolean"!=typeof b)throw new Error("noUiSlider ("+Z+"): 'snap' option must be a boolean.")}function I(a,b){if(a.animate=b,"boolean"!=typeof b)throw new Error("noUiSlider ("+Z+"): 'animate' option must be a boolean.")}function J(a,b){if(a.animationDuration=b,"number"!=typeof b)throw new Error("noUiSlider ("+Z+"): 'animationDuration' option must be a number.")}function K(a,b){var c,d=[!1];if("lower"===b?b=[!0,!1]:"upper"===b&&(b=[!1,!0]),!0===b||!1===b){for(c=1;c<a.handles;c++)d.push(b);d.push(!1)}else{if(!Array.isArray(b)||!b.length||b.length!==a.handles+1)throw new Error("noUiSlider ("+Z+"): 'connect' option doesn't match handle count.");d=b}a.connect=d}function L(a,b){switch(b){case"horizontal":a.ort=0;break;case"vertical":a.ort=1;break;default:throw new Error("noUiSlider ("+Z+"): 'orientation' option is invalid.")}}function M(a,b){if(!g(b))throw new Error("noUiSlider ("+Z+"): 'margin' option must be numeric.");if(0!==b&&(a.margin=a.spectrum.getMargin(b),!a.margin))throw new Error("noUiSlider ("+Z+"): 'margin' option is only supported on linear sliders.")}function N(a,b){if(!g(b))throw new Error("noUiSlider ("+Z+"): 'limit' option must be numeric.");if(a.limit=a.spectrum.getMargin(b),!a.limit||a.handles<2)throw new Error("noUiSlider ("+Z+"): 'limit' option is only supported on linear sliders with 2 or more handles.")}function O(a,b){if(!g(b)&&!Array.isArray(b))throw new Error("noUiSlider ("+Z+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(Array.isArray(b)&&2!==b.length&&!g(b[0])&&!g(b[1]))throw new Error("noUiSlider ("+Z+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(0!==b){if(Array.isArray(b)||(b=[b,b]),a.padding=[a.spectrum.getMargin(b[0]),a.spectrum.getMargin(b[1])],!1===a.padding[0]||!1===a.padding[1])throw new Error("noUiSlider ("+Z+"): 'padding' option is only supported on linear sliders.");if(a.padding[0]<0||a.padding[1]<0)throw new Error("noUiSlider ("+Z+"): 'padding' option must be a positive number(s).");if(a.padding[0]>=50||a.padding[1]>=50)throw new Error("noUiSlider ("+Z+"): 'padding' option must be less than half the range.")}}function P(a,b){switch(b){case"ltr":a.dir=0;break;case"rtl":a.dir=1;break;default:throw new Error("noUiSlider ("+Z+"): 'direction' option was not recognized.")}}function Q(a,b){if("string"!=typeof b)throw new Error("noUiSlider ("+Z+"): 'behaviour' must be a string containing options.");var c=b.indexOf("tap")>=0,d=b.indexOf("drag")>=0,e=b.indexOf("fixed")>=0,f=b.indexOf("snap")>=0,g=b.indexOf("hover")>=0;if(e){if(2!==a.handles)throw new Error("noUiSlider ("+Z+"): 'fixed' behaviour must be used with 2 handles");M(a,a.start[1]-a.start[0])}a.events={tap:c||f,drag:d,fixed:e,snap:f,hover:g}}function R(a,b){if(!1!==b)if(!0===b){a.tooltips=[];for(var c=0;c<a.handles;c++)a.tooltips.push(!0)}else{if(a.tooltips=j(b),a.tooltips.length!==a.handles)throw new Error("noUiSlider ("+Z+"): must pass a formatter for all handles.");a.tooltips.forEach(function(a){if("boolean"!=typeof a&&("object"!=typeof a||"function"!=typeof a.to))throw new Error("noUiSlider ("+Z+"): 'tooltips' must be passed a formatter or 'false'.")})}}function S(a,b){a.ariaFormat=b,D(b)}function T(a,b){a.format=b,D(b)}function U(a,b){if(void 0!==b&&"string"!=typeof b&&!1!==b)throw new Error("noUiSlider ("+Z+"): 'cssPrefix' must be a string or `false`.");a.cssPrefix=b}function V(a,b){if(void 0!==b&&"object"!=typeof b)throw new Error("noUiSlider ("+Z+"): 'cssClasses' must be an object.");if("string"==typeof a.cssPrefix){a.cssClasses={};for(var c in b)b.hasOwnProperty(c)&&(a.cssClasses[c]=a.cssPrefix+b[c])}else a.cssClasses=b}function W(a){var b={margin:0,limit:0,padding:0,animate:!0,animationDuration:300,ariaFormat:$,format:$},c={step:{r:!1,t:E},start:{r:!0,t:G},connect:{r:!0,t:K},direction:{r:!0,t:P},snap:{r:!1,t:H},animate:{r:!1,t:I},animationDuration:{r:!1,t:J},range:{r:!0,t:F},orientation:{r:!1,t:L},margin:{r:!1,t:M},limit:{r:!1,t:N},padding:{r:!1,t:O},behaviour:{r:!0,t:Q},ariaFormat:{r:!1,t:S},format:{r:!1,t:T},tooltips:{r:!1,t:R},cssPrefix:{r:!1,t:U},cssClasses:{r:!1,t:V}},d={connect:!1,direction:"ltr",behaviour:"tap",orientation:"horizontal",cssPrefix:"noUi-",cssClasses:{target:"target",base:"base",origin:"origin",handle:"handle",handleLower:"handle-lower",handleUpper:"handle-upper",horizontal:"horizontal",vertical:"vertical",background:"background",connect:"connect",connects:"connects",ltr:"ltr",rtl:"rtl",draggable:"draggable",drag:"state-drag",tap:"state-tap",active:"active",tooltip:"tooltip",pips:"pips",pipsHorizontal:"pips-horizontal",pipsVertical:"pips-vertical",marker:"marker",markerHorizontal:"marker-horizontal",markerVertical:"marker-vertical",markerNormal:"marker-normal",markerLarge:"marker-large",markerSub:"marker-sub",value:"value",valueHorizontal:"value-horizontal",valueVertical:"value-vertical",valueNormal:"value-normal",valueLarge:"value-large",valueSub:"value-sub"}};a.format&&!a.ariaFormat&&(a.ariaFormat=a.format),Object.keys(c).forEach(function(e){if(void 0===a[e]&&void 0===d[e]){if(c[e].r)throw new Error("noUiSlider ("+Z+"): '"+e+"' is required.");return!0}c[e].t(b,void 0===a[e]?d[e]:a[e])}),b.pips=a.pips;var e=document.createElement("div"),f=void 0!==e.style.msTransform,g=void 0!==e.style.transform;b.transformRule=g?"transform":f?"msTransform":"webkitTransform";var h=[["left","top"],["right","bottom"]];return b.style=h[b.dir][b.ort],b}function X(a,e,g){function k(a,b){var c=ya.createElement("div");return b&&l(c,b),a.appendChild(c),c}function s(a,b){var c=k(a,e.cssClasses.origin),d=k(c,e.cssClasses.handle);return d.setAttribute("data-handle",b),d.setAttribute("tabindex","0"),d.setAttribute("role","slider"),d.setAttribute("aria-orientation",e.ort?"vertical":"horizontal"),0===b?l(d,e.cssClasses.handleLower):b===e.handles-1&&l(d,e.cssClasses.handleUpper),c}function t(a,b){return!!b&&k(a,e.cssClasses.connect)}function u(a,b){var c=k(b,e.cssClasses.connects);ka=[],la=[],la.push(t(c,a[0]));for(var d=0;d<e.handles;d++)ka.push(s(b,d)),ta[d]=d,la.push(t(c,a[d+1]))}function v(a){l(a,e.cssClasses.target),0===e.dir?l(a,e.cssClasses.ltr):l(a,e.cssClasses.rtl),0===e.ort?l(a,e.cssClasses.horizontal):l(a,e.cssClasses.vertical),ja=k(a,e.cssClasses.base)}function w(a,b){return!!e.tooltips[b]&&k(a.firstChild,e.cssClasses.tooltip)}function x(){var a=ka.map(w);Q("update",function(b,c,d){if(a[c]){var f=b[c];!0!==e.tooltips[c]&&(f=e.tooltips[c].to(d[c])),a[c].innerHTML=f}})}function y(){Q("update",function(a,b,c,d,f){ta.forEach(function(a){var b=ka[a],d=U(sa,a,0,!0,!0,!0),g=U(sa,a,100,!0,!0,!0),h=f[a],i=e.ariaFormat.to(c[a]);b.children[0].setAttribute("aria-valuemin",d.toFixed(1)),b.children[0].setAttribute("aria-valuemax",g.toFixed(1)),b.children[0].setAttribute("aria-valuenow",h.toFixed(1)),b.children[0].setAttribute("aria-valuetext",i)})})}function z(a,b,c){if("range"===a||"steps"===a)return va.xVal;if("count"===a){if(b<2)throw new Error("noUiSlider ("+Z+"): 'values' (>= 2) required for mode 'count'.");var d=b-1,e=100/d;for(b=[];d--;)b[d]=d*e;b.push(100),a="positions"}return"positions"===a?b.map(function(a){return va.fromStepping(c?va.getStep(a):a)}):"values"===a?c?b.map(function(a){return va.fromStepping(va.getStep(va.toStepping(a)))}):b:void 0}function A(a,b,c){function e(a,b){return(a+b).toFixed(7)/1}var f={},g=va.xVal[0],h=va.xVal[va.xVal.length-1],i=!1,j=!1,k=0;return c=d(c.slice().sort(function(a,b){return a-b})),c[0]!==g&&(c.unshift(g),i=!0),c[c.length-1]!==h&&(c.push(h),j=!0),c.forEach(function(d,g){var h,l,m,n,o,p,q,r,s,t,u=d,v=c[g+1];if("steps"===b&&(h=va.xNumSteps[g]),h||(h=v-u),!1!==u&&void 0!==v)for(h=Math.max(h,1e-7),l=u;l<=v;l=e(l,h)){for(n=va.toStepping(l),o=n-k,r=o/a,s=Math.round(r),t=o/s,m=1;m<=s;m+=1)p=k+m*t,f[p.toFixed(5)]=["x",0];q=c.indexOf(l)>-1?1:"steps"===b?2:0,!g&&i&&(q=0),l===v&&j||(f[n.toFixed(5)]=[l,q]),k=n}}),f}function B(a,b,c){function d(a,b){var c=b===e.cssClasses.value,d=c?j:m,f=c?h:i;return b+" "+d[e.ort]+" "+f[a]}function f(a,f){f[1]=f[1]&&b?b(f[0],f[1]):f[1];var h=k(g,!1);h.className=d(f[1],e.cssClasses.marker),h.style[e.style]=a+"%",f[1]&&(h=k(g,!1),h.className=d(f[1],e.cssClasses.value),h.setAttribute("data-value",f[0]),h.style[e.style]=a+"%",h.innerText=c.to(f[0]))}var g=ya.createElement("div"),h=[e.cssClasses.valueNormal,e.cssClasses.valueLarge,e.cssClasses.valueSub],i=[e.cssClasses.markerNormal,e.cssClasses.markerLarge,e.cssClasses.markerSub],j=[e.cssClasses.valueHorizontal,e.cssClasses.valueVertical],m=[e.cssClasses.markerHorizontal,e.cssClasses.markerVertical];return l(g,e.cssClasses.pips),l(g,0===e.ort?e.cssClasses.pipsHorizontal:e.cssClasses.pipsVertical),Object.keys(a).forEach(function(b){f(b,a[b])}),g}function C(){na&&(b(na),na=null)}function D(a){C();var b=a.mode,c=a.density||1,d=a.filter||!1,e=a.values||!1,f=a.stepped||!1,g=z(b,e,f),h=A(c,b,g),i=a.format||{to:Math.round};return na=ra.appendChild(B(h,d,i))}function E(){var a=ja.getBoundingClientRect(),b="offset"+["Width","Height"][e.ort];return 0===e.ort?a.width||ja[b]:a.height||ja[b]}function F(a,b,c,d){var f=function(f){return!!(f=G(f,d.pageOffset,d.target||b))&&(!(ra.hasAttribute("disabled")&&!d.doNotReject)&&(!(n(ra,e.cssClasses.tap)&&!d.doNotReject)&&(!(a===oa.start&&void 0!==f.buttons&&f.buttons>1)&&((!d.hover||!f.buttons)&&(qa||f.preventDefault(),f.calcPoint=f.points[e.ort],void c(f,d))))))},g=[];return a.split(" ").forEach(function(a){b.addEventListener(a,f,!!qa&&{passive:!0}),g.push([a,f])}),g}function G(a,b,c){var d,e,f=0===a.type.indexOf("touch"),g=0===a.type.indexOf("mouse"),h=0===a.type.indexOf("pointer");if(0===a.type.indexOf("MSPointer")&&(h=!0),f){var i=function(a){return a.target===c||c.contains(a.target)};if("touchstart"===a.type){var j=Array.prototype.filter.call(a.touches,i);if(j.length>1)return!1;d=j[0].pageX,e=j[0].pageY}else{var k=Array.prototype.find.call(a.changedTouches,i);if(!k)return!1;d=k.pageX,e=k.pageY}}return b=b||o(ya),(g||h)&&(d=a.clientX+b.x,e=a.clientY+b.y),a.pageOffset=b,a.points=[d,e],a.cursor=g||h,a}function H(a){var b=a-f(ja,e.ort),c=100*b/E();return c=i(c),e.dir?100-c:c}function I(a){var b=100,c=!1;return ka.forEach(function(d,e){if(!d.hasAttribute("disabled")){var f=Math.abs(sa[e]-a);(f<b||100===f&&100===b)&&(c=e,b=f)}}),c}function J(a,b){"mouseout"===a.type&&"HTML"===a.target.nodeName&&null===a.relatedTarget&&L(a,b)}function K(a,b){if(-1===navigator.appVersion.indexOf("MSIE 9")&&0===a.buttons&&0!==b.buttonsProperty)return L(a,b);var c=(e.dir?-1:1)*(a.calcPoint-b.startCalcPoint);X(c>0,100*c/b.baseSize,b.locations,b.handleNumbers)}function L(a,b){b.handle&&(m(b.handle,e.cssClasses.active),ua-=1),b.listeners.forEach(function(a){za.removeEventListener(a[0],a[1])}),0===ua&&(m(ra,e.cssClasses.drag),_(),a.cursor&&(Aa.style.cursor="",Aa.removeEventListener("selectstart",c))),b.handleNumbers.forEach(function(a){S("change",a),S("set",a),S("end",a)})}function M(a,b){var d;if(1===b.handleNumbers.length){var f=ka[b.handleNumbers[0]];if(f.hasAttribute("disabled"))return!1;d=f.children[0],ua+=1,l(d,e.cssClasses.active)}a.stopPropagation();var g=[],h=F(oa.move,za,K,{target:a.target,handle:d,listeners:g,startCalcPoint:a.calcPoint,baseSize:E(),pageOffset:a.pageOffset,handleNumbers:b.handleNumbers,buttonsProperty:a.buttons,locations:sa.slice()}),i=F(oa.end,za,L,{target:a.target,handle:d,listeners:g,doNotReject:!0,handleNumbers:b.handleNumbers}),j=F("mouseout",za,J,{target:a.target,handle:d,listeners:g,doNotReject:!0,handleNumbers:b.handleNumbers});g.push.apply(g,h.concat(i,j)),a.cursor&&(Aa.style.cursor=getComputedStyle(a.target).cursor,ka.length>1&&l(ra,e.cssClasses.drag),Aa.addEventListener("selectstart",c,!1)),b.handleNumbers.forEach(function(a){S("start",a)})}function N(a){a.stopPropagation();var b=H(a.calcPoint),c=I(b);if(!1===c)return!1;e.events.snap||h(ra,e.cssClasses.tap,e.animationDuration),aa(c,b,!0,!0),_(),S("slide",c,!0),S("update",c,!0),S("change",c,!0),S("set",c,!0),e.events.snap&&M(a,{handleNumbers:[c]})}function O(a){var b=H(a.calcPoint),c=va.getStep(b),d=va.fromStepping(c);Object.keys(xa).forEach(function(a){"hover"===a.split(".")[0]&&xa[a].forEach(function(a){a.call(ma,d)})})}function P(a){a.fixed||ka.forEach(function(a,b){F(oa.start,a.children[0],M,{handleNumbers:[b]})}),a.tap&&F(oa.start,ja,N,{}),a.hover&&F(oa.move,ja,O,{hover:!0}),a.drag&&la.forEach(function(b,c){if(!1!==b&&0!==c&&c!==la.length-1){var d=ka[c-1],f=ka[c],g=[b];l(b,e.cssClasses.draggable),a.fixed&&(g.push(d.children[0]),g.push(f.children[0])),g.forEach(function(a){F(oa.start,a,M,{handles:[d,f],handleNumbers:[c-1,c]})})}})}function Q(a,b){xa[a]=xa[a]||[],xa[a].push(b),"update"===a.split(".")[0]&&ka.forEach(function(a,b){S("update",b)})}function R(a){var b=a&&a.split(".")[0],c=b&&a.substring(b.length);Object.keys(xa).forEach(function(a){var d=a.split(".")[0],e=a.substring(d.length);b&&b!==d||c&&c!==e||delete xa[a]})}function S(a,b,c){Object.keys(xa).forEach(function(d){var f=d.split(".")[0];a===f&&xa[d].forEach(function(a){a.call(ma,wa.map(e.format.to),b,wa.slice(),c||!1,sa.slice())})})}function T(a){return a+"%"}function U(a,b,c,d,f,g){return ka.length>1&&(d&&b>0&&(c=Math.max(c,a[b-1]+e.margin)),f&&b<ka.length-1&&(c=Math.min(c,a[b+1]-e.margin))),ka.length>1&&e.limit&&(d&&b>0&&(c=Math.min(c,a[b-1]+e.limit)),f&&b<ka.length-1&&(c=Math.max(c,a[b+1]-e.limit))),e.padding&&(0===b&&(c=Math.max(c,e.padding[0])),b===ka.length-1&&(c=Math.min(c,100-e.padding[1]))),c=va.getStep(c),!((c=i(c))===a[b]&&!g)&&c}function V(a,b){var c=e.ort;return(c?b:a)+", "+(c?a:b)}function X(a,b,c,d){var e=c.slice(),f=[!a,a],g=[a,!a];d=d.slice(),a&&d.reverse(),d.length>1?d.forEach(function(a,c){var d=U(e,a,e[a]+b,f[c],g[c],!1);!1===d?b=0:(b=d-e[a],e[a]=d)}):f=g=[!0];var h=!1;d.forEach(function(a,d){h=aa(a,c[a]+b,f[d],g[d])||h}),h&&d.forEach(function(a){S("update",a),S("slide",a)})}function Y(a,b){return e.dir?100-a-b:a}function $(a,b){sa[a]=b,wa[a]=va.fromStepping(b);var c="translate("+V(T(Y(b,0)-Ba),"0")+")";ka[a].style[e.transformRule]=c,ba(a),ba(a+1)}function _(){ta.forEach(function(a){var b=sa[a]>50?-1:1,c=3+(ka.length+b*a);ka[a].style.zIndex=c})}function aa(a,b,c,d){return!1!==(b=U(sa,a,b,c,d,!1))&&($(a,b),!0)}function ba(a){if(la[a]){var b=0,c=100;0!==a&&(b=sa[a-1]),a!==la.length-1&&(c=sa[a]);var d=c-b,f="translate("+V(T(Y(b,d)),"0")+")",g="scale("+V(d/100,"1")+")";la[a].style[e.transformRule]=f+" "+g}}function ca(a,b){return null===a||!1===a||void 0===a?sa[b]:("number"==typeof a&&(a=String(a)),a=e.format.from(a),a=va.toStepping(a),!1===a||isNaN(a)?sa[b]:a)}function da(a,b){var c=j(a),d=void 0===sa[0];b=void 0===b||!!b,e.animate&&!d&&h(ra,e.cssClasses.tap,e.animationDuration),ta.forEach(function(a){aa(a,ca(c[a],a),!0,!1)}),ta.forEach(function(a){aa(a,sa[a],!0,!0)}),_(),ta.forEach(function(a){S("update",a),null!==c[a]&&b&&S("set",a)})}function ea(a){da(e.start,a)}function fa(){var a=wa.map(e.format.to);return 1===a.length?a[0]:a}function ga(){for(var a in e.cssClasses)e.cssClasses.hasOwnProperty(a)&&m(ra,e.cssClasses[a]);for(;ra.firstChild;)ra.removeChild(ra.firstChild);delete ra.noUiSlider}function ha(){return sa.map(function(a,b){var c=va.getNearbySteps(a),d=wa[b],e=c.thisStep.step,f=null;!1!==e&&d+e>c.stepAfter.startValue&&(e=c.stepAfter.startValue-d),f=d>c.thisStep.startValue?c.thisStep.step:!1!==c.stepBefore.step&&d-c.stepBefore.highestStep,100===a?e=null:0===a&&(f=null);var g=va.countStepDecimals();return null!==e&&!1!==e&&(e=Number(e.toFixed(g))),null!==f&&!1!==f&&(f=Number(f.toFixed(g))),[f,e]})}function ia(a,b){var c=fa(),d=["margin","limit","padding","range","animate","snap","step","format"];d.forEach(function(b){void 0!==a[b]&&(g[b]=a[b])});var f=W(g);d.forEach(function(b){void 0!==a[b]&&(e[b]=f[b])}),va=f.spectrum,e.margin=f.margin,e.limit=f.limit,e.padding=f.padding,e.pips&&D(e.pips),sa=[],da(a.start||c,b)}var ja,ka,la,ma,na,oa=p(),pa=r(),qa=pa&&q(),ra=a,sa=[],ta=[],ua=0,va=e.spectrum,wa=[],xa={},ya=a.ownerDocument,za=ya.documentElement,Aa=ya.body,Ba="rtl"===ya.dir||1===e.ort?0:100;return v(ra),u(e.connect,ja),P(e.events),da(e.start),ma={destroy:ga,steps:ha,on:Q,off:R,get:fa,set:da,reset:ea,__moveHandles:function(a,b,c){X(a,b,sa,c)},options:g,updateOptions:ia,target:ra,removePips:C,pips:D},e.pips&&D(e.pips),e.tooltips&&x(),y(),ma}function Y(a,b){if(!a||!a.nodeName)throw new Error("noUiSlider ("+Z+"): create requires a single element, got: "+a);if(a.noUiSlider)throw new Error("noUiSlider ("+Z+"): Slider was already initialized.");var c=W(b,a),d=X(a,c,b);return a.noUiSlider=d,d}var Z="11.0.3";C.prototype.getMargin=function(a){var b=this.xNumSteps[0];if(b&&a/b%1!=0)throw new Error("noUiSlider ("+Z+"): 'limit', 'margin' and 'padding' must be divisible by step.");return 2===this.xPct.length&&t(this.xVal,a)},C.prototype.toStepping=function(a){return a=x(this.xVal,this.xPct,a)},C.prototype.fromStepping=function(a){return y(this.xVal,this.xPct,a)},C.prototype.getStep=function(a){return a=z(this.xPct,this.xSteps,this.snap,a)},C.prototype.getNearbySteps=function(a){var b=w(a,this.xPct);return{stepBefore:{startValue:this.xVal[b-2],step:this.xNumSteps[b-2],highestStep:this.xHighestCompleteStep[b-2]},thisStep:{startValue:this.xVal[b-1],step:this.xNumSteps[b-1],highestStep:this.xHighestCompleteStep[b-1]},stepAfter:{startValue:this.xVal[b-0],step:this.xNumSteps[b-0],highestStep:this.xHighestCompleteStep[b-0]}}},C.prototype.countStepDecimals=function(){var a=this.xNumSteps.map(k);return Math.max.apply(null,a)},C.prototype.convert=function(a){return this.getStep(this.toStepping(a))};var $={to:function(a){return void 0!==a&&a.toFixed(2)},from:Number};return{version:Z,create:Y}});
!function(t){"object"==typeof module&&"object"==typeof module.exports?t(require("jquery")):"function"==typeof define&&define.amd?define([],t(window.jQuery)):t(window.jQuery)}(function(t){if(!t)return console.warn("Unslider needs jQuery");t.Unslider=function(n,e){var i=this;return i._="unslider",i.defaults={autoplay:!1,delay:3e3,speed:750,easing:"swing",keys:{prev:37,next:39},nav:!0,arrows:{prev:'<a class="'+i._+'-arrow prev">Prev</a>',next:'<a class="'+i._+'-arrow next">Next</a>'},animation:"horizontal",selectors:{container:"ul:first",slides:"li"},animateHeight:!1,activeClass:i._+"-active",swipe:!0,swipeThreshold:.2},i.$context=n,i.options={},i.$parent=null,i.$container=null,i.$slides=null,i.$nav=null,i.$arrows=[],i.total=0,i.current=0,i.prefix=i._+"-",i.eventSuffix="."+i.prefix+~~(2e3*Math.random()),i.interval=[],i.init=function(n){return i.options=t.extend({},i.defaults,n),i.$container=i.$context.find(i.options.selectors.container).addClass(i.prefix+"wrap"),i.$slides=i.$container.children(i.options.selectors.slides),i.setup(),t.each(["nav","arrows","keys","infinite"],function(n,e){i.options[e]&&i["init"+t._ucfirst(e)]()}),jQuery.event.special.swipe&&i.options.swipe&&i.initSwipe(),i.options.autoplay&&i.start(),i.calculateSlides(),i.$context.trigger(i._+".ready"),i.animate(i.options.index||i.current,"init")},i.setup=function(){i.$context.addClass(i.prefix+i.options.animation).wrap('<div class="'+i._+'" />'),i.$parent=i.$context.parent("."+i._),"static"===i.$context.css("position")&&i.$context.css("position","relative"),i.$context.css("overflow","hidden")},i.calculateSlides=function(){if(i.$slides=i.$container.children(i.options.selectors.slides),i.total=i.$slides.length,"fade"!==i.options.animation){var t="width";"vertical"===i.options.animation&&(t="height"),i.$container.css(t,100*i.total+"%").addClass(i.prefix+"carousel"),i.$slides.css(t,100/i.total+"%")}},i.start=function(){return i.interval.push(setTimeout(function(){i.next()},i.options.delay)),i},i.stop=function(){for(var t;t=i.interval.pop();)clearTimeout(t);return i},i.initNav=function(){var n=t('<nav class="'+i.prefix+'nav"><ol /></nav>');i.$slides.each(function(e){var o=this.getAttribute("data-nav")||e+1;t.isFunction(i.options.nav)&&(o=i.options.nav.call(i.$slides.eq(e),e,o)),n.children("ol").append('<li data-slide="'+e+'">'+o+"</li>")}),i.$nav=n.insertAfter(i.$context),i.$nav.find("li").on("click"+i.eventSuffix,function(){var n=t(this).addClass(i.options.activeClass);n.siblings().removeClass(i.options.activeClass),i.animate(n.attr("data-slide"))})},i.initArrows=function(){!0===i.options.arrows&&(i.options.arrows=i.defaults.arrows),t.each(i.options.arrows,function(n,e){i.$arrows.push(t(e).insertAfter(i.$context).on("click"+i.eventSuffix,i[n]))})},i.initKeys=function(){!0===i.options.keys&&(i.options.keys=i.defaults.keys),t(document).on("keyup"+i.eventSuffix,function(n){t.each(i.options.keys,function(e,o){n.which===o&&t.isFunction(i[e])&&i[e].call(i)})})},i.initSwipe=function(){var t=i.$slides.width();"fade"!==i.options.animation&&i.$container.on({movestart:function(t){if(t.distX>t.distY&&t.distX<-t.distY||t.distX<t.distY&&t.distX>-t.distY)return!!t.preventDefault();i.$container.css("position","relative")},move:function(n){i.$container.css("left",-100*i.current+100*n.distX/t+"%")},moveend:function(n){Math.abs(n.distX)/t>i.options.swipeThreshold?i[n.distX<0?"next":"prev"]():i.$container.animate({left:-100*i.current+"%"},i.options.speed/2)}})},i.initInfinite=function(){var n=["first","last"];t.each(n,function(t,e){i.$slides.push.apply(i.$slides,i.$slides.filter(':not(".'+i._+'-clone")')[e]().clone().addClass(i._+"-clone")["insert"+(0===t?"After":"Before")](i.$slides[n[~~!t]]()))})},i.destroyArrows=function(){t.each(i.$arrows,function(t,n){n.remove()})},i.destroySwipe=function(){i.$container.off("movestart move moveend")},i.destroyKeys=function(){t(document).off("keyup"+i.eventSuffix)},i.setIndex=function(t){return t<0&&(t=i.total-1),i.current=Math.min(Math.max(0,t),i.total-1),i.options.nav&&i.$nav.find('[data-slide="'+i.current+'"]')._active(i.options.activeClass),i.$slides.eq(i.current)._active(i.options.activeClass),i},i.animate=function(n,e){if("first"===n&&(n=0),"last"===n&&(n=i.total),isNaN(n))return i;i.options.autoplay&&i.stop().start(),i.setIndex(n),i.$context.trigger(i._+".change",[n,i.$slides.eq(n)]);var o="animate"+t._ucfirst(i.options.animation);return t.isFunction(i[o])&&i[o](i.current,e),i},i.next=function(){var t=i.current+1;return t>=i.total&&(t=i.options.noloop&&!i.options.infinite?i.total-1:0),i.animate(t,"next")},i.prev=function(){var t=i.current-1;return t<0&&(t=i.options.noloop&&!i.options.infinite?0:i.total-1),i.animate(t,"prev")},i.animateHorizontal=function(t){var n="left";return"rtl"===i.$context.attr("dir")&&(n="right"),i.options.infinite&&i.$container.css("margin-"+n,"-100%"),i.slide(n,t)},i.animateVertical=function(t){return i.options.animateHeight=!0,i.options.infinite&&i.$container.css("margin-top",-i.$slides.outerHeight()),i.slide("top",t)},i.slide=function(t,n){if(i.animateHeight(n),i.options.infinite){var e;n===i.total-1&&(e=i.total-3,n=-1),n===i.total-2&&(e=0,n=i.total-2),"number"==typeof e&&(i.setIndex(e),i.$context.on(i._+".moved",function(){i.current===e&&i.$container.css(t,-100*e+"%").off(i._+".moved")}))}var o={};return o[t]=-100*n+"%",i._move(i.$container,o)},i.animateFade=function(t){i.animateHeight(t);var n=i.$slides.eq(t).addClass(i.options.activeClass);i._move(n.siblings().removeClass(i.options.activeClass),{opacity:0}),i._move(n,{opacity:1},!1)},i.animateHeight=function(t){i.options.animateHeight&&i._move(i.$context,{height:i.$slides.eq(t).outerHeight()},!1)},i._move=function(t,n,e,o){return!1!==e&&(e=function(){i.$context.trigger(i._+".moved")}),t._move(n,o||i.options.speed,i.options.easing,e)},i.init(e)},t.fn._active=function(t){return this.addClass(t).siblings().removeClass(t)},t._ucfirst=function(t){return(t+"").toLowerCase().replace(/^./,function(t){return t.toUpperCase()})},t.fn._move=function(){return this.stop(!0,!0),t.fn[t.fn.velocity?"velocity":"animate"].apply(this,arguments)},t.fn.unslider=function(n){return this.each(function(e,i){var o=t(i);if(!(t(i).data("unslider")instanceof t.Unslider)){if("string"==typeof n&&o.data("unslider")){n=n.split(":");var s=o.data("unslider")[n[0]];if(t.isFunction(s))return s.apply(o,n[1]?n[1].split(","):null)}return o.data("unslider",new t.Unslider(o,n))}})}});