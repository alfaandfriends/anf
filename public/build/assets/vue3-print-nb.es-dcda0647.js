class h{constructor(e){this.standards={strict:"strict",loose:"loose",html5:"html5"},this.previewBody=null,this.close=null,this.previewBodyUtilPrintBtn=null,this.selectArray=[],this.counter=0,this.settings={standard:this.standards.html5},Object.assign(this.settings,e),this.init()}init(){this.counter++,this.settings.id=`printArea_${this.counter}`;let e="";this.settings.url&&!this.settings.asyncUrl&&(e=this.settings.url);let l=this;if(this.settings.asyncUrl)return void l.settings.asyncUrl(function(i){let s=l.getPrintWindow(i);l.settings.preview?l.previewIfrmaeLoad():l.print(s)},l.settings.vue);let t=this.getPrintWindow(e);this.settings.url||this.write(t.doc),this.settings.preview?this.previewIfrmaeLoad():this.print(t)}addEvent(e,l,t){e.addEventListener?e.addEventListener(l,t,!1):e.attachEvent?e.attachEvent("on"+l,t):e["on"+l]=t}previewIfrmaeLoad(){let e=document.getElementById("vue-pirnt-nb-previewBox");if(e){let l=this,t=e.querySelector("iframe");this.settings.previewBeforeOpenCallback(),this.addEvent(t,"load",function(){l.previewBoxShow(),l.removeCanvasImg(),l.settings.previewOpenCallback()}),this.addEvent(e.querySelector(".previewBodyUtilPrintBtn"),"click",function(){l.settings.beforeOpenCallback(),l.settings.openCallback(),t.contentWindow.print(),l.settings.closeCallback()})}}removeCanvasImg(){let e=this;try{if(e.elsdom){let l=e.elsdom.querySelectorAll(".canvasImg");for(let t=0;t<l.length;t++)l[t].remove()}}catch(l){console.log(l)}}print(e){var l=this;let t=document.getElementById(this.settings.id)||e.f,i=document.getElementById(this.settings.id).contentWindow||e.f.contentWindow;l.settings.beforeOpenCallback(),l.addEvent(t,"load",function(){i.focus(),l.settings.openCallback(),i.print(),t.remove(),l.settings.closeCallback(),l.removeCanvasImg()})}write(e){e.open(),e.write(`${this.docType()}<html>${this.getHead()}${this.getBody()}</html>`),e.close()}docType(){return this.settings.standard===this.standards.html5?"<!DOCTYPE html>":`<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01${this.settings.standard===this.standards.loose?" Transitional":""}//EN" "http://www.w3.org/TR/html4/${this.settings.standard===this.standards.loose?"loose":"strict"}.dtd">`}getHead(){let e="",l="",t="";this.settings.extraHead&&this.settings.extraHead.replace(/([^,]+)/g,s=>{e+=s}),[].forEach.call(document.querySelectorAll("link"),function(s){s.href.indexOf(".css")>=0&&(l+=`<link type="text/css" rel="stylesheet" href="${s.href}" >`)});let i=document.styleSheets;if(i&&i.length>0)for(let s=0;s<i.length;s++)try{if(i[s].cssRules||i[s].rules){let r=i[s].cssRules||i[s].rules;for(let n=0;n<r.length;n++)t+=r[n].cssText}}catch(r){console.log(i[s].href+r)}return this.settings.extraCss&&this.settings.extraCss.replace(/([^,\s]+)/g,s=>{l+=`<link type="text/css" rel="stylesheet" href="${s}">`}),`<head><title>${this.settings.popTitle}</title>${e}${l}<style type="text/css">${t}</style></head>`}getBody(){let e=this.settings.ids;return e=e.replace(new RegExp("#","g"),""),this.elsdom=this.beforeHanler(document.getElementById(e)),"<body>"+this.getFormData(this.elsdom).outerHTML+"</body>"}beforeHanler(e){let l=e.querySelectorAll("canvas");for(let t=0;t<l.length;t++)if(!l[t].style.display){let i=l[t].parentNode,s=l[t].toDataURL("image/png"),r=new Image;r.className="canvasImg",r.style.display="none",r.src=s,i.appendChild(r)}return e}getFormData(e){let l=e.cloneNode(!0),t=l.querySelectorAll("input,select,textarea"),i=l.querySelectorAll(".canvasImg,canvas"),s=-1;for(let r=0;r<i.length;r++){let n=i[r].parentNode,o=i[r];o.tagName.toLowerCase()==="canvas"?n.removeChild(o):o.style.display="block"}for(let r=0;r<t.length;r++){let n=t[r],o=n.getAttribute("type"),a=t[r];if(o||(o=n.tagName==="SELECT"?"select":n.tagName==="TEXTAREA"?"textarea":""),n.tagName==="INPUT")o==="radio"||o==="checkbox"?n.checked&&a.setAttribute("checked",n.checked):(a.value=n.value,a.setAttribute("value",n.value));else if(o==="select"){s++;for(let d=0;d<e.querySelectorAll("select").length;d++){let p=e.querySelectorAll("select")[d];if(!p.getAttribute("newbs")&&p.setAttribute("newbs",d),p.getAttribute("newbs")==s){let u=e.querySelectorAll("select")[s].selectedIndex;n.options[u].setAttribute("selected",!0)}}}else a.innerHTML=n.value,a.setAttribute("html",n.value)}return l}getPrintWindow(e){var l=this.Iframe(e);return{f:l,win:l.contentWindow||l,doc:l.doc}}previewBoxShow(){let e=document.getElementById("vue-pirnt-nb-previewBox");e&&(document.querySelector("html").setAttribute("style","overflow: hidden"),e.style.display="block")}previewBoxHide(){let e=document.getElementById("vue-pirnt-nb-previewBox");e&&(document.querySelector("html").setAttribute("style","overflow: visible;"),e.querySelector("iframe")&&e.querySelector("iframe").remove(),e.style.display="none")}previewBox(){let e=document.getElementById("vue-pirnt-nb-previewBox"),l="previewBody";if(e)return e.querySelector("iframe")&&e.querySelector("iframe").remove(),{close:e.querySelector(".previewClose"),previewBody:e.querySelector(".previewBody")};let t=document.createElement("div");t.setAttribute("id","vue-pirnt-nb-previewBox"),t.setAttribute("style","position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;background: white;display:none"),t.style.zIndex=this.settings.zIndex;let i=document.createElement("div");i.setAttribute("class","previewHeader"),i.setAttribute("style","padding: 5px 20px;"),i.innerHTML=this.settings.previewTitle,t.appendChild(i),this.close=document.createElement("div");let s=this.close;s.setAttribute("class","previewClose"),s.setAttribute("style","position: absolute;top: 5px;right: 20px;width: 25px;height: 20px;cursor: pointer;");let r=document.createElement("div"),n=document.createElement("div");r.setAttribute("class","closeBefore"),r.setAttribute("style","position: absolute;width: 3px;height: 100%;background: #040404;transform: rotate(45deg); top: 0px;left: 50%;"),n.setAttribute("class","closeAfter"),n.setAttribute("style","position: absolute;width: 3px;height: 100%;background: #040404;transform: rotate(-45deg); top: 0px;left: 50%;"),s.appendChild(r),s.appendChild(n),i.appendChild(s),this.previewBody=document.createElement("div");let o=this.previewBody;o.setAttribute("class",l),o.setAttribute("style","display: flex;flex-direction: column; height: 100%;"),t.appendChild(o);let a=document.createElement("div");a.setAttribute("class","previewBodyUtil"),a.setAttribute("style","height: 32px;background: #474747;position: relative;"),o.appendChild(a),this.previewBodyUtilPrintBtn=document.createElement("div");let d=this.previewBodyUtilPrintBtn;return d.setAttribute("class","previewBodyUtilPrintBtn"),d.innerHTML=this.settings.previewPrintBtnLabel,d.setAttribute("style","position: absolute;padding: 2px 10px;margin-top: 3px;left: 24px;font-size: 14px;color: white;cursor: pointer;background-color: rgba(0,0,0,.12);background-image: linear-gradient(hsla(0,0%,100%,.05),hsla(0,0%,100%,0));background-clip: padding-box;border: 1px solid rgba(0,0,0,.35);border-color: rgba(0,0,0,.32) rgba(0,0,0,.38) rgba(0,0,0,.42);box-shadow: inset 0 1px 0 hsla(0,0%,100%,.05), inset 0 0 1px hsla(0,0%,100%,.15), 0 1px 0 hsla(0,0%,100%,.05);"),a.appendChild(d),document.body.appendChild(t),{close:this.close,previewBody:this.previewBody}}iframeBox(e,l){let t=document.createElement("iframe");return t.style.border="0px",t.style.position="absolute",t.style.width="0px",t.style.height="0px",t.style.right="0px",t.style.top="0px",t.setAttribute("id",e),t.setAttribute("src",l),t}Iframe(e){let l=this.settings.id;e=e||new Date().getTime();let t=this,i=this.iframeBox(l,e);try{if(this.settings.preview){i.setAttribute("style","border: 0px;flex: 1;");let s=this.previewBox(),r=s.previewBody,n=s.close;r.appendChild(i),this.addEvent(n,"click",function(){t.previewBoxHide()})}else document.body.appendChild(i);i.doc=null,i.doc=i.contentDocument?i.contentDocument:i.contentWindow?i.contentWindow.document:i.document}catch(s){throw new Error(s+". iframes may not be supported in this browser.")}if(i.doc==null)throw new Error("Cannot find document.");return i}}var v={directiveName:"print",mounted(c,e,l){let t=e.instance,i="";var s,r,n;r="click",n=()=>{if(typeof e.value=="string")i=e.value;else{if(typeof e.value!="object"||!e.value.id)return void window.print();{i=e.value.id;let a=i.replace(new RegExp("#","g"),"");document.getElementById(a)||(console.log("id in Error"),i="")}}o()},(s=c).addEventListener?s.addEventListener(r,n,!1):s.attachEvent?s.attachEvent("on"+r,n):s["on"+r]=n;const o=()=>{new h({ids:i,vue:t,url:e.value.url,standard:"",extraHead:e.value.extraHead,extraCss:e.value.extraCss,zIndex:e.value.zIndex||20002,previewTitle:e.value.previewTitle||"打印预览",previewPrintBtnLabel:e.value.previewPrintBtnLabel||"打印",popTitle:e.value.popTitle,preview:e.value.preview||!1,asyncUrl:e.value.asyncUrl,previewBeforeOpenCallback(){e.value.previewBeforeOpenCallback&&e.value.previewBeforeOpenCallback(t)},previewOpenCallback(){e.value.previewOpenCallback&&e.value.previewOpenCallback(t)},openCallback(){e.value.openCallback&&e.value.openCallback(t)},closeCallback(){e.value.closeCallback&&e.value.closeCallback(t)},beforeOpenCallback(){e.value.beforeOpenCallback&&e.value.beforeOpenCallback(t)}})}},install:function(c){c.directive("print",v)}};export{v as t};